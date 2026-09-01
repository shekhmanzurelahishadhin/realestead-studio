"use client";

import { useState } from "react";
import Image, { ImageProps } from "next/image";
import clsx from "clsx";

/**
 * Wraps next/image with a shimmering placeholder that cross-fades into the
 * real photo once it decodes. On a slow connection this keeps the layout
 * feeling alive instead of a blank tile, without changing what actually
 * downloads — the "faster" here is entirely perceptual.
 */
export default function SmartImage({
  className,
  onLoad,
  quality = 60,
  alt,
  ...props
}: ImageProps) {
  const [loaded, setLoaded] = useState(false);

  return (
    <>
      <div
        aria-hidden
        className={clsx(
          "absolute inset-0 bg-gradient-to-br from-surface via-card to-surface bg-[length:200%_200%] transition-opacity duration-500",
          loaded ? "opacity-0" : "animate-[shimmer_1.8s_ease-in-out_infinite] opacity-100"
        )}
      />
      <Image
        {...props}
        alt={alt}
        quality={quality}
        onLoad={(e) => {
          setLoaded(true);
          onLoad?.(e);
        }}
        className={clsx(
          "transition-opacity duration-700",
          loaded ? "opacity-100" : "opacity-0",
          className
        )}
      />
    </>
  );
}
