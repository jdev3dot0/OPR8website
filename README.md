# OPR8-IT WordPress (Combell migration)

WordPress rebuild that visually and structurally mirrors [www.opr8-it.be](https://www.opr8-it.be), packaged for deployment on **Combell** with a **domain cutover** of the existing **opr8-it.be** / **www.opr8-it.be** hostnames (not a new long-term domain).

## What’s in this repo

| Path | Role |
|------|------|
| `wp-content/themes/opr8-it/` | Custom theme (logo, hero, services, pages, contact form) |
| `docker-compose.yml` | Local WordPress + MySQL on port **43123** |
| `scripts/setup-wp.sh` | Creates pages, menu, activates theme |
| `scripts/export-theme-zip.sh` | Builds `deploy/combell/opr8-it-theme.zip` |
| `content/` | Page map + import notes |
| `deploy/combell/` | Cutover checklist + theme zip output |

Project docs (inventory / plan) live in the agent store when run from Cursor Cloud; the checklist below is self-contained for Combell.

## Run locally

Requirements: Docker + Docker Compose v2.

```bash
docker compose up -d
# Wait until MySQL is healthy (~20s on first boot), then seed pages/menu:
docker compose run --rm wpcli bash /var/www/html/opr8-scripts/setup-wp.sh
```

- Site: [http://127.0.0.1:43123](http://127.0.0.1:43123)
- Admin: [http://127.0.0.1:43123/wp-admin](http://127.0.0.1:43123/wp-admin) — user `admin` / password `opr8-local-admin`

Compose uses **host networking** (MySQL on `127.0.0.1:33123`, Apache on `43123`) so it works in environments where Docker bridge traffic between containers is blocked. On a normal laptop you can switch back to bridge networking if preferred.

Stop: `docker compose down` (add `-v` to wipe DB volumes).

Rebuild theme zip for Combell:

```bash
./scripts/export-theme-zip.sh
```

## Mimic coverage

**Included:** NL IA & nav, accent `#fb3c2d`, logo/header/footer, hero slideshow, four service blocks, sailing/drone icons, Contact / About / Websites / Drones / Zeilen pages, contact form + map embed, social links.

**Gaps vs live:** Revolution Slider / Flexform theme, Polylang FR/EN duplicates, CF7 + reCAPTCHA, licensed map plugin, production SMTP (local form shows a success notice; configure mail on Combell).

## Deploy to Combell (domain migration)

Current public DNS (pre-cutover): **one.com** nameservers (`ns01.one.com` / `ns02.one.com`), A `46.30.213.161`, mail on one.com MX.

### Blockers (user must provide)

- Combell control-panel access (or invite) with WordPress/PHP+MySQL hosting
- Choice: keep registrar at one.com and only change **A/www**, **or** move **NS** / **registrar** to Combell
- Mail plan: keep MX at one.com, move mail to Combell, or third-party mail — **do not change NS without recreating MX**

### Short path

1. On Combell: create hosting + DB; install WordPress.
2. Upload `deploy/combell/opr8-it-theme.zip` → activate **OPR8-IT**.
3. Create pages with slugs from `content/opr8-pages.json`; set **Diensten** as front page; build matching menu; Permalinks → Post name.
4. Test on Combell temporary/preview URL.
5. Lower TTL at one.com; day-of: point **A** (and `www`) to Combell **or** switch NS after cloning all DNS records (especially MX).
6. Set WP Site URL to `https://www.opr8-it.be` (or apex); enable SSL; verify form/mail.

Full cutover notes: `deploy/combell/CUTOVER.md`.

## License / assets

Brand imagery and copy are sourced from the existing OPR8-IT site for migration purposes. Flexform / Revolution Slider are **not** redistributed.
