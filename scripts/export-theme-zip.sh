#!/usr/bin/env bash
# Build deployable theme zip for Combell upload.
set -euo pipefail
ROOT="$(cd "$(dirname "$0")/.." && pwd)"
OUT="$ROOT/deploy/combell/opr8-it-theme.zip"
mkdir -p "$ROOT/deploy/combell"
rm -f "$OUT"
(
  cd "$ROOT/wp-content/themes"
  zip -r "$OUT" opr8-it \
    -x "opr8-it/**/.DS_Store" \
    -x "opr8-it/**/*.map"
)
echo "Wrote $OUT"
ls -lh "$OUT"
