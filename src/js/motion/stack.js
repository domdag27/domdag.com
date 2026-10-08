import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import { MOTION_OK, reducedMotion } from '../lib/reduced-motion.js';
import { scrollToY } from '../lib/scroll.js';

gsap.registerPlugin(ScrollTrigger);

/**
 * Work stack. The deck itself is pure CSS (position: sticky) so scrolling
 * stays native everywhere.
 *
 * Always on (navigation state, not decoration):
 * - active-card tracking: .stack-active on the card holding the top spot,
 *   mirrored to the deck-nav dots via aria-current
 * - dot clicks scroll the page so that project takes the top spot
 *
 * Motion-gated:
 * - entry reveal (card opacity + y, once)
 * - recede while covered (card scale + .stack-veil opacity, scrubbed)
 *
 * Trigger positions come from offsetTop (natural layout), never rects —
 * a stuck sticky panel reports a pinned rect, which would corrupt every
 * refresh that happens mid-deck (mobile URL-bar show/hide).
 */

function docTop(el) {
	let y = 0;
	for (let n = el; n; n = n.offsetParent) y += n.offsetTop;
	return y;
}

export function initStack() {
	const panels = gsap.utils.toArray('[data-stack] .stack-panel');
	if (panels.length < 2) return;

	const dots = gsap.utils.toArray('[data-deck-dot]');
	const countEl = document.querySelector('[data-deck-current]');
	const deck = panels[0].parentElement;
	const deckBottom = () => docTop(deck) + deck.offsetHeight;

	// A STUCK sticky element reports its displaced position through
	// offsetTop, so docTop(panel) goes stale for every panel already
	// scrolled past (dot clicks to earlier projects would mis-target).
	// Natural positions are rebuilt from list geometry instead: the deck's
	// own top plus the heights and row-gap of the preceding panels.
	const naturalTop = (i) => {
		const gap = parseFloat(getComputedStyle(deck).rowGap) || 0;
		let y = docTop(deck);
		for (let j = 0; j < i; j++) y += panels[j].offsetHeight + gap;
		return y;
	};

	/* ---------- always on: position tracking + dot navigation ---------- */

	panels.forEach((panel, i) => {
		const next = panels[i + 1];
		ScrollTrigger.create({
			start: () => naturalTop(i) - window.innerHeight * 0.6,
			end: () => (next ? naturalTop(i + 1) - window.innerHeight * 0.45 : deckBottom()),
			onToggle: (self) => {
				panel.classList.toggle('stack-active', self.isActive);
				const dot = dots[i];
				if (dot) {
					if (self.isActive) dot.setAttribute('aria-current', 'true');
					else dot.removeAttribute('aria-current');
				}
				if (self.isActive && countEl) {
					countEl.textContent = String(i + 1).padStart(2, '0');
				}
			},
		});
	});

	// Warm the deck's screenshots before the visitor reaches them: decoding
	// a lazy-loaded image mid-scroll is a visible hitch per card (measured
	// ~half the deck's dropped frames). Once the deck is within 1.5
	// viewports they are all about to be seen anyway. Runs regardless of
	// reduced motion — it's loading, not animation.
	const warm = new IntersectionObserver((entries) => {
		if (!entries.some((e) => e.isIntersecting)) return;
		warm.disconnect();
		deck.querySelectorAll('img[loading="lazy"]').forEach((img) => {
			img.loading = 'eager';
			if (img.decode) img.decode().catch(() => {});
		});
	}, { rootMargin: '150% 0px' });
	warm.observe(deck);

	dots.forEach((dot, i) => {
		dot.addEventListener('click', () => {
			const panel = panels[i];
			if (!panel) return;
			const stickyTop = parseFloat(getComputedStyle(panel).top) || 88;
			// Through the shared helper: Lenis owns the scroll position when
			// it runs, so a native smooth window.scrollTo would be overridden.
			scrollToY(naturalTop(i) - stickyTop + 2, !reducedMotion.matches);
		});
	});

	/* ---------- motion-gated: reveal + recede ---------- */

	const mm = gsap.matchMedia();

	mm.add(MOTION_OK, () => {
		panels.forEach((panel, i) => {
			const veil = panel.querySelector('.stack-veil');

			// Reveal and recede both target the PANEL (not the card): the
			// active-glow ::after lives on the panel, so scaling the panel
			// keeps the glow tracking the card exactly, and GSAP merges the
			// y/scale transforms on one element.
			//
			// will-change discipline for the whole deck: a panel is promoted
			// to its own layer ONLY while one of its tweens is live —
			// animating opacity/transform on an unpromoted card re-rasters
			// the full card every frame (the measured per-card hitch), while
			// 11 permanently promoted panels waste GPU memory instead.
			let revealing = false;
			let receding = false;
			const syncLayer = () => {
				gsap.set(panel, { willChange: revealing || receding ? 'transform, opacity' : 'auto' });
			};

			gsap.fromTo(
				panel,
				{ opacity: 0, y: 40 },
				{
					opacity: 1,
					y: 0,
					duration: 0.8,
					ease: 'power3.out',
					onStart: () => { revealing = true; syncLayer(); },
					onComplete: () => { revealing = false; syncLayer(); },
					scrollTrigger: {
						start: () => naturalTop(i) - window.innerHeight * 0.85,
						once: true,
					},
				}
			);

			const next = panels[i + 1];
			if (!next) return;

			// One scrubbed timeline (panel scale + veil dim) per covered card.
			const recede = gsap.timeline({
				scrollTrigger: {
					start: () => naturalTop(i + 1) - window.innerHeight,
					end: () => naturalTop(i + 1) - window.innerHeight * 0.25,
					// 0.4s catch-up, not hard-linked: native mouse wheels
					// scroll in ~100px steps and a true scrub snaps with them.
					scrub: 0.4,
					onToggle: (self) => {
						receding = self.isActive;
						syncLayer();
						if (veil) gsap.set(veil, { willChange: self.isActive ? 'opacity' : 'auto' });
					},
				},
			});
			recede.fromTo(panel, { scale: 1 }, { scale: 0.955, transformOrigin: 'center top', ease: 'none' }, 0);
			if (veil) recede.fromTo(veil, { opacity: 0 }, { opacity: 0.5, ease: 'none' }, 0);
		});
	});
}
