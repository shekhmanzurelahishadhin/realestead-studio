"use client";

import { useEffect, useRef, useState } from "react";
import Image from "next/image";
import Link from "next/link";
import { motion, useScroll, useTransform } from "framer-motion";
import RevealText from "@/components/animations/RevealText";
import MagneticButton from "@/components/animations/MagneticButton";
import { ArrowUpRight, ChevronDown } from "lucide-react";

const marks = [
  { value: "25+", label: "Years" },
  { value: "120+", label: "Projects" },
  { value: "18", label: "Cities" },
];

export default function Hero({
  posterUrl,
  videoUrl,
  tagline,
}: {
  posterUrl: string;
  /**
   * Ambient background clip, layered over the poster once the page is idle.
   * The poster image is what actually renders first and counts as the LCP —
   * the video loads only after idle, on desktop, on a fast connection, and
   * never under prefers-reduced-motion, so it can never slow down first
   * paint. If it fails to load for any reason the poster simply stays put.
   */
  videoUrl: string | null;
  tagline?: string | null;
}) {
  const ref = useRef<HTMLDivElement>(null);
  const { scrollYProgress } = useScroll({
    target: ref,
    offset: ["start start", "end start"],
  });

  const imageScale = useTransform(scrollYProgress, [0, 1], [1, 1.18]);
  const imageY = useTransform(scrollYProgress, [0, 1], ["0%", "12%"]);
  const overlayOpacity = useTransform(scrollYProgress, [0, 1], [0.4, 0.78]);
  const contentOpacity = useTransform(scrollYProgress, [0, 0.6], [1, 0]);
  const contentY = useTransform(scrollYProgress, [0, 1], ["0%", "18%"]);

  const [showVideo, setShowVideo] = useState(false);
  const [videoReady, setVideoReady] = useState(false);
  const [videoFailed, setVideoFailed] = useState(false);

  useEffect(() => {
    // Skip the clip on small screens, slow links, and reduced-motion setups.
    if (!videoUrl) return;
    if (window.matchMedia("(max-width: 767px)").matches) return;
    if (window.matchMedia("(prefers-reduced-motion: reduce)").matches) return;

    const conn = (
      navigator as Navigator & { connection?: { saveData?: boolean; effectiveType?: string } }
    ).connection;
    if (conn?.saveData) return;
    if (conn?.effectiveType && !["4g"].includes(conn.effectiveType)) return;

    // A plain timeout rather than requestIdleCallback — reliable and still
    // well clear of first paint / LCP, without depending on the main thread
    // actually going idle (which a busy page may never report).
    const id = window.setTimeout(() => setShowVideo(true), 800);
    return () => window.clearTimeout(id);
  }, [videoUrl]);

  return (
    <section
      ref={ref}
      className="grain relative h-[100svh] min-h-[640px] w-full overflow-hidden bg-invert"
    >
      {/* Poster image — the LCP element, preloaded */}
      <motion.div style={{ scale: imageScale, y: imageY }} className="absolute inset-0">
        <Image
          src={posterUrl}
          alt="Modern architectural building against the sky"
          fill
          preload
          fetchPriority="high"
          sizes="100vw"
          className="object-cover"
        />

        {showVideo && videoUrl && !videoFailed && (
          <video
            src={videoUrl}
            poster={posterUrl}
            autoPlay
            muted
            loop
            playsInline
            preload="none"
            aria-hidden
            onCanPlay={() => setVideoReady(true)}
            onError={() => setVideoFailed(true)}
            className={`absolute inset-0 h-full w-full object-cover transition-opacity duration-[1200ms] ${
              videoReady ? "opacity-100" : "opacity-0"
            }`}
          />
        )}
      </motion.div>

      {/* Scrims: flat darkening + a bottom gradient so text always reads */}
      <motion.div style={{ opacity: overlayOpacity }} className="absolute inset-0 bg-black" />
      <div className="pointer-events-none absolute inset-0 bg-gradient-to-t from-black via-transparent to-black/50" />
      <div
        aria-hidden
        className="animate-glow-drift pointer-events-none absolute -left-32 bottom-0 h-[28rem] w-[28rem] rounded-full bg-accent/20 blur-[120px]"
      />

      <motion.div
        style={{ opacity: contentOpacity, y: contentY }}
        className="relative z-10 flex h-full flex-col justify-end"
      >
        <div className="container-x pb-14 md:pb-16">
          <motion.div
            initial={{ opacity: 0 }}
            animate={{ opacity: 1 }}
            transition={{ duration: 0.8 }}
            className="mb-6 flex items-center gap-3"
          >
            <motion.span
              initial={{ scaleX: 0 }}
              animate={{ scaleX: 1 }}
              transition={{ duration: 0.9, ease: [0.22, 1, 0.36, 1] }}
              className="h-px w-10 origin-left bg-accent-soft"
            />
            <p className="text-xs font-medium tracking-[0.18em] text-on-invert/70">
              {tagline ?? "Real Estate & Construction Studio · Est. 2000"}
            </p>
          </motion.div>

          <RevealText
            as="h1"
            text="We build spaces that define the future."
            className="max-w-4xl font-display text-[13vw] leading-[0.98] tracking-tight text-on-invert sm:text-[9vw] md:text-[6.4vw] lg:text-[5.6vw]"
            stagger={0.045}
          />

          <div className="mt-9 flex flex-col items-start justify-between gap-8 md:flex-row md:items-end">
            <motion.p
              initial={{ opacity: 0, y: 16 }}
              animate={{ opacity: 1, y: 0 }}
              transition={{ delay: 0.9, duration: 0.8, ease: [0.22, 1, 0.36, 1] }}
              className="max-w-md text-base leading-relaxed text-on-invert/75"
            >
              Meridian designs, develops and constructs residential, commercial
              and mixed-use projects across Bangladesh &mdash; from first sketch
              to final handover.
            </motion.p>

            <motion.div
              initial={{ opacity: 0, y: 16 }}
              animate={{ opacity: 1, y: 0 }}
              transition={{ delay: 1.05, duration: 0.8, ease: [0.22, 1, 0.36, 1] }}
              className="flex shrink-0 gap-4"
            >
              <MagneticButton>
                <Link
                  href="/projects"
                  data-cursor="EXPLORE"
                  className="group inline-flex items-center gap-2.5 rounded-full bg-on-invert px-6 py-3.5 text-sm font-medium text-invert transition-colors duration-300 hover:bg-accent hover:text-accent-contrast"
                >
                  View Projects
                  <ArrowUpRight
                    size={16}
                    className="transition-transform duration-300 group-hover:translate-x-0.5 group-hover:-translate-y-0.5"
                  />
                </Link>
              </MagneticButton>
              <MagneticButton>
                <Link
                  href="/contact"
                  className="inline-flex items-center gap-2.5 rounded-full border border-on-invert/30 px-6 py-3.5 text-sm font-medium text-on-invert backdrop-blur-sm transition-colors duration-300 hover:border-on-invert hover:bg-on-invert/10"
                >
                  Start a Project
                </Link>
              </MagneticButton>
            </motion.div>
          </div>
        </div>

        {/* Bottom rail: scroll cue + quick marks */}
        <motion.div
          initial={{ opacity: 0 }}
          animate={{ opacity: 1 }}
          transition={{ delay: 1.3, duration: 0.8 }}
          className="border-t border-on-invert/15"
        >
          <div className="container-x flex items-center justify-between py-5">
            <div className="flex items-center gap-3 text-on-invert/60">
              <motion.div
                animate={{ y: [0, 6, 0] }}
                transition={{ repeat: Infinity, duration: 1.8, ease: "easeInOut" }}
              >
                <ChevronDown size={16} />
              </motion.div>
              <span className="text-xs tracking-[0.18em]">SCROLL</span>
            </div>

            <div className="flex items-center gap-8 sm:gap-12">
              {marks.map((m) => (
                <div key={m.label} className="text-right">
                  <p className="font-display text-xl text-on-invert sm:text-2xl">{m.value}</p>
                  <p className="text-[10px] tracking-[0.16em] text-on-invert-muted">
                    {m.label.toUpperCase()}
                  </p>
                </div>
              ))}
            </div>
          </div>
        </motion.div>
      </motion.div>
    </section>
  );
}
