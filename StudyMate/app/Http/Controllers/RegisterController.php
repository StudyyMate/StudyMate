<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    // ----------------------------------------------------------------
    // Proxy Wilayah API (Hindari CORS Browser)
    // ----------------------------------------------------------------
    public static function clearRegistrationSession(Request $request = null): void
    {
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

        if ($request) {
            $request->session()->forget($keys);
        } else {
            session()->forget($keys);
        }
    }

    public function getProvinces()
    {
        try {
            $data = json_decode(file_get_contents('https://wilayah.id/api/provinces.json'), true);
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['data' => []], 500);
        }
    }

    public function getRegencies(Request $request, $code = null)
    {
        try {
            $targetCode = $code ?: $request->query('province_code');
            $safeCode = preg_replace('/[^0-9.]/', '', (string) $targetCode);
            if (empty($safeCode)) {
                return response()->json(['data' => []]);
            }
            $data = json_decode(file_get_contents("https://wilayah.id/api/regencies/{$safeCode}.json"), true);
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['data' => []], 500);
        }
    }

    // ----------------------------------------------------------------
    // Step 1: Nama, Email & Gender
    // ----------------------------------------------------------------
    public function namaStore(Request $request)
    {
        $data = $request->validate([
            'nama'   => ['required', 'string', 'max:100'],
            'email'  => ['required', 'email', 'max:100', 'unique:users,email'],
            'gender' => ['required', 'string', 'in:Laki-laki,Perempuan'],
            'password'              => ['required', 'string', 'confirmed', function ($attribute, $value, $fail) {
                if (strlen($value) < 8 || !preg_match('/[0-9]/', $value) || !preg_match('/[\W_]/', $value)) {
                    $fail('Password tidak valid.');
                }
            }],
            'agree'                 => ['accepted'],
        ], [
            'nama.required'   => 'Data tidak boleh kosong.',
            'email.required'  => 'Alamat email wajib diisi.',
            'email.email'     => 'Format email tidak valid.',
            'email.unique'    => 'Email sudah terdaftar.',
            'gender.required' => 'Data tidak boleh kosong.',
            'gender.in'       => 'Pilih jenis kelamin yang valid.',
            'password.required'   => 'Data tidak boleh kosong.',
            'password.confirmed'  => 'Konfirmasi password tidak cocok.',
            'agree.accepted'      => 'Anda harus menyetujui Ketentuan Layanan.',
        ]);

        session([
            'register.nama'   => $data['nama'],
            'register.email'  => $data['email'],
            'register.gender' => $data['gender'],
            'register.password'=> $data['password'],
        ]);

        return redirect()->route('register.prodi');
    }

    // ----------------------------------------------------------------
    // Step 2: Program Studi
    // ----------------------------------------------------------------
    public function prodiStore(Request $request)
    {
        $data = $request->validate([
            'prodi'   => ['required', 'string', 'max:100'],
            'jurusan' => ['nullable', 'string', 'max:50'],
        ], [
            'prodi.required' => 'Data tidak boleh kosong.',
        ]);

        session([
            'register.prodi'   => $data['prodi'],
            'register.jurusan' => $data['jurusan'] ?? null,
        ]);

        return redirect()->route('register.minat');
    }

    // ----------------------------------------------------------------
    // Step 3: Minat / Bidang Diminati
    // ----------------------------------------------------------------
    public function minatStore(Request $request)
    {
        $request->validate([
            'minat'       => ['required', 'array', 'min:1', 'max:3'],
            'minat.*'     => ['string', 'max:50'],
            'minat_other' => ['nullable', 'string', 'max:50'],
        ], [
            'minat.required' => 'Data tidak boleh kosong.',
            'minat.min'      => 'Data tidak boleh kosong.',
            'minat.max'      => 'Maksimal 3 bidang minat yang dapat dipilih.',
        ]);

        $minatList = $request->input('minat');
        $customValue = null;

        // Jika user memilih opsi 'Other', pastikan field minat_other diisi
        if (in_array('Other', $minatList)) {
            $otherVal = trim($request->input('minat_other', ''));
            if ($otherVal === '') {
                return back()->withInput()->withErrors(['minat_other' => 'Bidang minat lainnya wajib diisi jika memilih opsi Other.']);
            }
            $customValue = $otherVal;
            // Hapus 'Other' dari list predefined
            $minatList = array_values(array_filter($minatList, fn($m) => $m !== 'Other'));

            session(['register.minat_other' => $otherVal]);
        } else {
            session()->forget('register.minat_other');
        }

        $bidangDiminati = [
            'predefined' => array_values($minatList),
            'custom'     => $customValue,
        ];

        session(['register.bidang_diminati' => $bidangDiminati]);

        return redirect()->route('register.domisili');
    }

    // ----------------------------------------------------------------
    // Step 4: Domisili (Provinsi & Kota)
    // ----------------------------------------------------------------
    public function store(Request $request)
    {
        $data = $request->validate([
            'provinsi' => ['required', 'string', 'max:100'],
            'kota'     => ['required', 'string', 'max:100'],
        ], [
            'provinsi.required' => 'Data tidak boleh kosong.',
            'kota.required'     => 'Data tidak boleh kosong.',
        ]);

        $lokasi = [
            'provinsi' => $data['provinsi'],
            'kota'     => $data['kota'],
        ];

        // Semua data dari session
        $nama            = session('register.nama');
        $email           = session('register.email');
        $password        = session('register.password');
        $gender          = session('register.gender');
        $prodi           = session('register.prodi');
        $bidang_diminati = session('register.bidang_diminati');

        if (!$nama || !$email || !$gender || !$prodi || !$bidang_diminati || !$lokasi) {
            return redirect()->route('register')->withErrors(['session' => 'Data registrasi tidak lengkap. Mulai dari awal.']);
        }

        $user = User::create([
            'nama'            => $nama,
            'email'           => $email,
            'password'        => Hash::make($password),
            'gender'          => $gender,
            'prodi'           => $prodi,
            'bidang_diminati' => $bidang_diminati,
            'lokasi'          => $lokasi,
            'streak'          => 0,
        ]);

        // Auto login user setelah berhasil register
        Auth::login($user);

        // Bersihkan session register
        self::clearRegistrationSession($request);

        return redirect('/dashboard')->with('success', 'Akun berhasil dibuat! Selamat datang di StudyMate.');
    }
}
