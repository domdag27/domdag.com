import { gsap } from 'gsap';
import { MOTION_OK } from '../lib/reduced-motion.js';

const SPEED = 60; // auto-scroll, px per second

/**
 * Stats ticker: JS-driven marquee that behaves like a carousel.
 * - auto-scrolls left; hovering pauses it
 * - click-drag (or touch-drag) scrubs it either direction, with momentum
 *   on release that decays back into the auto-scroll
 * - seamless wrap via the two identical .ticker-half copies
 * - pauses off-screen; under reduced motion this module never runs and
 *   the band stays static (the CSS fallback animation is globally killed)
 */
export function initTicker() {
	const root = document.querySelector('.ticker');
	const track = root?.querySelector('.ticker-track');
	const half = root?.querySelector('.ticker-half');
	if (!root || !track || !half) return;

	const mm = gsap.matchMedia();

	mm.add(MOTION_OK, () => {
		root.classList.add('ticker-js'); // disables the CSS fallback animation

		let x = 0;
		let vel = 0;
		let dragging = false;
		let hover = false;
		let visible = true;
		let lastX = 0;
		let lastT = 0;

		const wrap = () => {
			const w = half.offsetWidth;
			if (w) x = ((x % w) + w) % w;
		};

		const onFrame = (time, dt) => {
			if (!visible || dragging) return;
			const dts = Math.min(dt, 64) / 1000;
			if (Math.abs(vel) > 4) {
				// momentum from a throw, decaying
				x += vel * dts;
				vel *= Math.pow(0.88, dts * 60);
			} else if (!hover) {
				x += SPEED * dts;
			}
			wrap();
			track.style.transform = `translateX(${-x}px)`;
		};
		gsap.ticker.add(onFrame);

		const onEnter = () => (hover = true);
		const onLeave = () => (hover = false);
		root.addEventListener('pointerenter', onEnter);
		root.addEventListener('pointerleave', onLeave);

		const down = (e) => {
			dragging = true;
			vel = 0;
			lastX = e.clientX;
			lastT = performance.now();
			root.classList.add('ticker-dragging');
		};
		const move = (e) => {
			if (!dragging) return;
			const now = performance.now();
			const dx = e.clientX - lastX;
			x -= dx; // drag right = scroll back
			const dt = Math.max(1, now - lastT);
			vel = (-dx / dt) * 1000 * 0.8 + vel * 0.2; // smoothed throw velocity
			lastX = e.clientX;
			lastT = now;
			wrap();
			track.style.transform = `translateX(${-x}px)`;
		};
		const up = () => {
			if (!dragging) return;
			dragging = false;
			root.classList.remove('ticker-dragging');
		};
		root.addEventListener('pointerdown', down);
		window.addEventListener('pointermove', move);
		window.addEventListener('pointerup', up);
		window.addEventListener('pointercancel', up);

		const io = new IntersectionObserver(([entry]) => (visible = entry.isIntersecting));
		io.observe(root);

		return () => {
			gsap.ticker.remove(onFrame);
			io.disconnect();
			root.removeEventListener('pointerenter', onEnter);
			root.removeEventListener('pointerleave', onLeave);
			root.removeEventListener('pointerdown', down);
			window.removeEventListener('pointermove', move);
			window.removeEventListener('pointerup', up);
			window.removeEventListener('pointercancel', up);
			root.classList.remove('ticker-js', 'ticker-dragging');
			track.style.transform = '';
		};
	});
}
