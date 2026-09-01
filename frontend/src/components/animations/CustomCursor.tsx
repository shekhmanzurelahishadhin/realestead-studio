"use client";

import { useEffect, useRef, useState } from "react";

export default function CustomCursor() {
  const dotRef = useRef<HTMLDivElement>(null);
  const ringRef = useRef<HTMLDivElement>(null);
  const [label, setLabel] = useState("");
  const [active, setActive] = useState(false);

  useEffect(() => {
    if (window.matchMedia("(pointer: coarse)").matches) return;

    const pos = { x: 0, y: 0 };
    const ring = { x: 0, y: 0 };

    const onMove = (e: MouseEvent) => {
      pos.x = e.clientX;
      pos.y = e.clientY;
      if (dotRef.current) {
        dotRef.current.style.transform = `translate(${pos.x}px, ${pos.y}px) translate(-50%, -50%)`;
      }
    };

    let raf: number;
    const tick = () => {
      ring.x += (pos.x - ring.x) * 0.18;
      ring.y += (pos.y - ring.y) * 0.18;
      if (ringRef.current) {
        ringRef.current.style.transform = `translate(${ring.x}px, ${ring.y}px) translate(-50%, -50%)`;
      }
      raf = requestAnimationFrame(tick);
    };

    const onOver = (e: MouseEvent) => {
      const target = (e.target as HTMLElement)?.closest("[data-cursor]");
      if (target) {
        setActive(true);
        setLabel(target.getAttribute("data-cursor") || "");
      } else {
        setActive(false);
        setLabel("");
      }
    };

    window.addEventListener("mousemove", onMove);
    window.addEventListener("mouseover", onOver);
    raf = requestAnimationFrame(tick);

    return () => {
      window.removeEventListener("mousemove", onMove);
      window.removeEventListener("mouseover", onOver);
      cancelAnimationFrame(raf);
    };
  }, []);

  return (
    <>
      <div ref={dotRef} className="cursor-dot" />
      <div
        ref={ringRef}
        className="cursor-ring flex items-center justify-center text-center"
        style={{
          width: active ? 88 : 44,
          height: active ? 88 : 44,
          background: active ? "var(--accent)" : "transparent",
          borderColor: active ? "var(--accent)" : "var(--fg)",
        }}
      >
        {active && label && (
          <span className="font-body text-[10px] font-medium uppercase leading-tight tracking-[0.12em] text-accent-contrast">
            {label}
          </span>
        )}
      </div>
    </>
  );
}
