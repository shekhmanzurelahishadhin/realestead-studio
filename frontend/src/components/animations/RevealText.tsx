"use client";

import { motion } from "framer-motion";
import useInViewOnce from "@/hooks/useInViewOnce";

export default function RevealText({
  text,
  className,
  as: Tag = "h2",
  delay = 0,
  stagger = 0.05,
}: {
  text: string;
  className?: string;
  as?: "h1" | "h2" | "h3" | "p";
  delay?: number;
  stagger?: number;
}) {
  const words = text.split(" ");
  const { ref, inView } = useInViewOnce<HTMLElement>();

  return (
    <Tag ref={ref as React.RefObject<HTMLHeadingElement & HTMLParagraphElement>} className={className}>
      <span className="sr-only">{text}</span>
      <span aria-hidden className="inline">
        {words.map((word, i) => (
          <span key={i} className="inline-block overflow-hidden align-top pb-[0.08em]">
            <motion.span
              className="inline-block"
              initial={{ y: "110%" }}
              animate={inView ? { y: "0%" } : { y: "110%" }}
              transition={{
                duration: 0.85,
                delay: delay + i * stagger,
                ease: [0.22, 1, 0.36, 1],
              }}
            >
              {word}
              {i < words.length - 1 ? " " : ""}
            </motion.span>
          </span>
        ))}
      </span>
    </Tag>
  );
}
