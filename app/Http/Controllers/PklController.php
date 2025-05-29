<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use App\Models\Pkl;


class PklController extends Controller
{
    public function index(Request $request)
{
    $search = $request->input('search');

    $query = Pkl::with(['siswa', 'industri', 'guru']);

    if ($search) {
        $query->where(function ($q) use ($search) {
            $q->whereHas('siswa', function ($q2) use ($search) {
                $q2->where('nama', 'like', '%' . $search . '%');
            })->orWhereHas('industri', function ($q2) use ($search) {
                $q2->where('nama', 'like', '%' . $search . '%');
            });
        });
    }

    $pkls = $query->paginate(10)->withQueryString()->through(function ($pkl) {
        return [
            'id' => $pkl->id,
            'nama' => $pkl->siswa->nama,
            'industri' => $pkl->industri->nama,
            'mulai' => $pkl->mulai,
            'selesai' => $pkl->selesai,
            'guru' => $pkl->guru->nama,
        ];
    });

    return Inertia::render('Siswa/Dashboard', [
        'pkls' => $pkls,
        'filters' => [
            'search' => $search,
        ],
    ]);
}
}