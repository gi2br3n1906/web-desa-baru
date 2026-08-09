<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Umkm;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UmkmSyncController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        abort_unless($request->user()?->role === 'admin', 403);

        $validated = $request->validate([
            'items' => ['required', 'array', 'min:1', 'max:100'],
            'items.*.id' => ['required', 'string', 'max:100', 'distinct'],
            'items.*.nama_usaha' => ['required', 'string', 'max:255'],
            'items.*.pemilik' => ['required', 'string', 'max:255'],
            'items.*.dukuh' => ['required', 'string', 'max:255'],
            'items.*.alamat_lengkap' => ['required', 'string', 'max:2000'],
            'items.*.bentuk_usaha' => ['required', 'string', 'max:100'],
            'items.*.jenis_usaha' => ['required', 'string', 'max:255'],
            'items.*.no_hp' => ['nullable', 'string', 'max:25'],
            'items.*.created_at_offline' => ['nullable', 'date'],
            'items.*.status_sync' => ['nullable', 'boolean'],
        ]);

        $syncedIds = DB::transaction(function () use ($validated): array {
            $ids = [];

            foreach ($validated['items'] as $item) {
                Umkm::query()->updateOrCreate(
                    ['offline_sync_id' => $item['id']],
                    [
                        'nama_umkm' => $item['nama_usaha'],
                        'pemilik' => $item['pemilik'],
                        'kategori' => $item['jenis_usaha'],
                        'dusun' => $item['dukuh'],
                        'rt_rw' => '-',
                        'alamat_lengkap' => $item['alamat_lengkap'],
                        'bentuk_usaha' => $item['bentuk_usaha'],
                        'no_hp' => $item['no_hp'] ?? null,
                        'deskripsi' => 'Bentuk usaha: '.$item['bentuk_usaha'].'. Data disinkronkan dari antrean offline.',
                        'latitude' => null,
                        'longitude' => null,
                        'foto' => null,
                    ],
                );

                $ids[] = $item['id'];
            }

            return $ids;
        });

        return response()->json([
            'success' => true,
            'synced_count' => count($syncedIds),
            'synced_ids' => $syncedIds,
        ]);
    }
}