import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import { DrawSVGPlugin } from 'gsap/DrawSVGPlugin';
import { MOTION_OK as MOTION_OK_Q } from '../lib/reduced-motion.js';

gsap.registerPlugin(ScrollTrigger, DrawSVGPlugin);

/**
 * Case-study "What I built" flow: a signal sweeps the wire left to
 * right; as it reaches each step the node pops in, the label lights,
 * and the body text drops down to reveal. The ambient traveling pulse
 * (CSS) only fades in after the sweep lands — ambient layer last, per
 * the motion-design skill. On mobile the wire is hidden, so the same
 * timeline simply reads as a slow top-to-bottom cascade.
 */
export function initBuildFlow() {
	const mm = gsap.matchMedia();

	mm.add(MOTION_OK_Q, () => {
		const root = document.querySelector('[data-build-flow]');
		if (!root) return;
		const sweep = root.querySelector('.wire-sweep');
		const pulse = root.querySelector('.wire-pulse');
		const steps = gsap.utils.toArray(root.querySelectorAll('ol > li'));
		if (!sweep || !steps.length) return;

		// The signal LATCHES onto each dot: it eases into the node,
		// stops dead while that step reveals, then pulls away to the
		// next. TRAVEL = seconds for a full crossing (tuned down from
		// 6.3 — the slow version was a sit-through).
		const TRAVEL = 3.2;
		gsap.set(pulse, { opacity: 0 });
		gsap.set(sweep, { drawSVG: '0%' });

		const tl = gsap.timeline({
			scrollTrigger: { trigger: root, start: 'top 80%', once: true },
		});

		let pos = 0;
		steps.forEach((step, i) => {
			const node = step.querySelector('.flow-node');
			const label = step.querySelector('.flow-label');
			const body = step.querySelector('.flow-body');
			gsap.set(node, { scale: 0, opacity: 0, transformOrigin: 'center' });
			gsap.set(label, { opacity: 0 });
			gsap.set(body, { opacity: 0, y: -12 });
			const target = (100 / steps.length) * (i + 0.5);
			tl.to(sweep, {
				drawSVG: target + '%',
				duration: TRAVEL * (target - pos) / 100,
				ease: 'power1.inOut', // decelerates INTO the dot
			})
				.to(node, { scale: 1, opacity: 1, duration: 0.35, ease: 'power2.out' })
				.to(label, { opacity: 1, duration: 0.3 }, '-=0.22')
				.to(body, { opacity: 1, y: 0, duration: 0.45, ease: 'power2.out' }, '-=0.18');
			pos = target;
		});

		// release from the last dot and run out
		tl.to(sweep, { drawSVG: '100%', duration: TRAVEL * (100 - pos) / 100, ease: 'power1.in' }, '+=0.2')
			.to(sweep, { opacity: 0, duration: 0.7 })
			.call(() => armAmbient());

		// After the sweep: on fine pointers the dash FOLLOWS the mouse
		// along the wire (lerped via one quickSetter write per frame,
		// idle-skipped — per the perf contract no layout reads happen
		// here; the wire rect is cached on pointerenter). Touch and
		// coarse pointers keep the slow CSS crawl instead.
		let tickFn = null;
		const armAmbient = () => {
			const fine = window.matchMedia('(hover: hover) and (pointer: fine)');
			if (!fine.matches || !pulse) {
				gsap.to(pulse, { opacity: 1, duration: 0.8 });
				return;
			}
			pulse.style.animation = 'none';
			const setOff = gsap.quickSetter(pulse, 'strokeDashoffset');
			const setOp = gsap.quickSetter(pulse, 'opacity');
			let cur = 10;
			let tgt = 10;
			let op = 0;
			let opT = 0;
			let rect = null;
			let nodeCenters = [];
			const enter = () => {
				rect = root.getBoundingClientRect();
				// each node's center as a % of the wire, so the dash always
				// docks in the SAME spot on every box: centered on its node
				nodeCenters = steps.map((li) => {
					const n = li.querySelector('.flow-node');
					const r = n.getBoundingClientRect();
					return ((r.left + r.width / 2 - rect.left) / rect.width) * 100;
				});
				opT = 1;
			};
			const move = (e) => {
				if (!rect || !nodeCenters.length) enter();
				const x = ((e.clientX - rect.left) / rect.width) * 100;
				// containment, not nearest-node: whichever COLUMN the cursor
				// is in owns the dash (nodes sit at column left edges, so
				// nearest-node handed the right half of a box to the next
				// node and the dash looked misplaced)
				const col = Math.min(Math.max(Math.floor(x / (100 / nodeCenters.length)), 0), nodeCenters.length - 1);
				// dash LEFT edge sits on the dot and the tail extends right
				tgt = Math.min(Math.max(nodeCenters[col], 0), 93);
			};
			const leave = () => { opT = 0; };
			tickFn = () => {
				if (Math.abs(tgt - cur) < 0.05 && Math.abs(opT - op) < 0.01) return;
				cur += (tgt - cur) * 0.14;
				op += (opT - op) * 0.12;
				setOff(-cur);
				setOp(op * 0.9);
			};
			root.addEventListener('pointerenter', enter);
			root.addEventListener('pointermove', move, { passive: true });
			root.addEventListener('pointerleave', leave);
			gsap.ticker.add(tickFn);
		};

		return () => {
			tl.scrollTrigger?.kill();
			tl.kill();
			if (tickFn) gsap.ticker.remove(tickFn);
		};
	});
}

