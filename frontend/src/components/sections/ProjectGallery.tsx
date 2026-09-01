"use client";

import { useEffect, useState } from "react";
import { AnimatePresence, motion } from "framer-motion";
import SmartImage from "@/components/ui/SmartImage";
import FadeUp from "@/components/animations/FadeUp";
import { ChevronLeft, ChevronRight, X, ZoomIn } from "lucide-react";

/**
 * Gallery grid that opens a keyboard- and swipe-friendly lightbox — clicking
 * any photo is a real, working interaction, not a static picture wall.
 */
export default function ProjectGallery({
  images,
  alt,
}: {
  images: string[];
  alt: string;
}) {
  const [open, setOpen] = useState<number | null>(null);

  useEffect(() => {
    if (open === null) return;
    const onKey = (e: KeyboardEvent) => {
      if (e.key === "Escape") setOpen(null);
      if (e.key === "ArrowRight") setOpen((i) => (i === null ? i : (i + 1) % images.length));
      if (e.key === "ArrowLeft")
        setOpen((i) => (i === null ? i : (i - 1 + images.length) % images.length));
    };
    window.addEventListener("keydown", onKey);
    document.body.style.overflow = "hidden";
    return () => {
      window.removeEventListener("keydown", onKey);
      document.body.style.overflow = "";
    };
  }, [open, images.length]);

  return (
    <>
      <div className="grid grid-cols-2 gap-4 sm:gap-8 sm:grid-cols-3">
        {images.map((img, i) => (
          <FadeUp key={img + i} delay={i * 0.08} className={i === 0 ? "col-span-2 sm:col-span-3" : ""}>
            <button
              onClick={() => setOpen(i)}
              aria-label={`Open photo ${i + 1} of ${images.length}`}
              className={`group relative block w-full overflow-hidden rounded-xl ${
                i === 0 ? "aspect-[16/9]" : "aspect-[4/5]"
              }`}
            >
              <SmartImage
                src={img}
                alt={`${alt} gallery image ${i + 1}`}
                fill
                preload={i === 0}
                sizes="(min-width: 1024px) 45vw, 90vw"
                className="object-cover transition-transform duration-700 ease-[cubic-bezier(0.22,1,0.36,1)] group-hover:scale-105"
              />
              <div className="absolute inset-0 flex items-center justify-center bg-black/0 transition-colors duration-300 group-hover:bg-black/25">
                <ZoomIn
                  size={22}
                  className="scale-75 text-white opacity-0 transition-all duration-300 group-hover:scale-100 group-hover:opacity-100"
                />
              </div>
            </button>
          </FadeUp>
        ))}
      </div>

      <AnimatePresence>
        {open !== null && (
          <motion.div
            initial={{ opacity: 0 }}
            animate={{ opacity: 1 }}
            exit={{ opacity: 0 }}
            transition={{ duration: 0.3 }}
            className="fixed inset-0 z-[200] flex items-center justify-center bg-black/90 p-4 backdrop-blur-sm"
            onClick={() => setOpen(null)}
          >
            <button
              onClick={() => setOpen(null)}
              aria-label="Close gallery"
              className="absolute right-5 top-5 flex h-11 w-11 items-center justify-center rounded-full border border-white/20 text-white transition-colors hover:border-white hover:bg-white/10"
            >
              <X size={18} />
            </button>

            <button
              onClick={(e) => {
                e.stopPropagation();
                setOpen((i) => (i === null ? i : (i - 1 + images.length) % images.length));
              }}
              aria-label="Previous photo"
              className="absolute left-3 top-1/2 flex h-11 w-11 -translate-y-1/2 items-center justify-center rounded-full border border-white/20 text-white transition-colors hover:border-white hover:bg-white/10 sm:left-6"
            >
              <ChevronLeft size={20} />
            </button>
            <button
              onClick={(e) => {
                e.stopPropagation();
                setOpen((i) => (i === null ? i : (i + 1) % images.length));
              }}
              aria-label="Next photo"
              className="absolute right-3 top-1/2 flex h-11 w-11 -translate-y-1/2 items-center justify-center rounded-full border border-white/20 text-white transition-colors hover:border-white hover:bg-white/10 sm:right-6"
            >
              <ChevronRight size={20} />
            </button>

            <motion.div
              key={open}
              initial={{ opacity: 0, scale: 0.96 }}
              animate={{ opacity: 1, scale: 1 }}
              transition={{ duration: 0.35, ease: [0.22, 1, 0.36, 1] }}
              onClick={(e) => e.stopPropagation()}
              className="relative h-[75vh] w-full max-w-5xl"
            >
              <SmartImage
                src={images[open]}
                alt={`${alt} — photo ${open + 1}`}
                fill
                sizes="90vw"
                className="object-contain"
              />
            </motion.div>

            <span className="absolute bottom-5 left-1/2 -translate-x-1/2 text-xs tracking-[0.14em] text-white/60">
              {open + 1} / {images.length}
            </span>
          </motion.div>
        )}
      </AnimatePresence>
    </>
  );
}
