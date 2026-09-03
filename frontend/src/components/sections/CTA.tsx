import ParallaxImage from "@/components/animations/ParallaxImage";
import RevealText from "@/components/animations/RevealText";
import Button from "@/components/ui/Button";
import { Mail, Phone } from "lucide-react";

export default function CTA() {
  return (
    <section className="grain relative overflow-hidden bg-invert py-32 text-on-invert md:py-44">
      <ParallaxImage
        src="http://127.0.0.1:8000/storage/images/cta-facade-dusk.jpg"
        alt="Contemporary building facade at dusk"
        className="absolute inset-0 opacity-30 dark:opacity-20"
        sizes="100vw"
        strength={40}
      />
      <div className="pointer-events-none absolute inset-0 bg-gradient-to-t from-invert via-invert/70 to-invert/40" />
      <div
        aria-hidden
        className="animate-glow-drift pointer-events-none absolute -right-20 top-10 h-96 w-96 rounded-full bg-accent/15 blur-[120px]"
      />

      <div className="container-x relative">
        <p className="eyebrow mb-6">Start Here</p>
        <RevealText
          as="h2"
          text="Let's build something extraordinary."
          className="max-w-3xl font-display text-5xl leading-[1.05] tracking-tight sm:text-6xl md:text-7xl"
        />

        <div className="mt-12 flex flex-wrap gap-4">
          <Button href="/contact" variant="light" cursorLabel="START">
            Start a Project
          </Button>
          <Button href="/properties" variant="ghost-dark">
            Explore Properties
          </Button>
        </div>

        <div className="mt-14 flex flex-wrap gap-x-10 gap-y-4 border-t border-on-invert/15 pt-8 text-sm">
          <a
            href="tel:+8801711000000"
            className="link-underline flex items-center gap-2.5 text-on-invert/80 transition-colors hover:text-accent-soft"
          >
            <Phone size={15} className="text-accent-soft" /> +880 1711 000 000
          </a>
          <a
            href="mailto:hello@meridian.studio"
            className="link-underline flex items-center gap-2.5 text-on-invert/80 transition-colors hover:text-accent-soft"
          >
            <Mail size={15} className="text-accent-soft" /> hello@meridian.studio
          </a>
        </div>
      </div>
    </section>
  );
}
