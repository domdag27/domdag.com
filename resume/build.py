#!/usr/bin/env python3
"""
Resume generator: reads site data as JSON on stdin (see build.sh) and
writes the branded one-page PDF.

Brand rules (see .claude/skills/resume): light background, black text,
Space Grotesk headings + Inter body + mono details, ONE accent color in
the print-safe deep cyan (#0e7490) because the site's screen accent
(#a3e635) fails contrast on white. ATS-safe: real embedded text, no
tables, no graphics carrying meaning. Must stay exactly one page, and
should USE the page: target bottom edge ~245-262mm, not a half-empty
sheet.
"""
import json
import sys
from pathlib import Path

from fpdf import FPDF

HERE = Path(__file__).parent
OUT = HERE.parent / 'assets' / 'Domenick-DAgostino-Resume.pdf'

ACCENT = (14, 116, 144)     # #0e7490 deep cyan, print-safe match for the site's #1FD5F9 (lime era: #4d7c0f)
INK = (17, 24, 39)
MUTED = (90, 98, 110)
HAIR = (224, 227, 222)

data = json.load(sys.stdin)
profile, skills, experience, education = (
    data['profile'], data['skills'], data['experience'], data['education'])
clients = data.get('clients', [])

pdf = FPDF(format='Letter', unit='mm')
pdf.set_title("Domenick D'Agostino Resume")
pdf.set_author("Domenick D'Agostino")
pdf.set_auto_page_break(False)
pdf.add_page()
for fam, style, file in [
    ('SpaceGrotesk', '', 'SpaceGrotesk-Regular.ttf'),
    ('SpaceGrotesk', 'B', 'SpaceGrotesk-Bold.ttf'),
    ('SpaceGroteskMed', '', 'SpaceGrotesk-Medium.ttf'),
    ('Inter', '', 'Inter-Regular.ttf'),
    ('Inter', 'B', 'Inter-Bold.ttf'),
    ('InterSemi', '', 'Inter-SemiBold.ttf'),
]:
    pdf.add_font(fam, style, str(HERE / 'fonts' / file))
pdf.add_font('Mono', '', '/usr/share/fonts/truetype/dejavu/DejaVuSansMono.ttf')

W = 216
ML, MR, MT = 16, 16, 16
LEFT_W = 58           # sidebar column width
GUTTER = 9
RIGHT_X = ML + LEFT_W + GUTTER
RIGHT_W = W - MR - RIGHT_X

# ---- Header ----
pdf.set_xy(ML, MT)
pdf.set_text_color(*INK)
pdf.set_font('SpaceGrotesk', 'B', 29)
pdf.cell(0, 11, profile['name'])
pdf.set_xy(ML, MT + 12)
pdf.set_font('SpaceGroteskMed', '', 13)
pdf.set_text_color(*ACCENT)
pdf.cell(0, 7, profile['title'])

# Portfolio line: the single most important link on the page.
py = MT + 22.5
pdf.set_fill_color(*ACCENT)
pdf.rect(ML + 0.3, py + 1.6, 2.2, 2.2, 'F')
pdf.set_xy(ML + 5, py)
pdf.set_font('Mono', '', 8.2)
pdf.set_text_color(*MUTED)
pdf.cell(pdf.get_string_width('PORTFOLIO') + 3, 5.4, 'PORTFOLIO')
pdf.set_font('SpaceGrotesk', 'B', 12.5)
pdf.set_text_color(*ACCENT)
pdf.cell(60, 5.4, 'domdag.com', link='https://domdag.com')

pdf.set_font('Mono', '', 8.4)
pdf.set_text_color(*MUTED)
contact_lines = [
    (profile['email'], 'mailto:' + profile['email']),
    (profile['phone'], None),
    (profile['location'], None),
    ('linkedin.com/in/domenickedagostino', profile['linkedin']),
]
for i, (line, href) in enumerate(contact_lines):
    pdf.set_xy(W - MR - 80, MT + 2 + i * 5.1)
    pdf.cell(80, 5.1, line, align='R', link=href or '')

pdf.set_draw_color(*ACCENT)
pdf.set_line_width(0.9)
pdf.line(ML, MT + 31.5, W - MR, MT + 31.5)

TOP = MT + 39


def section_head(x, y, w, label):
    pdf.set_xy(x, y)
    pdf.set_font('SpaceGrotesk', 'B', 11.5)
    pdf.set_text_color(*ACCENT)
    pdf.cell(w, 6, label.upper())
    pdf.set_draw_color(*HAIR)
    pdf.set_line_width(0.3)
    pdf.line(x, y + 7, x + w, y + 7)
    return y + 9.8


