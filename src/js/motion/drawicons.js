import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import { DrawSVGPlugin } from 'gsap/DrawSVGPlugin';
import { MOTION_OK } from '../lib/reduced-motion.js';

gsap.registerPlugin(ScrollTrigger, DrawSVGPlugin);

/**
 * Stroke icons that literally draw themselves in when scrolled into view
 * (stat badges, or anything marked [data-draw-icon] whose SVG children
 * are stroke-based). The wrapping badge fades up first, then the strokes
 * trace in. Once per element; absent under reduced motion.
 */
export function initDrawIcons() {
	const mm = gsap.matchMedia();

	mm.add(MOTION_OK, () => {
		gsap.utils.toArray('[data-draw-icon]').forEach((wrap, i) => {
			const strokes = wrap.querySelectorAll('path, circle, line, polyline');
			const badge = wrap.closest('.stat-badge') || wrap;

			const tl = gsap.timeline({
				delay: i * 0.15,
				scrollTrigger: { trigger: badge, start: 'top 88%', once: true },
			});
			tl.fromTo(badge,
				{ opacity: 0, y: 20 },
				{ opacity: 1, y: 0, duration: 0.5, ease: 'power3.out' }
			).fromTo(strokes,
				{ drawSVG: '0%' },
				{ drawSVG: '100%', duration: 0.7, ease: 'power2.inOut', stagger: 0.12 },
				'-=0.2'
			);
		});
	});
}
