import RevealText from "@/components/animations/RevealText";
import FadeUp from "@/components/animations/FadeUp";

export default function PageHero({
  eyebrow,
  title,
  description,
}: {
  eyebrow: string;
  title: string;
  description?: string;
}) {
  return (
    <section className="relative overflow-hidden">
      {/* Soft accent wash behind the heading */}
      <div
        aria-hidden
        className="animate-glow-drift pointer-events-none absolute -left-40 -top-24 h-[30rem] w-[30rem] rounded-full bg-accent/10 blur-[130px]"
      />

      <div className="container-x relative pb-16 pt-40 md:pb-20 md:pt-48">
        <p className="eyebrow mb-6">{eyebrow}</p>
        <RevealText
          as="h1"
          text={title}
          className="max-w-3xl font-display text-5xl leading-[1.05] tracking-tight text-fg sm:text-6xl md:text-7xl"
        />
        {description && (
          <FadeUp delay={0.2}>
            <p className="mt-8 max-w-lg text-base leading-relaxed text-fg-soft">
              {description}
            </p>
          </FadeUp>
        )}
      </div>
    </section>
  );
}
