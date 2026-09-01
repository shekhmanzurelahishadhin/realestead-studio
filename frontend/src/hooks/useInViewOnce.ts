"use client";

import { useEffect, useRef, useState } from "react";

/**
 * Fires once, the first time the element scrolls into view.
 *
 * We drive reveals from this rather than Framer Motion's `whileInView`,
 * which does not fire in the installed motion build. Using `animate` with
 * a plain IntersectionObserver is both reliable and version-independent.
 *
 * Falls back to visible when IntersectionObserver is unavailable, so content
 * is never left hidden.
 */
export default function useInViewOnce<T extends HTMLElement>(
  rootMargin = "0px 0px -10% 0px"
) {
  const ref = useRef<T>(null);
  const [inView, setInView] = useState(false);

  useEffect(() => {
    const el = ref.current;
    if (!el) return;

    if (typeof IntersectionObserver === "undefined") {
      // No IntersectionObserver support — reveal immediately rather than
      // leave content permanently hidden. Deferred a tick so this doesn't
      // synchronously set state from inside the effect body.
      const id = requestAnimationFrame(() => setInView(true));
      return () => cancelAnimationFrame(id);
    }

    const observer = new IntersectionObserver(
      ([entry]) => {
        if (entry.isIntersecting) {
          setInView(true);
          observer.disconnect();
        }
      },
      { threshold: 0, rootMargin }
    );

    observer.observe(el);
    return () => observer.disconnect();
  }, [rootMargin]);

  return { ref, inView };
}
