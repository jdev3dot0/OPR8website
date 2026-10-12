#!/usr/bin/env bash
# Idempotent WP install + OPR8 content seed.
# Run: docker compose run --rm wpcli bash /var/www/html/opr8-scripts/setup-wp.sh
set -euo pipefail

cd /var/www/html
export WP_CLI_ALLOW_ROOT=1

echo "Waiting for WordPress files..."
for i in $(seq 1 90); do
  if [[ -f wp-config.php ]]; then
    echo "Found wp-config.php"
    break
  fi
  sleep 2
done

if [[ ! -f wp-config.php ]]; then
  echo "ERROR: wp-config.php missing — is the wordpress service running?"
  exit 1
fi

echo "Waiting for database connectivity..."
for i in $(seq 1 60); do
  if wp db query "SELECT 1" --skip-column-names >/dev/null 2>&1; then
    echo "Database OK"
    break
  fi
  sleep 2
done

if ! wp core is-installed 2>/dev/null; then
  echo "Installing WordPress..."
  wp core install \
    --url="http://127.0.0.1:43123" \
    --title="OPR8-IT" \
    --admin_user="admin" \
    --admin_password="opr8-local-admin" \
    --admin_email="info@opr8-it.be" \
    --skip-email
else
  echo "WordPress already installed"
fi

wp rewrite structure '/%postname%/' --hard
wp theme activate opr8-it
wp language core install nl_NL --activate 2>/dev/null || true
wp site switch-language nl_NL 2>/dev/null || true

create_page() {
  local slug="$1"
  local title="$2"
  local existing
  existing=$(wp post list --post_type=page --name="$slug" --field=ID 2>/dev/null | head -n1 || true)
  if [[ -n "${existing:-}" ]]; then
    echo "Page exists: $slug ($existing)"
    printf '%s' "$existing"
    return 0
  fi
  wp post create --post_type=page --post_status=publish --post_title="$title" --post_name="$slug" --porcelain
}

HOME_ID=$(create_page "diensten" "Diensten")
CONTACT_ID=$(create_page "contact" "Contact")
ABOUT_ID=$(create_page "wie-is-opr8-it" "Wie is OPR8-IT?")
WEB_ID=$(create_page "websites" "Websites")
DRONE_ID=$(create_page "opr8-it-drones" "OPR8-IT & drones")
SAIL_ID=$(create_page "opr8-it-zeilen" "OPR8-IT & zeilen")

wp option update show_on_front page
wp option update page_on_front "$HOME_ID"
wp option update blogdescription "IT Support"

MENU_ID=$(wp menu list --fields=term_id,name --format=csv | awk -F, 'NR>1 && $2=="Primary"{print $1; exit}')
if [[ -z "${MENU_ID:-}" ]]; then
  MENU_ID=$(wp menu create "Primary" --porcelain)
fi
wp menu location assign "$MENU_ID" primary || true

EXISTING_ITEMS=$(wp menu item list "$MENU_ID" --format=ids 2>/dev/null || true)
if [[ -n "${EXISTING_ITEMS:-}" ]]; then
  # shellcheck disable=SC2086
  wp menu item delete $EXISTING_ITEMS || true
fi

wp menu item add-post "$MENU_ID" "$HOME_ID" --title="Diensten"
wp menu item add-post "$MENU_ID" "$CONTACT_ID" --title="Contact"
wp menu item add-post "$MENU_ID" "$ABOUT_ID" --title="Wie is OPR8-IT?"
wp menu item add-post "$MENU_ID" "$WEB_ID" --title="Websites"
wp menu item add-post "$MENU_ID" "$DRONE_ID" --title="OPR8-IT & drones"

wp post delete 1 --force 2>/dev/null || true
for sample in sample-page voorbeeld-pagina; do
  SID=$(wp post list --post_type=page --name="$sample" --field=ID 2>/dev/null | head -n1 || true)
  [[ -n "${SID:-}" ]] && wp post delete "$SID" --force || true
done

# Ensure theme files are readable
chmod -R a+rX /var/www/html/wp-content/themes/opr8-it 2>/dev/null || true

echo "Setup complete."
echo "Front page ID: $HOME_ID"
echo "Zeilen page ID: $SAIL_ID"
echo "Admin: admin / opr8-local-admin"
echo "URL: http://127.0.0.1:43123"
