import type { NextConfig } from "next";

const nextConfig: NextConfig = {
  images: {
    // AVIF first (smallest), WebP fallback for older browsers.
    formats: ["image/avif", "image/webp"],
    // Next 16 requires an explicit allowlist; 75 is the default quality.
    qualities: [60, 75, 90],
    minimumCacheTTL: 60 * 60 * 24 * 30,
    remotePatterns: [
      {
        protocol: "https",
        hostname: "images.unsplash.com",
      },
    ],
  },
  experimental: {
    // Tree-shake barrel imports so only the icons//motion parts we use ship.
    optimizePackageImports: ["lucide-react", "framer-motion"],
  },
};

export default nextConfig;
