#!/bin/sh
# Compress images under storage/app/public for web delivery.
set -e

ROOT="$(cd "$(dirname "$0")/.." && pwd)"
STORAGE="$ROOT/storage/app/public"
QUALITY="${IMAGE_QUALITY:-82}"
MAX_SIZE="${IMAGE_MAX_SIZE:-1200}"

if ! command -v cwebp >/dev/null 2>&1; then
  echo "cwebp is required but not installed." >&2
  exit 1
fi

optimize_file() {
  src="$1"
  dir="$(dirname "$src")"
  base="$(basename "$src")"
  name="${base%.*}"
  ext="$(echo "${base##*.}" | tr '[:upper:]' '[:lower:]')"
  dest="$dir/$name.webp"
  tmp="$(mktemp "${TMPDIR:-/tmp}/seed-img.XXXXXX")"

  cp "$src" "$tmp.$ext"
  sips -Z "$MAX_SIZE" "$tmp.$ext" --out "$tmp.$ext" >/dev/null 2>&1 || true

  if cwebp -q "$QUALITY" -m 6 "$tmp.$ext" -o "$dest" >/dev/null 2>&1; then
    before=$(stat -f%z "$src" 2>/dev/null || stat -c%s "$src")
    after=$(stat -f%z "$dest" 2>/dev/null || stat -c%s "$dest")
    rm -f "$tmp.$ext"
    if [ "$after" -ge "$before" ] && [ "$ext" = "webp" ]; then
      rm -f "$dest"
      echo "Skipped (no gain): $src"
      return 0
    fi
    if [ "$src" != "$dest" ]; then
      rm -f "$src"
    fi
    echo "$src -> $dest ($(numfmt --to=iec "$before" 2>/dev/null || echo "${before}B") -> $(numfmt --to=iec "$after" 2>/dev/null || echo "${after}B"))"
    return 0
  fi

  rm -f "$tmp.$ext"
  if [ "$ext" = "jpg" ] || [ "$ext" = "jpeg" ]; then
    sips -s formatOptions "$QUALITY" "$src" >/dev/null 2>&1 || true
    echo "Recompressed JPEG: $src"
  fi
}

recompress_webp() {
  src="$1"
  tmp="$(mktemp "${TMPDIR:-/tmp}/seed-webp.XXXXXX").webp"
  if cwebp -q "$QUALITY" -m 6 "$src" -o "$tmp" >/dev/null 2>&1; then
    before=$(stat -f%z "$src" 2>/dev/null || stat -c%s "$src")
    after=$(stat -f%z "$tmp" 2>/dev/null || stat -c%s "$tmp")
    if [ "$after" -lt "$before" ]; then
      mv "$tmp" "$src"
      echo "Recompressed WebP: $src ($(numfmt --to=iec "$before" 2>/dev/null || echo "${before}B") -> $(numfmt --to=iec "$after" 2>/dev/null || echo "${after}B"))"
    else
      rm -f "$tmp"
    fi
  else
    rm -f "$tmp"
  fi
}

find "$STORAGE" -type f \( -iname '*.png' -o -iname '*.jpg' -o -iname '*.jpeg' \) | while read -r file; do
  optimize_file "$file"
done

find "$STORAGE" -type f -iname '*.webp' | while read -r file; do
  recompress_webp "$file"
done

echo "Done."
