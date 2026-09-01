"use client";

import { createContext, useCallback, useContext, useEffect, useState } from "react";

export type Theme = "light" | "dark";

export const THEME_STORAGE_KEY = "meridian-theme";

type ThemeContextValue = {
  theme: Theme;
  toggle: () => void;
  setTheme: (theme: Theme) => void;
};

const ThemeContext = createContext<ThemeContextValue | null>(null);

/**
 * Inlined in <head> before paint so the correct theme class is on <html>
 * on the very first frame — no flash of the wrong theme.
 */
export const themeInitScript = `(function(){try{var s=localStorage.getItem("${THEME_STORAGE_KEY}");var t=s==="light"||s==="dark"?s:(window.matchMedia("(prefers-color-scheme: dark)").matches?"dark":"light");var e=document.documentElement;e.classList.toggle("dark",t==="dark");e.style.colorScheme=t;e.dataset.theme=t;}catch(_){}})();`;

function applyTheme(theme: Theme) {
  const el = document.documentElement;
  el.classList.toggle("dark", theme === "dark");
  el.style.colorScheme = theme;
  el.dataset.theme = theme;
}

export default function ThemeProvider({ children }: { children: React.ReactNode }) {
  // Seeded from the DOM, which the init script already set correctly.
  const [theme, setThemeState] = useState<Theme>("light");

  useEffect(() => {
    // Reads the class the inline init script already applied pre-paint —
    // this only syncs React state to match, it never changes the theme.
    // eslint-disable-next-line react-hooks/set-state-in-effect
    setThemeState(document.documentElement.classList.contains("dark") ? "dark" : "light");
  }, []);

  // Follow the OS only while the visitor hasn't made an explicit choice.
  useEffect(() => {
    const mq = window.matchMedia("(prefers-color-scheme: dark)");
    const onChange = (e: MediaQueryListEvent) => {
      if (localStorage.getItem(THEME_STORAGE_KEY)) return;
      const next: Theme = e.matches ? "dark" : "light";
      applyTheme(next);
      setThemeState(next);
    };
    mq.addEventListener("change", onChange);
    return () => mq.removeEventListener("change", onChange);
  }, []);

  const setTheme = useCallback((next: Theme) => {
    applyTheme(next);
    setThemeState(next);
    try {
      localStorage.setItem(THEME_STORAGE_KEY, next);
    } catch {
      /* storage blocked — the theme still applies for this session */
    }
  }, []);

  const toggle = useCallback(() => {
    setTheme(document.documentElement.classList.contains("dark") ? "light" : "dark");
  }, [setTheme]);

  return (
    <ThemeContext.Provider value={{ theme, toggle, setTheme }}>
      {children}
    </ThemeContext.Provider>
  );
}

export function useTheme() {
  const ctx = useContext(ThemeContext);
  if (!ctx) throw new Error("useTheme must be used inside <ThemeProvider>");
  return ctx;
}
