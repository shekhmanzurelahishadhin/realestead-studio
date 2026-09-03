"use client";

import { useState } from "react";
import { AnimatePresence, motion } from "framer-motion";
import { Testimonial } from "@/types";
import { ArrowLeft, ArrowRight, Quote, Star } from "lucide-react";

export default function Testimonials({ testimonials }: { testimonials: Testimonial[] }) {
  const [[index, direction], setState] = useState<[number, number]>([0, 1]);
  const active = testimonials[index];

  const go = (dir: 1 | -1) =>
    setState(([prev]) => [(prev + dir + testimonials.length) % testimonials.length, dir]);

  return (
    <section className="bg-surface py-28 md:py-36">
      <div className="container-x">
        <p className="eyebrow mb-6">Client Voices</p>

        <div className="grid grid-cols-1 gap-10 lg:grid-cols-[auto_1fr_auto] lg:items-center">
          <Quote
            className="hidden shrink-0 text-accent/50 lg:block"
            size={52}
            strokeWidth={1}
          />

          <div className="min-h-[210px]">
            <AnimatePresence mode="wait" custom={direction}>
              <motion.div
                key={active.id}
                custom={direction}
                initial={{ opacity: 0, y: 20 * direction }}
                animate={{ opacity: 1, y: 0 }}
                exit={{ opacity: 0, y: -20 * direction }}
                transition={{ duration: 0.45, ease: [0.22, 1, 0.36, 1] }}
              >
                <div className="mb-5 flex gap-1" aria-label="Five out of five stars">
                  {Array.from({ length: 5 }).map((_, i) => (
                    <Star key={i} size={14} className="fill-accent text-accent" />
                  ))}
                </div>

                <p className="max-w-2xl font-display text-2xl leading-snug tracking-tight text-fg sm:text-3xl">
                  &ldquo;{active.quote}&rdquo;
                </p>
                <div className="mt-6">
                  <p className="text-sm font-medium text-fg">{active.name}</p>
                  <p className="text-sm text-muted">
                    {active.role} &middot; {active.project}
                  </p>
                </div>
              </motion.div>
            </AnimatePresence>
          </div>

          <div className="flex items-center gap-5">
            {/* Position dots */}
            <div className="flex gap-2">
              {testimonials.map((t, i) => (
                <button
                  key={t.id}
                  onClick={() => setState([i, i > index ? 1 : -1])}
                  aria-label={`Show testimonial ${i + 1}`}
                  aria-current={i === index}
                  className={`h-1.5 rounded-full transition-all duration-500 ${
                    i === index ? "w-6 bg-accent" : "w-1.5 bg-line-strong hover:bg-accent/50"
                  }`}
                />
              ))}
            </div>

            <div className="flex gap-3">
              <button
                onClick={() => go(-1)}
                aria-label="Previous testimonial"
                className="flex h-11 w-11 items-center justify-center rounded-full border hairline text-fg transition-colors duration-300 hover:border-accent hover:bg-accent hover:text-accent-contrast"
              >
                <ArrowLeft size={16} />
              </button>
              <button
                onClick={() => go(1)}
                aria-label="Next testimonial"
                className="flex h-11 w-11 items-center justify-center rounded-full border hairline text-fg transition-colors duration-300 hover:border-accent hover:bg-accent hover:text-accent-contrast"
              >
                <ArrowRight size={16} />
              </button>
            </div>
          </div>
        </div>
      </div>
    </section>
  );
}
