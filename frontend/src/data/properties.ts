import { Property } from "@/types";

export const properties: Property[] = [
  {
    id: "r1",
    slug: "the-skyline-residence",
    title: "The Skyline Residence",
    location: "Gulshan 2, Dhaka",
    price: 28500000,
    priceLabel: "৳ 2.85 Cr",
    area: 2450,
    bedrooms: 3,
    bathrooms: 3,
    status: "available",
    image:
      "https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?q=80&w=1200&auto=format&fit=crop",
    gallery: [
      "https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?q=80&w=1800&auto=format&fit=crop",
      "https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?q=80&w=1800&auto=format&fit=crop",
    ],
    amenities: ["Lake view", "Private lift lobby", "Rooftop pool", "24/7 concierge"],
  },
  {
    id: "r2",
    slug: "arcadia-garden-duplex",
    title: "Arcadia Garden Duplex",
    location: "Gulshan Avenue, Dhaka",
    price: 41200000,
    priceLabel: "৳ 4.12 Cr",
    area: 3600,
    bedrooms: 4,
    bathrooms: 4,
    status: "available",
    image:
      "https://images.unsplash.com/photo-1493809842364-78817add7ffb?q=80&w=1200&auto=format&fit=crop",
    gallery: [
      "https://images.unsplash.com/photo-1493809842364-78817add7ffb?q=80&w=1800&auto=format&fit=crop",
      "https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?q=80&w=1800&auto=format&fit=crop",
    ],
    amenities: ["Private garden", "Double-height living", "Home office", "EV charging"],
  },
  {
    id: "r3",
    slug: "riverside-loft-12b",
    title: "Riverside Loft 12B",
    location: "Agrabad, Chittagong",
    price: 16800000,
    priceLabel: "৳ 1.68 Cr",
    area: 1780,
    bedrooms: 2,
    bathrooms: 2,
    status: "upcoming",
    image:
      "https://images.unsplash.com/photo-1600566753086-00f18fb6b3ea?q=80&w=1200&auto=format&fit=crop",
    gallery: [
      "https://images.unsplash.com/photo-1600566753086-00f18fb6b3ea?q=80&w=1800&auto=format&fit=crop",
    ],
    amenities: ["River view", "Exposed concrete finish", "Co-working lounge"],
  },
  {
    id: "r4",
    slug: "grand-terrace-penthouse",
    title: "Grand Terrace Penthouse",
    location: "Banani, Dhaka",
    price: 65000000,
    priceLabel: "৳ 6.50 Cr",
    area: 4800,
    bedrooms: 5,
    bathrooms: 5,
    status: "sold",
    image:
      "https://images.unsplash.com/photo-1580587771525-78b9dba3b914?q=80&w=1200&auto=format&fit=crop",
    gallery: [
      "https://images.unsplash.com/photo-1580587771525-78b9dba3b914?q=80&w=1800&auto=format&fit=crop",
    ],
    amenities: ["360° city view", "Private terrace pool", "Wine cellar", "Smart home system"],
  },
];
