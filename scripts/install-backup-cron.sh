#!/usr/bin/env bash
set -euo pipefail

project_dir="$(cd -- "$(dirname -- "${BASH_SOURCE[0]}")/.." && pwd)"
docker_bin="$(command -v docker || true)"
cd "$project_dir"

if [[ -z "$docker_bin" ]]; then
    echo "Docker CLI was not found. Install Docker Engine and Compose first." >&2
    exit 1
fi

if ! command -v crontab >/dev/null 2>&1; then
    echo "crontab was not found. Install cron first (sudo apt install cron)." >&2
    exit 1
fi

if [[ ! -f "$project_dir/.env" ]]; then
    echo "Missing $project_dir/.env. Copy .env.example to .env and configure it first." >&2
    exit 1
fi

"$docker_bin" compose -f "$project_dir/docker-compose.yml" config -q
mkdir -p "$project_dir/storage/logs"

current_crontab="$(crontab -l 2>/dev/null || true)"
filtered_crontab="$(printf '%s\n' "$current_crontab" | sed '/# DESA_APP_BACKUP$/d')"

{
    if [[ -n "${filtered_crontab//[[:space:]]/}" ]]; then
        printf '%s\n' "$filtered_crontab"
    fi
    printf '0 2 * * * cd %q && %q compose -f %q run --rm backup >> %q 2>&1 # DESA_APP_BACKUP\n' \
        "$project_dir" \
        "$docker_bin" \
        "$project_dir/docker-compose.yml" \
        "$project_dir/storage/logs/backup-cron.log"
} | crontab -

echo "Daily database backup scheduled for 02:00 in the VM's local timezone."
echo "Verify it with: crontab -l"
