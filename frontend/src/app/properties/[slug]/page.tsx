import type { Metadata } from "next";
import { notFound } from "next/navigation";
import Link from "next/link";
import { getProperty } from "@/lib/api";
import FadeUp from "@/components/animations/FadeUp";
import RevealText from "@/components/animations/RevealText";
import PropertyGallery from "@/components/sections/PropertyGallery";
import Button from "@/components/ui/Button";
import { ArrowLeft, BedDouble, Bath, Ruler, Check, MapPin, Navigation } from "lucide-react";

export async function generateMetadata({
  params,
}: {
  params: Promise<{ slug: string }>;
}): Promise<Metadata> {
  const { slug } = await params;
  const property = await getProperty(slug);
  if (!property) return {};
  return {
    title: property.title,
    description: `${property.title} in ${property.location} — ${property.bedrooms} bed, ${property.area} sq ft.`,
  };
}

export default async function PropertyDetailPage({
  params,
}: {
  params: Promise<{ slug: string }>;
}) {
  const { slug } = await params;
  const property = await getProperty(slug);
  if (!property) notFound();

  const directionsHref = `https://www.google.com/maps/search/?api=1&query=${encodeURIComponent(
    `${property.title}, ${property.location}`
  )}`;

  return (
    <section className="pt-32 md:pt-40">
      <div className="container-x">
        <FadeUp>
          <Link
            href="/properties"
            className="mb-8 inline-flex items-center gap-2 text-xs tracking-wide text-muted hover:text-accent"
          >
            <ArrowLeft size={14} /> All properties
          </Link>
        </FadeUp>

        <div className="grid grid-cols-1 gap-14 lg:grid-cols-12">
          <div className="lg:col-span-7">
            <FadeUp delay={0.05}>
              <PropertyGallery images={property.gallery} alt={property.title} />
            </FadeUp>

            <FadeUp delay={0.15} className="mt-14">
              <p className="eyebrow mb-4">Amenities</p>
              <ul className="grid grid-cols-2 gap-3">
                {property.amenities.map((a) => (
                  <li key={a} className="flex items-center gap-2 text-sm text-fg-soft">
                    <Check size={14} className="text-accent" /> {a}
                  </li>
                ))}
              </ul>
            </FadeUp>

            <FadeUp delay={0.2} className="mt-14 border-t hairline pt-10">
              <div className="mb-4 flex items-center justify-between">
                <p className="eyebrow">Location</p>
                <a
                  href={directionsHref}
                  target="_blank"
                  rel="noopener noreferrer"
                  className="link-underline flex items-center gap-1.5 text-xs font-medium text-accent"
                >
                  <Navigation size={13} /> Get directions
                </a>
              </div>
              <a
                href={directionsHref}
                target="_blank"
                rel="noopener noreferrer"
                className="group flex aspect-[16/7] items-center justify-center rounded-xl border hairline bg-surface text-sm text-muted transition-colors duration-300 hover:border-accent/50 hover:text-accent"
              >
                <span className="flex items-center gap-2">
                  <MapPin size={16} className="transition-transform duration-300 group-hover:-translate-y-0.5" />
                  {property.location} &mdash; open in Google Maps
                </span>
              </a>
            </FadeUp>
          </div>

          <aside className="lg:col-span-4 lg:col-start-9">
            <FadeUp delay={0.1} className="card-surface rounded-2xl p-7 lg:sticky lg:top-28">
              <p className="text-xs tracking-[0.14em] text-accent">
                {property.status.toUpperCase()}
              </p>
              <RevealText
                as="h1"
                text={property.title}
                className="mt-2 font-display text-4xl tracking-tight text-fg"
              />
              <p className="mt-2 text-sm text-muted">{property.location}</p>

              <div className="mt-8 flex items-center gap-6 border-y hairline py-6 text-sm text-fg-soft">
                <span className="flex items-center gap-2">
                  <BedDouble size={16} className="text-accent" /> {property.bedrooms} beds
                </span>
                <span className="flex items-center gap-2">
                  <Bath size={16} className="text-accent" /> {property.bathrooms} baths
                </span>
                <span className="flex items-center gap-2">
                  <Ruler size={16} className="text-accent" /> {property.area.toLocaleString()} sqft
                </span>
              </div>

              <div className="mt-6">
                <p className="text-xs tracking-[0.1em] text-muted">STARTING FROM</p>
                <p className="mt-1 font-display text-3xl text-fg">{property.priceLabel}</p>
              </div>

              <div className="mt-8 space-y-3">
                <Button href="/contact" className="w-full justify-center" cursorLabel="ENQUIRE">
                  Enquire About This Property
                </Button>
                <a
                  href="tel:+8801711000000"
                  className="flex w-full items-center justify-center rounded-full border hairline px-6 py-3.5 text-sm font-medium text-fg transition-colors duration-300 hover:border-accent hover:text-accent"
                >
                  Call +880 1711 000 000
                </a>
              </div>
            </FadeUp>
          </aside>
        </div>
      </div>
    </section>
  );
}
