import { gsap } from 'gsap';
import { MOTION_OK } from '../lib/reduced-motion.js';

const GRID = 48; // must match the hero-bg background-size

/**
 * Ambient hero background, two layers of quiet life on the 48px grid:
 * - falling cells: lit squares stepping down a column like falling code
 * - blink cells: squares that color in and fade back out
 * Everything is transform/opacity only, pauses while the hero is
 * off-screen, and never runs under reduced motion (static grid instead).
 */
export function initGridRain() {
	const host = document.querySelector('[data-hero-rain]');
	const hero = document.getElementById('hero');
	if (!host || !hero) return;

	const mm = gsap.matchMedia();

	mm.add(MOTION_OK, () => {
		let alive = true;
		let visible = true;
		const tweens = new Set();
		const cells = [];

		const track = (tl) => {
			tweens.add(tl);
			if (!visible) tl.pause();
			return tl;
		};

		const spawnFaller = (el) => {
			if (!alive) return;
			const cols = Math.max(1, Math.floor(host.clientWidth / GRID));
			const rows = Math.max(4, Math.floor(host.clientHeight / GRID));
			const steps = gsap.utils.random(4, 9, 1);
			const col = gsap.utils.random(0, cols - 1, 1);
			const startRow = gsap.utils.random(-1, Math.max(0, rows - steps), 1);
			const stepDur = gsap.utils.random(0.28, 0.55);
			const travel = steps * stepDur;

			const tl = track(gsap.timeline({
				delay: gsap.utils.random(0, 3.5),
				onComplete: () => { tweens.delete(tl); spawnFaller(el); },
			}));
			tl.set(el, { x: col * GRID + 1, y: startRow * GRID + 1, opacity: 0 })
				.to(el, { y: (startRow + steps) * GRID + 1, duration: travel, ease: `steps(${steps})` }, 0)
				.to(el, { opacity: gsap.utils.random(0.09, 0.2), duration: 0.3, ease: 'none' }, 0)
				.to(el, { opacity: 0, duration: 0.6, ease: 'none' }, Math.max(0.3, travel - 0.6));
		};

		const spawnBlink = (el) => {
			if (!alive) return;
			const cols = Math.max(1, Math.floor(host.clientWidth / GRID));
			const rows = Math.max(1, Math.floor(host.clientHeight / GRID));
			const tl = track(gsap.timeline({
				delay: gsap.utils.random(0.5, 6),
				onComplete: () => { tweens.delete(tl); spawnBlink(el); },
			}));
			tl.set(el, {
				x: gsap.utils.random(0, cols - 1, 1) * GRID + 1,
				y: gsap.utils.random(0, rows - 1, 1) * GRID + 1,
				opacity: 0,
			})
				.to(el, { opacity: gsap.utils.random(0.05, 0.14), duration: gsap.utils.random(0.4, 1), ease: 'none' })
				.to(el, { opacity: 0, duration: gsap.utils.random(0.8, 1.6), ease: 'none' }, '+=' + gsap.utils.random(0.2, 1));
		};

		const make = (n, variant) => {
			for (let i = 0; i < n; i++) {
				const el = document.createElement('div');
				el.className = 'rain-cell' + (variant === 'fall' ? ' rain-cell-fall' : '');
				host.appendChild(el);
				cells.push(el);
				(variant === 'fall' ? spawnFaller : spawnBlink)(el);
			}
		};
		make(gsap.utils.clamp(6, 14, Math.floor(host.clientWidth / 110)), 'fall');
		make(7, 'blink');

		// Don't burn frames while the hero is off-screen.
		const io = new IntersectionObserver(([entry]) => {
			visible = entry.isIntersecting;
			tweens.forEach((t) => (visible ? t.play() : t.pause()));
		});
		io.observe(hero);

		return () => {
			alive = false;
			io.disconnect();
			tweens.forEach((t) => t.kill());
			tweens.clear();
			cells.forEach((c) => c.remove());
		};
	});
}
