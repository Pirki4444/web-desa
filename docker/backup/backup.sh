#!/bin/sh
set -eu

backup_once() {
    timestamp=$(date -u '+%Y%m%dT%H%M%SZ')
    destination="/backups/${DB_DATABASE}_${timestamp}.sql.gz"
    sql_tmp="/backups/.${DB_DATABASE}_${timestamp}.sql.tmp"
    gzip_tmp="${destination}.tmp"

    trap 'rm -f "$sql_tmp" "$gzip_tmp"' EXIT HUP INT TERM

    MYSQL_PWD="$MYSQL_PASSWORD" mysqldump \
        --host="$DB_HOST" \
        --user="$MYSQL_USER" \
        --single-transaction \
        --routines \
        --triggers \
        --events \
        "$DB_DATABASE" > "$sql_tmp"

    gzip -c "$sql_tmp" > "$gzip_tmp"
    mv "$gzip_tmp" "$destination"
    rm -f "$sql_tmp"
    trap - EXIT HUP INT TERM

    find /backups -type f -name "${DB_DATABASE}_*.sql.gz" \
        -mtime "+${BACKUP_RETENTION_DAYS}" -delete

    echo "Database backup created: $destination"
}

if [ "${1:-}" = "--once" ]; then
    backup_once
    exit 0
fi

while :; do
    if ! backup_once; then
        echo "Backup failed; retrying in 60 seconds." >&2
        sleep 60
        continue
    fi

    sleep "$BACKUP_INTERVAL_SECONDS"
done
