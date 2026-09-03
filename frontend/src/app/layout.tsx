import type { Metadata, Viewport } from "next";
import { Space_Grotesk, Inter } from "next/font/google";
import "./globals.css";
import Navbar from "@/components/layout/Navbar";
import Footer from "@/components/layout/Footer";
import CustomCursor from "@/components/animations/CustomCursor";
import SmoothLoader from "@/components/animations/SmoothLoader";
import ThemeProvider, { themeInitScript } from "@/components/theme/ThemeProvider";
import BackToTop from "@/components/ui/BackToTop";
import { getSettings } from "@/lib/api";

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

export async function generateMetadata(): Promise<Metadata> {
  const settings = await getSettings();
  const description =
    settings.tagline ??
    `${settings.siteName} is a real estate development and construction studio.`;

  return {
    metadataBase: new URL("https://meridian-studio.example.com"),
    title: {
      default: `${settings.siteName} — Real Estate & Construction`,
      template: `%s — ${settings.siteName}`,
    },
    description,
    openGraph: {
      title: `${settings.siteName} — Real Estate & Construction`,
      description,
      type: "website",
      locale: "en_US",
    },
    twitter: {
      card: "summary_large_image",
      title: `${settings.siteName} — Real Estate & Construction`,
      description,
    },
  };
}

export const viewport: Viewport = {
  themeColor: [
    { media: "(prefers-color-scheme: light)", color: "#f0f7f2" },
    { media: "(prefers-color-scheme: dark)", color: "#0a0f0e" },
  ],
};

export default async function RootLayout({
  children,
}: Readonly<{
  children: React.ReactNode;
}>) {
  const settings = await getSettings();

  return (
    <html lang="en" suppressHydrationWarning data-scroll-behavior="smooth">
      <head>
        {/* Runs before first paint so the stored theme is applied with no flash. */}
        <script dangerouslySetInnerHTML={{ __html: themeInitScript }} />
        {/* Warm up the image CDN while the document is still parsing. */}
        <link rel="preconnect" href="http://127.0.0.1:8000" />
        <link rel="dns-prefetch" href="http://127.0.0.1:8000" />
      </head>
      <body className={`${spaceGrotesk.variable} ${inter.variable} antialiased`}>
        <ThemeProvider>
          <SmoothLoader siteName={settings.siteName} />
          <CustomCursor />
          <Navbar settings={settings} />
          <main id="main">{children}</main>
          <Footer settings={settings} />
          <BackToTop />
        </ThemeProvider>
      </body>
    </html>
  );
}
