"use client";

import { useState } from "react";
import { motion } from "framer-motion";
import MagneticButton from "@/components/animations/MagneticButton";
import { ArrowUpRight, Check } from "lucide-react";

export default function ContactForm() {
  const [submitted, setSubmitted] = useState(false);

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    // Wire this to your API route / Laravel endpoint when the backend exists.
    setSubmitted(true);
  };

  if (submitted) {
    return (
      <motion.div
        initial={{ opacity: 0, y: 16 }}
        animate={{ opacity: 1, y: 0 }}
        transition={{ duration: 0.5, ease: [0.22, 1, 0.36, 1] }}
        className="flex min-h-[320px] flex-col items-center justify-center rounded-xl border hairline bg-card p-10 text-center"
      >
        <motion.span
          initial={{ scale: 0 }}
          animate={{ scale: 1 }}
          transition={{ delay: 0.15, type: "spring", stiffness: 320, damping: 18 }}
          className="mb-5 flex h-14 w-14 items-center justify-center rounded-full bg-accent text-accent-contrast"
        >
          <Check size={24} />
        </motion.span>
        <p className="font-display text-2xl text-fg">Message sent</p>
        <p className="mt-2 max-w-xs text-sm text-muted">
          Thank you for reaching out. A member of our team will get back to you
          within one business day.
        </p>
      </motion.div>
    );
  }

  return (
    <form onSubmit={handleSubmit} className="space-y-8">
      <div className="grid grid-cols-1 gap-8 sm:grid-cols-2">
        <Field label="Full name" name="name" type="text" required />
        <Field label="Email address" name="email" type="email" required />
      </div>
      <div className="grid grid-cols-1 gap-8 sm:grid-cols-2">
        <Field label="Phone" name="phone" type="tel" />
        <Field label="Subject" name="subject" type="text" />
      </div>
      <div className="group">
        <label htmlFor="message" className="text-xs tracking-[0.1em] text-muted">
          MESSAGE
        </label>
        <textarea
          id="message"
          name="message"
          required
          rows={5}
          className="mt-2 w-full resize-none border-b hairline bg-transparent py-2 text-fg outline-none transition-colors focus:border-accent"
        />
      </div>

      <MagneticButton>
        <button
          type="submit"
          data-cursor="SEND"
          className="group inline-flex items-center gap-2.5 rounded-full bg-fg px-7 py-4 text-sm font-medium text-canvas transition-colors duration-300 hover:bg-accent hover:text-accent-contrast"
        >
          Send Message
          <ArrowUpRight
            size={16}
            className="transition-transform duration-300 group-hover:translate-x-0.5 group-hover:-translate-y-0.5"
          />
        </button>
      </MagneticButton>
    </form>
  );
}

function Field({
  label,
  name,
  type,
  required,
}: {
  label: string;
  name: string;
  type: string;
  required?: boolean;
}) {
  return (
    <div>
      <label htmlFor={name} className="text-xs tracking-[0.1em] text-muted">
        {label.toUpperCase()}
      </label>
      <input
        id={name}
        name={name}
        type={type}
        required={required}
        className="mt-2 w-full border-b hairline bg-transparent py-2 text-fg outline-none transition-colors focus:border-accent"
      />
    </div>
  );
}
