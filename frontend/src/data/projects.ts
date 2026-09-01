import { Project } from "@/types";

export const projects: Project[] = [
  {
    id: "p1",
    slug: "the-arcadia",
    name: "The Arcadia",
    location: "Gulshan, Dhaka",
    category: "Luxury Residential",
    year: "2024",
    description:
      "A 32-storey residential tower organised around a central light well, pairing exposed concrete with warm timber interiors. Each residence is oriented to frame the lake beyond Gulshan Avenue.",
    image:
      "https://images.unsplash.com/photo-1613977257363-707ba9348227?q=80&w=1200&auto=format&fit=crop",
    gallery: [
      "https://images.unsplash.com/photo-1613977257363-707ba9348227?q=80&w=1800&auto=format&fit=crop",
      "https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?q=80&w=1800&auto=format&fit=crop",
      "https://images.unsplash.com/photo-1493809842364-78817add7ffb?q=80&w=1800&auto=format&fit=crop",
    ],
    stats: [
      { label: "Units", value: "184" },
      { label: "Floors", value: "32" },
      { label: "Completed", value: "2024" },
    ],
  },
  {
    id: "p2",
    slug: "riverside-heights",
    name: "Riverside Heights",
    location: "Agrabad, Chittagong",
    category: "Mixed-Use Development",
    year: "2023",
    description:
      "A terraced mixed-use block stepping down toward the Karnaphuli waterfront, combining retail podiums with residences shaded by perforated brise-soleil screens.",
    image:
      "https://images.unsplash.com/photo-1523217582562-09d0def993a6?q=80&w=1200&auto=format&fit=crop",
    gallery: [
      "https://images.unsplash.com/photo-1523217582562-09d0def993a6?q=80&w=1800&auto=format&fit=crop",
      "https://images.unsplash.com/photo-1449844908441-8829872d2607?q=80&w=1800&auto=format&fit=crop",
      "https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?q=80&w=1800&auto=format&fit=crop",
    ],
    stats: [
      { label: "Retail units", value: "46" },
      { label: "Residences", value: "220" },
      { label: "Completed", value: "2023" },
    ],
  },
  {
    id: "p3",
    slug: "the-grand-terrace",
    name: "The Grand Terrace",
    location: "Banani, Dhaka",
    category: "Commercial & Residential",
    year: "2022",
    description:
      "A commercial ground plane topped with garden residences, using deep terraces and planting to break the tower's mass into a stack of private courtyards.",
    image:
      "https://images.unsplash.com/photo-1512917774080-9991f1c4c750?q=80&w=1200&auto=format&fit=crop",
    gallery: [
      "https://images.unsplash.com/photo-1512917774080-9991f1c4c750?q=80&w=1800&auto=format&fit=crop",
      "https://images.unsplash.com/photo-1518005020951-eccb494ad742?q=80&w=1800&auto=format&fit=crop",
      "https://images.unsplash.com/photo-1583608205776-bfd35f0d9f83?q=80&w=1800&auto=format&fit=crop",
    ],
    stats: [
      { label: "Office floors", value: "12" },
      { label: "Sky residences", value: "58" },
      { label: "Completed", value: "2022" },
    ],
  },
  {
    id: "p4",
    slug: "meridian-quarter",
    name: "Meridian Quarter",
    location: "Bashundhara, Dhaka",
    category: "Township Development",
    year: "2025",
    description:
      "A low-rise township of courtyard villas and shared gardens, planned around a car-free spine that connects a school, clinic and market square.",
    image:
      "https://images.unsplash.com/photo-1600585154340-be6161a56a0c?q=80&w=1200&auto=format&fit=crop",
    gallery: [
      "https://images.unsplash.com/photo-1600585154340-be6161a56a0c?q=80&w=1800&auto=format&fit=crop",
      "https://images.unsplash.com/photo-1564013799919-ab600027ffc6?q=80&w=1800&auto=format&fit=crop",
      "https://images.unsplash.com/photo-1568605114967-8130f3a36994?q=80&w=1800&auto=format&fit=crop",
    ],
    stats: [
      { label: "Villas", value: "96" },
      { label: "Green area", value: "40%" },
      { label: "Completing", value: "2025" },
    ],
  },
];
