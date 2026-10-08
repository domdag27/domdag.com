/**
 * Single source of truth for the user's motion preference.
 * Motion modules additionally wrap themselves in gsap.matchMedia(), which
 * auto-reverts their animations if the OS setting changes mid-session.
 */
export const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');

export const MOTION_OK = '(prefers-reduced-motion: no-preference)';
