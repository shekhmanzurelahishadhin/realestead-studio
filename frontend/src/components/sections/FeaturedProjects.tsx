import { projects } from "@/data/projects";
import HorizontalScroll from "@/components/animations/HorizontalScroll";
import RevealText from "@/components/animations/RevealText";
import SmartImage from "@/components/ui/SmartImage";
import Link from "next/link";
import { ArrowRight, ArrowUpRight, MapPin } from "lucide-react";

export default function FeaturedProjects() {
  return (
    <section className="bg-surface py-28 md:py-36">
      <div className="container-x mb-14 flex items-end justify-between gap-6">
        <div>
          <p className="eyebrow mb-6">Featured Work</p>
          <RevealText
            as="h2"
            text="Selected projects"
            className="font-display text-4xl tracking-tight text-fg sm:text-5xl"
          />
        </div>
        <Link
          href="/projects"
          className="link-underline hidden shrink-0 items-center gap-2 pb-1 text-sm font-medium text-fg transition-colors hover:text-accent md:inline-flex"
        >
          All projects <ArrowUpRight size={15} />
        </Link>
      </div>

      <p className="container-x mb-4 flex items-center gap-2 text-xs tracking-[0.1em] text-muted md:hidden">
        <ArrowRight size={12} /> SWIPE TO EXPLORE
      </p>

      <HorizontalScroll>
        {projects.map((project, i) => (
          <Link
            href={`/projects/${project.slug}`}
            key={project.id}
            data-cursor="VIEW PROJECT"
            className="sheen group relative ml-6 h-[62vh] min-h-[420px] w-[85vw] shrink-0 snap-start overflow-hidden rounded-xl sm:w-[62vw] md:w-[46vw] lg:w-[36vw]"
          >
            <span className="absolute left-6 top-6 z-10 font-display text-sm text-white/80">
              {String(i + 1).padStart(2, "0")}
            </span>

            <SmartImage
              src={project.image}
              alt={project.name}
              fill
              sizes="(min-width: 1024px) 36vw, (min-width: 640px) 62vw, 85vw"
              className="object-cover transition-transform duration-[1200ms] ease-[cubic-bezier(0.22,1,0.36,1)] group-hover:scale-110"
            />
            <div className="absolute inset-0 bg-gradient-to-t from-black/85 via-black/15 to-transparent" />

            <span className="absolute right-6 top-6 z-10 flex h-11 w-11 translate-y-2 items-center justify-center rounded-full bg-accent text-accent-contrast opacity-0 transition-all duration-500 group-hover:translate-y-0 group-hover:opacity-100">
              <ArrowUpRight size={18} />
            </span>

            <div className="absolute inset-x-0 bottom-0 z-10 p-7">
              <p className="text-xs tracking-[0.14em] text-white/70">
                {project.category.toUpperCase()} &middot; {project.year}
              </p>
              <h3 className="mt-2 font-display text-2xl text-white transition-transform duration-500 group-hover:-translate-y-1">
                {project.name}
              </h3>
              <p className="mt-1.5 flex items-center gap-1.5 text-sm text-white/70">
                <MapPin size={13} /> {project.location}
              </p>
            </div>
          </Link>
        ))}

        <div className="ml-6 flex h-[62vh] min-h-[420px] w-[70vw] shrink-0 snap-start items-center pr-16 sm:w-[50vw] md:w-[32vw]">
          <Link
            href="/projects"
            className="group flex items-center gap-3 text-lg font-medium text-fg transition-colors hover:text-accent"
          >
            View all projects
            <span className="flex h-11 w-11 items-center justify-center rounded-full border hairline transition-colors duration-300 group-hover:border-accent group-hover:bg-accent group-hover:text-accent-contrast">
              <ArrowUpRight size={18} />
            </span>
          </Link>
        </div>
      </HorizontalScroll>
    </section>
  );
}
