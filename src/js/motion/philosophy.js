import { gsap } from 'gsap';
import { TextPlugin } from 'gsap/TextPlugin';
import { MOTION_OK } from '../lib/reduced-motion.js';

gsap.registerPlugin(TextPlugin);

/**
 * Philosophy line: "A great website is ____." typed and backspaced on a
 * loop by the terminal caret. Each word lands with a personality beat:
 * fast types at triple speed and skids to a stop, responsive squishes
 * like a viewport, scalable pops up a size, accessible puts on a real
 * focus ring. The static (no-JS / reduced-motion) text stays "easy to
 * use", and a sr-only sentence carries the full list.
 */

const WORDS = [
	{ w: 'fast', fx: 'fast', type: 0.02 },
	{ w: 'accessible', fx: 'focus' },
	{ w: 'responsive', fx: 'squish' },
	{ w: 'scalable', fx: 'pop' },
	{ w: 'simple' },
	{ w: 'lightweight' },
	{ w: 'built to last' },
	{ w: 'easy to use' },
];

export function initPhilosophy() {
	const mm = gsap.matchMedia();

	mm.add(MOTION_OK, () => {
		const word = document.querySelector('[data-philo]');
		const count = document.querySelector('[data-philo-count]');
		if (!word) return;

		const fx = {
			fast: () => gsap.fromTo(word, { skewX: -12, x: -8 }, { skewX: 0, x: 0, duration: 0.5, ease: 'power3.out' }),
			squish: () => gsap.fromTo(word, { scaleX: 0.68, transformOrigin: 'left center' }, { scaleX: 1, duration: 0.7, ease: 'elastic.out(1, 0.5)' }),
			pop: () => gsap.fromTo(word, { scale: 0.82, transformOrigin: 'left bottom' }, { scale: 1, duration: 0.5, ease: 'back.out(2.2)' }),
			focus: () => word.classList.add('philo-focus'),
		};

		const tl = gsap.timeline({ repeat: -1, delay: 1.2 });
		// start by clearing the statically-rendered word
		tl.to(word, { duration: 0.35, text: '', ease: 'none' });
		WORDS.forEach((item, i) => {
			tl.call(() => {
				word.classList.remove('philo-focus');
				gsap.set(word, { clearProps: 'transform' });
				if (count) count.textContent = String(i + 1).padStart(2, '0');
			})
				.to(word, { duration: item.w.length * (item.type || 0.055), text: item.w, ease: 'none' })
				.call(() => { if (item.fx) fx[item.fx](); })
				.to(word, { duration: item.w.length * 0.028, text: '', ease: 'none' }, `+=${1.6}`);
		});

		return () => {
			tl.kill();
			gsap.killTweensOf(word);
			word.classList.remove('philo-focus');
			gsap.set(word, { clearProps: 'all' });
			word.textContent = 'easy to use';
			if (count) count.textContent = '02';
		};
	});
}
