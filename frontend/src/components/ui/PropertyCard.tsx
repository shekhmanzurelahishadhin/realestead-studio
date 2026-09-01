import Link from "next/link";
import { Property } from "@/types";
import { BedDouble, Bath, Ruler, ArrowUpRight } from "lucide-react";
import SmartImage from "@/components/ui/SmartImage";
import clsx from "clsx";

const statusLabel: Record<Property["status"], string> = {
  available: "Available",
  sold: "Sold",
  upcoming: "Upcoming",
};

export default function PropertyCard({ property }: { property: Property }) {
  return (
    <Link
      href={`/properties/${property.slug}`}
      data-cursor="VIEW"
      className="group block"
    >
      <article className="card-surface overflow-hidden rounded-2xl">
        <div className="sheen relative aspect-[4/5] overflow-hidden">
          <SmartImage
            src={property.image}
            alt={property.title}
            fill
            sizes="(min-width: 1024px) 25vw, (min-width: 640px) 45vw, 90vw"
            className="object-cover transition-transform duration-[1100ms] ease-[cubic-bezier(0.22,1,0.36,1)] group-hover:scale-[1.06]"
          />
          <div className="absolute inset-0 bg-gradient-to-t from-black/55 via-black/0 to-black/0" />

          <span
            className={clsx(
              "absolute left-4 top-4 rounded-full px-3 py-1 text-[10px] font-medium tracking-[0.1em] backdrop-blur-sm",
              property.status === "available" && "bg-canvas/90 text-fg",
              property.status === "upcoming" && "bg-accent text-accent-contrast",
              property.status === "sold" && "bg-black/75 text-white"
            )}
          >
            {statusLabel[property.status].toUpperCase()}
          </span>

          <span className="absolute right-4 top-4 flex h-9 w-9 translate-y-2 items-center justify-center rounded-full bg-accent text-accent-contrast opacity-0 shadow-lg transition-all duration-500 group-hover:translate-y-0 group-hover:opacity-100">
            <ArrowUpRight size={15} />
          </span>
        </div>

        <div className="p-5">
          <h3 className="font-display text-lg text-fg transition-colors duration-300 group-hover:text-accent">
            {property.title}
          </h3>
          <p className="mt-1 text-sm text-muted">{property.location}</p>

          <div className="mt-4 flex items-center gap-4 text-xs text-fg-soft">
            <span className="flex items-center gap-1.5" title="Bedrooms">
              <BedDouble size={14} className="text-accent" /> {property.bedrooms}
            </span>
            <span className="flex items-center gap-1.5" title="Bathrooms">
              <Bath size={14} className="text-accent" /> {property.bathrooms}
            </span>
            <span className="flex items-center gap-1.5" title="Floor area">
              <Ruler size={14} className="text-accent" /> {property.area.toLocaleString()} sqft
            </span>
          </div>

          <div className="mt-4 flex items-end justify-between border-t hairline pt-4">
            <div>
              <p className="text-[10px] tracking-[0.1em] text-muted">STARTING FROM</p>
              <p className="mt-1 font-display text-lg text-fg">{property.priceLabel}</p>
            </div>
          </div>
        </div>
      </article>
    </Link>
  );
}
