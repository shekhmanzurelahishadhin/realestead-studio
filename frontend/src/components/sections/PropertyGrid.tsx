"use client";

import { useMemo, useState } from "react";
import { motion, AnimatePresence } from "framer-motion";
import { properties } from "@/data/properties";
import PropertyCard from "@/components/ui/PropertyCard";
import { Search, SearchX, X } from "lucide-react";
import clsx from "clsx";
import { PropertyStatus } from "@/types";

const statusFilters: { label: string; value: PropertyStatus | "all" }[] = [
  { label: "All", value: "all" },
  { label: "Available", value: "available" },
  { label: "Upcoming", value: "upcoming" },
  { label: "Sold", value: "sold" },
];

export default function PropertyGrid() {
  const [query, setQuery] = useState("");
  const [status, setStatus] = useState<PropertyStatus | "all">("all");

  const filtered = useMemo(() => {
    const q = query.trim().toLowerCase();
    return properties.filter((p) => {
      const matchesStatus = status === "all" || p.status === status;
      const matchesQuery =
        q === "" ||
        p.title.toLowerCase().includes(q) ||
        p.location.toLowerCase().includes(q);
      return matchesStatus && matchesQuery;
    });
  }, [query, status]);

  return (
    <div className="container-x pb-28">
      <div className="mb-14 flex flex-col gap-6 border-b hairline pb-8 md:flex-row md:items-center md:justify-between">
        <div className="flex flex-wrap gap-2">
          {statusFilters.map((f) => (
            <button
              key={f.value}
              onClick={() => setStatus(f.value)}
              aria-pressed={status === f.value}
              className={clsx(
                "relative rounded-full px-4 py-2 text-xs font-medium tracking-wide transition-colors duration-300",
                status === f.value ? "text-canvas" : "text-fg-soft hover:text-accent"
              )}
            >
              {status === f.value && (
                <motion.span
                  layoutId="property-filter-pill"
                  transition={{ type: "spring", stiffness: 420, damping: 34 }}
                  className="absolute inset-0 rounded-full bg-fg"
                />
              )}
              <span className="relative z-[1]">{f.label}</span>
            </button>
          ))}
        </div>

        <div className="group flex items-center gap-2 border-b hairline pb-2 transition-colors focus-within:border-accent md:w-72">
          <Search size={16} className="shrink-0 text-muted transition-colors group-focus-within:text-accent" />
          <input
            value={query}
            onChange={(e) => setQuery(e.target.value)}
            placeholder="Search by name or location"
            aria-label="Search properties"
            className="w-full bg-transparent text-sm text-fg placeholder:text-muted focus:outline-none"
          />
          {query && (
            <button
              onClick={() => setQuery("")}
              aria-label="Clear search"
              className="shrink-0 text-muted transition-colors hover:text-accent"
            >
              <X size={14} />
            </button>
          )}
        </div>
      </div>

      {filtered.length === 0 ? (
        <div className="flex flex-col items-center gap-3 py-24 text-center">
          <SearchX size={28} strokeWidth={1.5} className="text-accent" />
          <p className="font-display text-xl text-fg">No matching properties</p>
          <p className="max-w-xs text-sm text-muted">
            Try a different search term or clear the status filter.
          </p>
        </div>
      ) : (
        <motion.div
          layout
          className="grid grid-cols-1 gap-x-8 gap-y-12 sm:grid-cols-2 lg:grid-cols-3"
        >
          <AnimatePresence mode="popLayout">
            {filtered.map((property, i) => (
              <motion.div
                key={property.id}
                layout
                initial={{ opacity: 0, y: 24 }}
                animate={{ opacity: 1, y: 0 }}
                exit={{ opacity: 0, scale: 0.97 }}
                transition={{
                  duration: 0.5,
                  delay: (i % 3) * 0.06,
                  ease: [0.22, 1, 0.36, 1],
                }}
              >
                <PropertyCard property={property} />
              </motion.div>
            ))}
          </AnimatePresence>
        </motion.div>
      )}
    </div>
  );
}
