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

export default function Home() {
  return (
    <>
      <Hero />
      <Marquee />
      <About />
      <Stats />
      <FeaturedProjects />
      <FeaturedProperties />
      <Services />
      <Process />
      <Testimonials />
      <CTA />
    </>
  );
}
