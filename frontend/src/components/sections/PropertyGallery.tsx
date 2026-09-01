"use client";

import { useState } from "react";
import { AnimatePresence, motion } from "framer-motion";
import SmartImage from "@/components/ui/SmartImage";
import clsx from "clsx";
import { Expand } from "lucide-react";

/**
 * Main photo + thumbnail strip. Clicking a thumbnail swaps the main image
 * with a crossfade — the gallery is a real interactive element, not a
 * static grid of pictures.
 */
export default function PropertyGallery({
  images,
  alt,
}: {
  images: string[];
  alt: string;
}) {
  const [active, setActive] = useState(0);

  return (
    <div>
      <div className="relative aspect-[4/3] overflow-hidden rounded-2xl bg-invert-soft">
        <AnimatePresence mode="wait">
          <motion.div
            key={active}
            initial={{ opacity: 0, scale: 1.03 }}
            animate={{ opacity: 1, scale: 1 }}
            exit={{ opacity: 0 }}
            transition={{ duration: 0.45, ease: [0.22, 1, 0.36, 1] }}
            className="absolute inset-0"
          >
            <SmartImage
              src={images[active]}
              alt={`${alt} — photo ${active + 1}`}
              fill
              preload={active === 0}
              sizes="(min-width: 1024px) 55vw, 100vw"
              className="object-cover"
            />
          </motion.div>
        </AnimatePresence>

        <span className="absolute bottom-4 right-4 flex items-center gap-1.5 rounded-full bg-canvas/90 px-3 py-1.5 text-xs font-medium text-fg backdrop-blur-sm">
          <Expand size={13} /> {active + 1} / {images.length}
        </span>
      </div>

      {images.length > 1 && (
        <div className="mt-4 grid grid-cols-3 gap-4 sm:grid-cols-4">
          {images.map((img, i) => (
            <button
              key={img + i}
              onClick={() => setActive(i)}
              aria-label={`View photo ${i + 1}`}
              aria-current={active === i}
              className={clsx(
                "relative aspect-square overflow-hidden rounded-lg bg-invert-soft ring-2 ring-offset-2 ring-offset-canvas transition-all duration-300",
                active === i ? "ring-accent" : "ring-transparent hover:ring-line-strong"
              )}
            >
              <SmartImage
                src={img}
                alt={`${alt} thumbnail ${i + 1}`}
                fill
                sizes="120px"
                className={clsx(
                  "object-cover transition-opacity duration-300",
                  active === i ? "opacity-100" : "opacity-70 hover:opacity-100"
                )}
              />
            </button>
          ))}
        </div>
      )}
    </div>
  );
}
