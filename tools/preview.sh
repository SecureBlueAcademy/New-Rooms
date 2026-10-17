#!/usr/bin/env bash
# Serve one or more room folders locally with the real room-engine.php and preview stubs.
#   tools/preview.sh "<room folder>" ["<room folder>" ...]
# Prints the theory and practical URLs. Re-run after editing a room to refresh the copy.
# Env: PREVIEW_ROOT (default /tmp/cbx-preview), PREVIEW_PORT (default 8765).
set -euo pipefail
here="$(cd "$(dirname "$0")" && pwd)"; repo="$(dirname "$here")"
root="${PREVIEW_ROOT:-/tmp/cbx-preview}"; port="${PREVIEW_PORT:-8765}"
mkdir -p "$root/includes" "$root/assets" "$root/rooms"
cp "$repo/platform/includes/room-engine.php" "$root/includes/"
cp "$repo/platform/assets/style.css" "$repo/platform/assets/rooms-style.css" "$root/assets/"
cp -r "$here/preview/stubs/." "$root/"
for room in "$@"; do
  theory="$(ls "$room"/*.php | grep -v -- '-practical\.php$' | head -1)"
  slug="$(basename "$theory" .php)"
  rm -rf "$root/rooms/$slug"; mkdir -p "$root/rooms/$slug"; cp "$room"/* "$root/rooms/$slug/"
  practical="$(ls "$room"/*-practical.php | head -1)"
  echo "THEORY    http://127.0.0.1:$port/rooms/$slug/$(basename "$theory")"
  echo "PRACTICAL http://127.0.0.1:$port/rooms/$slug/$(basename "$practical")"
done
if ! curl -s -o /dev/null "http://127.0.0.1:$port/login.php"; then
  (cd "$root" && nohup php -S "127.0.0.1:$port" -t "$root" "$here/preview/router.php" >"$root/server.log" 2>&1 &)
  for _ in $(seq 1 30); do curl -s -o /dev/null "http://127.0.0.1:$port/login.php" && break; sleep 0.2; done
fi
