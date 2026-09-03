import { Property } from "@/types";
import RevealText from "@/components/animations/RevealText";
import FadeUp from "@/components/animations/FadeUp";
import PropertyCard from "@/components/ui/PropertyCard";
import Button from "@/components/ui/Button";

export default function FeaturedProperties({ properties }: { properties: Property[] }) {
  return (
    <section className="container-x py-28 md:py-36">
      <div className="mb-14 flex items-end justify-between gap-6">
        <div>
          <p className="eyebrow mb-6">Available Now</p>
          <RevealText
            as="h2"
            text="Featured properties"
            className="font-display text-4xl tracking-tight text-fg sm:text-5xl"
          />
        </div>
        <p className="hidden max-w-xs text-sm leading-relaxed text-muted md:block">
          A selection of residences ready to move into, plus what is coming
          next across Dhaka and Chittagong.
        </p>
      </div>

      <div className="grid grid-cols-1 gap-x-8 gap-y-12 sm:grid-cols-2 lg:grid-cols-4">
        {properties.map((property, i) => (
          <FadeUp key={property.id} delay={i * 0.08}>
            <PropertyCard property={property} />
          </FadeUp>
        ))}
      </div>

      <FadeUp delay={0.2} className="mt-16 flex justify-center">
        <Button href="/properties" variant="ghost" cursorLabel="BROWSE">
          Browse all properties
        </Button>
      </FadeUp>
    </section>
  );
}
