import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import { MOTION_OK } from '../lib/reduced-motion.js';

gsap.registerPlugin(ScrollTrigger);

/**
 * Generic scroll-in reveal for any element marked [data-reveal].
 * Fires once per element; cheap by design (transform + opacity only).
 */
export function initReveals() {
	const mm = gsap.matchMedia();

	mm.add(MOTION_OK, () => {
		// Container mode: direct children cascade in. Numbers are the
		// motion-design skill's Premium list recipe (350ms, 80ms stagger,
		// cubic-bezier(0.4,0,0.2,1)) — total stays under its 500ms budget.
		gsap.utils.toArray('[data-reveal-stagger]').forEach((wrap) => {
			gsap.fromTo(
				wrap.children,
				{ opacity: 0, y: 20 },
				{
					opacity: 1,
					y: 0,
					duration: 0.35,
					ease: 'power2.out',
					stagger: 0.08,
					scrollTrigger: { trigger: wrap, start: 'top 85%', once: true },
				}
			);
		});

		gsap.utils.toArray('[data-reveal]').forEach((el) => {
			gsap.fromTo(
				el,
				{ opacity: 0, y: 28 },
				{
					opacity: 1,
					y: 0,
					duration: 0.8,
					ease: 'power3.out',
					scrollTrigger: {
						trigger: el,
						start: 'top 85%',
						once: true,
					},
				}
			);
		});
	});
}
