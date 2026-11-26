# Backup dan Pemulihan Database

## Jadwal dan lokasi

Container `backup` membuat satu backup saat `docker compose up -d` dijalankan. Jadwal harian berikutnya dikelola oleh **crontab Ubuntu pukul 02.00 waktu lokal VM**. Cron menjalankan container backup sekali jalan; dump gzip disimpan di volume Docker `backup_data`, terpisah dari volume MySQL `mysql_data`. File yang lebih tua dari tujuh hari dihapus otomatis.

Setelah meng-clone proyek dan menyiapkan `.env`, pasang cron dan daftarkan jadwal:

```bash
sudo apt update
sudo apt install -y cron
sudo systemctl enable --now cron
bash scripts/install-backup-cron.sh
crontab -l
```

Installer menambahkan atau memperbarui satu baris bertanda `DESA_APP_BACKUP`; entri crontab lain tetap dipertahankan. Untuk memeriksa hasil dan waktu backup:

```bash
docker compose logs backup
docker compose run --rm --no-deps --entrypoint ls backup -lh /backups
tail -n 50 storage/logs/backup-cron.log
```

Jalankan backup manual kapan saja:

```bash
docker compose run --rm backup
```

## Uji pemulihan tanpa mengubah database aktif

1. Buat database sementara:

   ```bash
   docker compose exec -T mysql mysql -uroot -proot_password -e "CREATE DATABASE desa_app_restore CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci"
   ```

2. Pulihkan file terbaru ke database sementara:

   ```bash
   docker compose run --rm --entrypoint /bin/sh backup -c 'set -eu; newest=$(find /backups -type f -name "desa_app_*.sql.gz" | sort | tail -n 1); gzip -dc "$newest" | MYSQL_PWD="$MYSQL_PASSWORD" mysql -h "$DB_HOST" -u "$MYSQL_USER" desa_app_restore'
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
docker compose run --rm --entrypoint /bin/sh backup -c 'set -eu; newest=$(find /backups -type f -name "desa_app_*.sql.gz" | sort | tail -n 1); gzip -dc "$newest" | MYSQL_PWD="$MYSQL_PASSWORD" mysql -h "$DB_HOST" -u "$MYSQL_USER" desa_app'
docker compose start app
```

Volume backup berada di disk VM yang menjalankan Compose. Untuk melindungi backup dari kerusakan disk VM, salin volume atau file backup terjadwal ke disk lain di luar VM.