/**
 * Floating case dock: visible while the reader is between the hero and
 * the hand-off section. Pure IntersectionObserver state (no scroll
 * handlers, works under reduced motion — the CSS just drops the
 * transition there).
 */
export function initCaseFloat() {
	const dock = document.querySelector('[data-case-float]');
	const hero = document.querySelector('[data-case-hero]');
	const end = document.querySelector('[data-case-end]');
	if (!dock || !hero) return;
	let pastHero = false;
	let atEnd = false;
	const paint = () => dock.classList.toggle('is-on', pastHero && !atEnd);
	const ioHero = new IntersectionObserver(([e]) => {
		pastHero = !e.isIntersecting && e.boundingClientRect.bottom < 0;
		paint();
	});
	ioHero.observe(hero);
	if (end) {
		const ioEnd = new IntersectionObserver(([e]) => {
			atEnd = e.isIntersecting;
			paint();
		});
		ioEnd.observe(end);
	}
}

/**
 * Case-study gallery: a fixed-height stage + filmstrip thumbnails
 * (replaced the horizontal scroll-snap carousel — mixed-aspect
 * screenshots made slide heights jump and offsets read as cut-off
 * slides; a constant stage sidesteps all of it). Thumbs, prev/next,
 * and arrow keys switch the featured shot with a quick fade
 * (motion-ok only); clicking the stage opens the lightbox, a native
 * <dialog> whose prev/next walk the same item list.
 */

const MOTION_OK = window.matchMedia('(prefers-reduced-motion: no-preference)');

export function initGallery() {
	const root = document.querySelector('[data-gallery]');
	if (!root) return;
	const stage = root.querySelector('[data-gal-stage]');
	const img = root.querySelector('[data-gal-img]');
	const num = root.querySelector('[data-gal-num]');
	const cap = root.querySelector('[data-gal-cap]');
	const thumbs = Array.from(root.querySelectorAll('[data-gal-thumb]'));
	const prev = root.querySelector('[data-gal-prev]');
	const next = root.querySelector('[data-gal-next]');
	if (!stage || !img) return;

	// Item list: from the thumbs, or just the stage's initial shot.
	const items = thumbs.length
		? thumbs.map((t) => ({ src: t.dataset.galSrc, alt: t.dataset.galAlt, caption: t.dataset.galCaption, w: t.dataset.galW, h: t.dataset.galH }))
		: [{ src: img.src, alt: img.alt, caption: cap?.textContent || '', w: img.width, h: img.height }];
	let index = 0;

	const render = () => {
		const it = items[index];
		img.src = it.src;
		img.alt = it.alt || '';
		if (it.w) img.width = it.w;
		if (it.h) img.height = it.h;
		if (num) num.textContent = String(index + 1).padStart(2, '0');
		if (cap) cap.textContent = it.caption || '';
		thumbs.forEach((t, k) => {
			if (k === index) {
				t.setAttribute('aria-current', 'true');
				t.scrollIntoView({ block: 'nearest', inline: 'nearest', behavior: MOTION_OK.matches ? 'smooth' : 'auto' });
			} else {
				t.removeAttribute('aria-current');
			}
		});
	};
	const show = (i) => {
		index = (i + items.length) % items.length;
		if (MOTION_OK.matches) {
			img.classList.add('is-swapping');
			setTimeout(() => {
				render();
				// let the new frame decode, then fade back in
				requestAnimationFrame(() => img.classList.remove('is-swapping'));
			}, 220);
		} else {
			render();
		}
	};
	thumbs.forEach((t, i) => t.addEventListener('click', () => show(i)));
	prev?.addEventListener('click', () => show(index - 1));
	next?.addEventListener('click', () => show(index + 1));
	// arrow keys browse while the stage has focus; the filmstrip keeps
	// the active thumb in view as the index moves
	stage.addEventListener('keydown', (e) => {
		if (e.key === 'ArrowLeft') { e.preventDefault(); show(index - 1); }
		if (e.key === 'ArrowRight') { e.preventDefault(); show(index + 1); }
	});

	// ---- Lightbox: native <dialog>; Esc + focus handling come free ----
	const box = document.querySelector('dialog.lightbox');
	if (box && typeof box.showModal === 'function') {
		const lbImg = box.querySelector('[data-lb-img]');
		const lbCap = box.querySelector('[data-lb-cap]');
		let lbIndex = 0;
		const lbShow = (i) => {
			lbIndex = (i + items.length) % items.length;
			const it = items[lbIndex];
			lbImg.src = it.src;
			lbImg.alt = it.alt || '';
			lbCap.textContent = it.caption || '';
			lbCap.hidden = !it.caption;
		};
		stage.addEventListener('click', () => {
			lbShow(index);
			box.showModal();
		});
		box.querySelector('[data-lb-close]')?.addEventListener('click', () => box.close());
		box.querySelector('[data-lb-prev]')?.addEventListener('click', () => lbShow(lbIndex - 1));
		box.querySelector('[data-lb-next]')?.addEventListener('click', () => lbShow(lbIndex + 1));
		box.addEventListener('click', (e) => {
			if (e.target === box) box.close();
		});
		box.addEventListener('keydown', (e) => {
			if (e.key === 'ArrowLeft') lbShow(lbIndex - 1);
			if (e.key === 'ArrowRight') lbShow(lbIndex + 1);
		});
		box.addEventListener('close', () => {
			// keep stage and lightbox in sync, and hand focus back
			show(lbIndex);
			stage.focus();
		});
	}
}
