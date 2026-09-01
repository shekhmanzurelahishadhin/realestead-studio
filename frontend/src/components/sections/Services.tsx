"use client";

import { useState } from "react";
import Image from "next/image";
import { AnimatePresence, motion } from "framer-motion";
import { services } from "@/data/content";
import RevealText from "@/components/animations/RevealText";
import { serviceIcons } from "@/data/icons";
import { ArrowUpRight, Plus } from "lucide-react";

export default function Services() {
  const [active, setActive] = useState(0);
  const current = services[Math.max(0, active)];

  return (
    <section className="grain relative overflow-hidden bg-invert py-28 text-on-invert md:py-36">
      <div
        aria-hidden
        className="animate-glow-drift pointer-events-none absolute -left-40 top-1/3 h-96 w-96 rounded-full bg-accent/12 blur-[120px]"
      />

      <div className="container-x relative">
        <p className="eyebrow mb-6">What We Do</p>
        <RevealText
          as="h2"
          text="A studio built end to end"
          className="max-w-2xl font-display text-4xl tracking-tight sm:text-5xl"
        />

        <div className="mt-16 grid grid-cols-1 gap-10 lg:grid-cols-[1fr_1fr]">
          {/* Desktop: hover list */}
          <div className="hidden lg:block">
            {services.map((service, i) => {
              const Icon = serviceIcons[service.id];
              return (
                <button
                  key={service.id}
                  onMouseEnter={() => setActive(i)}
                  onFocus={() => setActive(i)}
                  className="group flex w-full items-center gap-5 border-t border-on-invert/15 py-6 text-left transition-colors last:border-b last:border-b-on-invert/15"
                >
                  <Icon
                    size={20}
                    strokeWidth={1.5}
                    className={`shrink-0 transition-colors duration-300 ${
                      active === i ? "text-accent-soft" : "text-on-invert/35"
                    }`}
                  />
                  <span
                    className={`flex-1 font-display text-2xl transition-colors duration-300 xl:text-3xl ${
                      active === i ? "text-accent-soft" : "text-on-invert/50"
                    }`}
                  >
                    {service.title}
                  </span>
                  <ArrowUpRight
                    size={20}
                    className={`shrink-0 transition-all duration-300 ${
                      active === i
                        ? "translate-x-0 translate-y-0 opacity-100"
                        : "-translate-x-2 translate-y-2 opacity-0"
                    }`}
                  />
                </button>
              );
            })}
          </div>

          {/* Mobile: accordion */}
          <div className="lg:hidden">
            {services.map((service, i) => {
              const Icon = serviceIcons[service.id];
              return (
                <div
                  key={service.id}
                  className="border-t border-on-invert/15 py-5 last:border-b last:border-b-on-invert/15"
                >
                  <button
                    onClick={() => setActive(active === i ? -1 : i)}
                    aria-expanded={active === i}
                    className="flex w-full items-center gap-3 text-left"
                  >
                    <Icon size={18} strokeWidth={1.5} className="shrink-0 text-accent-soft" />
                    <span className="flex-1 font-display text-xl">{service.title}</span>
                    <Plus
                      size={18}
                      className={`shrink-0 transition-transform duration-300 ${
                        active === i ? "rotate-45 text-accent-soft" : ""
                      }`}
                    />
                  </button>
                  <AnimatePresence initial={false}>
                    {active === i && (
                      <motion.div
                        initial={{ height: 0, opacity: 0 }}
                        animate={{ height: "auto", opacity: 1 }}
                        exit={{ height: 0, opacity: 0 }}
                        transition={{ duration: 0.35, ease: [0.22, 1, 0.36, 1] }}
                        className="overflow-hidden"
                      >
                        <p className="pt-4 text-sm leading-relaxed text-on-invert-muted">
                          {service.description}
                        </p>
                      </motion.div>
                    )}
                  </AnimatePresence>
                </div>
              );
            })}
          </div>

          {/* Image panel */}
          <div className="relative hidden aspect-[4/5] overflow-hidden rounded-xl lg:block">
            <AnimatePresence mode="wait">
              <motion.div
                key={current.id}
                initial={{ opacity: 0, scale: 1.06 }}
                animate={{ opacity: 1, scale: 1 }}
                exit={{ opacity: 0 }}
                transition={{ duration: 0.6, ease: [0.22, 1, 0.36, 1] }}
                className="absolute inset-0"
              >
                <Image
                  src={current.image}
                  alt={current.title}
                  fill
                  sizes="(min-width: 1024px) 40vw, 90vw"
                  className="object-cover"
                />
                <div className="absolute inset-0 bg-gradient-to-t from-black/85 via-black/20 to-transparent" />
                <div className="absolute inset-x-0 bottom-0 p-7">
                  <p className="font-display text-2xl text-white">{current.title}</p>
                  <p className="mt-2 text-sm leading-relaxed text-white/75">
                    {current.description}
                  </p>
                </div>
              </motion.div>
            </AnimatePresence>
          </div>
        </div>
      </div>
    </section>
  );
}
