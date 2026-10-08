/**
 * Toolbox tile disclosures (About section). Each category card's tiles act
 * as disclosure buttons for a shared description panel: click a tile to
 * read a plain-English explanation, click it again to close. Runs for
 * everyone — the open/close glide is pure CSS (grid-template-rows), which
 * the global reduced-motion rules turn into an instant toggle.
 */
export function initSkills() {
	document.querySelectorAll('.bento-card').forEach((card) => {
		const buttons = [...card.querySelectorAll('.tech-tile-btn')];
		const panel = card.querySelector('.skill-panel');
		if (!buttons.length || !panel) return;

		const term = panel.querySelector('.skill-panel-term');
		const desc = panel.querySelector('.skill-panel-desc');
		let active = null;

		const close = () => {
			if (active) active.setAttribute('aria-expanded', 'false');
			active = null;
			panel.classList.remove('open');
			panel.setAttribute('aria-hidden', 'true');
		};

		buttons.forEach((btn) => {
			btn.addEventListener('click', () => {
				if (active === btn) {
					close();
					return;
				}
				if (active) active.setAttribute('aria-expanded', 'false');
				active = btn;
				btn.setAttribute('aria-expanded', 'true');
				term.textContent = btn.dataset.skillLabel + '.';
				desc.textContent = btn.dataset.skillDesc;
				panel.classList.add('open');
				panel.setAttribute('aria-hidden', 'false');
			});
		});
	});
}
