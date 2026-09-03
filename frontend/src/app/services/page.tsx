import type { Metadata } from "next";
import Image from "next/image";
import PageHero from "@/components/sections/PageHero";
import { getServices } from "@/lib/api";
import FadeUp from "@/components/animations/FadeUp";
import Button from "@/components/ui/Button";
import CTA from "@/components/sections/CTA";

export const metadata: Metadata = {
  title: "Services",
  description: "Development, construction, architecture, interiors, property management and commercial delivery.",
};

export default async function ServicesPage() {
  const services = await getServices();

  return (
    <>
      <PageHero
        eyebrow="Capabilities"
        title="Every discipline, one accountable team."
        description="From land acquisition to the last coat of paint, we hold design, engineering and construction under one roof."
      />

      <section className="container-x pb-28">
        <div className="divide-y hairline border-t hairline">
          {services.map((service, i) => (
            <FadeUp key={service.id} delay={i * 0.05}>
              <div className="grid grid-cols-1 gap-8 py-12 md:grid-cols-[80px_1fr_1.3fr_auto] md:items-center md:gap-10">
                <span className="font-display text-lg text-accent">
                  {String(i + 1).padStart(2, "0")}
                </span>
                <div className="relative aspect-[4/3] w-full overflow-hidden md:w-40">
                  <Image
                    src={service.image}
                    alt={service.title}
                    fill
                    sizes="200px"
                    className="object-cover"
                  />
                </div>
                <div>
                  <h3 className="font-display text-2xl text-fg">{service.title}</h3>
                  <p className="mt-2 max-w-md text-sm leading-relaxed text-fg-soft">
                    {service.description}
                  </p>
                </div>
                <Button href="/contact" variant="ghost" cursorLabel="ENQUIRE" className="justify-self-start md:justify-self-end">
                  Enquire
                </Button>
              </div>
            </FadeUp>
          ))}
        </div>
      </section>

      <CTA />
    </>
  );
}
