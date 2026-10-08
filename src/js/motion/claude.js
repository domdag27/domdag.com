import { gsap } from 'gsap';
import { MOTION_OK } from '../lib/reduced-motion.js';

/**
 * The Claude starburst on the featured About card: a gentle idle bob with
 * a playful full spin every few seconds. Small, decorative, paused while
 * off-screen, and absent entirely under reduced motion.
 */
export function initClaudeMark() {
	const mark = document.querySelector('.claude-mark');
	if (!mark) return;

	const mm = gsap.matchMedia();

	mm.add(MOTION_OK, () => {
		const bob = gsap.to(mark, {
			y: -4,
			duration: 2.2,
			yoyo: true,
			repeat: -1,
			ease: 'sine.inOut',
			paused: true,
		});
		const spin = gsap.to(mark, {
			rotation: 360,
			duration: 1.1,
			ease: 'back.out(1.4)',
			repeat: -1,
			repeatDelay: 6.8,
			transformOrigin: '50% 50%',
			paused: true,
		});

		const io = new IntersectionObserver(([entry]) => {
			const on = entry.isIntersecting;
			bob[on ? 'play' : 'pause']();
			spin[on ? 'play' : 'pause']();
		});
		io.observe(mark);

		return () => {
			io.disconnect();
			bob.kill();
			spin.kill();
			gsap.set(mark, { clearProps: 'all' });
		};
	});
}
