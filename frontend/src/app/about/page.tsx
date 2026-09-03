import type { Metadata } from "next";
import PageHero from "@/components/sections/PageHero";
import FadeUp from "@/components/animations/FadeUp";
import RevealText from "@/components/animations/RevealText";
import ImageReveal from "@/components/animations/ImageReveal";
import SmartImage from "@/components/ui/SmartImage";
import Stats from "@/components/sections/Stats";
import CTA from "@/components/sections/CTA";
import { getStats } from "@/lib/api";
import { Flag } from "lucide-react";

const milestones = [
  { year: "2000", text: "Meridian founded in Dhaka with a single residential project in Dhanmondi." },
  { year: "2008", text: "Opened a second studio in Chittagong to serve the port-city market." },
  { year: "2014", text: "Delivered our first mixed-use development, Riverside Heights." },
  { year: "2021", text: "Launched an in-house sustainability practice for all new developments." },
  { year: "2026", text: "120+ projects delivered across 18 cities in Bangladesh." },
];

const leadership = [
  {
    name: "Rafiqul Islam",
    role: "Founder & Managing Director",
    image: "http://127.0.0.1:8000/storage/images/leader-rafiqul.jpg",
  },
  {
    name: "Shirin Akhter",
    role: "Head of Architecture",
    image: "http://127.0.0.1:8000/storage/images/leader-shirin.jpg",
  },
  {
    name: "Tanvir Ahmed",
    role: "Head of Construction",
    image: "http://127.0.0.1:8000/storage/images/leader-tanvir.jpg",
  },
];

export const metadata: Metadata = {
  title: "About",
  description: "Meridian's story, mission and leadership team.",
};

export default async function AboutPage() {
  const stats = await getStats();

  return (
    <>
      <PageHero
        eyebrow="Our Story"
        title="Twenty-five years of building with intent."
        description="Meridian began with a single residential project in Dhanmondi. Today we design, develop and construct across Bangladesh."
      />

      <section className="container-x pb-28">
        <div className="grid grid-cols-1 gap-12 lg:grid-cols-12">
          <div className="lg:col-span-6">
            <ImageReveal
              src="http://127.0.0.1:8000/storage/images/meridian-quarter.jpg"
              alt="Meridian architectural project exterior"
              className="aspect-[4/5]"
            />
          </div>
          <div className="flex flex-col justify-center lg:col-span-6">
            <p className="eyebrow mb-6 uppercase">Mission &amp; Vision</p>
            <RevealText
              as="h2"
              text="Architecture that responds to place, not trend."
              className="font-display text-3xl leading-tight tracking-tight text-fg sm:text-4xl"
            />
            <FadeUp delay={0.15} className="mt-8 space-y-5 text-base leading-relaxed text-fg-soft">
              <p>
                Our mission is to develop buildings that improve the daily
                life of the people inside them &mdash; through light,
                material, and considered planning, not spectacle.
              </p>
              <p>
                Our vision is a Bangladesh where every city has developments
                built for its own climate and culture, not imported from
                elsewhere.
              </p>
            </FadeUp>
          </div>
        </div>
      </section>

      <Stats stats={stats} />

      <section className="container-x py-28">
        <p className="eyebrow mb-6 uppercase">Timeline</p>
        <RevealText
          as="h2"
          text="Milestones along the way"
          className="max-w-xl font-display text-4xl tracking-tight text-fg sm:text-5xl"
        />

        <div className="mt-16 divide-y hairline border-t hairline">
          {milestones.map((m, i) => (
            <FadeUp key={m.year} delay={i * 0.05}>
              <div className="group grid grid-cols-1 gap-3 py-7 sm:grid-cols-[40px_100px_1fr] sm:items-center">
                <span className="flex h-9 w-9 items-center justify-center rounded-full border hairline text-accent transition-colors duration-500 group-hover:border-accent group-hover:bg-accent group-hover:text-accent-contrast">
                  <Flag size={14} strokeWidth={1.5} />
                </span>
                <span className="font-display text-2xl text-fg">{m.year}</span>
                <p className="max-w-xl text-sm leading-relaxed text-fg-soft">{m.text}</p>
              </div>
            </FadeUp>
          ))}
        </div>
      </section>

      <section className="bg-surface py-28">
        <div className="container-x">
          <p className="eyebrow mb-6 uppercase">Leadership</p>
          <RevealText
            as="h2"
            text="The people behind the practice"
            className="max-w-xl font-display text-4xl tracking-tight text-fg sm:text-5xl"
          />

          <div className="mt-16 grid grid-cols-1 gap-10 sm:grid-cols-3">
            {leadership.map((person, i) => (
              <FadeUp key={person.name} delay={i * 0.08}>
                <div className="group relative aspect-[3/4] overflow-hidden rounded-xl bg-invert-soft">
                  <SmartImage
                    src={person.image}
                    alt={person.name}
                    fill
                    sizes="(min-width: 768px) 30vw, 90vw"
                    className="object-cover grayscale transition-all duration-700 ease-[cubic-bezier(0.22,1,0.36,1)] group-hover:scale-105 group-hover:grayscale-0"
                  />
                </div>
                <p className="mt-4 font-display text-xl text-fg">{person.name}</p>
                <p className="text-sm text-muted">{person.role}</p>
              </FadeUp>
            ))}
          </div>
        </div>
      </section>

      <CTA />
    </>
  );
}
