import { Service, Testimonial, ProcessStep, Stat } from "@/types";

export const services: Service[] = [
  {
    id: "s1",
    title: "Real Estate Development",
    description:
      "End-to-end development from land acquisition and feasibility to sales — we carry projects from concept to keys handed over.",
    image:
      "https://images.unsplash.com/photo-1487958449943-2429e8be8625?q=80&w=1800&auto=format&fit=crop",
  },
  {
    id: "s2",
    title: "Construction",
    description:
      "In-house construction management with certified engineers on every site, holding tolerances to the millimetre from foundation to façade.",
    image:
      "https://images.unsplash.com/photo-1503387762-592deb58ef4e?q=80&w=1800&auto=format&fit=crop",
  },
  {
    id: "s3",
    title: "Architectural Design",
    description:
      "A design studio that treats climate, light and material as the brief — every building begins with the site, not a template.",
    image:
      "https://images.unsplash.com/photo-1518005020951-eccb494ad742?q=80&w=1800&auto=format&fit=crop",
  },
  {
    id: "s4",
    title: "Interior Design",
    description:
      "Interiors conceived alongside the architecture, so joinery, light and material continue the building's logic into every room.",
    image:
      "https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?q=80&w=1800&auto=format&fit=crop",
  },
  {
    id: "s5",
    title: "Property Management",
    description:
      "Long-term stewardship of every building we deliver — facilities, tenancy and maintenance handled by one accountable team.",
    image:
      "https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?q=80&w=1800&auto=format&fit=crop",
  },
  {
    id: "s6",
    title: "Commercial Development",
    description:
      "Offices and retail built for the way people work and shop now — flexible floorplates, daylight and easy servicing.",
    image:
      "https://images.unsplash.com/photo-1523217582562-09d0def993a6?q=80&w=1800&auto=format&fit=crop",
  },
];

export const testimonials: Testimonial[] = [
  {
    id: "t1",
    quote:
      "Their attention to detail and commitment to quality transformed our vision into something far beyond what we imagined.",
    name: "Farhana Rahman",
    role: "Homeowner",
    project: "The Arcadia",
  },
  {
    id: "t2",
    quote:
      "We handed them a difficult site and a tight programme. What came back was a building that solved both, elegantly.",
    name: "Imtiaz Hossain",
    role: "Managing Director, Orion Retail Group",
    project: "Riverside Heights",
  },
  {
    id: "t3",
    quote:
      "From the first sketch to the final walkthrough, communication was constant and the craftsmanship never wavered.",
    name: "Nusrat Jahan",
    role: "Homeowner",
    project: "The Grand Terrace",
  },
];

export const processSteps: ProcessStep[] = [
  {
    id: "c1",
    index: "01",
    title: "Concept",
    description: "Site analysis, feasibility and an architectural concept grounded in context and light.",
  },
  {
    id: "c2",
    index: "02",
    title: "Design",
    description: "Detailed architectural and structural design, developed alongside interior and landscape.",
  },
  {
    id: "c3",
    index: "03",
    title: "Planning",
    description: "Approvals, permitting and a construction programme sequenced for cost and quality.",
  },
  {
    id: "c4",
    index: "04",
    title: "Construction",
    description: "In-house project management on site, with weekly progress reporting to every stakeholder.",
  },
  {
    id: "c5",
    index: "05",
    title: "Quality Control",
    description: "Independent inspection at every milestone, from structural pour to final finishes.",
  },
  {
    id: "c6",
    index: "06",
    title: "Delivery",
    description: "Handover documentation, aftercare and a maintenance plan for the building's first year.",
  },
];

export const stats: Stat[] = [
  { id: "st1", value: 25, suffix: "+", label: "Years experience" },
  { id: "st2", value: 120, suffix: "+", label: "Projects delivered" },
  { id: "st3", value: 18, suffix: "", label: "Cities" },
  { id: "st4", value: 2.4, suffix: "M+", label: "Sq ft developed" },
];
