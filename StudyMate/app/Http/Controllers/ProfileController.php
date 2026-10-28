<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function show()
    {
        return view('profil', ['user' => Auth::user()]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama'        => ['required', 'string', 'max:100'],
            'gender'      => ['required', 'string', 'in:Laki-laki,Perempuan'],
            'prodi'       => ['required', 'string', 'max:100'],
            'prodi_other' => ['nullable', 'string', 'max:100'],
            'minat'       => ['required', 'array', 'min:1', 'max:3'],
            'minat.*'     => ['string', 'max:50'],
            'minat_other' => ['nullable', 'string', 'max:50'],
            'provinsi'    => ['required', 'string', 'max:100'],
            'kota'        => ['required', 'string', 'max:100'],
            'foto_profil' => ['nullable', 'image', 'max:2048'],
        ], [
            'nama.required'     => 'Data tidak boleh kosong.',
            'gender.required'   => 'Data tidak boleh kosong.',
            'prodi.required'    => 'Data tidak boleh kosong.',
            'minat.required'    => 'Data tidak boleh kosong.',
            'minat.min'         => 'Data tidak boleh kosong.',
            'provinsi.required' => 'Data tidak boleh kosong.',
            'kota.required'     => 'Data tidak boleh kosong.',
            'foto_profil.image' => 'File harus berupa gambar.',
            'foto_profil.max'   => 'Ukuran file foto maksimal 2MB.',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Prodi Other
        $prodi = $request->input('prodi');
        if ($prodi === 'Other') {
            $prodi = trim((string) $request->input('prodi_other'));
            if ($prodi === '') {
                return back()->withErrors(['prodi' => 'Data tidak boleh kosong.'])->withInput();
            }
        }

        // Minat Other
        $minatList = $request->input('minat', []);
        $customValue = null;
        if (in_array('Other', $minatList)) {
            $otherVal = trim($request->input('minat_other', ''));
            if ($otherVal === '') {
                return back()->withErrors(['minat_other' => 'Data tidak boleh kosong.'])->withInput();
            }
            $customValue = $otherVal;
            $minatList = array_values(array_filter($minatList, fn($m) => $m !== 'Other'));
        }

        // Upload foto
        $fotoPath = $user->foto_profil;
        if ($request->hasFile('foto_profil')) {
            if ($fotoPath && Storage::disk('public')->exists($fotoPath)) {
                Storage::disk('public')->delete($fotoPath);
            }
            $fotoPath = $request->file('foto_profil')->store('avatars', 'public');
        }

        $user->update([
            'nama'            => $request->input('nama'),
            'gender'          => $request->input('gender'),
            'prodi'           => $prodi,
            'bidang_diminati' => ['predefined' => array_values($minatList), 'custom' => $customValue],
            'lokasi'          => ['provinsi' => $request->input('provinsi'), 'kota' => $request->input('kota')],
            'foto_profil'     => $fotoPath,
        ]);

        return redirect()->route('profil')->with('success', 'Profil berhasil diperbarui.');
    }
}
