"use client";

import { useEffect, useState } from "react";
import { motion, AnimatePresence } from "framer-motion";

/**
 * First-visit intro. It is deliberately short and tracks real readiness
 * (fonts + window load) rather than a fixed timer, so it never adds more
 * than a moment to the perceived load. Skipped entirely on repeat views
 * within the session and under prefers-reduced-motion.
 */
export default function SmoothLoader() {
  const [progress, setProgress] = useState(0);
  const [done, setDone] = useState(false);
  const [mounted, setMounted] = useState(false);

  useEffect(() => {
    const seen = sessionStorage.getItem("meridian-loaded");
    const reduced = window.matchMedia("(prefers-reduced-motion: reduce)").matches;

    if (seen || reduced) {
      // Skip the intro entirely — nothing to animate, so mark done at once.
      // eslint-disable-next-line react-hooks/set-state-in-effect
      setDone(true);
      return;
    }

    setMounted(true);

    let raf = 0;
    let finished = false;
    const start = performance.now();
    const MIN = 450; // never flash by faster than this
    const MAX = 1100; // never hold longer than this

    const finish = () => {
      if (finished) return;
      finished = true;
      setProgress(100);
      sessionStorage.setItem("meridian-loaded", "1");
      setTimeout(() => setDone(true), 260);
    };

    // Creep toward 90% while assets settle, then snap to 100% on ready.
    const tick = (now: number) => {
      const elapsed = now - start;
      setProgress(Math.min(90, Math.round((elapsed / MAX) * 100)));
      if (!finished) raf = requestAnimationFrame(tick);
    };
    raf = requestAnimationFrame(tick);

    const ready = Promise.all([
      document.fonts?.ready ?? Promise.resolve(),
      document.readyState === "complete"
        ? Promise.resolve()
        : new Promise<void>((r) => window.addEventListener("load", () => r(), { once: true })),
    ]);

    const minTimer = setTimeout(() => ready.then(finish), MIN);
    const maxTimer = setTimeout(finish, MAX);

    return () => {
      cancelAnimationFrame(raf);
      clearTimeout(minTimer);
      clearTimeout(maxTimer);
    };
  }, []);

  if (!mounted) return null;

  return (
    <AnimatePresence>
      {!done && (
        <motion.div
          className="grain fixed inset-0 z-[300] flex flex-col items-center justify-center bg-invert text-on-invert"
          initial={{ opacity: 1 }}
          exit={{ opacity: 0 }}
          transition={{ duration: 0.5, ease: [0.22, 1, 0.36, 1] }}
        >
          <div
            aria-hidden
            className="pointer-events-none absolute h-72 w-72 rounded-full bg-accent/20 blur-[100px]"
          />

          <motion.div
            initial={{ clipPath: "inset(100% 0 0 0)" }}
            animate={{ clipPath: "inset(0% 0 0 0)" }}
            transition={{ duration: 0.7, ease: [0.22, 1, 0.36, 1] }}
            className="relative overflow-hidden"
          >
            <p className="font-display text-4xl tracking-tight md:text-5xl">Meridian</p>
          </motion.div>

          <div className="relative mt-8 h-px w-40 bg-on-invert/20">
            <motion.div
              className="h-full bg-accent"
              animate={{ width: `${progress}%` }}
              transition={{ duration: 0.3, ease: "linear" }}
            />
          </div>
          <p className="relative mt-4 font-body text-xs tracking-[0.2em] text-on-invert-muted">
            {progress.toString().padStart(3, "0")}%
          </p>
        </motion.div>
      )}
    </AnimatePresence>
  );
}
