<?php
$profile = domdag_profile();
$status  = isset( $_GET['contact'] ) ? sanitize_key( wp_unslash( $_GET['contact'] ) ) : '';

$channels = [
	[
		'label' => $profile['email'],
		'href'  => 'mailto:' . $profile['email'],
		'icon'  => '<path d="M4 6h16v12H4V6Zm0 1 8 6 8-6" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>',
	],
	[
		'label' => $profile['phone'],
		'href'  => 'tel:' . $profile['phone_href'],
		'icon'  => '<path d="M5 4h4l2 5-2.5 1.5a11 11 0 0 0 5 5L15 13l5 2v4a2 2 0 0 1-2 2A16 16 0 0 1 3 6a2 2 0 0 1 2-2Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>',
	],
	[
		'label'    => 'LinkedIn',
		'href'     => $profile['linkedin'],
		'external' => true,
		'icon'     => '<path d="M6.5 9.5v8M6.5 6.4v.1M11 17.5v-4.6a2.8 2.8 0 0 1 5.5 0v4.6" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>',
	],
	[
		'label'    => 'Resume (PDF)',
		'href'     => get_theme_file_uri( 'assets/Domenick-DAgostino-Resume.pdf' ) . '?v=' . filemtime( get_theme_file_path( 'assets/Domenick-DAgostino-Resume.pdf' ) ),
		'external' => true,
		'icon'     => '<path d="M7 3h7l4 4v14H7V3Zm7 0v4h4M10 12h6M10 15.5h6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>',
	],
];
?>
<section id="contact" aria-labelledby="contact-h" class="scene-contact relative border-t border-edge/60 bg-surface/30 py-20 md:py-[8.1rem]">
	<span class="section-index" aria-hidden="true">04</span>
	<div class="container-site relative">
		<div class="relative grid gap-12 lg:grid-cols-[1fr_1.618fr] lg:gap-16">
			<div data-reveal>
				<p class="prompt-eyebrow" aria-hidden="true"><span class="p-user">dom@domdag</span>:<span class="p-path">~/contact</span><span class="prompt-caret"></span></p>
				<h2 id="contact-h" class="section-title mt-3">Let's build something.</h2>
				<p class="mt-4 max-w-md text-lg text-muted"><span class="intro-comment" aria-hidden="true">//&nbsp;</span>Have a project in mind, a role to fill, or just want to talk front-end? Reach out any way you like.</p>

				<ul class="mt-10 border-b border-edge" role="list">
					<?php foreach ( $channels as $i => $ch ) : ?>
						<li>
							<a
								class="contact-row focus-ring"
								href="<?php echo esc_url( $ch['href'] ); ?>"
								<?php echo ! empty( $ch['external'] ) ? 'rel="noopener noreferrer nofollow" target="_blank"' : ''; ?>
								<?php echo ! empty( $ch['download'] ) ? 'download' : ''; ?>
							>
								<span class="contact-row-num" aria-hidden="true"><?php printf( '%02d', $i + 1 ); ?></span>
								<svg aria-hidden="true" class="text-accent" width="18" height="18" viewBox="0 0 24 24" fill="none"><?php echo $ch['icon']; // phpcs:ignore -- static markup above. ?></svg>
								<span><?php echo wp_kses( $ch['label'], [] ); ?><?php if ( ! empty( $ch['external'] ) ) : ?><span class="sr-only"> (opens in a new tab)</span><?php endif; ?></span>
								<svg aria-hidden="true" class="contact-row-arrow" width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M3 8h9m0 0L8.5 4.5M12 8l-3.5 3.5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>

			<div data-reveal>
				<div class="terminal-card">
					<div class="terminal-bar" aria-hidden="true">
						<span class="terminal-dot bg-accent/90"></span>
						<span class="terminal-dot bg-accent/40"></span>
						<span class="terminal-dot bg-accent/20"></span>
						<span class="terminal-title">domdag27@gmail.com:~/send-message</span>
					</div>
					<div class="terminal-body">
						<?php if ( $status === 'sent' ) : ?>
							<div class="form-banner form-banner-ok" role="status">Thanks, your message is on its way. I'll get back to you soon.</div>
						<?php elseif ( $status === 'invalid' ) : ?>
							<div class="form-banner form-banner-err" role="alert">Please fill in your name, a valid email, and a message.</div>
						<?php elseif ( $status === 'error' ) : ?>
							<div class="form-banner form-banner-err" role="alert">Something went wrong. Please try again, or email me directly.</div>
						<?php endif; ?>

						<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
							<input type="hidden" name="action" value="domdag_contact">
							<input type="hidden" name="form_ts" value="<?php echo esc_attr( (string) time() ); ?>">
							<?php wp_nonce_field( 'domdag_contact', 'domdag_nonce' ); ?>

							<p class="hp-field" aria-hidden="true">
								<label for="company_website">Leave this field empty</label>
								<input type="text" id="company_website" name="company_website" tabindex="-1" autocomplete="off">
							</p>

							<div class="grid gap-5 sm:grid-cols-2">
								<div>
									<label class="form-label" for="your_name"><span aria-hidden="true" class="text-accent">$&nbsp;</span>name</label>
									<input class="form-input" type="text" id="your_name" name="your_name" autocomplete="name" required>
								</div>
								<div>
									<label class="form-label" for="your_email"><span aria-hidden="true" class="text-accent">$&nbsp;</span>email</label>
									<input class="form-input" type="email" id="your_email" name="your_email" autocomplete="email" required>
								</div>
							</div>
							<div class="mt-5">
								<label class="form-label" for="your_message"><span aria-hidden="true" class="text-accent">$&nbsp;</span>message</label>
								<textarea class="form-input min-h-36 resize-y" id="your_message" name="your_message" required></textarea>
							</div>
							<button type="submit" class="btn-accent mt-6 w-full justify-center sm:w-auto">
								Send message
								<svg aria-hidden="true" width="15" height="15" viewBox="0 0 16 16" fill="none"><path d="M2 8h11m0 0L9 4m4 4-4 4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
							</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
