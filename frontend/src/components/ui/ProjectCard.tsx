import Link from "next/link";
import { ArrowUpRight, MapPin } from "lucide-react";
import { Project } from "@/types";
import SmartImage from "@/components/ui/SmartImage";

export default function ProjectCard({ project }: { project: Project }) {
  return (
    <Link
      href={`/projects/${project.slug}`}
      data-cursor="VIEW"
      className="card-surface group block overflow-hidden rounded-2xl"
    >
      <div className="sheen relative aspect-[4/3] overflow-hidden">
        <SmartImage
          src={project.image}
          alt={project.name}
          fill
          sizes="(min-width: 1024px) 45vw, 90vw"
          className="object-cover transition-transform duration-[1100ms] ease-[cubic-bezier(0.22,1,0.36,1)] group-hover:scale-[1.06]"
        />
        <div className="absolute inset-0 bg-gradient-to-t from-black/65 via-black/0 to-black/0 opacity-0 transition-opacity duration-500 group-hover:opacity-100" />

        <span className="absolute right-4 top-4 flex h-10 w-10 translate-y-2 items-center justify-center rounded-full bg-accent text-accent-contrast opacity-0 shadow-lg transition-all duration-500 group-hover:translate-y-0 group-hover:opacity-100">
          <ArrowUpRight size={17} />
        </span>

        <span className="absolute bottom-4 left-4 rounded-full bg-canvas/90 px-3 py-1 text-[10px] font-medium tracking-[0.12em] text-fg backdrop-blur-sm">
          {project.year}
        </span>
      </div>

      <div className="p-5">
        <div className="flex items-start justify-between gap-4">
          <h3 className="font-display text-xl text-fg transition-colors duration-300 group-hover:text-accent">
            {project.name}
          </h3>
          <p className="shrink-0 pt-1 text-[10px] tracking-[0.1em] text-muted">
            {project.category.toUpperCase()}
          </p>
        </div>
        <p className="mt-1.5 flex items-center gap-1.5 text-sm text-muted">
          <MapPin size={13} className="text-accent" /> {project.location}
        </p>
      </div>
    </Link>
  );
}
