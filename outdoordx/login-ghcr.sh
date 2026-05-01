#!/usr/bin/env bash
set -euo pipefail

cd /opt/outdoordx

if [ ! -f ".env" ]; then
  echo "ERROR: .env file not found in /opt/outdoordx"
  exit 1
fi

set -a
source .env
set +a

if [ -z "${GHCR_TOKEN:-}" ]; then
  echo "ERROR: GHCR_TOKEN not found in .env"
  exit 1
fi

echo "$GHCR_TOKEN" | docker login ghcr.io -u ea1het --password-stdin

echo "GHCR login completed successfully."
