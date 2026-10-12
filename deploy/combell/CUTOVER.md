# opr8-it.be → Combell cutover

Authoritative production domain: **opr8-it.be** (+ **www**). This is a migration of the existing site/domain onto Combell hosting, not a new brand domain.

## Pre-cutover facts

| Item | Current |
|------|---------|
| Registrar / DNS | one.com (`ns01.one.com`, `ns02.one.com`) |
| Web A | `46.30.213.161` |
| Mail MX | one.com mailpods |

## Credentials / access needed from user

- [ ] Combell login (or agency invite) with WordPress hosting
- [ ] Confirm mail stays at one.com **or** provide Combell/third-party MX targets
- [ ] Confirm only `opr8-it.be` / `www` (no other production hostname)

## Steps

### 1. Build on Combell (DNS still on one.com)

1. Create webspace + MySQL; install WordPress (PHP 8.x).
2. Upload `opr8-it-theme.zip` → Appearance → Themes → **Activate**.
3. Pages (publish) with exact slugs:
   - `diensten` (Settings → Reading → static front page)
   - `contact`, `wie-is-opr8-it`, `websites`, `opr8-it-drones`, `opr8-it-zeilen`
4. Appearance → Menus → Primary: Diensten, Contact, Wie is OPR8-IT?, Websites, OPR8-IT & drones.
5. Permalinks → Post name.
6. Optional: Contact Form 7, SMTP plugin, SSL once domain points here.
7. QA on Combell preview/IP if available.

### 2. DNS cutover options

**A — Recommended if mail stays at one.com:** at one.com DNS, change only web records:

- Lower TTL to 300 for 24–48h.
- Set `@` A (and AAAA if used) to Combell web IP.
- Set `www` A or CNAME per Combell docs.
- **Leave MX/SPF alone** unless mail moves.

**B — Combell nameservers:** recreate **all** records in Combell DNS (A, www, MX, TXT/SPF/DKIM, subdomains), then switch NS at one.com to Combell’s NS values.

**C — Registrar transfer to Combell:** unlock + Auth code at one.com → transfer in Combell; hosting/DNS still configured separately. Complete hosting setup **before** relying on the transfer.

### 3. Go-live

1. Flip DNS as chosen.
2. WordPress Address + Site Address → `https://www.opr8-it.be` (or apex; redirect the other).
3. Search-replace old URLs if needed.
4. Test homepage, nav, contact form, HTTPS, email.
5. Keep one.com hosting ~7 days for rollback (revert A/NS).

### 4. Rollback

Restore previous A/www (or NS) to one.com; old site answers again if still online.