# ---- Left column: skills + education ----
y = section_head(ML, TOP, LEFT_W, 'Skills')
for group, items in skills.items():
    pdf.set_xy(ML, y)
    pdf.set_font('InterSemi', '', 9.4)
    pdf.set_text_color(*INK)
    pdf.multi_cell(LEFT_W, 4.5, group, align='L')
    y = pdf.get_y() + 0.8
    pdf.set_xy(ML, y)
    pdf.set_font('Inter', '', 9.2)
    pdf.set_text_color(*MUTED)
    pdf.multi_cell(LEFT_W, 4.5, ', '.join(i['label'] for i in items), align='L')
    y = pdf.get_y() + 4.4

# Recognizable names beat adjectives (see /recruiter-grade); sourced from
# domdag_projects() so this always matches the site's work deck.
if clients:
    y = section_head(ML, y + 3, LEFT_W, 'Selected Clients')
    for name in clients:
        pdf.set_fill_color(*ACCENT)
        pdf.rect(ML + 2.4, y + 1.4, 1.5, 1.5, 'F')
        pdf.set_xy(ML + 5.8, y)
        pdf.set_font('Inter', '', 9.2)
        pdf.set_text_color(*INK)
        pdf.multi_cell(LEFT_W - 5.8, 4.4, name, align='L')
        y = pdf.get_y() + 1.0
    y += 2.2

y = section_head(ML, y + 3, LEFT_W, 'Education')
pdf.set_xy(ML, y)
pdf.set_font('InterSemi', '', 9.4)
pdf.set_text_color(*INK)
pdf.multi_cell(LEFT_W, 4.5, education['school'], align='L')
pdf.set_xy(ML, pdf.get_y() + 0.8)
pdf.set_font('Inter', '', 9.2)
pdf.set_text_color(*MUTED)
pdf.multi_cell(LEFT_W, 4.5, education['degree'], align='L')
pdf.set_xy(ML, pdf.get_y() + 0.8)
pdf.set_font('Mono', '', 8.2)
pdf.multi_cell(LEFT_W, 4.5, education['period'], align='L')
pdf.set_xy(ML, pdf.get_y() + 0.8)
pdf.set_font('Inter', '', 9.2)
pdf.multi_cell(LEFT_W, 4.5, education['extra'], align='L')

# ---- Right column: profile + experience ----
y = section_head(RIGHT_X, TOP, RIGHT_W, 'Profile')
pdf.set_xy(RIGHT_X, y)
pdf.set_font('Inter', '', 9.8)
pdf.set_text_color(*INK)
pdf.multi_cell(RIGHT_W, 5.0, profile['summary'], align='L')
y = pdf.get_y() + 4.6

y = section_head(RIGHT_X, y, RIGHT_W, 'Experience')
for job in experience:
    pdf.set_xy(RIGHT_X, y)
    pdf.set_font('SpaceGrotesk', 'B', 11.2)
    pdf.set_text_color(*INK)
    pdf.cell(RIGHT_W - 34, 5.6, job['role'])
    pdf.set_font('Mono', '', 8.2)
    pdf.set_text_color(*MUTED)
    pdf.set_xy(RIGHT_X + RIGHT_W - 34, y + 0.8)
    pdf.cell(34, 4.4, job['period'], align='R')
    y += 6.0
    pdf.set_xy(RIGHT_X, y)
    pdf.set_font('InterSemi', '', 9.6)
    pdf.set_text_color(*ACCENT)
    company_w = pdf.get_string_width(job['company'])
    pdf.cell(company_w + 2, 4.6, job['company'])
    if job.get('where'):
        pdf.set_font('Inter', '', 8.8)
        pdf.set_text_color(*MUTED)
        pdf.cell(RIGHT_W - company_w - 2, 4.6, '· ' + job['where'])
    y += 6.2
    for b in job['bullets']:
        pdf.set_fill_color(*ACCENT)
        pdf.rect(RIGHT_X + 2.6, y + 1.5, 1.7, 1.7, 'F')
        pdf.set_xy(RIGHT_X + 6.8, y)
        pdf.set_font('Inter', '', 9.3)
        pdf.set_text_color(*INK)
        pdf.multi_cell(RIGHT_W - 6.8, 4.55, b, align='L')
        y = pdf.get_y() + 1.15
    y += 3.0

assert pdf.pages_count == 1, f'resume overflowed to {pdf.pages_count} pages'
assert y <= 279 - 12, f'content ran past the bottom margin (y={y:.1f})'

OUT.parent.mkdir(exist_ok=True)
pdf.output(str(OUT))
print(f'wrote {OUT} ({OUT.stat().st_size // 1024} KB), bottom y={y:.1f}mm')
