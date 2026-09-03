import RevealText from "@/components/animations/RevealText";
import ImageReveal from "@/components/animations/ImageReveal";
import FadeUp from "@/components/animations/FadeUp";
import Button from "@/components/ui/Button";
import { Compass, HardHat, Leaf } from "lucide-react";

const pillars = [
  {
    icon: Compass,
    title: "Design-led",
    text: "Every project starts with the site, its climate and its light — never a template.",
  },
  {
    icon: HardHat,
    title: "Built in-house",
    text: "Design, engineering and construction sit under one roof and one accountability.",
  },
  {
    icon: Leaf,
    title: "Built to last",
    text: "Material choices judged over decades of use, not the day of handover.",
  },
];

export default function About() {
  return (
    <section className="container-x py-28 md:py-36">
      <div className="grid grid-cols-1 gap-12 lg:grid-cols-12 lg:gap-8">
        <div className="lg:col-span-7">
          <p className="eyebrow mb-6">About Meridian</p>
          <RevealText
            as="h2"
            text="We don't just build. We create places to belong."
            className="max-w-2xl font-display text-4xl leading-[1.08] tracking-tight text-fg sm:text-5xl md:text-6xl"
          />

          <FadeUp delay={0.15} className="mt-10 max-w-xl">
            <p className="text-base leading-relaxed text-fg-soft">
              For twenty-five years, Meridian has developed and constructed
              residential, commercial and mixed-use buildings across
              Bangladesh. We hold design, engineering and construction under
              one roof, so every decision made on paper survives all the way
              to the finished building.
            </p>
            <p className="mt-5 text-base leading-relaxed text-fg-soft">
              Our philosophy is simple: architecture should respond to its
              climate, its site and the people who will live in it &mdash;
              not the other way around.
            </p>
          </FadeUp>

          <div className="mt-12 grid grid-cols-1 gap-6 sm:grid-cols-3">
            {pillars.map((pillar, i) => (
              <FadeUp key={pillar.title} delay={0.2 + i * 0.08}>
                <div className="card-surface group h-full rounded-xl p-5">
                  <span className="flex h-11 w-11 items-center justify-center rounded-full bg-accent/10 text-accent transition-transform duration-500 group-hover:-translate-y-1 group-hover:bg-accent group-hover:text-accent-contrast">
                    <pillar.icon size={20} strokeWidth={1.5} />
                  </span>
                  <p className="mt-4 font-display text-lg text-fg">{pillar.title}</p>
                  <p className="mt-1.5 text-sm leading-relaxed text-muted">{pillar.text}</p>
                </div>
              </FadeUp>
            ))}
          </div>

          <FadeUp delay={0.3} className="mt-10">
            <Button href="/about" variant="ghost" cursorLabel="ABOUT">
              Our Story
            </Button>
          </FadeUp>
        </div>

        <div className="lg:col-span-5 lg:pt-16">
          <ImageReveal
            src="http://127.0.0.1:8000/storage/images/architectural-detail.jpg"
            alt="Interior architectural detail with warm natural light"
            className="aspect-[4/5] w-full rounded-xl"
            sizes="(min-width: 1024px) 40vw, 90vw"
          />
          <FadeUp delay={0.2}>
            <p className="mt-4 text-xs tracking-wide text-muted">
              Interior study &mdash; The Grand Terrace, Banani
            </p>
          </FadeUp>
        </div>
      </div>
    </section>
  );
}
