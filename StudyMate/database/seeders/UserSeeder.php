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
    }
}
