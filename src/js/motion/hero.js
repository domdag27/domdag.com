import { gsap } from 'gsap';
import { SplitText } from 'gsap/SplitText';
import { MOTION_OK } from '../lib/reduced-motion.js';

gsap.registerPlugin(SplitText);

/**
 * Hero entrance: headline words rise in, then the supporting elements
 * stagger up. Runs once on load.
 */
export function initHero() {
	const mm = gsap.matchMedia();

	mm.add(MOTION_OK, () => {
		const headline = document.querySelector('#hero [data-split]');
		const animated = gsap.utils.toArray('#hero [data-animate]');
		if (!headline) return;

		const split = new SplitText(headline, { type: 'words', wordsClass: 'hero-word' });

		const tl = gsap.timeline({ defaults: { ease: 'power3.out' } });

		tl.set(headline, { opacity: 1 })
			.from(split.words, {
				yPercent: 110,
				opacity: 0,
				duration: 0.9,
				stagger: 0.045,
			})
			.to(animated, {
				opacity: 1,
				y: 0,
				duration: 0.7,
				stagger: 0.12,
				startAt: { y: 24 },
			}, '-=0.45');

		// How-it-works diagram: three numbered steps on one signal axis
		// (01 idea orb -> 02 code chip -> 03 product browser). The signal
		// pulses on the connections run in CSS; this ~9s loop tells the
		// story: the idea sparks, the chip flashes as it compiles, the
		// site builds in the browser and scrolls through two beats. The
		// drawn state is the finished site for no-JS/reduced-motion.
		const art = document.querySelector('#hero [data-hero-art]');
		let artTl = null;
		let shuffleCall = null;
		const spins = [];
		if (art) {
			const inNode = art.querySelector('.in-node');
			const inHalo = art.querySelector('.in-halo');
			const chipHalo = art.querySelector('.chip-halo');
			const chipFlash = art.querySelector('.chip-flash');
			const loader = art.querySelector('.scr-loader');
			const site = art.querySelector('.scr-site');
			const siteInner = art.querySelector('.scr-site-inner');
			const siteEls = gsap.utils.toArray('.site-el', art);

			// Continuous ambience: both dashed halos breathe gently.
			if (inHalo) spins.push(gsap.to(inHalo, { scale: 1.08, svgOrigin: '64 219', duration: 2.6, repeat: -1, yoyo: true, ease: 'sine.inOut' }));
			if (chipHalo) spins.push(gsap.to(chipHalo, { scale: 1.05, svgOrigin: '185 219', duration: 3.2, repeat: -1, yoyo: true, ease: 'sine.inOut' }));

			// The chip's pixel matrix: each cell flips (scaleX through 0,
			// like a tile turning on edge) and comes back as the other
			// face — pixel <-> code glyph. Cells are drawn checkerboarded
			// (even index = glyph showing), and each cycle flips twice so
			// a cell always returns to its drawn face before repeating.
			const cells = gsap.utils.toArray('.px-cell', art);
			cells.forEach((cell, i) => {
				const sq = cell.querySelector('.px-sq');
				const gl = cell.querySelector('.px-gl');
				if (!sq || !gl) return;
				let glyphShowing = i % 2 === 0;
				const tl = gsap.timeline({
					repeat: -1,
					delay: gsap.utils.random(0, 2.5),
					repeatDelay: gsap.utils.random(0.4, 1.8),
				});
				for (let k = 0; k < 2; k++) {
					const cur = glyphShowing ? gl : sq;
					const next = glyphShowing ? sq : gl;
					tl.to(cell, { scaleX: 0, duration: 0.16, ease: 'power1.in', transformOrigin: '50% 50%' })
						.set(cur, { opacity: 0 })
						.set(next, { opacity: 1 })
						.to(cell, { scaleX: 1, duration: 0.16, ease: 'power1.out' })
						.to(cell, { scaleX: 1, duration: gsap.utils.random(0.5, 1.6) });
					glyphShowing = !glyphShowing;
				}
				spins.push(tl);
			});

			// ...and the matrix keeps rearranging itself: every couple of
			// seconds two cells swap (or three rotate) to a new slot on the
			// 15-unit grid pitch, sliding while the flips keep running.
			// perm[cellIndex] = the slot that cell currently occupies.
			if (cells.length === 9) {
				const PITCH = 15;
				const slotX = (s) => (s % 3) * PITCH;
				const slotY = (s) => Math.floor(s / 3) * PITCH;
				const perm = cells.map((_, i) => i);
				const shuffle = () => {
					const picks = gsap.utils.shuffle(cells.map((_, i) => i)).slice(0, Math.random() < 0.6 ? 2 : 3);
					const firstSlot = perm[picks[0]];
					for (let k = 0; k < picks.length - 1; k++) perm[picks[k]] = perm[picks[k + 1]];
					perm[picks[picks.length - 1]] = firstSlot;
					picks.forEach((i, k) => {
						gsap.to(cells[i], {
							x: slotX(perm[i]) - slotX(i),
							y: slotY(perm[i]) - slotY(i),
							duration: 0.5,
							delay: k * 0.06,
							ease: 'power2.inOut',
						});
					});
					shuffleCall = gsap.delayedCall(gsap.utils.random(1.6, 3.0), shuffle);
				};
				shuffleCall = gsap.delayedCall(gsap.utils.random(1.0, 2.0), shuffle);
			}

			artTl = gsap.timeline({ delay: 0.6, repeat: -1, repeatDelay: 1.4, defaults: { ease: 'power2.out' } });
			artTl
				.set(site, { opacity: 1 }, 0)
				// 01 — the idea sparks.
				.fromTo(inNode,
					{ scale: 1, svgOrigin: '64 219' },
					{ scale: 1.6, duration: 0.3, repeat: 1, yoyo: true, ease: 'sine.inOut' },
					0
				)
				// 02 — the chip takes it in and compiles (border flash).
				.fromTo(chipFlash, { opacity: 0 }, { opacity: 1, duration: 0.25 }, 0.9)
				.to(chipFlash, { opacity: 0, duration: 0.5 }, 1.5)
				// 03 — the product comes online: loader sweeps, site builds.
				.fromTo(loader,
					{ opacity: 1, scaleX: 0, transformOrigin: 'left center' },
					{ scaleX: 1, duration: 0.45, ease: 'power4.out' },
					1.4
				)
				.to(loader, { opacity: 0, duration: 0.2 }, 1.9)
				.fromTo(siteEls,
					{ y: 10, opacity: 0 },
					{ y: 0, opacity: 1, duration: 0.35, stagger: 0.04, ease: 'power3.out' },
					1.6
				)
				// ...and the screen scrolls through the page in two beats.
				.fromTo(siteInner, { y: 0 }, { y: -70, duration: 1.6, ease: 'power2.inOut' }, 3.4)
				.to(siteInner, { y: -134, duration: 1.6, ease: 'power2.inOut' }, 5.6)
				// Close the loop on a blank screen (scene cut, not a glitch).
				.to(site, { opacity: 0, duration: 0.45 }, 7.8);

			// The scene lives in the background: as the visitor scrolls out
			// of the hero it drifts down and dissolves rather than moving
			// rigidly with the page like a card. Targets a dedicated wrapper
			// — NEVER the [data-animate] art element itself, or this scrubbed
			// tween records the pre-entrance opacity:0 as its start value and
			// any scroll makes the scene vanish.
			const drift = document.querySelector('#hero [data-hero-drift]');
			if (drift) {
				gsap.to(drift, {
					y: 70,
					opacity: 0.25,
					scale: 0.97,
					ease: 'none',
					scrollTrigger: {
						trigger: '#hero',
						start: 'top top',
						end: 'bottom top',
						// smoothed so stepped mouse-wheel input doesn't snap it
						scrub: 0.5,
					},
				});
			}
		}

		// Don't tick the art's infinite loops (story timeline, 9 pixel
		// flips, halos, shuffle) while the hero is off-screen: Lenis runs
		// scrolling on the main thread, so this work becomes scroll jank
		// for the entire rest of the page. Same pattern as gridrain/ticker.
		// shuffleCall is read at toggle time — shuffle() reassigns it, and
		// a paused delayedCall never fires, so none spawn while hidden.
		// The CSS wire pulses pause via .hero-offstage.
		const hero = document.getElementById('hero');
		let io = null;
		if (art && hero) {
			const loops = () => [artTl, shuffleCall, ...spins].filter(Boolean);
			io = new IntersectionObserver(([entry]) => {
				hero.classList.toggle('hero-offstage', !entry.isIntersecting);
				loops().forEach((a) => (entry.isIntersecting ? a.play() : a.pause()));
			});
			io.observe(hero);
		}

		return () => {
			split.revert();
			tl.kill();
			if (io) io.disconnect();
			hero?.classList.remove('hero-offstage');
			if (artTl) artTl.kill();
			if (shuffleCall) shuffleCall.kill();
			gsap.killTweensOf('#hero .px-cell');
			spins.forEach((s) => s.kill());
		};
	});

}
