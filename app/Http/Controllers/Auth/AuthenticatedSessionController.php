<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('welcome');
    }

    public function store(Request $request): RedirectResponse
    {
        $role = $request->input('role');
        $input = $request->input('email');
        $password = $request->input('password');

        $request->validate([
            'role' => ['required', 'in:admin,dosen,mahasiswa'],
            'password' => ['required', 'string'],
        ]);

        switch ($role) {
            case 'admin':
                $request->validate([
                    'email' => ['required', 'email'],
                ], [
                    'email.required' => 'Email admin wajib diisi.',
                    'email.email' => 'Format email admin tidak valid.',
                ]);
                $field = 'email';
                break;

            case 'mahasiswa':
                $request->validate([
                    'email' => ['required', 'regex:/^\d{8,15}$/'],
                ], [
                    'email.required' => 'NIM mahasiswa wajib diisi.',
                    'email.regex' => 'NIM harus berupa angka dengan panjang 8 sampai 15 digit.',
                ]);
                $field = 'NIM';
                break;

            case 'dosen':
                if (filter_var($input, FILTER_VALIDATE_EMAIL)) {
                    $field = 'email';
                    $request->validate([
                        'email' => ['required', 'email'],
                    ], [
                        'email.required' => 'Email dosen wajib diisi.',
                        'email.email' => 'Format email dosen tidak valid.',
                    ]);
                } else {
                    $request->validate([
                        'email' => ['required', 'regex:/^\d{10}$/'],
                    ], [
                        'email.required' => 'NIDN dosen wajib diisi.',
                        'email.regex' => 'NIDN harus berupa 10 digit angka.',
                    ]);
                    $field = 'NIDN';
                }
                break;

            default:
                return back()->withErrors(['role' => 'Role tidak valid'])->withInput();
        }

        $user = User::where($field, $input)
            ->where('role', $role)
            ->first();

        if (!$user || !Hash::check($password, $user->password)) {
            return back()->withErrors([
                'email' => 'Kredensial yang diberikan tidak cocok dengan data kami.',
            ])->withInput();
        }

        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();
        $request->session()->flash('show_mobile_warning', true);
        logger('Login berhasil', ['user' => $user]);

        return match ($user->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'dosen' => redirect()->route('dosen.dashboard'),
            'mahasiswa' => redirect()->route('mahasiswa.dashboard'),
            default => redirect('/'),
        };
    }


    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
