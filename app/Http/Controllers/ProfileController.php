<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException; // Import Guzzle's RequestException

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Fetch program studi (prodi) from PDDIKTI API with static backup.
     */
    public function getProdi(Request $request)
    {
        $keyword = strtolower($request->input('keyword'));

        // Daftar prodi statis UICI sebagai backup
        $staticProdiList = [
            'Informatika',
            'Teknik Industri',
            'Bisnis Digital',
            'Sains Data',
            'Digital Neuropsikologi',
            'Komunikasi Digital',
            'Teknologi Industri Pertanian',
        ];

        // Guzzle client
        $client = new Client();
        $url = "https://api-pddikti.ridwaanhall.com/search/prodi/" . urlencode($keyword);

        try {
            // Coba ambil data dari API
            $response = $client->request('GET', $url);
            $data = json_decode($response->getBody()->getContents(), true);

            // Filter data hanya untuk kampus UICI
            $filteredData = array_filter($data, function ($prodi) {
                return $prodi['pt_singkat'] === 'UICI' || $prodi['pt'] === 'UNIVERSITAS INSAN CITA INDONESIA';
            });

            // Ubah format data menjadi array of string
            $result = array_map(function ($prodi) {
                return $prodi['nama'] . ' (' . $prodi['jenjang'] . ')';
            }, $filteredData);

            // Jika API tidak mengembalikan hasil, gunakan daftar statis
            if (empty($result)) {
                $result = array_values(array_filter($staticProdiList, function ($prodi) use ($keyword) {
                    return strpos(strtolower($prodi), $keyword) !== false;
                }));
            }

            return response()->json($result);

        } catch (RequestException $e) {
            // Jika request ke API gagal, gunakan daftar statis
            $filteredList = array_values(array_filter($staticProdiList, function ($prodi) use ($keyword) {
                return strpos(strtolower($prodi), $keyword) !== false;
            }));

            return response()->json($filteredList);
        }
    }

    /**
     * Fetch bidang keahlian from a static list or a different API.
     */
    public function getBidangKeahlian(Request $request)
    {
        $keyword = strtolower($request->input('keyword'));

        // Contoh daftar bidang keahlian statis
        $bidangKeahlianList = [
            'Teknik Informatika',
            'Sistem Informasi',
            'Desain Komunikasi Visual',
            'Manajemen',
            'Akuntansi',
            'Hukum',
            'Psikologi',
            'Kedokteran',
            'Ilmu Komputer'
        ];

        // Filter daftar berdasarkan keyword
        $filteredList = array_filter($bidangKeahlianList, function ($bidang) use ($keyword) {
            return strpos(strtolower($bidang), $keyword) !== false;
        });

        return response()->json(array_values($filteredList));
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'no_hp' => 'nullable|string|max:20',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ];

        if ($user->role === 'mahasiswa') {
            $rules['NIM'] = 'required|string|max:50|unique:users,NIM,' . $user->id;
            $rules['prodi'] = 'required|string|max:100';
        } elseif ($user->role === 'dosen') {
            $rules['NIDN'] = 'required|string|max:50|unique:users,NIDN,' . $user->id;
            $rules['bidang_keahlian'] = 'required|string|max:100';
        }

        $messages = [
            'NIM.required' => 'NIM wajib diisi.',
            'NIM.unique' => 'NIM sudah digunakan.',
            'NIDN.required' => 'NIDN wajib diisi.',
            'NIDN.unique' => 'NIDN sudah digunakan.',
        ];

        $validated = $request->validate($rules, $messages);

        // Upload foto
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto')->store('profile_pictures', 'public');
            $validated['foto'] = $foto;
        }

        $user->update($validated);

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
