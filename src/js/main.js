import '../css/main.css';

import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import Lenis from 'lenis';

import { reducedMotion } from './lib/reduced-motion.js';
import { setLenis } from './lib/scroll.js';
import { initNav } from './nav.js';
import { initSkills } from './skills.js';
import { initHero } from './motion/hero.js';
import { initReveals } from './motion/reveals.js';
import { initStack } from './motion/stack.js';
import { initGridRain } from './motion/gridrain.js';
import { initClaudeMark } from './motion/claude.js';
import { initDrawIcons } from './motion/drawicons.js';
import { initTicker } from './motion/ticker.js';
import { initGallery, initBuildFlow, initCaseFloat } from './motion/carousel.js';
import { initPhilosophy } from './motion/philosophy.js';

gsap.registerPlugin(ScrollTrigger);

// Disables the CSS failsafe reveal — the bundle is alive.
document.documentElement.classList.add('gsap-ready');

/* ---------- Scrolling ----------
   Lenis smooth scrolling is ON (SMOOTH_SCROLL) — Dom's explicit call,
   2026-10-07: "animate every pixel smoothly". Native scrolling was tried
   for one day and felt WORSE (mouse wheels step ~100px per notch with
   nothing interpolating between). The catch with Lenis is that scrolling
   runs on the main thread, so ANY per-frame rendering cost becomes a
   scroll stutter — the 2026-10 jank was image decode mid-scroll, full-card
   paint transitions, and un-throttled hero loops, all fixed since. If
   scroll jank ever comes back, profile and fix the RENDERING (see the
   /motion perf budget); do not remove the glide. Flip to false for
   native scrolling — every code path below already supports it. */
const SMOOTH_SCROLL = true;

let lenis = null;
if (SMOOTH_SCROLL && !reducedMotion.matches) {
	lenis = new Lenis({ lerp: 0.12 });
	lenis.on('scroll', ScrollTrigger.update);
	gsap.ticker.add((time) => lenis.raf(time * 1000));
	gsap.ticker.lagSmoothing(0);
	setLenis(lenis);
}

// If the user enables reduced motion mid-session, stop smooth scrolling too
// (gsap.matchMedia reverts the animations on its own).
reducedMotion.addEventListener('change', (e) => {
	if (e.matches && lenis) {
		lenis.destroy();
		lenis = null;
	}
});

/* ---------- Anchor navigation: smooth scroll + move focus to the target ---------- */

// Must match the CSS scroll-padding-top (5.5rem) so the JS path and the
// native/reduced-motion path land identically.
const HEADER_OFFSET = 88;

function docTop(el) {
	let y = 0;
	for (let n = el; n; n = n.offsetParent) y += n.offsetTop;
	return y;
}

document.addEventListener('click', (e) => {
	const link = e.target.closest('a[href^="#"]');
	if (!link || link.hash.length < 2) return;
	const target = document.querySelector(link.hash);
	if (!target) return;

	e.preventDefault();
	closeMenu();

	const focusTarget = () => {
		if (!target.hasAttribute('tabindex')) target.tabIndex = -1;
		target.focus({ preventScroll: true });
	};

	if (lenis) {
		// Lenis fixes the destination at call time; layout can still shift
		// mid-glide (fonts/images settling), so re-measure on arrival and
		// snap the remaining drift.
		const dest = () => Math.max(0, docTop(target) - HEADER_OFFSET);
		lenis.scrollTo(dest(), {
			onComplete: () => {
				const d = dest();
				if (Math.abs(d - window.scrollY) > 2) lenis.scrollTo(d, { immediate: true });
				focusTarget();
			},
		});
	} else {
		target.scrollIntoView({ behavior: reducedMotion.matches ? 'auto' : 'smooth' });
		focusTarget();
	}
	history.pushState(null, '', link.hash);
});

/* ---------- Mobile menu (plain DOM, works with or without motion) ---------- */

const menuToggle = document.querySelector('.menu-toggle');
const mobileMenu = document.getElementById('mobile-menu');

function closeMenu() {
	if (!menuToggle || !mobileMenu || mobileMenu.hidden) return;
	// Don't strand keyboard focus inside a hidden menu.
	const hadFocus = mobileMenu.contains(document.activeElement);
	mobileMenu.hidden = true;
	if (hadFocus) menuToggle.focus();
	menuToggle.setAttribute('aria-expanded', 'false');
	menuToggle.querySelector('.menu-icon-open')?.classList.remove('hidden');
	menuToggle.querySelector('.menu-icon-close')?.classList.add('hidden');
}

menuToggle?.addEventListener('click', () => {
	const open = mobileMenu.hidden;
	mobileMenu.hidden = !open;
	menuToggle.setAttribute('aria-expanded', String(open));
	menuToggle.querySelector('.menu-icon-open')?.classList.toggle('hidden', open);
	menuToggle.querySelector('.menu-icon-close')?.classList.toggle('hidden', !open);
});

document.addEventListener('keydown', (e) => {
	if (e.key === 'Escape') closeMenu();
});

/* ---------- Motion modules (each self-gates via gsap.matchMedia) ---------- */

initNav();
initSkills();
initHero();
initReveals();
initStack();
initGridRain();
initClaudeMark();
initDrawIcons();
initTicker();
initGallery();
initBuildFlow();
initCaseFloat();
initPhilosophy();

/* ---------- Announce the post-submit contact banner reliably ---------- */

const contactStatus = new URLSearchParams(location.search).get('contact');
if (contactStatus !== null) {
	const banner = document.querySelector('.form-banner');
	if (banner) {
		banner.tabIndex = -1;
		banner.focus({ preventScroll: false });
	}
}

/* ---------- Contact form draft: survive the server-side error redirect ----------
   The handler redirects on validation failure, which would wipe typed
   input. Field values are mirrored into sessionStorage as the visitor
   types, restored on load unless the submission succeeded, and cleared
   on success. Wrapped in try/catch: storage can throw in private
   windows, and the form must work identically without it. */

try {
	const form = document.querySelector('#contact form');
	const KEY = 'domdag-contact-draft';
	if (form) {
		const fields = ['your_name', 'your_email', 'your_message']
			.map((n) => form.elements[n])
			.filter(Boolean);
		if (contactStatus === 'sent') {
			sessionStorage.removeItem(KEY);
		} else {
			const draft = JSON.parse(sessionStorage.getItem(KEY) || '{}');
			fields.forEach((f) => {
				if (!f.value && draft[f.name]) f.value = draft[f.name];
			});
		}
		form.addEventListener('input', () => {
			const draft = {};
			fields.forEach((f) => { draft[f.name] = f.value; });
			sessionStorage.setItem(KEY, JSON.stringify(draft));
		});
	}
} catch (_) {
	/* storage unavailable: plain form behavior */
}
