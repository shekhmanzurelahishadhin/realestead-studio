"use client";

import { useEffect, useState } from "react";
import useInViewOnce from "@/hooks/useInViewOnce";

export default function Counter({
  value,
  suffix = "",
  duration = 1.6,
  decimals,
}: {
  value: number;
  suffix?: string;
  duration?: number;
  decimals?: number;
}) {
  const { ref, inView } = useInViewOnce<HTMLSpanElement>();
  const [display, setDisplay] = useState(0);

  const places = decimals ?? (value % 1 !== 0 ? 1 : 0);

  useEffect(() => {
    if (!inView) return;
    const start = performance.now();
    let raf: number;

    const tick = (now: number) => {
      const t = Math.min(1, (now - start) / (duration * 1000));
      const eased = 1 - Math.pow(1 - t, 3);
      setDisplay(value * eased);
      if (t < 1) raf = requestAnimationFrame(tick);
    };
    raf = requestAnimationFrame(tick);
    return () => cancelAnimationFrame(raf);
  }, [inView, value, duration]);

  return (
    <span ref={ref}>
      {display.toFixed(places)}
      {suffix}
    </span>
  );
}
