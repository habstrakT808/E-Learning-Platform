// tailwind.config.js
import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";
import typography from "@tailwindcss/typography";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Inter", "Figtree", ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: {
                    50: "#f0f4fe",
                    100: "#dbe4ff",
                    200: "#bfd1ff",
                    300: "#93b4fd",
                    400: "#608dfa",
                    500: "#3b6ef6",
                    600: "#2552eb",
                    700: "#1d3ed8",
                    800: "#1e30af",
                    900: "#1e248a",
                    950: "#111554",
                },
                secondary: {
                    50: "#f9f6fe",
                    100: "#f1e9fd",
                    200: "#e3d4fa",
                    300: "#cdb3f5",
                    400: "#b285ee",
                    500: "#9d5ee5",
                    600: "#8a3bd8",
                    700: "#742dc0",
                    800: "#60259c",
                    900: "#4e207e",
                    950: "#301258",
                },
                tertiary: {
                    50: "#fdf2f8",
                    100: "#fce7f3",
                    200: "#fbcfe8",
                    300: "#f9a8d4",
                    400: "#f472b6",
                    500: "#ec4899",
                    600: "#db2777",
                    700: "#be185d",
                    800: "#9d174d",
                    900: "#831843",
                    950: "#500724",
                },
                accent: {
                    50: "#ecfdf5",
                    100: "#d1fae5",
                    200: "#a7f3d0",
                    300: "#6ee7b7",
                    400: "#34d399",
                    500: "#10b981",
                    600: "#059669",
                    700: "#047857",
                    800: "#065f46",
                    900: "#064e3b",
                    950: "#022c22",
                },
                night: {
                    50: "#f8fafc",
                    100: "#f1f5f9",
                    200: "#e2e8f0",
                    300: "#cbd5e1",
                    400: "#94a3b8",
                    500: "#64748b",
                    600: "#475569",
                    700: "#1a1b29",
                    800: "#111827",
                    900: "#0a0b1a",
                    950: "#030712",
                },
            },
            animation: {
                "fade-in": "fadeIn 0.5s ease-in-out",
                "slide-up": "slideUp 0.5s ease-out",
                "bounce-slow": "bounce 2s infinite",
                "pulse-slow": "pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite",
                float: "float 6s ease-in-out infinite",
                glow: "glow 2s ease-in-out infinite alternate",
                reverse: "spin 3s linear infinite reverse",
            },
            keyframes: {
                fadeIn: {
                    "0%": { opacity: "0" },
                    "100%": { opacity: "1" },
                },
                slideUp: {
                    "0%": { transform: "translateY(20px)", opacity: "0" },
                    "100%": { transform: "translateY(0)", opacity: "1" },
                },
                float: {
                    "0%, 100%": { transform: "translateY(0)" },
                    "50%": { transform: "translateY(-10px)" },
                },
                glow: {
                    "0%": { boxShadow: "0 0 5px rgba(155, 89, 182, 0.5)" },
                    "100%": { boxShadow: "0 0 20px rgba(155, 89, 182, 0.8)" },
                },
            },
            backgroundImage: {
                "gradient-radial": "radial-gradient(var(--tw-gradient-stops))",
                "gradient-conic":
                    "conic-gradient(from 90deg at 50% 50%, var(--tw-gradient-stops))",
            },
        },
    },

    plugins: [forms, typography],
};
