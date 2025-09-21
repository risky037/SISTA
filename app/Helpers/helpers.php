<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use App\Models\Notification;

if (!function_exists('getCachedNotifications')) {
    /**
     * Mengambil dan meng-cache notifikasi untuk pengguna yang sedang login.
     *
     * @return array
     */
    function getCachedNotifications()
    {
        $user = Auth::user();

        if (!$user)
            return [];

        $notifications = [];

        $notifications = Cache::rememberForever('static_notifications_' . $user->id, function () use ($user) {
            $static = [];

            if (Hash::check('UICImantap2025', $user->password)) {
                $static[] = [
                    'id' => 'static-password',
                    'type' => 'warning',
                    'title' => 'Ubah Password Anda',
                    'message' => 'Anda masih menggunakan password default. Silahkan Ubah Password Anda.',
                    'link' => route('profile.edit') . '#change-password-first',
                    'is_read' => true,
                ];
            }

            if ($user->role === 'mahasiswa') {
                if (!$user->NIM || !$user->prodi) {
                    $static[] = [
                        'id' => 'static-profil-mahasiswa',
                        'type' => 'info',
                        'title' => 'Lengkapi Profil',
                        'message' => 'Lengkapi data profil Anda seperti NIM dan Program Studi.',
                        'link' => route('profile.edit'),
                        'is_read' => true,
                    ];
                }
            } elseif ($user->role === 'dosen') {
                if (!$user->NIDN || !$user->bidang_keahlian) {
                    $static[] = [
                        'id' => 'static-profil-dosen',
                        'type' => 'info',
                        'title' => 'Lengkapi Profil',
                        'message' => 'Lengkapi data profil Anda seperti NIDN dan Bidang Keahlian.',
                        'link' => route('profile.edit'),
                        'is_read' => true,
                    ];
                }
            } elseif ($user->role === 'admin') {
                if (!$user->no_hp) {
                    $static[] = [
                        'id' => 'static-profil-admin',
                        'type' => 'info',
                        'title' => 'Lengkapi Nomor Telepon',
                        'message' => 'Lengkapi Nomor Telepon anda sebagai admin!',
                        'link' => route('profile.edit'),
                        'is_read' => true,
                    ];
                }
            }

            return $static;
        });

        $notifikasiDB = Notification::where('user_id', $user->id)
            ->latest()
            ->take(10)
            ->get()
            ->map(function ($notif) {
                return [
                    'id' => $notif->id,
                    'title' => $notif->title,
                    'message' => $notif->message,
                    'link' => $notif->link ?? '#',
                    'type' => $notif->type ?? 'info',
                    'is_read' => $notif->is_read,
                ];
            })
            ->toArray();

        return array_merge($notifications, $notifikasiDB);
    }

    /**
     * Menghitung jumlah notifikasi belum dibaca untuk pengguna yang sedang login.
     *
     * @return int
     */
    function getUnreadNotificationCount()
    {
        $user = Auth::user();

        if (!$user)
            return 0;

        return Notification::where('user_id', $user->id)
            ->where('is_read', false)
            ->count();
    }

}