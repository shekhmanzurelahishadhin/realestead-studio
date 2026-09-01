import Link from "next/link";
import { Mail, MapPin, Phone } from "lucide-react";

/**
 * Brand marks are drawn inline — lucide dropped its brand icon set, and these
 * add no dependency and no extra request.
 */
function InstagramMark(props: React.SVGProps<SVGSVGElement>) {
  return (
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1.7" strokeLinecap="round" {...props}>
      <rect x="2.5" y="2.5" width="19" height="19" rx="5.5" />
      <circle cx="12" cy="12" r="4.2" />
      <circle cx="17.6" cy="6.4" r="1.1" fill="currentColor" stroke="none" />
    </svg>
  );
}

function LinkedinMark(props: React.SVGProps<SVGSVGElement>) {
  return (
    <svg viewBox="0 0 24 24" fill="currentColor" {...props}>
      <path d="M4.98 3.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5ZM3 9.5h4v11H3v-11Zm6.5 0h3.8v1.5a4.2 4.2 0 0 1 3.7-2c3 0 4 2 4 5v6.5h-4V15c0-1.6-.6-2.6-2-2.6s-2.3 1-2.3 2.6v5.5h-3.2v-11Z" />
    </svg>
  );
}

function FacebookMark(props: React.SVGProps<SVGSVGElement>) {
  return (
    <svg viewBox="0 0 24 24" fill="currentColor" {...props}>
      <path d="M13.5 21v-8h2.7l.4-3.1h-3.1V7.9c0-.9.25-1.5 1.55-1.5H16.7V3.6c-.3 0-1.3-.1-2.45-.1-2.4 0-4.05 1.5-4.05 4.2v2.2H7.5V13h2.7v8h3.3Z" />
    </svg>
  );
}

const columns = [
  {
    title: "Navigate",
    links: [
      { href: "/projects", label: "Projects" },
      { href: "/properties", label: "Properties" },
      { href: "/services", label: "Services" },
      { href: "/about", label: "About" },
    ],
  },
  {
    title: "Projects",
    links: [
      { href: "/projects/the-arcadia", label: "The Arcadia" },
      { href: "/projects/riverside-heights", label: "Riverside Heights" },
      { href: "/projects/the-grand-terrace", label: "The Grand Terrace" },
    ],
  },
];

const contact = [
  { href: "tel:+8801711000000", label: "+880 1711 000 000", icon: Phone },
  { href: "mailto:hello@meridian.studio", label: "hello@meridian.studio", icon: Mail },
  { href: "/contact", label: "House 14, Road 7, Gulshan 1, Dhaka", icon: MapPin },
];

const socials = [
  { href: "#", label: "Instagram", icon: InstagramMark },
  { href: "#", label: "LinkedIn", icon: LinkedinMark },
  { href: "#", label: "Facebook", icon: FacebookMark },
];

export default function Footer() {
  return (
    <footer className="border-t hairline bg-surface pt-20">
      <div className="container-x">
        <div className="grid grid-cols-1 gap-14 pb-16 md:grid-cols-[1.4fr_1fr_1fr_1.2fr]">
          <div>
            <div className="flex items-center gap-2.5">
              <span className="flex h-7 w-7 items-center justify-center rounded-full border hairline">
                <span className="h-2 w-2 rounded-full bg-accent" />
              </span>
              <p className="font-display text-3xl tracking-tight text-fg">Meridian</p>
            </div>
            <p className="mt-5 max-w-xs text-sm leading-relaxed text-muted">
              A real estate development and construction studio designing and
              building considered spaces across Bangladesh since 2000.
            </p>
            <div className="mt-7 flex gap-3">
              {socials.map((s) => (
                <a
                  key={s.label}
                  href={s.href}
                  aria-label={s.label}
                  className="flex h-10 w-10 items-center justify-center rounded-full border hairline text-fg-soft transition-colors duration-300 hover:border-accent hover:bg-accent hover:text-accent-contrast"
                >
                  <s.icon className="h-4 w-4" aria-hidden />
                </a>
              ))}
            </div>
          </div>

          {columns.map((col) => (
            <div key={col.title}>
              <p className="eyebrow">{col.title}</p>
              <ul className="mt-5 space-y-3">
                {col.links.map((link) => (
                  <li key={link.label}>
                    <Link
                      href={link.href}
                      className="link-underline text-sm text-fg-soft transition-colors hover:text-accent"
                    >
                      {link.label}
                    </Link>
                  </li>
                ))}
              </ul>
            </div>
          ))}

          <div>
            <p className="eyebrow">Contact</p>
            <ul className="mt-5 space-y-3">
              {contact.map((item) => (
                <li key={item.label}>
                  <Link
                    href={item.href}
                    className="group flex items-start gap-2.5 text-sm text-fg-soft transition-colors hover:text-accent"
                  >
                    <item.icon size={15} className="mt-0.5 shrink-0 text-accent" />
                    <span>{item.label}</span>
                  </Link>
                </li>
              ))}
            </ul>
          </div>
        </div>

        <div className="flex flex-col items-start justify-between gap-4 border-t hairline py-8 text-xs text-muted md:flex-row md:items-center">
          <p>© {new Date().getFullYear()} Meridian Development Ltd. All rights reserved.</p>
          <div className="flex gap-6">
            <Link href="/privacy" className="transition-colors hover:text-accent">
              Privacy
            </Link>
            <Link href="/terms" className="transition-colors hover:text-accent">
              Terms
            </Link>
          </div>
        </div>
      </div>
    </footer>
  );
}
