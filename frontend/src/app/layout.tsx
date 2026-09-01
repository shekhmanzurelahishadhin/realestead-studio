import type { Metadata, Viewport } from "next";
import { Space_Grotesk, Inter } from "next/font/google";
import "./globals.css";
import Navbar from "@/components/layout/Navbar";
import Footer from "@/components/layout/Footer";
import CustomCursor from "@/components/animations/CustomCursor";
import SmoothLoader from "@/components/animations/SmoothLoader";
import ThemeProvider, { themeInitScript } from "@/components/theme/ThemeProvider";
import BackToTop from "@/components/ui/BackToTop";

const spaceGrotesk = Space_Grotesk({
  subsets: ["latin"],
  variable: "--font-display-raw",
  weight: ["500", "600", "700"],
  display: "swap",
  preload: true,
});

const inter = Inter({
  subsets: ["latin"],
  variable: "--font-body-raw",
  display: "swap",
  preload: true,
});

export const metadata: Metadata = {
  metadataBase: new URL("https://meridian-studio.example.com"),
  title: {
    default: "Meridian — Real Estate & Construction",
    template: "%s — Meridian",
  },
  description:
    "Meridian is a real estate development and construction studio designing and building residential, commercial and mixed-use projects across Bangladesh.",
  openGraph: {
    title: "Meridian — Real Estate & Construction",
    description:
      "We build spaces that define the future. A real estate development and construction studio.",
    type: "website",
    locale: "en_US",
  },
  twitter: {
    card: "summary_large_image",
    title: "Meridian — Real Estate & Construction",
    description: "We build spaces that define the future.",
  },
};

export const viewport: Viewport = {
  themeColor: [
    { media: "(prefers-color-scheme: light)", color: "#f0f7f2" },
    { media: "(prefers-color-scheme: dark)", color: "#0a0f0e" },
  ],
};

export default function RootLayout({
  children,
}: Readonly<{
  children: React.ReactNode;
}>) {
  return (
    <html lang="en" suppressHydrationWarning data-scroll-behavior="smooth">
      <head>
        {/* Runs before first paint so the stored theme is applied with no flash. */}
        <script dangerouslySetInnerHTML={{ __html: themeInitScript }} />
        {/* Warm up the image CDN while the document is still parsing. */}
        <link rel="preconnect" href="https://images.unsplash.com" />
        <link rel="dns-prefetch" href="https://images.unsplash.com" />
      </head>
      <body className={`${spaceGrotesk.variable} ${inter.variable} antialiased`}>
        <ThemeProvider>
          <SmoothLoader />
          <CustomCursor />
          <Navbar />
          <main id="main">{children}</main>
          <Footer />
          <BackToTop />
        </ThemeProvider>
      </body>
    </html>
  );
}
