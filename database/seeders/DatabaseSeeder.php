<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\VillageProfile;
use App\Models\VillageOfficial;
use App\Models\News;
use App\Models\Event;
use App\Models\ServiceType;
use App\Models\ServiceRequest;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Admin User
        $admin = User::create([
            'name'               => 'Administrator Desa',
            'email'              => 'admin@desa.id',
            'password'           => Hash::make('password123'),
            'role'               => 'admin',
            'email_verified_at'  => now(),
        ]);

        // 2. Village Profile
        VillageProfile::create([
            'village_name'          => 'Desa Maju Sejahtera',
            'district'              => 'Kecamatan Nusantara Indah',
            'regency'               => 'Kabupaten Sejahtera Raya',
            'province'              => 'Jawa Tengah',
            'postal_code'           => '50123',
            'history'               => 'Desa Maju Sejahtera berdiri sejak tahun 1945, tepat setelah kemerdekaan Republik Indonesia diproklamasikan. Desa ini awalnya merupakan sebuah pedukuhan kecil yang dihuni oleh para petani dan nelayan yang berpindah dari daerah pesisir. Seiring berjalannya waktu, desa ini berkembang pesat dengan ditandai berbagai pembangunan infrastruktur dan peningkatan kesejahteraan masyarakat yang signifikan. Nama "Maju Sejahtera" sendiri diberikan oleh tokoh-tokoh pendiri desa sebagai harapan dan doa agar seluruh warga dapat hidup makmur dan sejahtera.',
            'vision'                => 'Terwujudnya Desa Maju Sejahtera yang mandiri, berbudaya, dan berdaya saing menuju masyarakat yang adil, makmur, dan sejahtera berdasarkan nilai-nilai Pancasila dan kearifan lokal.',
            'mission'               => "1. Meningkatkan kualitas pelayanan publik yang prima dan transparan kepada seluruh masyarakat desa.\n2. Mengembangkan potensi ekonomi lokal berbasis pertanian, UMKM, dan pariwisata desa secara berkelanjutan.\n3. Meningkatkan kualitas sumber daya manusia melalui pendidikan, pelatihan, dan pemberdayaan masyarakat.\n4. Membangun infrastruktur desa yang berkualitas dan merata untuk mendukung aktivitas warga.\n5. Melestarikan budaya dan adat istiadat lokal sebagai identitas dan kekuatan karakter masyarakat desa.",
            'geography'             => 'Desa Maju Sejahtera terletak di dataran rendah dengan ketinggian rata-rata 50 meter di atas permukaan laut. Desa ini berbatasan dengan Desa Sumber Makmur di sebelah utara, Sungai Bening di sebelah selatan, Desa Karya Bakti di sebelah timur, dan Hutan Lindung Sejahtera di sebelah barat. Kondisi tanah yang subur sangat mendukung aktivitas pertanian, terutama padi sawah, hortikultura, dan perkebunan.',
            'village_head_name'     => 'Bapak Suryanto, S.Sos.',
            'village_head_photo'    => null,
            'village_head_message'  => 'Dengan mengucap syukur kepada Tuhan Yang Maha Esa, kami menyambut hangat seluruh warga dan tamu yang mengunjungi portal resmi Desa Maju Sejahtera. Melalui website ini, kami berkomitmen untuk menghadirkan pelayanan publik yang lebih mudah, cepat, dan transparan. Kami mengundang seluruh warga untuk aktif berpartisipasi dalam pembangunan desa demi mewujudkan cita-cita bersama menuju desa yang maju dan sejahtera.',
            'total_population'      => 4237,
            'total_families'        => 1156,
            'total_area'            => 824.50,
            'total_dusun'           => 4,
            'phone'                 => '(0291) 123-4567',
            'email'                 => 'info@desamajusejahtera.id',
            'address'               => 'Jl. Raya Desa No. 1, Desa Maju Sejahtera, Kec. Nusantara Indah',
            'website'               => 'https://desamajusejahtera.id',
        ]);

        // 3. Village Officials
        $officials = [
            ['name' => 'Suryanto, S.Sos.',          'position' => 'Kepala Desa',          'nip' => null,                    'order' => 1],
            ['name' => 'Dra. Rahayu Setyaningsih',  'position' => 'Sekretaris Desa',      'nip' => '19780512 200801 2 005', 'order' => 2],
            ['name' => 'Bambang Purnomo, S.E.',      'position' => 'Kaur Keuangan',        'nip' => '19820304 201001 1 003', 'order' => 3],
            ['name' => 'Ahmad Fauzi, S.IP.',         'position' => 'Kasi Pemerintahan',    'nip' => '19851122 201001 1 002', 'order' => 4],
            ['name' => 'Siti Munawaroh, A.Md.',      'position' => 'Kasi Kesejahteraan',   'nip' => '19900617 201501 2 001', 'order' => 5],
            ['name' => 'Sutrisno',                   'position' => 'Kepala Dusun Krajan',  'nip' => null,                    'order' => 6],
        ];

        foreach ($officials as $official) {
            VillageOfficial::create(array_merge($official, [
                'phone'       => null,
                'photo'       => null,
                'description' => null,
                'is_active'   => true,
            ]));
        }

        // 4. News
        $newsData = [
            [
                'title'        => 'Realisasi Dana Desa Triwulan III Capai 87 Persen',
                'category'     => 'Pemerintahan',
                'excerpt'      => 'Pemerintah Desa Maju Sejahtera telah merealisasikan anggaran Dana Desa triwulan ketiga sebesar 87% dari total pagu anggaran yang ditetapkan.',
                'content'      => '<p>Pemerintah Desa Maju Sejahtera dengan bangga mengumumkan bahwa realisasi penggunaan Dana Desa untuk triwulan ketiga tahun 2026 telah mencapai <strong>87 persen</strong> dari total pagu anggaran sebesar Rp 1,2 Miliar.</p><p>Kepala Desa Suryanto dalam keterangannya menyampaikan bahwa dana tersebut telah digunakan untuk berbagai program prioritas, antara lain:</p><ul><li>Pembangunan jalan desa sepanjang 2,3 km</li><li>Renovasi balai pertemuan warga</li><li>Program pemberdayaan ekonomi UMKM lokal</li><li>Bantuan sosial untuk 45 keluarga kurang mampu</li></ul><p>"Kami berkomitmen untuk menggunakan setiap rupiah dana desa secara akuntabel, transparan, dan benar-benar berdampak pada peningkatan kesejahteraan warga," ujar Suryanto.</p><p>Laporan pertanggungjawaban lengkap dapat diakses oleh warga melalui kantor desa atau diunduh melalui portal informasi resmi ini.</p>',
                'published_at' => now()->subDays(2),
                'views'        => 234,
            ],
            [
                'title'        => 'Pembangunan Jalan Dusun Krajan Resmi Dimulai',
                'category'     => 'Pembangunan',
                'excerpt'      => 'Peletakan batu pertama pembangunan jalan rabat beton sepanjang 650 meter di Dusun Krajan dilakukan oleh Kepala Desa bersama warga.',
                'content'      => '<p>Desa Maju Sejahtera kembali menunjukkan komitmennya dalam pembangunan infrastruktur dengan dimulainya proyek perbaikan jalan di Dusun Krajan. Acara peletakan batu pertama dihadiri langsung oleh Kepala Desa Suryanto dan seluruh perangkat desa.</p><p>Proyek senilai Rp 320 juta ini akan membangun jalan rabat beton sepanjang <strong>650 meter</strong> dan lebar 3 meter. Pembangunan ditargetkan selesai dalam waktu 60 hari kerja.</p><p>Warga Dusun Krajan menyambut gembira dimulainya pembangunan ini. "Jalan yang baik akan sangat membantu aktivitas petani membawa hasil panen ke pasar," ujar Pak Sutrisno selaku Kepala Dusun Krajan.</p>',
                'published_at' => now()->subDays(5),
                'views'        => 187,
            ],
            [
                'title'        => 'Posyandu Balita Raih Penghargaan Terbaik Tingkat Kecamatan',
                'category'     => 'Sosial',
                'excerpt'      => 'Posyandu Melati Desa Maju Sejahtera berhasil meraih predikat Posyandu Terbaik tingkat Kecamatan Nusantara Indah dalam penilaian tahunan.',
                'content'      => '<p>Kabar membanggakan datang dari Posyandu Melati Desa Maju Sejahtera. Posyandu yang aktif melayani warga sejak tahun 2008 ini berhasil meraih penghargaan sebagai <strong>Posyandu Terbaik Tingkat Kecamatan</strong> dalam penilaian yang dilakukan oleh Dinas Kesehatan Kabupaten Sejahtera Raya.</p><p>Penghargaan ini diberikan berdasarkan beberapa indikator, antara lain tingkat kunjungan balita yang mencapai 95%, ketersediaan kader kesehatan terlatih, kualitas pelayanan, dan kelengkapan data posyandu.</p><p>Ketua Posyandu Melati, Ibu Sri Wahyuni, mengucapkan terima kasih kepada seluruh kader dan warga yang telah mendukung kegiatan posyandu.</p>',
                'published_at' => now()->subDays(10),
                'views'        => 312,
            ],
            [
                'title'        => 'Pengumuman: Jadwal Pembagian BLT-DD Bulan Ini',
                'category'     => 'Pengumuman',
                'excerpt'      => 'Pemerintah desa mengumumkan jadwal dan mekanisme pembagian Bantuan Langsung Tunai Dana Desa (BLT-DD) untuk bulan November 2026.',
                'content'      => '<p>Kepada seluruh Keluarga Penerima Manfaat (KPM) Bantuan Langsung Tunai Dana Desa (BLT-DD) di Desa Maju Sejahtera, berikut adalah informasi jadwal pembagian BLT-DD untuk bulan November 2026:</p><p><strong>Jadwal Pembagian:</strong></p><ul><li>Dusun Krajan: Senin, 2 Desember 2026, pukul 08.00 - 12.00 WIB</li><li>Dusun Rejo: Selasa, 3 Desember 2026, pukul 08.00 - 12.00 WIB</li><li>Dusun Sari: Rabu, 4 Desember 2026, pukul 08.00 - 12.00 WIB</li><li>Dusun Mulyo: Kamis, 5 Desember 2026, pukul 08.00 - 12.00 WIB</li></ul><p><strong>Lokasi:</strong> Balai Desa Maju Sejahtera<br><strong>Syarat:</strong> Membawa KTP dan kartu KPM asli.</p>',
                'published_at' => now()->subDays(1),
                'views'        => 489,
            ],
            [
                'title'        => 'Pelatihan Budidaya Jamur Tiram untuk Ibu-Ibu PKK',
                'category'     => 'Sosial',
                'excerpt'      => 'Sebanyak 30 ibu rumah tangga mengikuti pelatihan budidaya jamur tiram yang diselenggarakan oleh PKK Desa Maju Sejahtera bekerjasama dengan Dinas Pertanian.',
                'content'      => '<p>Dalam rangka meningkatkan kemandirian ekonomi keluarga, PKK Desa Maju Sejahtera bekerjasama dengan Dinas Pertanian Kabupaten Sejahtera Raya menggelar pelatihan <strong>Budidaya Jamur Tiram</strong> yang diikuti oleh 30 ibu rumah tangga dari berbagai dusun.</p><p>Pelatihan berlangsung selama dua hari dan mencakup materi pembuatan baglog, inokulasi bibit, pemeliharaan, panen, hingga pengolahan jamur menjadi produk bernilai jual tinggi seperti keripik jamur dan abon jamur.</p>',
                'published_at' => now()->subDays(15),
                'views'        => 156,
            ],
            [
                'title'        => 'Desa Maju Sejahtera Ikuti Lomba Desa Bersih Tingkat Kabupaten',
                'category'     => 'Pemerintahan',
                'excerpt'      => 'Desa Maju Sejahtera resmi mendaftarkan diri sebagai peserta Lomba Desa Bersih dan Sehat Tingkat Kabupaten Sejahtera Raya tahun 2026.',
                'content'      => '<p>Pemerintah Desa Maju Sejahtera dengan penuh semangat mendaftarkan diri sebagai peserta <strong>Lomba Desa Bersih dan Sehat Tingkat Kabupaten Sejahtera Raya Tahun 2026</strong>.</p><p>Kepala Desa Suryanto mengajak seluruh elemen masyarakat untuk bergotong royong menjaga kebersihan lingkungan. "Ini bukan sekadar perlombaan, tapi momentum kita bersama untuk menciptakan lingkungan desa yang bersih, sehat, dan nyaman bagi seluruh warga," tegasnya.</p>',
                'published_at' => now()->subDays(20),
                'views'        => 98,
            ],
        ];

        foreach ($newsData as $news) {
            News::create(array_merge($news, [
                'user_id' => $admin->id,
                'slug'    => Str::slug($news['title']),
                'image'   => null,
                'status'  => 'published',
            ]));
        }

        // 5. Events
        $events = [
            [
                'title'          => 'Musyawarah Desa (Musdes) Pembahasan RAPBDes 2027',
                'description'    => 'Musyawarah Desa untuk membahas dan menetapkan Rancangan Anggaran Pendapatan dan Belanja Desa (RAPBDes) tahun anggaran 2027. Seluruh tokoh masyarakat, Ketua RT/RW, dan warga diharapkan hadir.',
                'start_datetime' => now()->addDays(5)->setTime(9, 0),
                'end_datetime'   => now()->addDays(5)->setTime(14, 0),
                'location'       => 'Balai Desa Maju Sejahtera',
                'organizer'      => 'Pemerintah Desa & BPD',
                'status'         => 'upcoming',
            ],
            [
                'title'          => 'Peringatan Hari Jadi Desa ke-81',
                'description'    => 'Perayaan Hari Jadi Desa Maju Sejahtera yang ke-81 akan diisi dengan berbagai kegiatan, termasuk upacara adat, pertunjukan seni budaya, perlombaan warga, dan pameran produk UMKM lokal.',
                'start_datetime' => now()->addDays(14)->setTime(7, 0),
                'end_datetime'   => now()->addDays(14)->setTime(21, 0),
                'location'       => 'Lapangan Desa Maju Sejahtera',
                'organizer'      => 'Panitia Hari Jadi Desa',
                'status'         => 'upcoming',
            ],
            [
                'title'          => 'Vaksinasi Hewan Ternak Gratis',
                'description'    => 'Program vaksinasi hewan ternak (sapi, kambing, domba) gratis yang diselenggarakan oleh Dinas Peternakan Kabupaten bekerjasama dengan Pemerintah Desa Maju Sejahtera.',
                'start_datetime' => now()->addDays(3)->setTime(8, 0),
                'end_datetime'   => now()->addDays(3)->setTime(12, 0),
                'location'       => 'Kandang Komunal RT 03 Dusun Rejo',
                'organizer'      => 'Dinas Peternakan & Pemerintah Desa',
                'status'         => 'upcoming',
            ],
            [
                'title'          => 'Kerja Bakti Bersih Desa Bulanan',
                'description'    => 'Kegiatan rutin kerja bakti membersihkan lingkungan desa, got/saluran air, dan fasilitas umum. Warga dihimbau membawa peralatan kebersihan masing-masing.',
                'start_datetime' => now()->subDays(10)->setTime(7, 0),
                'end_datetime'   => now()->subDays(10)->setTime(10, 0),
                'location'       => 'Seluruh Wilayah Desa',
                'organizer'      => 'Karang Taruna & Pemerintah Desa',
                'status'         => 'completed',
            ],
            [
                'title'          => 'Sosialisasi Program BPJS Kesehatan untuk Warga Desa',
                'description'    => 'Sosialisasi manfaat dan cara pendaftaran BPJS Kesehatan, khususnya untuk warga yang belum memiliki jaminan kesehatan. Narasumber dari Kantor BPJS Kesehatan Kabupaten.',
                'start_datetime' => now()->subDays(20)->setTime(9, 0),
                'end_datetime'   => now()->subDays(20)->setTime(12, 0),
                'location'       => 'Balai Desa Maju Sejahtera',
                'organizer'      => 'BPJS Kesehatan & Pemerintah Desa',
                'status'         => 'completed',
            ],
        ];

        foreach ($events as $event) {
            Event::create(array_merge($event, ['image' => null]));
        }

        // 6. Service Types
        $serviceTypes = [
            [
                'name'           => 'Surat Keterangan Domisili',
                'code'           => 'SKDOM',
                'description'    => 'Surat resmi dari pemerintah desa yang menyatakan bahwa seseorang berdomisili/bertempat tinggal di wilayah desa tersebut.',
                'requirements'   => [
                    'Fotokopi KTP yang masih berlaku (1 lembar)',
                    'Fotokopi Kartu Keluarga (KK) terbaru (1 lembar)',
                    'Surat pengantar dari RT setempat',
                    'Materai Rp 10.000 (1 lembar, jika diperlukan)',
                ],
                'estimated_time' => '1 Hari Kerja',
                'fee'            => 'Gratis',
                'order'          => 1,
                'is_active'      => true,
            ],
            [
                'name'           => 'Surat Keterangan Tidak Mampu (SKTM)',
                'code'           => 'SKTM',
                'description'    => 'Surat keterangan resmi yang menyatakan bahwa pemohon termasuk dalam kategori keluarga tidak mampu secara ekonomi.',
                'requirements'   => [
                    'Fotokopi KTP pemohon (1 lembar)',
                    'Fotokopi Kartu Keluarga (KK) (1 lembar)',
                    'Surat pengantar dari RT dan RW setempat',
                    'Pas foto 3x4 terbaru (2 lembar)',
                    'Surat keterangan penghasilan dari tempat kerja (jika ada)',
                ],
                'estimated_time' => '2 Hari Kerja',
                'fee'            => 'Gratis',
                'order'          => 2,
                'is_active'      => true,
            ],
            [
                'name'           => 'Surat Keterangan Usaha (SKU)',
                'code'           => 'SKU',
                'description'    => 'Surat resmi dari pemerintah desa yang menerangkan bahwa pemohon menjalankan usaha tertentu di wilayah desa.',
                'requirements'   => [
                    'Fotokopi KTP yang masih berlaku (1 lembar)',
                    'Fotokopi Kartu Keluarga (KK) (1 lembar)',
                    'Surat pengantar dari RT setempat',
                    'Foto lokasi usaha (min. 2 foto)',
                    'Deskripsi singkat jenis dan alamat usaha',
                ],
                'estimated_time' => '2 Hari Kerja',
                'fee'            => 'Gratis',
                'order'          => 3,
                'is_active'      => true,
            ],
            [
                'name'           => 'Surat Pengantar KTP / Kartu Keluarga',
                'code'           => 'SPKTP',
                'description'    => 'Surat pengantar dari pemerintah desa yang diperlukan untuk proses pembuatan atau perubahan KTP dan Kartu Keluarga di Disdukcapil.',
                'requirements'   => [
                    'Blangko permohonan dari kantor desa (tersedia gratis)',
                    'Fotokopi KK lama (1 lembar)',
                    'Fotokopi akta kelahiran (1 lembar)',
                    'Surat pengantar dari RT setempat',
                    'Untuk perubahan data: sertakan dokumen pendukung perubahan',
                ],
                'estimated_time' => '1 Hari Kerja',
                'fee'            => 'Gratis',
                'order'          => 4,
                'is_active'      => true,
            ],
        ];

        foreach ($serviceTypes as $type) {
            ServiceType::create($type);
        }

        // 7. Service Requests
        $serviceTypeIds = ServiceType::pluck('id')->toArray();

        $serviceRequests = [
            [
                'tracking_code'   => 'DS-2026-0023',
                'service_type_id' => $serviceTypeIds[0],
                'applicant_name'  => 'Budi Santoso',
                'nik'             => '3301012501880001',
                'phone'           => '081234567890',
                'description'     => 'Membutuhkan surat keterangan domisili untuk keperluan pendaftaran sekolah anak.',
                'status'          => 'selesai',
                'admin_note'      => 'Surat telah diterbitkan. Silakan diambil di kantor desa pada jam kerja.',
                'processed_by'    => $admin->id,
                'processed_at'    => now()->subDays(3),
                'created_at'      => now()->subDays(5),
                'updated_at'      => now()->subDays(3),
            ],
            [
                'tracking_code'   => 'DS-2026-0145',
                'service_type_id' => $serviceTypeIds[1],
                'applicant_name'  => 'Sari Dewi Rahayu',
                'nik'             => '3301016507920003',
                'phone'           => '085678901234',
                'description'     => 'Mengajukan SKTM untuk persyaratan beasiswa pendidikan anak di SMA Negeri 1.',
                'status'          => 'diproses',
                'admin_note'      => 'Sedang dalam proses verifikasi data. Mohon menunggu 1-2 hari kerja.',
                'processed_by'    => $admin->id,
                'processed_at'    => now()->subDay(),
                'created_at'      => now()->subDays(2),
                'updated_at'      => now()->subDay(),
            ],
            [
                'tracking_code'   => 'DS-2026-0167',
                'service_type_id' => $serviceTypeIds[2],
                'applicant_name'  => 'Ahmad Riyadi',
                'nik'             => '3301011508750002',
                'phone'           => '089012345678',
                'description'     => 'Memerlukan SKU untuk pengajuan pinjaman modal usaha warung kelontong di RT 05.',
                'status'          => 'menunggu',
                'admin_note'      => null,
                'processed_by'    => null,
                'processed_at'    => null,
                'created_at'      => now()->subHours(5),
                'updated_at'      => now()->subHours(5),
            ],
            [
                'tracking_code'   => 'DS-2026-0089',
                'service_type_id' => $serviceTypeIds[3],
                'applicant_name'  => 'Nurul Hidayah',
                'nik'             => '3301014203950006',
                'phone'           => '087654321098',
                'description'     => 'Permohonan surat pengantar untuk mengurus KTP yang hilang di Disdukcapil.',
                'status'          => 'selesai',
                'admin_note'      => 'Surat pengantar sudah siap. Harap segera diambil sebelum masa berlakunya habis (7 hari).',
                'processed_by'    => $admin->id,
                'processed_at'    => now()->subDays(7),
                'created_at'      => now()->subDays(8),
                'updated_at'      => now()->subDays(7),
            ],
            [
                'tracking_code'   => 'DS-2026-0201',
                'service_type_id' => $serviceTypeIds[1],
                'applicant_name'  => 'Hendra Gunawan',
                'nik'             => '3301012209800004',
                'phone'           => '082198765432',
                'description'     => 'Membutuhkan SKTM untuk keringanan biaya rawat inap di RS Daerah.',
                'status'          => 'ditolak',
                'admin_note'      => 'Pengajuan ditolak karena data NIK tidak sesuai dengan data kependudukan yang ada. Harap datang langsung ke kantor desa dengan membawa KTP asli untuk klarifikasi.',
                'processed_by'    => $admin->id,
                'processed_at'    => now()->subDays(1),
                'created_at'      => now()->subDays(3),
                'updated_at'      => now()->subDays(1),
            ],
        ];

        foreach ($serviceRequests as $request) {
            ServiceRequest::create($request);
        }
    }
}
