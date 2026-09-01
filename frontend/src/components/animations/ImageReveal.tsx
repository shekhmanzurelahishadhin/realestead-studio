"use client";

import { motion } from "framer-motion";
import Image from "next/image";
import useInViewOnce from "@/hooks/useInViewOnce";

export default function ImageReveal({
  src,
  alt,
  className,
  sizes = "100vw",
  preload = false,
}: {
  src: string;
  alt: string;
  className?: string;
  sizes?: string;
  preload?: boolean;
}) {
  const { ref, inView } = useInViewOnce<HTMLDivElement>();

  return (
    <div ref={ref} className={`relative overflow-hidden ${className ?? ""}`}>
      <motion.div
        className="absolute inset-0 z-10 origin-left bg-canvas"
        initial={{ scaleX: 1 }}
        animate={inView ? { scaleX: 0 } : { scaleX: 1 }}
        transition={{ duration: 1, ease: [0.76, 0, 0.24, 1] }}
      />
      <motion.div
        className="relative h-full w-full"
        initial={{ scale: 1.25 }}
        animate={inView ? { scale: 1 } : { scale: 1.25 }}
        transition={{ duration: 1.2, ease: [0.22, 1, 0.36, 1] }}
      >
        <Image src={src} alt={alt} fill sizes={sizes} preload={preload} className="object-cover" />
      </motion.div>
    </div>
  );
}
