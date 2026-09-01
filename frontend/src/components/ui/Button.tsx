import Link from "next/link";
import { ReactNode } from "react";
import { ArrowUpRight } from "lucide-react";
import clsx from "clsx";

export default function Button({
  href,
  children,
  variant = "primary",
  icon = true,
  className,
  cursorLabel,
}: {
  href: string;
  children: ReactNode;
  variant?: "primary" | "ghost" | "light" | "ghost-dark";
  icon?: boolean;
  className?: string;
  cursorLabel?: string;
}) {
  const base =
    "group relative inline-flex items-center gap-2.5 overflow-hidden rounded-full px-6 py-3.5 text-sm font-medium tracking-wide transition-colors duration-300";

  const styles = {
    primary: "bg-fg text-canvas hover:bg-accent hover:text-accent-contrast",
    ghost: "border border-line-strong text-fg hover:border-accent hover:text-accent",
    "ghost-dark":
      "border border-on-invert/30 text-on-invert hover:border-accent hover:text-accent-soft",
    light: "bg-on-invert text-invert hover:bg-accent hover:text-accent-contrast",
  };

  return (
    <Link
      href={href}
      data-cursor={cursorLabel}
      className={clsx(base, styles[variant], className)}
    >
      <span className="relative z-[2]">{children}</span>
      {icon && (
        <ArrowUpRight
          size={16}
          className="relative z-[2] transition-transform duration-300 group-hover:translate-x-0.5 group-hover:-translate-y-0.5"
        />
      )}
    </Link>
  );
}
