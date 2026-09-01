export type Project = {
  id: string;
  slug: string;
  name: string;
  location: string;
  category: string;
  year: string;
  description: string;
  image: string;
  gallery: string[];
  stats: { label: string; value: string }[];
};

export type PropertyStatus = "available" | "sold" | "upcoming";

export type Property = {
  id: string;
  slug: string;
  title: string;
  location: string;
  price: number;
  priceLabel: string;
  area: number;
  bedrooms: number;
  bathrooms: number;
  status: PropertyStatus;
  image: string;
  gallery: string[];
  amenities: string[];
};

export type Service = {
  id: string;
  title: string;
  description: string;
  image: string;
};

export type Testimonial = {
  id: string;
  quote: string;
  name: string;
  role: string;
  project: string;
};

export type ProcessStep = {
  id: string;
  index: string;
  title: string;
  description: string;
};

export type Stat = {
  id: string;
  value: number;
  suffix: string;
  label: string;
};
