<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $locations = [
            ['provinsi' => 'Jawa Timur', 'kota' => 'Kota Surabaya'],
            ['provinsi' => 'Jawa Timur', 'kota' => 'Kabupaten Ngawi'],
            ['provinsi' => 'Jawa Timur', 'kota' => 'Kabupaten Malang'],
            ['provinsi' => 'Jawa Barat', 'kota' => 'Kota Bandung'],
            ['provinsi' => 'Jawa Barat', 'kota' => 'Kota Bekasi'],
            ['provinsi' => 'Jawa Tengah', 'kota' => 'Kota Semarang'],
            ['provinsi' => 'Bali', 'kota' => 'Kabupaten Badung'],
            ['provinsi' => 'Banten', 'kota' => 'Kota Tangerang'],
            ['provinsi' => 'DKI Jakarta', 'kota' => 'Kota Administrasi Jakarta Selatan'],
            ['provinsi' => 'Sumatera Utara', 'kota' => 'Kota Medan'],
            ['provinsi' => 'DI Yogyakarta', 'kota' => 'Kota Yogyakarta'],
            ['provinsi' => 'DI Yogyakarta', 'kota' => 'Kabupaten Sleman'],
            ['provinsi' => 'Banten', 'kota' => 'Kota Serang'],
            ['provinsi' => 'Bali', 'kota' => 'Kota Denpasar'],
            ['provinsi' => 'Nusa Tenggara Barat', 'kota' => 'Kota Mataram'],
            ['provinsi' => 'Sumatera Barat', 'kota' => 'Kota Padang'],
            ['provinsi' => 'Riau', 'kota' => 'Kota Pekanbaru'],
            ['provinsi' => 'Kalimantan Timur', 'kota' => 'Kota Samarinda'],
            ['provinsi' => 'Sulawesi Selatan', 'kota' => 'Kota Makassar'],
            ['provinsi' => 'Sulawesi Utara', 'kota' => 'Kota Manado'],
            ['provinsi' => 'Papua', 'kota' => 'Kota Jayapura'],
        ];

        $prodis = [
            'Teknik Informatika',
            'Sistem Informasi',
            'Teknologi Informasi',
            'Rekayasa Perangkat Lunak',
            'Sains Data',
            'Teknik Komputer',
            'Teknik Elektro',
            'Teknik Industri',
            'Bisnis Digital',
            'Manajemen',
            'Akuntansi',
            'Ilmu Komunikasi',
            'Desain Komunikasi Visual',
            'Arsitektur',
            'Statistika',
            'Matematika',
            'Psikologi',
            'Ilmu Hukum',
            'Hubungan Internasional',
        ];

        $interests = [
            ['Artificial Intelligence', 'Machine Learning', 'Data Science', 'Analytics'],
            ['Software Engineering', 'Web Development'],
            ['Database', 'Big Data', 'Cloud Computing', 'DevOps'],
            ['UI/UX Design', 'Mobile App Development'],
            ['Cyber Security', 'Networking'],
            ['IoT', 'Embedded Systems', 'Robotics'],
            ['Game Development', 'Graphic Design'],
            ['Finance', 'Investment', 'Entrepreneurship'],
            ['Digital Marketing', 'Content Creation', 'Branding'],
            ['Research', 'Academic Writing', 'Statistics'],
            ['Product Management', 'Business Analysis', 'Public Speaking'],
            ['Blockchain', 'Web3', 'Cryptography'],
        ];

        $firstNames = [
            'Alya', 'Bima', 'Citra', 'Daffa', 'Eka', 'Farhan', 'Gita', 'Hana',
            'Intan', 'Jihan', 'Kevin', 'Laras', 'Maya', 'Nadia', 'Oka', 'Putri',
            'Raka', 'Salsa', 'Tasya', 'Vino', 'Adinda', 'Bagas', 'Dimas', 'Nayla',
            'Rizky', 'Syifa', 'Galang', 'Tiara', 'Naufal', 'Rania', 'Yoga', 'Widya',
            'Fikri', 'Karina', 'Ilham', 'Mira', 'Tegar', 'Alika', 'Rendy', 'Bella',
        ];

        $lastNames = [
            'Pratama', 'Lestari', 'Saputra', 'Permata', 'Wijaya', 'Setiawan',
            'Kusuma', 'Nugroho', 'Ramadhan', 'Wulandari',
        ];

        $password = Hash::make('password');

        for ($index = 1; $index <= 100; $index++) {
            // Nama sintetis realistis, stabil, unik, dan aman untuk demo.
            $firstName = $firstNames[($index - 1) % count($firstNames)];
            $lastName = $lastNames[intdiv($index - 1, count($firstNames)) % count($lastNames)];
            $username = $firstName . ' ' . $lastName;

            // Pola deterministik menjaga variasi dan membuat seeding ulang stabil.
            $location = $locations[($index * 8 + 3) % count($locations)];
            $prodi = $prodis[($index * 11 + 5) % count($prodis)];
            $interestGroup = $interests[($index * 5 + 2) % count($interests)];
            $interestCount = ($index % 3) + 1;
            $selectedInterests = array_slice($interestGroup, 0, $interestCount);
            $customInterest = $index % 5 === 0 ? 'Product Management' : null;

            User::updateOrCreate(
                ['email' => "seed.user{$index}@studymate.test"],
                [
                    'nama' => $username,
                    'password' => $password,
                    'lokasi' => $location,
                    'gender' => $index % 2 === 0 ? 'Perempuan' : 'Laki-laki',
                    'prodi' => $prodi,
                    'bidang_diminati' => [
                        'predefined' => $selectedInterests,
                        'custom' => $customInterest,
                    ],
                    'foto_profil' => null,
                    'streak' => ($index * 3 + 7) % 35,
                ]
            );
        }

        // Cohort khusus Surabaya untuk memastikan data demo punya kandidat
        // yang relevan pada domisili, prodi, dan minat teknis.
        $surabayaProfiles = [
            ['nama' => 'Rafi Prakoso', 'gender' => 'Laki-laki', 'prodi' => 'Sistem Informasi', 'minat' => ['Software Engineering', 'Artificial Intelligence & ML', 'Cyber Security']],
            ['nama' => 'Nabila Salsabila', 'gender' => 'Perempuan', 'prodi' => 'Sistem Informasi', 'minat' => ['Artificial Intelligence', 'Machine Learning', 'Cloud Computing']],
            ['nama' => 'Fajar Maulana', 'gender' => 'Laki-laki', 'prodi' => 'Teknologi Informasi', 'minat' => ['Cloud Computing', 'DevOps', 'Cyber Security']],
            ['nama' => 'Mutiara Putri', 'gender' => 'Perempuan', 'prodi' => 'Teknik Informatika', 'minat' => ['Cyber Security', 'Networking', 'Cloud Computing']],
            ['nama' => 'Rizal Aditya', 'gender' => 'Laki-laki', 'prodi' => 'Rekayasa Perangkat Lunak', 'minat' => ['Software Engineering', 'Cloud Computing', 'DevOps']],
            ['nama' => 'Shafira Anjani', 'gender' => 'Perempuan', 'prodi' => 'Sistem Informasi', 'minat' => ['Cyber Security', 'DevOps', 'Artificial Intelligence']],
            ['nama' => 'Dion Mahendra', 'gender' => 'Laki-laki', 'prodi' => 'Teknik Komputer', 'minat' => ['Cloud Computing', 'DevOps', 'Networking']],
            ['nama' => 'Aurel Maharani', 'gender' => 'Perempuan', 'prodi' => 'Sains Data', 'minat' => ['Artificial Intelligence', 'Machine Learning', 'Data Science']],
            ['nama' => 'Bintang Ramadhan', 'gender' => 'Laki-laki', 'prodi' => 'Teknik Informatika', 'minat' => ['Cyber Security', 'Cloud Computing', 'DevOps']],
            ['nama' => 'Celine Oktavia', 'gender' => 'Perempuan', 'prodi' => 'Teknologi Informasi', 'minat' => ['Cloud Computing', 'DevOps', 'Networking']],
            ['nama' => 'Damar Wijaya', 'gender' => 'Laki-laki', 'prodi' => 'Sistem Informasi', 'minat' => ['Software Engineering', 'DevOps', 'Database']],
            ['nama' => 'Elisa Maharani', 'gender' => 'Perempuan', 'prodi' => 'Rekayasa Perangkat Lunak', 'minat' => ['Software Engineering', 'Cloud Computing', 'Cyber Security']],
            ['nama' => 'Gerry Firmansyah', 'gender' => 'Laki-laki', 'prodi' => 'Teknik Komputer', 'minat' => ['IoT', 'Embedded Systems', 'Cyber Security']],
            ['nama' => 'Hilda Prameswari', 'gender' => 'Perempuan', 'prodi' => 'Sains Data', 'minat' => ['Data Science', 'Artificial Intelligence', 'Machine Learning']],
            ['nama' => 'Iqbal Ramdani', 'gender' => 'Laki-laki', 'prodi' => 'Teknik Informatika', 'minat' => ['Cyber Security', 'Networking', 'Cryptography']],
            ['nama' => 'Kirana Ayu', 'gender' => 'Perempuan', 'prodi' => 'Sistem Informasi', 'minat' => ['Artificial Intelligence', 'Database', 'Big Data']],
            ['nama' => 'Luthfi Hakim', 'gender' => 'Laki-laki', 'prodi' => 'Teknologi Informasi', 'minat' => ['Cloud Computing', 'DevOps', 'Software Engineering']],
            ['nama' => 'Monica Zahra', 'gender' => 'Perempuan', 'prodi' => 'Rekayasa Perangkat Lunak', 'minat' => ['Mobile App Development', 'Software Engineering', 'UI/UX Design']],
            ['nama' => 'Rangga Pradipta', 'gender' => 'Laki-laki', 'prodi' => 'Teknik Komputer', 'minat' => ['Cloud Computing', 'Cyber Security', 'DevOps']],
        ];

        foreach ($surabayaProfiles as $offset => $profile) {
            $number = 101 + $offset;

            User::updateOrCreate(
                ['email' => "seed.user{$number}@studymate.test"],
                [
                    'nama' => $profile['nama'],
                    'password' => $password,
                    'lokasi' => [
                        'provinsi' => 'Jawa Timur',
                        'kota' => 'Kota Surabaya',
                    ],
                    'gender' => $profile['gender'],
                    'prodi' => $profile['prodi'],
                    'bidang_diminati' => [
                        'predefined' => $profile['minat'],
                        'custom' => null,
                    ],
                    'foto_profil' => null,
                    'streak' => ($number * 3 + 7) % 35,
                ]
            );
        }
    }
}
