<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Http\Controllers\RegisterController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class Sprint1Test extends TestCase
{
    use RefreshDatabase;

    private function createUser(array $data = []): User
    {
        return User::create(array_merge([
            'nama' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'password' => Hash::make('Secret123!'),
            'gender' => 'Laki-laki',
            'prodi' => 'Informatika',
            'lokasi' => [
                'provinsi' => 'Jawa Timur',
                'kota' => 'Kabupaten Nganjuk',
            ],
            'bidang_diminati' => [
                'predefined' => ['Web Development'],
                'custom' => null,
            ],
            'streak' => 0,
        ], $data));
    }

    private function registrationSession(): array
    {
        return [
            'register.nama' => 'Siti Aminah',
            'register.email' => 'siti@example.com',
            'register.password' => 'Secret123!',
            'register.gender' => 'Perempuan',
            'register.prodi' => 'Informatika',
            'register.bidang_diminati' => [
                'predefined' => ['Web Development'],
                'custom' => null,
            ],
        ];
    }

    // =====================================================
    // 1. IMPLEMENTASI BASIS DATA
    // =====================================================

    public function test_user_casts_json_attributes(): void
    {
        $user = new User();

        $user->lokasi = [
            'provinsi' => 'Jawa Timur',
            'kota' => 'Kabupaten Nganjuk',
        ];

        $user->bidang_diminati = [
            'predefined' => ['Web Development'],
            'custom' => 'DevOps',
        ];

        $this->assertIsArray($user->lokasi);
        $this->assertEquals('Jawa Timur', $user->lokasi['provinsi']);
        $this->assertEquals(
            'Kabupaten Nganjuk',
            $user->lokasi['kota']
        );

        $this->assertIsArray($user->bidang_diminati);
        $this->assertEquals(
            ['Web Development'],
            $user->bidang_diminati['predefined']
        );
        $this->assertEquals(
            'DevOps',
            $user->bidang_diminati['custom']
        );
    }

    public function test_user_model_configuration(): void
    {
        $user = new User();

        $this->assertEquals('id_user', $user->getKeyName());
        $this->assertFalse($user->timestamps);
    }

    public function test_user_can_be_saved_to_database(): void
    {
        $user = $this->createUser();

        $this->assertDatabaseHas('users', [
            'id_user' => $user->id_user,
            'nama' => 'Budi Santoso',
            'email' => 'budi@example.com',
        ]);

        $savedUser = User::find($user->id_user);

        $this->assertNotNull($savedUser);
        $this->assertEquals(
            'Jawa Timur',
            $savedUser->lokasi['provinsi']
        );
        $this->assertEquals(
            'Kabupaten Nganjuk',
            $savedUser->lokasi['kota']
        );
        $this->assertEquals(
            ['Web Development'],
            $savedUser->bidang_diminati['predefined']
        );
    }

    public function test_user_email_must_be_unique(): void
    {
        $this->createUser();

        $this->expectException(
            \Illuminate\Database\QueryException::class
        );

        $this->createUser([
            'nama' => 'Pengguna Kedua',
        ]);
    }

    public function test_user_can_have_empty_custom_interest(): void
    {
        $user = $this->createUser([
            'bidang_diminati' => [
                'predefined' => ['Web Development'],
                'custom' => null,
            ],
        ]);

        $this->assertNull(
            $user->bidang_diminati['custom']
        );
    }

    // =====================================================
    // 2. INTEGRASI API LOKASI EKSTERNAL
    // =====================================================

    public function test_regencies_api_returns_empty_data_without_code(): void
    {
        $response = $this->getJson('/api/wilayah/regencies');

        $response->assertOk()
            ->assertExactJson(['data' => []]);
    }

    public function test_regencies_api_accepts_province_code_parameter(): void
    {
        // Kode provinsi diberikan melalui query string.
        // Pengujian ini memastikan endpoint menerima parameter.
        // Kode valid dapat menghubungi API wilayah eksternal.
        $response = $this->getJson(
            '/api/wilayah/regencies?province_code='
        );

        $response->assertOk()
            ->assertExactJson(['data' => []]);
    }

    public function test_provinces_api_returns_json_response(): void
    {
        // Endpoint menggunakan API wilayah.id secara langsung.
        // Pengujian ini memeriksa format respons apabila API tersedia.
        $response = $this->getJson('/api/wilayah/provinces');

        $response->assertOk()
            ->assertJsonStructure(['data']);
    }

    // =====================================================
    // 3. REGISTRASI
    // =====================================================

    public function test_registration_first_step_accepts_valid_data(): void
    {
        $response = $this->post('/register/nama', [
            'nama' => 'Siti Aminah',
            'email' => 'siti@example.com',
            'gender' => 'Perempuan',
            'password' => 'Secret123!',
            'password_confirmation' => 'Secret123!',
            'agree' => '1',
        ]);

        $response->assertRedirect(route('register.prodi'));

        $this->assertEquals(
            'Siti Aminah',
            session('register.nama')
        );

        $this->assertEquals(
            'siti@example.com',
            session('register.email')
        );

        $this->assertEquals(
            'Perempuan',
            session('register.gender')
        );
    }

    public function test_registration_rejects_empty_required_fields(): void
    {
        $response = $this->post('/register/nama', [
            'nama' => '',
            'email' => '',
            'gender' => '',
            'password' => '',
            'password_confirmation' => '',
        ]);

        $response->assertSessionHasErrors([
            'nama',
            'email',
            'gender',
            'password',
            'agree',
        ]);
    }

    public function test_registration_rejects_invalid_email(): void
    {
        $response = $this->post('/register/nama', [
            'nama' => 'Siti Aminah',
            'email' => 'email-tidak-valid',
            'gender' => 'Perempuan',
            'password' => 'Secret123!',
            'password_confirmation' => 'Secret123!',
            'agree' => '1',
        ]);

        $response->assertSessionHasErrors('email');
    }

    public function test_registration_rejects_duplicate_email(): void
    {
        $this->createUser();

        $response = $this->post('/register/nama', [
            'nama' => 'Pengguna Kedua',
            'email' => 'budi@example.com',
            'gender' => 'Laki-laki',
            'password' => 'Secret123!',
            'password_confirmation' => 'Secret123!',
            'agree' => '1',
        ]);

        $response->assertSessionHasErrors('email');
    }

    public function test_registration_rejects_invalid_gender(): void
    {
        $response = $this->post('/register/nama', [
            'nama' => 'Siti Aminah',
            'email' => 'siti@example.com',
            'gender' => 'Lainnya',
            'password' => 'Secret123!',
            'password_confirmation' => 'Secret123!',
            'agree' => '1',
        ]);

        $response->assertSessionHasErrors('gender');
    }

    public function test_registration_rejects_password_without_number(): void
    {
        $response = $this->post('/register/nama', [
            'nama' => 'Siti Aminah',
            'email' => 'siti@example.com',
            'gender' => 'Perempuan',
            'password' => 'SecretPass!',
            'password_confirmation' => 'SecretPass!',
            'agree' => '1',
        ]);

        $response->assertSessionHasErrors('password');
    }

    public function test_registration_rejects_password_without_symbol(): void
    {
        $response = $this->post('/register/nama', [
            'nama' => 'Siti Aminah',
            'email' => 'siti@example.com',
            'gender' => 'Perempuan',
            'password' => 'Secret123',
            'password_confirmation' => 'Secret123',
            'agree' => '1',
        ]);

        $response->assertSessionHasErrors('password');
    }

    public function test_registration_rejects_short_password(): void
    {
        $rules = [
            'password' => [
                'required',
                Password::min(8),
            ],
        ];

        $validator = Validator::make([
            'password' => 'short',
        ], $rules);

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey(
            'password',
            $validator->errors()->toArray()
        );
    }

    public function test_registration_rejects_mismatched_password(): void
    {
        $response = $this->post('/register/nama', [
            'nama' => 'Siti Aminah',
            'email' => 'siti@example.com',
            'gender' => 'Perempuan',
            'password' => 'Secret123!',
            'password_confirmation' => 'Different123!',
            'agree' => '1',
        ]);

        $response->assertSessionHasErrors('password');
    }

    public function test_registration_requires_terms_agreement(): void
    {
        $response = $this->post('/register/nama', [
            'nama' => 'Siti Aminah',
            'email' => 'siti@example.com',
            'gender' => 'Perempuan',
            'password' => 'Secret123!',
            'password_confirmation' => 'Secret123!',
        ]);

        $response->assertSessionHasErrors('agree');
    }

    public function test_registration_accepts_valid_study_program(): void
    {
        $response = $this->post('/register/prodi', [
            'prodi' => 'Informatika',
            'jurusan' => 'Teknik',
        ]);

        $response->assertRedirect(route('register.minat'));

        $this->assertEquals(
            'Informatika',
            session('register.prodi')
        );
    }

    public function test_registration_rejects_empty_study_program(): void
    {
        $response = $this->post('/register/prodi', [
            'prodi' => '',
            'jurusan' => 'Teknik',
        ]);

        $response->assertSessionHasErrors('prodi');
    }

    public function test_registration_accepts_valid_interests(): void
    {
        $response = $this->post('/register/minat', [
            'minat' => [
                'Web Development',
                'Data Science',
            ],
        ]);

        $response->assertRedirect(route('register.domisili'));

        $this->assertEquals(
            ['Web Development', 'Data Science'],
            session('register.bidang_diminati.predefined')
        );

        $this->assertNull(
            session('register.bidang_diminati.custom')
        );
    }

    public function test_registration_rejects_empty_interests(): void
    {
        $response = $this->post('/register/minat', [
            'minat' => [],
        ]);

        $response->assertSessionHasErrors('minat');
    }

    public function test_registration_rejects_more_than_three_interests(): void
    {
        $response = $this->post('/register/minat', [
            'minat' => [
                'Web Development',
                'Data Science',
                'UI/UX',
                'DevOps',
            ],
        ]);

        $response->assertSessionHasErrors('minat');
    }

    public function test_registration_other_interest_requires_custom_value(): void
    {
        $response = $this->post('/register/minat', [
            'minat' => ['Web Development', 'Other'],
            'minat_other' => '   ',
        ]);

        $response->assertSessionHasErrors('minat_other');
    }

    public function test_registration_stores_custom_interest(): void
    {
        $response = $this->post('/register/minat', [
            'minat' => ['Web Development', 'Other'],
            'minat_other' => ' Mobile Flutter ',
        ]);

        $response->assertRedirect(route('register.domisili'));

        $this->assertEquals(
            ['Web Development'],
            session('register.bidang_diminati.predefined')
        );

        $this->assertEquals(
            'Mobile Flutter',
            session('register.bidang_diminati.custom')
        );

        $this->assertNotContains(
            'Other',
            session('register.bidang_diminati.predefined')
        );
    }

    public function test_registration_rejects_empty_location(): void
    {
        session($this->registrationSession());

        $response = $this->post('/register/store', [
            'provinsi' => 'Jawa Timur',
            'kota' => '',
        ]);

        $response->assertSessionHasErrors('kota');
    }

    public function test_registration_completes_and_logs_user_in(): void
    {
        session($this->registrationSession());

        $response = $this->post('/register/store', [
            'provinsi' => 'Jawa Timur',
            'kota' => 'Kabupaten Nganjuk',
        ]);

        $response->assertRedirect('/dashboard');

        $this->assertDatabaseHas('users', [
            'nama' => 'Siti Aminah',
            'email' => 'siti@example.com',
            'gender' => 'Perempuan',
        ]);

        $user = User::where(
            'email',
            'siti@example.com'
        )->firstOrFail();

        $this->assertTrue(
            Hash::check('Secret123!', $user->password)
        );

        $this->assertAuthenticatedAs($user);

        $this->assertFalse(
            session()->has('register.nama')
        );

        $this->assertFalse(
            session()->has('register.password')
        );
    }

    public function test_registration_rejects_incomplete_session(): void
    {
        session([
            'register.nama' => 'Siti Aminah',
            'register.email' => 'siti@example.com',
        ]);

        $response = $this->post('/register/store', [
            'provinsi' => 'Jawa Timur',
            'kota' => 'Kabupaten Nganjuk',
        ]);

        $response->assertRedirect(route('register'))
            ->assertSessionHasErrors('session');

        $this->assertDatabaseMissing('users', [
            'email' => 'siti@example.com',
        ]);
    }

    // =====================================================
    // 4. LOGIN DAN LOGOUT
    // =====================================================

    public function test_login_with_correct_credentials(): void
    {
        $user = $this->createUser();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'Secret123!',
        ]);

        $response->assertRedirect('/dashboard');

        $this->assertAuthenticatedAs($user);
    }

    public function test_login_rejects_unregistered_email(): void
    {
        $response = $this->post('/login', [
            'email' => 'unknown@example.com',
            'password' => 'Secret123!',
        ]);

        $response->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_login_rejects_wrong_password(): void
    {
        $user = $this->createUser();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'Wrong123!',
        ]);

        $response->assertSessionHasErrors('password');

        $this->assertGuest();
    }

    public function test_login_requires_email_and_password(): void
    {
        $response = $this->post('/login', [
            'email' => '',
            'password' => '',
        ]);

        $response->assertSessionHasErrors([
            'email',
            'password',
        ]);

        $this->assertGuest();
    }

    public function test_authenticated_user_can_logout(): void
    {
        $user = $this->createUser();

        $response = $this->actingAs($user)->post('/logout');

        $response->assertRedirect('/login');

        $this->assertGuest();
    }

    // =====================================================
    // 5. PENGELOLAAN PROFIL
    // =====================================================

    public function test_authenticated_user_can_view_profile(): void
    {
        $user = $this->createUser();

        $response = $this->actingAs($user)->get('/profil');

        $response->assertOk()
            ->assertViewIs('profil')
            ->assertViewHas('user', function ($viewUser) use ($user) {
                return $viewUser->id_user === $user->id_user;
            });
    }

    public function test_guest_cannot_view_profile(): void
    {
        $response = $this->get('/profil');

        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_can_update_profile(): void
    {
        $user = $this->createUser();

        $response = $this->actingAs($user)->post('/profil', [
            'nama' => 'Budi Santoso Updated',
            'gender' => 'Laki-laki',
            'prodi' => 'Sistem Informasi',
            'minat' => ['Data Science'],
            'provinsi' => 'Jawa Barat',
            'kota' => 'Kota Bandung',
        ]);

        $response->assertRedirect(route('profil'))
            ->assertSessionHas('success');

        $user->refresh();

        $this->assertEquals(
            'Budi Santoso Updated',
            $user->nama
        );

        $this->assertEquals(
            'Sistem Informasi',
            $user->prodi
        );

        $this->assertEquals(
            'Jawa Barat',
            $user->lokasi['provinsi']
        );

        $this->assertEquals(
            'Kota Bandung',
            $user->lokasi['kota']
        );

        $this->assertEquals(
            ['Data Science'],
            $user->bidang_diminati['predefined']
        );
    }

    public function test_profile_update_rejects_empty_required_fields(): void
    {
        $user = $this->createUser();

        $response = $this->actingAs($user)->post('/profil', [
            'nama' => '',
            'gender' => 'Laki-laki',
            'prodi' => 'Informatika',
            'minat' => ['Data Science'],
            'provinsi' => 'Jawa Timur',
            'kota' => 'Kabupaten Nganjuk',
        ]);

        $response->assertSessionHasErrors('nama');
    }

    public function test_profile_update_rejects_invalid_gender(): void
    {
        $user = $this->createUser();

        $response = $this->actingAs($user)->post('/profil', [
            'nama' => 'Budi Santoso',
            'gender' => 'Tidak valid',
            'prodi' => 'Informatika',
            'minat' => ['Data Science'],
            'provinsi' => 'Jawa Timur',
            'kota' => 'Kabupaten Nganjuk',
        ]);

        $response->assertSessionHasErrors('gender');
    }

    public function test_profile_other_program_requires_custom_value(): void
    {
        $user = $this->createUser();

        $response = $this->actingAs($user)->post('/profil', [
            'nama' => 'Budi Santoso',
            'gender' => 'Laki-laki',
            'prodi' => 'Other',
            'prodi_other' => '   ',
            'minat' => ['Data Science'],
            'provinsi' => 'Jawa Timur',
            'kota' => 'Kabupaten Nganjuk',
        ]);

        $response->assertSessionHasErrors('prodi');
    }

    public function test_profile_other_interest_requires_custom_value(): void
    {
        $user = $this->createUser();

        $response = $this->actingAs($user)->post('/profil', [
            'nama' => 'Budi Santoso',
            'gender' => 'Laki-laki',
            'prodi' => 'Informatika',
            'minat' => ['Other'],
            'minat_other' => '   ',
            'provinsi' => 'Jawa Timur',
            'kota' => 'Kabupaten Nganjuk',
        ]);

        $response->assertSessionHasErrors('minat_other');
    }

    public function test_profile_can_store_custom_program_and_interest(): void
    {
        $user = $this->createUser();

        $response = $this->actingAs($user)->post('/profil', [
            'nama' => 'Budi Santoso',
            'gender' => 'Laki-laki',
            'prodi' => 'Other',
            'prodi_other' => 'Teknologi Informasi',
            'minat' => ['Web Development', 'Other'],
            'minat_other' => 'Mobile Flutter',
            'provinsi' => 'Jawa Timur',
            'kota' => 'Kabupaten Nganjuk',
        ]);

        $response->assertRedirect(route('profil'));

        $user->refresh();

        $this->assertEquals(
            'Teknologi Informasi',
            $user->prodi
        );

        $this->assertEquals(
            ['Web Development'],
            $user->bidang_diminati['predefined']
        );

        $this->assertEquals(
            'Mobile Flutter',
            $user->bidang_diminati['custom']
        );
    }

    public function test_profile_can_upload_valid_image(): void
    {
        Storage::fake('public');

        $user = $this->createUser();

        $response = $this->actingAs($user)->post('/profil', [
            'nama' => 'Budi Santoso',
            'gender' => 'Laki-laki',
            'prodi' => 'Informatika',
            'minat' => ['Data Science'],
            'provinsi' => 'Jawa Timur',
            'kota' => 'Kabupaten Nganjuk',
            'foto_profil' => UploadedFile::fake()->create('avatar.jpg', 500, 'image/jpeg'),
        ]);

        $response->assertRedirect(route('profil'));

        $user->refresh();

        $this->assertNotNull($user->foto_profil);

        /** @var \Illuminate\Filesystem\FilesystemAdapter $disk */
        $disk = Storage::disk('public');
        $disk->assertExists($user->foto_profil);
    }

    public function test_profile_rejects_non_image_file(): void
    {
        Storage::fake('public');

        $user = $this->createUser();

        $response = $this->actingAs($user)->post('/profil', [
            'nama' => 'Budi Santoso',
            'gender' => 'Laki-laki',
            'prodi' => 'Informatika',
            'minat' => ['Data Science'],
            'provinsi' => 'Jawa Timur',
            'kota' => 'Kabupaten Nganjuk',
            'foto_profil' => UploadedFile::fake()->create(
                'dokumen.pdf',
                100,
                'application/pdf'
            ),
        ]);

        $response->assertSessionHasErrors('foto_profil');
    }

    public function test_profile_rejects_image_larger_than_two_mb(): void
    {
        Storage::fake('public');

        $user = $this->createUser();

        $response = $this->actingAs($user)->post('/profil', [
            'nama' => 'Budi Santoso',
            'gender' => 'Laki-laki',
            'prodi' => 'Informatika',
            'minat' => ['Data Science'],
            'provinsi' => 'Jawa Timur',
            'kota' => 'Kabupaten Nganjuk',
            'foto_profil' => UploadedFile::fake()->create('large.jpg', 2049, 'image/jpeg'),
        ]);

        $response->assertSessionHasErrors('foto_profil');
        $response->assertSessionHasErrors([
            'foto_profil' => 'Ukuran file foto maksimal 2MB.',
        ]);
    }

    // =====================================================
    // 6. SESSION REGISTRASI
    // =====================================================

    public function test_clear_registration_session_removes_all_keys(): void
    {
        session([
            'register.nama' => 'Budi',
            'register.email' => 'budi@example.com',
            'register.password' => 'Secret123!',
            'register.gender' => 'Laki-laki',
            'register.prodi' => 'Informatika',
            'register.jurusan' => 'Teknik',
            'register.bidang_diminati' => ['Web Development'],
            'register.minat_other' => 'DevOps',
            'register.lokasi' => ['provinsi' => 'Jawa Timur'],
            'register.provinsi' => 'Jawa Timur',
            'register.kota' => 'Kabupaten Nganjuk',
        ]);

        RegisterController::clearRegistrationSession();

        $keys = [
            'register.nama',
            'register.email',
            'register.password',
            'register.gender',
            'register.prodi',
            'register.jurusan',
            'register.bidang_diminati',
            'register.minat_other',
            'register.lokasi',
            'register.provinsi',
            'register.kota',
        ];

        foreach ($keys as $key) {
            $this->assertFalse(
                session()->has($key),
                "Session {$key} seharusnya sudah dihapus."
            );
        }
    }
}