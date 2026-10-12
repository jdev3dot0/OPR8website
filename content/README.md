# Content for OPR8-IT WordPress

Pages are created by `scripts/setup-wp.sh` (preferred for local Docker).

For Combell manual import without WP-CLI:

1. Create pages with these slugs: `diensten` (set as front page), `contact`, `wie-is-opr8-it`, `websites`, `opr8-it-drones`, `opr8-it-zeilen`.
2. Activate the `opr8-it` theme — page bodies for those slugs are rendered by theme template parts (copy lives in the theme).
3. Optionally paste richer HTML from the live site into the page editor; the theme templates already match the NL inventory.

`opr8-pages.json` is a machine-readable page map for automation.
