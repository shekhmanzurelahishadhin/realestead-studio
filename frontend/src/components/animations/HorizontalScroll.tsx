"use client";

import { useEffect, useRef, ReactNode } from "react";
import gsap from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";

/**
 * Desktop: GSAP pins the section and scrubs the track horizontally as the
 * page scrolls. Mobile/tablet: that pin-and-scrub trick fights native touch
 * scrolling, so instead the track is left as a plain horizontal
 * scroll-snap strip the visitor swipes through directly.
 */
export default function HorizontalScroll({ children }: { children: ReactNode }) {
  const sectionRef = useRef<HTMLDivElement>(null);
  const trackRef = useRef<HTMLDivElement>(null);

  useEffect(() => {
    gsap.registerPlugin(ScrollTrigger);

    const reduceMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;
    const isDesktop = window.matchMedia("(min-width: 768px)").matches;

    if (reduceMotion || !isDesktop) return;

    const section = sectionRef.current;
    const track = trackRef.current;
    if (!section || !track) return;

    // Pin just below the fixed navbar, not flush with the viewport top —
    // otherwise the navbar sits over the pinned strip and clips it for the
    // whole time this section is pinned.
    const navHeight = document.querySelector("header")?.getBoundingClientRect().height ?? 0;

    const ctx = gsap.context(() => {
      // Read the scroll distance live rather than once at setup time — on
      // first mount the track can still be mid-layout (fonts/images not
      // settled yet), which would otherwise freeze in a stale, too-small
      // measurement and silently skip pinning for the rest of the page's life.
      const getDistance = () => Math.max(0, track.scrollWidth - section.clientWidth);

      gsap.to(track, {
        x: () => -getDistance(),
        ease: "none",
        scrollTrigger: {
          trigger: section,
          start: `top ${navHeight}px`,
          end: () => `+=${getDistance()}`,
          scrub: 1,
          pin: true,
          anticipatePin: 1,
          invalidateOnRefresh: true,
        },
      });

      // Re-measure once everything (webfonts, images) has actually settled —
      // covers the case where the first ScrollTrigger.refresh() ran too early.
      const refresh = () => ScrollTrigger.refresh();
      window.addEventListener("load", refresh);
      document.fonts?.ready?.then(refresh);
      const imgs = Array.from(track.querySelectorAll("img"));
      imgs.forEach((img) => {
        if (!img.complete) img.addEventListener("load", refresh, { once: true });
      });
    }, section);

    return () => ctx.revert();
  }, []);

  return (
    <div ref={sectionRef} className="relative overflow-hidden">
      <div
        ref={trackRef}
        className="flex w-max snap-x snap-mandatory overflow-x-auto scroll-smooth [-webkit-overflow-scrolling:touch] [scrollbar-width:none] will-change-transform [&::-webkit-scrollbar]:hidden md:snap-none md:overflow-visible"
      >
        {children}
      </div>
    </div>
  );
}
