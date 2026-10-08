# domdag.com

The custom WordPress theme behind [domdag.com](https://domdag.com), my portfolio. The site is the work sample; this repo is the source.

**Stack:** classic PHP theme · Vite 6 · Tailwind CSS v4 · GSAP 3 (ScrollTrigger, SplitText, DrawSVG) · Lenis smooth scrolling. No page builders, no component framework: server-rendered HTML with a single deferred JS bundle.

## What to look at

**Performance is a budget, not a hope.**
- The whole stylesheet is inlined into `<head>` (`inc/assets.php`) because it was the page's only render-blocking request. The page ships at ~31KB over the wire.
- One JS bundle, under 66KB gzipped *including* GSAP, ScrollTrigger, SplitText, and Lenis. The budget (90KB) is written into [`/.claude/skills/motion/SKILL.md`](.claude/skills/motion/SKILL.md) along with the rules that keep it honest.
- Hard rule, enforced in review: animate transform/opacity/clip-path only, and never read layout on the scroll path. `src/js/nav.js` opens with the performance contract; every measured value is cached outside the frame loop.

**Accessibility is in the defaults.**
- Every motion module wraps its work in `gsap.matchMedia('(prefers-reduced-motion: no-preference)')` and renders a coherent static state without it. Lenis is never constructed under reduced motion.
- Semantic landmarks, skip link, managed focus on anchor navigation, `aria-live` where state changes, and WCAG-checked contrast ratios recorded as comments next to the tokens they describe (`src/css/main.css`).

**One source of truth.**
- All content lives in `inc/data.php`: profile, projects, case studies, skills, experience. Templates are dumb loops. The JSON-LD in `inc/seo.php` and the generated resume PDF (`resume/build.py`) read the same data, so copy can never drift between surfaces.

**Motion with intent.**
- `src/js/motion/` is a set of small, self-cleaning modules: the hero's how-it-works diagram, scroll reveals, the work deck's sticky stack, a scroll-snap-free gallery with a native `<dialog>` lightbox, and the case pages' signal-wire choreography.
- Design decisions that were tried and rejected are documented in the motion playbook so they stay rejected.

## Working on it

```bash
npm install
npm run build   # production build -> dist/ (manifest read by inc/assets.php)
npm run dev     # watch mode
```

The theme expects a standard WordPress install with this directory at `wp-content/themes/domdag/`.

## A note on the `.claude/` directory

This project is also an experiment in AI-assisted development done seriously: the `.claude/` directory at the project root (not in this repo) contains the skills and review agents that enforce the rules above — an adversarial recruiter critic, accessibility and SEO auditors, and playbooks for motion, copy, and design tokens. I use Claude daily; the judgment and the final call on every line stay human.

---

© Domenick D'Agostino. Code is published for review as a work sample; the client imagery and content belong to their respective owners.
