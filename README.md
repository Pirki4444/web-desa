# Sistem Informasi Desa

Aplikasi informasi dan layanan desa berbasis Laravel, MySQL, Docker Compose, dan ProxySQL. Compose menyediakan Glances, Grafana dengan Prometheus, serta backup database harian.

## Push proyek ini ke GitHub

Buat repository kosong di GitHub terlebih dahulu (tanpa README atau file awal lain), lalu dari PowerShell di folder proyek jalankan:

```powershell
git add -A
git commit -m "Siapkan aplikasi desa untuk deployment"
git branch -M main
git remote add origin https://github.com/USERNAME/NAMA-REPO.git
git push -u origin main
```

Ganti `USERNAME/NAMA-REPO` dengan pemilik dan nama repository GitHub. `.env` lokal tidak ikut terunggah.

## Clone dan jalankan di Ubuntu dalam VMware

### 1. Siapkan VM

Matikan VM sebelum mengubah pengaturan VMware. Alokasikan **4 vCPU dan 4 GB RAM**, pasang Ubuntu, lalu pastikan VM dapat mengakses internet. Docker Engine dan plugin Docker Compose harus terpasang. Ikuti panduan resmi [instalasi Docker Engine di Ubuntu](https://docs.docker.com/engine/install/ubuntu/) dan [instalasi Compose plugin](https://docs.docker.com/compose/install/linux/) bila belum tersedia.

### 2. Clone repository

Jalankan di terminal Ubuntu. Ganti URL dengan alamat repository GitHub milikmu:

```bash
sudo apt update
sudo apt install -y git openssl
git clone https://github.com/USERNAME/NAMA-REPO.git
cd NAMA-REPO
```

### 3. Konfigurasi dan mulai aplikasi

```bash
cp .env.example .env
sed -i "s|^APP_KEY=.*|APP_KEY=base64:$(openssl rand -base64 32 | tr -d '\n')|" .env
sed -i "s|^GRAFANA_ADMIN_PASSWORD=.*|GRAFANA_ADMIN_PASSWORD=$(openssl rand -hex 24)|" .env
docker compose up --build -d
docker compose ps
```

Tunggu sampai MySQL berstatus `healthy`, lalu buat tabel dan data demo **satu kali**:

```bash
docker compose exec app php artisan migrate --seed --force
```

Jika `docker compose exec` memberi tahu container belum siap, tunggu beberapa detik dan jalankan kembali perintah migrasi. Periksa log dengan `docker compose logs -f app` jika masih gagal.

### 4. Buka aplikasi

Cari IP VM Ubuntu dengan:

```bash
hostname -I
```

Dari komputer host atau perangkat satu jaringan, buka alamat berikut dan ganti `<IP-VM>` dengan IP Ubuntu:

- Aplikasi: `http://<IP-VM>:8000`
- Admin: `http://<IP-VM>:8000/login`
- Dashboard Grafana: `http://<IP-VM>:3000` (user dan password dari `.env`)
- Monitoring langsung Glances: `http://<IP-VM>:61208`
- Pemeriksaan aplikasi/database: `http://<IP-VM>:8000/health`

Grafana sudah dipasangi sumber data Prometheus dan dashboard **Infrastruktur Desa**. Dashboard menampilkan CPU, memori, disk VM, status target monitoring, serta CPU dan memori container. Glances tetap berjalan untuk inspeksi langsung. Jika layanan tidak dapat diakses, atur adapter jaringan VMware ke **Bridged** atau **Host-only** sesuai jaringan, lalu izinkan port 8000, 3000, dan 61208 di firewall Ubuntu. Akun admin aplikasi demo: `admin@desa.id` / `password123`.

## Komponen sistem

- Laravel menerima trafik web pada port 8000.
- ProxySQL menjadi jalur koneksi aplikasi ke MySQL. Kedua layanan database hanya tersedia di jaringan internal Compose.
- Glances menyajikan metrik host/container pada port 61208.
- Prometheus mengumpulkan metrik VM dari Node Exporter dan metrik container dari cAdvisor; Grafana menyajikannya pada port 3000.
- Backup membuat dump gzip saat mulai lalu setiap 24 jam; retensi tujuh hari di volume `backup_data`.

Panduan rancangan VM dan scaling ada di [CLOUD_DEPLOYMENT.md](CLOUD_DEPLOYMENT.md). Jadwal backup dan langkah pemulihan ada di [BACKUP_AND_RESTORE.md](BACKUP_AND_RESTORE.md).

## Perintah pengelolaan

```bash
docker compose logs -f app
docker compose ps
docker compose exec backup ls -lh /backups
docker compose down
```

`docker compose down` mempertahankan database, backup, data Prometheus, dan Grafana di volume. Jangan gunakan `docker compose down -v` kecuali memang ingin menghapus data tersebut.

## Pengaturan sebelum dipakai di luar demo

Ubah kata sandi MySQL pada `docker-compose.yml` dan kredensial backend di `proxysql.cnf` secara bersamaan. Jangan commit file `.env`; file tersebut berisi kunci aplikasi. Aturan `.gitignore` sudah mengecualikan konfigurasi lokal, dependensi, log, cache, dan file hasil build.
