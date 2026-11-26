# Backup dan Pemulihan Database

## Jadwal dan lokasi

Container `backup` membuat dump database `desa_app` saat mulai, lalu setiap 24 jam. File disimpan sebagai gzip di volume Docker `backup_data`, terpisah dari volume MySQL `mysql_data`. Backup yang lebih tua dari tujuh hari dihapus otomatis.

Untuk memeriksa hasilnya:

```bash
docker compose logs backup
docker compose exec backup ls -lh /backups
```

Backup manual:

```bash
docker compose exec -T backup /bin/sh /backup.sh --once
```

## Uji pemulihan tanpa mengubah database aktif

1. Buat database sementara:

   ```bash
   docker compose exec -T mysql mysql -uroot -proot_password -e "CREATE DATABASE desa_app_restore CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci"
   ```

2. Pulihkan file terbaru ke database sementara:

   ```bash
   docker compose exec -T backup sh -c 'set -eu; newest=$(find /backups -type f -name "desa_app_*.sql.gz" | sort | tail -n 1); gzip -dc "$newest" | MYSQL_PWD="$MYSQL_PASSWORD" mysql -h "$DB_HOST" -u "$MYSQL_USER" desa_app_restore'
   ```

3. Pastikan tabel tersedia:

   ```bash
   docker compose exec -T mysql mysql -uroot -proot_password -N -e "SHOW TABLES FROM desa_app_restore"
   ```

4. Hapus database sementara setelah pemeriksaan:

   ```bash
   docker compose exec -T mysql mysql -uroot -proot_password -e "DROP DATABASE desa_app_restore"
   ```

## Pemulihan ke database aplikasi

Pemulihan ke `desa_app` akan mengganti isi database. Pastikan file backup benar dan hentikan aplikasi terlebih dahulu:

```bash
docker compose stop app
docker compose exec -T mysql mysql -uroot -proot_password -e "DROP DATABASE IF EXISTS desa_app; CREATE DATABASE desa_app CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci"
docker compose exec -T backup sh -c 'set -eu; newest=$(find /backups -type f -name "desa_app_*.sql.gz" | sort | tail -n 1); gzip -dc "$newest" | MYSQL_PWD="$MYSQL_PASSWORD" mysql -h "$DB_HOST" -u "$MYSQL_USER" desa_app'
docker compose start app
```

Volume backup berada di penyimpanan Docker pada VM yang menjalankan Compose. Untuk perlindungan saat disk VM rusak, salin volume atau file backup terjadwal ke disk lain di luar VM.
