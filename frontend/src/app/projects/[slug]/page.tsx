import type { Metadata } from "next";
import { notFound } from "next/navigation";
import Link from "next/link";
import { getProject, getProjects } from "@/lib/api";
import FadeUp from "@/components/animations/FadeUp";
import RevealText from "@/components/animations/RevealText";
import SmartImage from "@/components/ui/SmartImage";
import ProjectGallery from "@/components/sections/ProjectGallery";
import ProjectCard from "@/components/ui/ProjectCard";
import Button from "@/components/ui/Button";
import { ArrowLeft } from "lucide-react";

export async function generateMetadata({
  params,
}: {
  params: Promise<{ slug: string }>;
}): Promise<Metadata> {
  const { slug } = await params;
  const project = await getProject(slug);
  if (!project) return {};
  return {
    title: project.name,
    description: project.description,
  };
}

export default async function ProjectDetailPage({
  params,
}: {
  params: Promise<{ slug: string }>;
}) {
  const { slug } = await params;
  const project = await getProject(slug);
  if (!project) notFound();

  const allProjects = await getProjects();
  const related = allProjects.filter((p) => p.slug !== slug).slice(0, 2);

  return (
    <>
      <section className="relative h-[70vh] min-h-[480px] w-full overflow-hidden bg-invert">
        <SmartImage
          src={project.image}
          alt={project.name}
          fill
          preload
          sizes="100vw"
          className="object-cover"
        />
        <div className="absolute inset-0 bg-gradient-to-t from-black/85 via-black/20 to-black/10" />
        <div className="container-x absolute inset-x-0 bottom-0 pb-14">
          <FadeUp>
            <Link
              href="/projects"
              className="mb-6 inline-flex items-center gap-2 text-xs tracking-wide text-white/70 hover:text-white"
            >
              <ArrowLeft size={14} /> All projects
            </Link>
            <p className="text-xs tracking-[0.14em] text-white/70">
              {project.category.toUpperCase()} &middot; {project.location}
            </p>
          </FadeUp>
          <RevealText
            as="h1"
            text={project.name}
            className="mt-3 font-display text-5xl tracking-tight text-white sm:text-6xl md:text-7xl"
          />
        </div>
      </section>

      <section className="container-x py-20 md:py-28">
        <div className="grid grid-cols-1 gap-14 lg:grid-cols-12">
          <div className="lg:col-span-7">
            <FadeUp>
              <p className="text-lg leading-relaxed text-fg-soft">{project.description}</p>
            </FadeUp>

            <div className="mt-14">
              <ProjectGallery images={project.gallery} alt={project.name} />
            </div>
          </div>

          <aside className="lg:col-span-4 lg:col-start-9">
            <FadeUp delay={0.15} className="card-surface sticky top-28 rounded-2xl p-8">
              <p className="eyebrow mb-5">Project Details</p>
              <dl className="space-y-4">
                {project.stats.map((stat) => (
                  <div key={stat.label} className="flex justify-between border-b hairline pb-3 text-sm">
                    <dt className="text-muted">{stat.label}</dt>
                    <dd className="font-medium text-fg">{stat.value}</dd>
                  </div>
                ))}
                <div className="flex justify-between pb-1 text-sm">
                  <dt className="text-muted">Location</dt>
                  <dd className="font-medium text-fg">{project.location}</dd>
                </div>
              </dl>
              <div className="mt-8">
                <Button href="/contact" cursorLabel="ENQUIRE" className="w-full justify-center">
                  Enquire About This Project
                </Button>
              </div>
            </FadeUp>
          </aside>
        </div>
      </section>

      <section className="border-t hairline bg-surface py-24">
        <div className="container-x">
          <p className="eyebrow mb-10">More Projects</p>
          <div className="grid grid-cols-1 gap-x-8 gap-y-16 md:grid-cols-2">
            {related.map((p, i) => (
              <FadeUp key={p.id} delay={i * 0.1}>
                <ProjectCard project={p} />
              </FadeUp>
            ))}
          </div>
        </div>
      </section>
    </>
  );
}
