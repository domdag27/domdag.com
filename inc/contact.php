<?php
/**
 * Contact form handler: admin-post.php + wp_mail, with honeypot,
 * nonce, and a minimum-elapsed-time check.
 *
 * Every valid submission is ALSO appended to a private log under
 * wp-content/uploads/contact-log/ so no lead is lost if wp_mail
 * silently fails (deliverability on this host is unverified).
 */

add_action( 'admin_post_nopriv_domdag_contact', 'domdag_handle_contact' );
add_action( 'admin_post_domdag_contact', 'domdag_handle_contact' );

function domdag_handle_contact(): void {
	$back = home_url( '/' );

	$fail = static function ( string $code ) use ( $back ): void {
		wp_safe_redirect( $back . '?contact=' . $code . '#contact' );
		exit;
	};

	if ( ! isset( $_POST['domdag_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['domdag_nonce'] ) ), 'domdag_contact' ) ) {
		$fail( 'error' );
	}

	// Honeypot: real users never fill this; bots do.
	if ( ! empty( $_POST['company_website'] ?? '' ) ) {
		// Pretend success so bots learn nothing.
		$fail( 'sent' );
	}

	// Bots submit instantly; humans take at least a few seconds.
	$started = absint( $_POST['form_ts'] ?? 0 );
	if ( $started && ( time() - $started ) < 4 ) {
		$fail( 'sent' );
	}

	$name    = sanitize_text_field( wp_unslash( $_POST['your_name'] ?? '' ) );
	$email   = sanitize_email( wp_unslash( $_POST['your_email'] ?? '' ) );
	$message = sanitize_textarea_field( wp_unslash( $_POST['your_message'] ?? '' ) );

	if ( $name === '' || ! is_email( $email ) || $message === '' ) {
		$fail( 'invalid' );
	}

	// Private submission log — the safety net for lost mail.
	// Stored as a .php file whose first line exits, so it stays unreadable
	// over HTTP on BOTH stacks (nginx ignores .htaccess; the .htaccess deny
	// is kept as defense in depth for the Apache hybrid stack).
	$log_dir  = trailingslashit( wp_get_upload_dir()['basedir'] ) . 'contact-log';
	$log_file = "$log_dir/submissions.log.php";
	if ( wp_mkdir_p( $log_dir ) ) {
		if ( ! file_exists( "$log_dir/.htaccess" ) ) {
			file_put_contents( "$log_dir/.htaccess", "Require all denied\n" );
		}
		if ( ! file_exists( "$log_dir/index.php" ) ) {
			file_put_contents( "$log_dir/index.php", "<?php // silence\n" );
		}
		if ( ! file_exists( $log_file ) ) {
			file_put_contents( $log_file, "<?php exit; // private log ?>\n", LOCK_EX );
		}
		$line = sprintf( "[%s] %s <%s>\n%s\n---\n", gmdate( 'c' ), $name, $email, $message );
		file_put_contents( $log_file, $line, FILE_APPEND | LOCK_EX );
	}

	$profile = domdag_profile();
	$sent    = wp_mail(
		$profile['email'],
		sprintf( 'Portfolio contact from %s', $name ),
		sprintf( "Name: %s\nEmail: %s\n\n%s\n", $name, $email, $message ),
		[ 'Reply-To: ' . $name . ' <' . $email . '>' ]
	);

	// The log already captured it, so report success either way;
	// a mail failure is an ops problem, not the visitor's.
	wp_safe_redirect( $back . '?contact=sent#contact' );
	exit;
}
