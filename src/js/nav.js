import { gsap } from 'gsap';
import { reducedMotion } from './lib/reduced-motion.js';

/**
 * Navigation chrome: scroll-progress line, the dock's sliding scroll-spy
 * highlight, the IDE gutter, and the full-bar→dock morph state.
 *
 * PERFORMANCE CONTRACT: update() runs on every scroll frame (Lenis fires
 * per frame), so it must never read layout (offsetTop/scrollHeight/...).
 * All geometry is measured in measure() — on init, resize, and font load —
 * and update() consumes the cached numbers. Reading layout per frame
 * forces a synchronous reflow that collides with the dock morph's own
 * per-frame layout and makes the condense stutter.
 */

function docTop(el) {
	let y = 0;
	for (let n = el; n; n = n.offsetParent) y += n.offsetTop;
	return y;
}

export function initNav() {
	const prog = document.querySelector('[data-scroll-progress]');
	const hero = document.getElementById('hero');
	const headerEl = document.querySelector('header');
	const spyNav = document.querySelector('[data-nav-spy]');
	const ind = spyNav?.querySelector('[data-nav-ind]');
	const links = spyNav ? gsap.utils.toArray('a[href^="#"]', spyNav) : [];
	const map = links
		.map((a) => ({ a, sec: document.querySelector(a.hash) }))
		.filter((x) => x.sec);

	let current = null;

	// IDE line-number gutter (decorative; CSS shows it 2xl+ only).
	const LINE_H = 28;
	const gutter = document.createElement('div');
	gutter.className = 'ide-gutter';
	gutter.setAttribute('aria-hidden', 'true');
	document.body.prepend(gutter);
	let gutterLines = 0;
	let gutterPad = 0;

	// Cached geometry (refreshed by measure(), never read in update()).
	let maxScroll = 1;
	let docH = 1;
	let secTops = [];

	const measure = () => {
		maxScroll = Math.max(1, document.documentElement.scrollHeight - window.innerHeight);
		docH = document.documentElement.scrollHeight;
		secTops = map.map((x) => docTop(x.sec));

		gutterPad = parseFloat(getComputedStyle(gutter).paddingTop) || 0;
		const lines = Math.max(0, Math.ceil((docH - gutterPad) / LINE_H));
		if (lines !== gutterLines) {
			gutterLines = lines;
			gutter.style.height = docH + 'px';
			let html = '';
			for (let i = 1; i <= lines; i++) html += '<span>' + i + '</span>';
			gutter.innerHTML = html;
		}
	};

	const moveIndicator = (link) => {
		if (!ind) return;
		if (!link) {
			gsap.to(ind, { opacity: 0, duration: reducedMotion.matches ? 0 : 0.25 });
			return;
		}
		const target = { x: link.offsetLeft, width: link.offsetWidth, opacity: 1 };
		if (reducedMotion.matches) gsap.set(ind, target);
		else gsap.to(ind, { ...target, duration: 0.45, ease: 'power3.out' });
	};

	const update = () => {
		const y = window.scrollY;

		if (prog) prog.style.transform = `scaleX(${Math.min(1, y / maxScroll)})`;

		// Full-width bar at the top; condenses into the dock on scroll.
		// Hysteresis (70 down / 30 up) keeps the boundary from chattering.
		if (headerEl) {
			const isScrolled = headerEl.classList.contains('nav-scrolled');
			const scrolled = isScrolled ? y > 30 : y >= 70;
			if (scrolled !== isScrolled) {
				headerEl.classList.toggle('nav-scrolled', scrolled);
				// Link positions shift during the morph: re-seat the
				// indicator once the transition settles.
				setTimeout(() => {
					measure();
					moveIndicator(current);
				}, 600);
			}
		}

		if (!map.length) return;
		const pos = y + 160;
		let active = null;
		for (let i = 0; i < map.length; i++) {
			if (secTops[i] <= pos) active = map[i];
		}
		if (window.innerHeight + y >= docH - 4) active = map[map.length - 1];

		const link = active ? active.a : null;
		if (link !== current) {
			current = link;
			links.forEach((l) => {
				if (l === current) l.setAttribute('aria-current', 'true');
				else l.removeAttribute('aria-current');
			});
			moveIndicator(current);
		}
	};

	window.addEventListener('scroll', update, { passive: true });
	window.addEventListener('resize', () => {
		measure();
		current = null;
		update();
	});
	// Re-measure once the web fonts settle (link widths change).
	document.fonts?.ready?.then(() => {
		measure();
		current = null;
		update();
	});
	// Late layout shifts (images sizing in) also move section tops.
	window.addEventListener('load', measure);

	measure();
	update();
}
