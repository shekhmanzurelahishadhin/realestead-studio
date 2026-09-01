import type { Metadata } from "next";
import PageHero from "@/components/sections/PageHero";
import PropertyGrid from "@/components/sections/PropertyGrid";

export const metadata: Metadata = {
  title: "Properties",
  description: "Browse available, upcoming and sold residences from Meridian.",
};

export default function PropertiesPage() {
  return (
    <>
      <PageHero
        eyebrow="Residences"
        title="Find your next address."
        description="Available, upcoming and recently completed residences across Dhaka and Chittagong."
      />
      <PropertyGrid />
    </>
  );
}
