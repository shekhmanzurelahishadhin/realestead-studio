import { stats } from "@/data/content";
import Counter from "@/components/animations/Counter";
import FadeUp from "@/components/animations/FadeUp";

export default function Stats() {
  return (
    <section className="grain relative overflow-hidden border-y hairline bg-invert text-on-invert">
      <div
        aria-hidden
        className="animate-glow-drift pointer-events-none absolute -top-24 right-1/4 h-72 w-72 rounded-full bg-accent/15 blur-[100px]"
      />
      <div className="container-x relative grid grid-cols-2 gap-y-12 py-16 md:grid-cols-4 md:py-20">
        {stats.map((stat, i) => (
          <FadeUp key={stat.id} delay={i * 0.08}>
            <div className="border-l border-on-invert/15 pl-5">
              <p className="font-display text-4xl tracking-tight sm:text-5xl">
                <Counter value={stat.value} suffix={stat.suffix} />
              </p>
              <p className="mt-2 text-xs tracking-[0.14em] text-on-invert-muted">
                {stat.label.toUpperCase()}
              </p>
            </div>
          </FadeUp>
        ))}
      </div>
    </section>
  );
}
