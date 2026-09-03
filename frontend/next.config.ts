import type { NextConfig } from "next";

const nextConfig: NextConfig = {
  images: {
    // AVIF first (smallest), WebP fallback for older browsers.
    formats: ["image/avif", "image/webp"],
    // Next 16 requires an explicit allowlist; 75 is the default quality.
    qualities: [60, 75, 90],
    minimumCacheTTL: 60 * 60 * 24 * 30,
    // Local dev only: the Laravel API is on 127.0.0.1, which Next 16 blocks
    // by default as an SSRF guard against optimizing attacker-supplied URLs.
    // Safe here since the image source is our own backend, not user input.
    dangerouslyAllowLocalIP: true,
    remotePatterns: [
      {
        protocol: "http",
        hostname: "127.0.0.1",
        port: "8000",
        pathname: "/storage/**",
      },
      {
        protocol: "http",
        hostname: "localhost",
        port: "8000",
        pathname: "/storage/**",
      },
    ],
  },
  experimental: {
    // Tree-shake barrel imports so only the icons//motion parts we use ship.
    optimizePackageImports: ["lucide-react", "framer-motion"],
  },
};

export default nextConfig;
