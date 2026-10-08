/**
 * Shared programmatic scrolling. When Lenis is running it OWNS the scroll
 * position, so native window.scrollTo({behavior:'smooth'}) gets overridden
 * and appears to do nothing — every module must scroll through here.
 */
let lenis = null;

export function setLenis(instance) {
	lenis = instance;
}

export function scrollToY(y, smooth = true) {
	if (lenis) {
		lenis.scrollTo(y, smooth ? {} : { immediate: true });
	} else {
		window.scrollTo({ top: y, behavior: smooth ? 'smooth' : 'auto' });
	}
}
