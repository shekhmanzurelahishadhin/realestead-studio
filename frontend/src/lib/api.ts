import {
  Project,
  Property,
  PropertyStatus,
  Service,
  Testimonial,
  ProcessStep,
  Stat,
  SiteSettings,
} from "@/types";

/**
 * Base URL of the Laravel API. Falls back to the local dev server so the
 * app still works out of the box with `php artisan serve`.
 */
const API_URL = process.env.NEXT_PUBLIC_API_URL ?? "http://127.0.0.1:8000/api";

type Envelope<T> = { data: T };

async function apiGet<T>(path: string, revalidate = 60): Promise<T> {
  const res = await fetch(`${API_URL}${path}`, {
    next: { revalidate },
  });
  if (!res.ok) {
    throw new Error(`API request failed: ${path} (${res.status})`);
  }
  const json: Envelope<T> = await res.json();
  return json.data;
}

export async function getProjects(): Promise<Project[]> {
  return apiGet<Project[]>("/projects");
}

export async function getProject(slug: string): Promise<Project | null> {
  try {
    return await apiGet<Project>(`/projects/${slug}`);
  } catch {
    return null;
  }
}

export async function getProperties(params?: {
  status?: PropertyStatus | "all";
  q?: string;
}): Promise<Property[]> {
  const search = new URLSearchParams();
  if (params?.status && params.status !== "all") search.set("status", params.status);
  if (params?.q) search.set("q", params.q);
  const qs = search.toString();
  return apiGet<Property[]>(`/properties${qs ? `?${qs}` : ""}`);
}

export async function getProperty(slug: string): Promise<Property | null> {
  try {
    return await apiGet<Property>(`/properties/${slug}`);
  } catch {
    return null;
  }
}

export async function getServices(): Promise<Service[]> {
  return apiGet<Service[]>("/services");
}

export async function getTestimonials(): Promise<Testimonial[]> {
  return apiGet<Testimonial[]>("/testimonials");
}

export async function getProcessSteps(): Promise<ProcessStep[]> {
  return apiGet<ProcessStep[]>("/process-steps");
}

export async function getStats(): Promise<Stat[]> {
  return apiGet<Stat[]>("/stats");
}

/**
 * Used only if the API is unreachable when rendering the layout (which wraps
 * every page) — keeps the site from hard-failing to a 500 screen when the
 * backend happens to be down.
 */
const FALLBACK_SETTINGS: SiteSettings = {
  siteName: "Meridian",
  tagline: "Real Estate & Construction Studio · Est. 2000",
  logoImage: null,
  favicon: null,
  heroImage: "http://127.0.0.1:8000/storage/images/architecture-sky.jpg",
  heroVideo: null,
  phone: null,
  email: null,
  address: null,
  socials: { instagram: null, linkedin: null, facebook: null },
};

export async function getSettings(): Promise<SiteSettings> {
  try {
    return await apiGet<SiteSettings>("/settings");
  } catch {
    return FALLBACK_SETTINGS;
  }
}

export type ContactPayload = {
  name: string;
  email: string;
  phone?: string;
  subject?: string;
  message: string;
};

export type ContactResult =
  | { ok: true }
  | { ok: false; message: string; errors?: Record<string, string[]> };

/** Called from the browser (client component), so it hits the API directly. */
export async function submitContact(payload: ContactPayload): Promise<ContactResult> {
  try {
    const res = await fetch(`${API_URL}/contact`, {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(payload),
    });

    if (res.ok) return { ok: true };

    if (res.status === 422) {
      const body = await res.json();
      return { ok: false, message: "Please check the highlighted fields.", errors: body.errors };
    }

    return { ok: false, message: "Something went wrong. Please try again shortly." };
  } catch {
    return { ok: false, message: "Could not reach the server. Please try again shortly." };
  }
}
