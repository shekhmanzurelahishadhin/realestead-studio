"use client";

import { useRef } from "react";
import { motion, useScroll, useTransform } from "framer-motion";
import { processSteps } from "@/data/content";
import { processIcons, fallbackIcon } from "@/data/icons";
import RevealText from "@/components/animations/RevealText";
import useInViewOnce from "@/hooks/useInViewOnce";

export default function Process() {
  const ref = useRef<HTMLDivElement>(null);
  const { ref: listRef, inView } = useInViewOnce<HTMLDivElement>();
  const { scrollYProgress } = useScroll({
    target: ref,
    offset: ["start 75%", "end 60%"],
  });
  const lineHeight = useTransform(scrollYProgress, [0, 1], ["0%", "100%"]);

  return (
    <section className="container-x py-28 md:py-36">
      <p className="eyebrow mb-6">How We Work</p>
      <RevealText
        as="h2"
        text="From concept to keys"
        className="max-w-2xl font-display text-4xl tracking-tight text-fg sm:text-5xl"
      />

      <div ref={ref} className="relative mt-20">
        {/* Progress rail — fills as the section scrolls past */}
        <div className="absolute left-[19px] top-0 hidden h-full w-px bg-line md:block">
          <motion.div style={{ height: lineHeight }} className="w-px bg-accent" />
        </div>

        <div ref={listRef} className="divide-y hairline">
          {processSteps.map((step, i) => {
            const Icon = processIcons[step.id] ?? fallbackIcon;
            return (
              <motion.div
                key={step.id}
                initial={{ opacity: 0, y: 24 }}
                animate={inView ? { opacity: 1, y: 0 } : { opacity: 0, y: 24 }}
                transition={{ duration: 0.7, delay: i * 0.05, ease: [0.22, 1, 0.36, 1] }}
                className="group grid grid-cols-1 gap-3 py-8 md:grid-cols-[40px_140px_1fr] md:items-start md:gap-8"
              >
                {/* Node on the rail */}
                <div className="relative z-[1] flex h-10 w-10 items-center justify-center rounded-full border hairline bg-canvas text-accent transition-colors duration-500 group-hover:border-accent group-hover:bg-accent group-hover:text-accent-contrast">
                  <Icon size={17} strokeWidth={1.5} />
                </div>

                <div>
                  <span className="font-body text-xs tracking-[0.16em] text-accent">
                    {step.index}
                  </span>
                  <h3 className="mt-1 font-display text-2xl text-fg">{step.title}</h3>
                </div>

                <p className="max-w-md text-sm leading-relaxed text-fg-soft md:pt-6">
                  {step.description}
                </p>
              </motion.div>
            );
          })}
        </div>
      </div>
    </section>
  );
}
