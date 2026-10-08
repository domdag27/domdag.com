#!/usr/bin/env bash
# Regenerate the branded resume PDF from the site's single content source
# (inc/data.php). Run from anywhere.
set -euo pipefail
SITE=/home/bayshore-digital/webapps/dom-portfolio
wp --path="$SITE" eval '
echo json_encode([
	"profile"    => domdag_profile(),
	"skills"     => domdag_skills(),
	"experience" => domdag_experience(),
	"education"  => domdag_education(),
	"clients"    => array_slice( array_values( array_diff(
		array_column( domdag_projects(), "name" ),
		[ "Snap Pak", "Workmaster", "Frankford Shade Designer" ] // employers + duplicate client
	) ), 0, 6 ),
], JSON_UNESCAPED_UNICODE);
' | python3 "$SITE/wp-content/themes/domdag/resume/build.py"
