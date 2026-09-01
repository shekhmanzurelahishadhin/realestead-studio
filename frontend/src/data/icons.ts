import type { LucideIcon } from "lucide-react";
import {
  Building2,
  ClipboardCheck,
  Compass,
  DraftingCompass,
  HardHat,
  Handshake,
  KeyRound,
  Landmark,
  LayoutDashboard,
  PencilRuler,
  ShieldCheck,
  Sofa,
} from "lucide-react";

/** Icon per service id — keeps JSX out of the plain data modules. */
export const serviceIcons: Record<string, LucideIcon> = {
  s1: Landmark, // Real Estate Development
  s2: HardHat, // Construction
  s3: DraftingCompass, // Architectural Design
  s4: Sofa, // Interior Design
  s5: LayoutDashboard, // Property Management
  s6: Building2, // Commercial Development
};

/** Icon per process step id. */
export const processIcons: Record<string, LucideIcon> = {
  c1: Compass, // Concept
  c2: PencilRuler, // Design
  c3: ClipboardCheck, // Planning
  c4: HardHat, // Construction
  c5: ShieldCheck, // Quality Control
  c6: KeyRound, // Delivery
};

export const fallbackIcon: LucideIcon = Handshake;
