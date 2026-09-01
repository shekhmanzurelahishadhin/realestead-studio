"use client";

import { useMemo, useState } from "react";
import { motion, AnimatePresence } from "framer-motion";
import { projects } from "@/data/projects";
import ProjectCard from "@/components/ui/ProjectCard";
import clsx from "clsx";

export default function ProjectGrid() {
  const categories = useMemo(
    () => ["All", ...Array.from(new Set(projects.map((p) => p.category)))],
    []
  );
  const [filter, setFilter] = useState("All");

  const filtered =
    filter === "All" ? projects : projects.filter((p) => p.category === filter);

  return (
    <div className="container-x pb-28">
      <div className="mb-14 flex flex-wrap items-center gap-3 border-b hairline pb-8">
        {categories.map((cat) => (
          <button
            key={cat}
            onClick={() => setFilter(cat)}
            aria-pressed={filter === cat}
            className={clsx(
              "relative rounded-full px-4 py-2 text-xs font-medium tracking-wide transition-colors duration-300",
              filter === cat ? "text-canvas" : "text-fg-soft hover:text-accent"
            )}
          >
            {/* Shared pill that slides between the active filters */}
            {filter === cat && (
              <motion.span
                layoutId="project-filter-pill"
                transition={{ type: "spring", stiffness: 420, damping: 34 }}
                className="absolute inset-0 rounded-full bg-fg"
              />
            )}
            <span className="relative z-[1]">{cat}</span>
          </button>
        ))}

        <span className="ml-auto text-xs tracking-[0.12em] text-muted">
          {filtered.length} {filtered.length === 1 ? "PROJECT" : "PROJECTS"}
        </span>
      </div>

      <motion.div layout className="grid grid-cols-1 gap-x-8 gap-y-16 md:grid-cols-2">
        <AnimatePresence mode="popLayout">
          {filtered.map((project, i) => (
            <motion.div
              key={project.id}
              layout
              initial={{ opacity: 0, y: 24 }}
              animate={{ opacity: 1, y: 0 }}
              exit={{ opacity: 0, scale: 0.97 }}
              transition={{
                duration: 0.5,
                delay: (i % 2) * 0.06,
                ease: [0.22, 1, 0.36, 1],
              }}
            >
              <ProjectCard project={project} />
            </motion.div>
          ))}
        </AnimatePresence>
      </motion.div>
    </div>
  );
}
