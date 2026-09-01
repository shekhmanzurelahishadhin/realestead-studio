import type { Metadata } from "next";
import PageHero from "@/components/sections/PageHero";
import ContactForm from "@/components/sections/ContactForm";
import { MapPin, Phone, Mail } from "lucide-react";

export const metadata: Metadata = {
  title: "Contact",
  description: "Get in touch with Meridian to start a project or enquire about a property.",
};

export default function ContactPage() {
  return (
    <>
      <PageHero
        eyebrow="Get In Touch"
        title="Let's talk about your project."
        description="Whether you're planning a development or looking for your next home, our team is ready to help."
      />

      <section className="container-x pb-28">
        <div className="grid grid-cols-1 gap-16 lg:grid-cols-12">
          <div className="lg:col-span-7">
            <ContactForm />
          </div>

          <div className="lg:col-span-4 lg:col-start-9">
            <div className="space-y-8 border-t hairline pt-8 lg:border-t-0 lg:border-l lg:pl-10 lg:pt-0">
              <div>
                <p className="eyebrow mb-3 uppercase">Office</p>
                <p className="flex items-start gap-2.5 text-sm text-fg-soft">
                  <MapPin size={16} className="mt-0.5 shrink-0 text-accent" />
                  House 14, Road 7, Gulshan 1, Dhaka 1212, Bangladesh
                </p>
              </div>
              <div>
                <p className="eyebrow mb-3 uppercase">Phone</p>
                <p className="flex items-center gap-2.5 text-sm text-fg-soft">
                  <Phone size={16} className="text-accent" /> +880 1711 000 000
                </p>
              </div>
              <div>
                <p className="eyebrow mb-3 uppercase">Email</p>
                <p className="flex items-center gap-2.5 text-sm text-fg-soft">
                  <Mail size={16} className="text-accent" /> hello@meridian.studio
                </p>
              </div>
              <div className="flex aspect-[4/3] items-center justify-center border hairline bg-surface text-sm text-muted">
                Map placeholder &mdash; Gulshan 1, Dhaka
              </div>
            </div>
          </div>
        </div>
      </section>
    </>
  );
}
