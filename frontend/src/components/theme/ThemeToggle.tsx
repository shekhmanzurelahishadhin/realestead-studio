"use client";

import { motion } from "framer-motion";
import { Moon, Sun } from "lucide-react";
import clsx from "clsx";
import { useTheme } from "./ThemeProvider";

/**
 * Sliding day/night switch. The knob animates between the two ends and the
 * icons cross-fade, so the state is readable at a glance in both themes.
 */
export default function ThemeToggle({
  className,
  onDark = false,
}: {
  /** Extra classes for the track. */
  className?: string;
  /** Force the light-on-dark styling (e.g. over the transparent hero). */
  onDark?: boolean;
}) {
  const { theme, toggle } = useTheme();
  const isDark = theme === "dark";

  return (
    <button
      type="button"
      onClick={toggle}
      role="switch"
      aria-checked={isDark}
      aria-label={`Switch to ${isDark ? "light" : "dark"} mode`}
      title={`Switch to ${isDark ? "light" : "dark"} mode`}
      data-cursor={isDark ? "LIGHT" : "DARK"}
      className={clsx(
        "relative inline-flex h-9 w-[62px] shrink-0 items-center rounded-full border p-1 transition-colors duration-500",
        onDark
          ? "border-on-invert/30 bg-on-invert/10 hover:border-on-invert/60"
          : "border-line bg-surface hover:border-accent/50",
        className
      )}
    >
      {/* Sliding knob */}
      <motion.span
        aria-hidden
        layout
        transition={{ type: "spring", stiffness: 500, damping: 34, mass: 0.6 }}
        className={clsx(
          "flex h-7 w-7 items-center justify-center rounded-full shadow-sm",
          isDark ? "ml-auto bg-accent text-accent-contrast" : "mr-auto bg-fg text-canvas"
        )}
      >
        <motion.span
          key={theme}
          initial={{ rotate: -90, opacity: 0, scale: 0.6 }}
          animate={{ rotate: 0, opacity: 1, scale: 1 }}
          transition={{ duration: 0.35, ease: [0.22, 1, 0.36, 1] }}
          className="flex items-center justify-center"
        >
          {isDark ? <Moon size={14} strokeWidth={2} /> : <Sun size={14} strokeWidth={2} />}
        </motion.span>
      </motion.span>

      {/* Ghost icon on the empty side, for affordance */}
      <span
        aria-hidden
        className={clsx(
          "pointer-events-none absolute flex h-7 w-7 items-center justify-center opacity-40",
          isDark ? "left-1" : "right-1",
          onDark ? "text-on-invert" : "text-muted"
        )}
      >
        {isDark ? <Sun size={13} strokeWidth={2} /> : <Moon size={13} strokeWidth={2} />}
      </span>
    </button>
  );
}
