const words = [
  "Residential",
  "Commercial",
  "Mixed-Use",
  "Interiors",
  "Master Planning",
  "Construction",
];

/**
 * Infinite scrolling word band. The list is rendered twice and translated by
 * -50%, so the loop is seamless. Pure CSS — no scroll listener, no JS cost.
 */
export default function Marquee() {
  return (
    <section
      aria-label="Our disciplines"
      className="marquee-mask overflow-hidden border-y hairline bg-surface py-7"
    >
      <div className="animate-marquee flex w-max items-center gap-10 will-change-transform">
        {[0, 1].map((copy) => (
          <div key={copy} aria-hidden={copy === 1} className="flex items-center gap-10">
            {words.map((word) => (
              <div key={word} className="flex items-center gap-10">
                <span className="whitespace-nowrap font-display text-2xl tracking-tight text-fg/70 sm:text-3xl">
                  {word}
                </span>
                <span className="h-1.5 w-1.5 shrink-0 rounded-full bg-accent" />
              </div>
            ))}
          </div>
        ))}
      </div>
    </section>
  );
}
