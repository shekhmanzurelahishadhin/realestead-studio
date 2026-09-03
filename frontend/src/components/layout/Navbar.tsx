"use client";

import { useEffect, useState } from "react";
import Link from "next/link";
import { usePathname } from "next/navigation";
import { motion, AnimatePresence, useScroll, useSpring } from "framer-motion";
import { ArrowUpRight, Menu, X } from "lucide-react";
import clsx from "clsx";
import Image from "next/image";
import ThemeToggle from "@/components/theme/ThemeToggle";
import { SiteSettings } from "@/types";

const links = [
  { href: "/projects", label: "Projects" },
  { href: "/properties", label: "Properties" },
  { href: "/services", label: "Services" },
  { href: "/about", label: "About" },
  { href: "/contact", label: "Contact" },
];

export default function Navbar({ settings }: { settings: SiteSettings }) {
  const [scrolled, setScrolled] = useState(false);
  const [open, setOpen] = useState(false);
  const pathname = usePathname();
  const isHome = pathname === "/";

  const { scrollYProgress } = useScroll();
  const progress = useSpring(scrollYProgress, { stiffness: 260, damping: 40, mass: 0.4 });

  useEffect(() => {
    const onScroll = () => setScrolled(window.scrollY > 40);
    onScroll();
    window.addEventListener("scroll", onScroll, { passive: true });
    return () => window.removeEventListener("scroll", onScroll);
  }, []);

  useEffect(() => {
    // Close the menu on route change. No render-time alternative exists here
    // since the menu is layout-level state, not tied to a remountable key.
    // eslint-disable-next-line react-hooks/set-state-in-effect
    setOpen(false);
  }, [pathname]);

  // Lock body scroll while the fullscreen menu is open.
  useEffect(() => {
    document.body.style.overflow = open ? "hidden" : "";
    return () => {
      document.body.style.overflow = "";
    };
  }, [open]);

  useEffect(() => {
    const onKey = (e: KeyboardEvent) => e.key === "Escape" && setOpen(false);
    window.addEventListener("keydown", onKey);
    return () => window.removeEventListener("keydown", onKey);
  }, []);

  /** Over the home hero image, before scrolling: light text on the photo. */
  const transparent = isHome && !scrolled && !open;
  /** Any dark backdrop behind the bar — the hero photo or the open menu. */
  const onDark = transparent || open;

  return (
    <>
      <header
        className={clsx(
          "fixed inset-x-0 top-0 z-[100] transition-[padding] duration-500",
          scrolled || !isHome || open ? "py-3" : "py-6"
        )}
      >
        <div
          className={clsx(
            "container-x flex items-center justify-between gap-6 transition-colors duration-500"
          )}
        >
          {/* Glass panel behind the bar once scrolled */}
          <div
            aria-hidden
            className={clsx(
              "absolute inset-0 -z-10 border-b transition-all duration-500",
              scrolled && !open
                ? "border-line bg-canvas/80 backdrop-blur-xl"
                : "border-transparent bg-transparent"
            )}
          />

          <Link
            href="/"
            aria-label={`${settings.siteName} — home`}
            className={clsx(
              "group relative z-[1] flex items-center gap-2.5 transition-colors duration-500",
              onDark ? "text-on-invert" : "text-fg"
            )}
          >
            {settings.logoImage ? (
              <Image
                src={settings.logoImage}
                alt={settings.siteName}
                width={28}
                height={28}
                className="h-7 w-7 shrink-0 rounded-full object-cover"
              />
            ) : (
              <span
                aria-hidden
                className="relative flex h-7 w-7 items-center justify-center overflow-hidden rounded-full border border-current/40"
              >
                <span className="h-2 w-2 rounded-full bg-accent transition-transform duration-500 group-hover:scale-[2.6]" />
              </span>
            )}
            <span className="font-display text-xl tracking-tight">{settings.siteName}</span>
          </Link>

          <nav className="hidden items-center gap-9 lg:flex">
            {links.map((link) => (
              <Link
                key={link.href}
                href={link.href}
                data-active={pathname.startsWith(link.href)}
                className={clsx(
                  "link-underline text-sm font-medium tracking-wide transition-colors duration-500",
                  transparent
                    ? "text-on-invert/85 hover:text-on-invert"
                    : "text-fg-soft hover:text-fg"
                )}
              >
                {link.label}
              </Link>
            ))}
          </nav>

          <div className="flex items-center gap-3">
            <ThemeToggle onDark={onDark} />

            <Link
              href="/contact"
              className={clsx(
                "group hidden items-center gap-2 rounded-full px-5 py-2.5 text-sm font-medium transition-colors duration-500 md:inline-flex",
                transparent
                  ? "bg-on-invert text-invert hover:bg-accent hover:text-accent-contrast"
                  : "bg-fg text-canvas hover:bg-accent hover:text-accent-contrast"
              )}
            >
              Let&apos;s Talk
              <ArrowUpRight
                size={15}
                className="transition-transform duration-300 group-hover:translate-x-0.5 group-hover:-translate-y-0.5"
              />
            </Link>

            <button
              aria-label={open ? "Close menu" : "Open menu"}
              aria-expanded={open}
              onClick={() => setOpen((v) => !v)}
              className={clsx(
                "relative z-[1] flex h-9 w-9 items-center justify-center rounded-full border transition-colors lg:hidden",
                onDark ? "border-on-invert/40 text-on-invert" : "border-line text-fg"
              )}
            >
              {open ? <X size={18} /> : <Menu size={18} />}
            </button>
          </div>
        </div>

        {/* Reading progress */}
        <motion.div
          aria-hidden
          style={{ scaleX: progress }}
          className={clsx(
            "absolute inset-x-0 bottom-0 h-px origin-left bg-accent transition-opacity duration-500",
            scrolled && !open ? "opacity-100" : "opacity-0"
          )}
        />
      </header>

      <AnimatePresence>
        {open && (
          <motion.div
            initial={{ clipPath: "inset(0 0 100% 0)" }}
            animate={{ clipPath: "inset(0 0 0% 0)" }}
            exit={{ clipPath: "inset(0 0 100% 0)" }}
            transition={{ duration: 0.6, ease: [0.76, 0, 0.24, 1] }}
            className="grain fixed inset-0 z-[90] flex flex-col justify-center bg-invert px-8"
          >
            {/* Ambient accent glow */}
            <div
              aria-hidden
              className="animate-glow-drift pointer-events-none absolute -right-24 top-1/4 h-72 w-72 rounded-full bg-accent/20 blur-[90px]"
            />

            <nav className="relative flex flex-col">
              {links.map((link, i) => (
                <motion.div
                  key={link.href}
                  initial={{ y: 44, opacity: 0 }}
                  animate={{ y: 0, opacity: 1 }}
                  transition={{
                    delay: 0.15 + i * 0.06,
                    duration: 0.6,
                    ease: [0.22, 1, 0.36, 1],
                  }}
                >
                  <Link
                    href={link.href}
                    className="group flex items-baseline gap-4 border-b border-on-invert/10 py-4 font-display text-4xl text-on-invert/90 transition-colors hover:text-accent-soft sm:text-5xl"
                  >
                    <span className="font-body text-xs tracking-[0.2em] text-on-invert-muted">
                      {String(i + 1).padStart(2, "0")}
                    </span>
                    <span className="transition-transform duration-500 group-hover:translate-x-2">
                      {link.label}
                    </span>
                  </Link>
                </motion.div>
              ))}
            </nav>

            <motion.div
              initial={{ opacity: 0 }}
              animate={{ opacity: 1 }}
              transition={{ delay: 0.5, duration: 0.6 }}
              className="relative mt-12 space-y-2 text-sm tracking-wide text-on-invert-muted"
            >
              {settings.address && <p>{settings.address}</p>}
              {settings.phone && <p>{settings.phone}</p>}
            </motion.div>
          </motion.div>
        )}
      </AnimatePresence>
    </>
  );
}
