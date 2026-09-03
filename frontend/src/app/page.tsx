import Hero from "@/components/sections/Hero";
import Marquee from "@/components/sections/Marquee";
import About from "@/components/sections/About";
import Stats from "@/components/sections/Stats";
import FeaturedProjects from "@/components/sections/FeaturedProjects";
import FeaturedProperties from "@/components/sections/FeaturedProperties";
import Services from "@/components/sections/Services";
import Process from "@/components/sections/Process";
import Testimonials from "@/components/sections/Testimonials";
import CTA from "@/components/sections/CTA";
import {
  getProjects,
  getProperties,
  getServices,
  getProcessSteps,
  getTestimonials,
  getStats,
  getSettings,
} from "@/lib/api";

export default async function Home() {
  const [projects, properties, services, processSteps, testimonials, stats, settings] =
    await Promise.all([
      getProjects(),
      getProperties(),
      getServices(),
      getProcessSteps(),
      getTestimonials(),
      getStats(),
      getSettings(),
    ]);

  return (
    <>
      <Hero posterUrl={settings.heroImage} videoUrl={settings.heroVideo} tagline={settings.tagline} />
      <Marquee />
      <About />
      <Stats stats={stats} />
      <FeaturedProjects projects={projects} />
      <FeaturedProperties properties={properties.slice(0, 4)} />
      <Services services={services} />
      <Process steps={processSteps} />
      <Testimonials testimonials={testimonials} />
      <CTA />
    </>
  );
}
