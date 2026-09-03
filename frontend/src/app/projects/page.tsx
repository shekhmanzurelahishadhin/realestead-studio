import type { Metadata } from "next";
import PageHero from "@/components/sections/PageHero";
import ProjectGrid from "@/components/sections/ProjectGrid";
import { getProjects } from "@/lib/api";

export const metadata: Metadata = {
  title: "Projects",
  description: "Explore Meridian's portfolio of residential, commercial and mixed-use developments.",
};

export default async function ProjectsPage() {
  const projects = await getProjects();

  return (
    <>
      <PageHero
        eyebrow="Portfolio"
        title="A body of work shaped by place."
        description="Twenty-five years of residential, commercial and mixed-use developments across Bangladesh."
      />
      <ProjectGrid projects={projects} />
    </>
  );
}
