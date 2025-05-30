<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Siswa;
use App\Models\Guru;
use App\Models\Industri;
use App\Models\PKL;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class GuruController extends Controller
{
    public function dashboard(Request $request)
    {
        $user = Auth::user();
        $guru = Guru::where('email', $user->email)->first();

        $allStudents = Siswa::select('id', 'nama', 'nis')->get();

        $pklData = PKL::join('siswas', 'pkls.siswa_id', '=', 'siswas.id')
            ->join('industris', 'pkls.industri_id', '=', 'industris.id')
            ->select(
                'pkls.id as pkl_id',
                'siswas.id as siswa_id',
                'siswas.nama',
                'siswas.nis',
                'industris.nama as industri',
                'industris.bidang_usaha',
                'industris.alamat',
                'industris.kontak',
                'industris.website',
                'pkls.mulai',
                'pkls.selesai'
            )
            ->get();

        $pklByStudentId = [];
        foreach ($pklData as $pkl) {
            $pklByStudentId[$pkl->siswa_id] = [
                'industri' => $pkl->industri,
                'mulai' => $pkl->mulai,
                'selesai' => $pkl->selesai,
                'industri_detail' => [
                    'bidang_usaha' => $pkl->bidang_usaha ?? '-',
                    'alamat' => $pkl->alamat ?? '-',
                    'kontak' => $pkl->kontak ?? '-',
                    'website' => $pkl->website ?? '-',
                ]
            ];
        }

        $students = [];
        foreach ($allStudents as $student) {
            $hasPkl = isset($pklByStudentId[$student->id]);

            $students[] = [
                'id' => $student->id,
                'nama' => $student->nama,
                'nis' => $student->nis,
                'status_pkl' => $hasPkl,
                'pkl' => $hasPkl ? $pklByStudentId[$student->id] : null
            ];
        }

        $today = Carbon::now()->format('Y-m-d');
        $active = DB::select("SELECT COUNT(*) as count FROM pkls WHERE mulai <= ? AND selesai >= ?", [$today, $today]);
        $activePklCount = $active[0]->count;
        
        if ($activePklCount == 0 && count($pklData) > 0) {
            $activePklCount = count($pklData);
        }
        
        $stats = [
            'totalStudents' => $allStudents->count(),
            'totalIndustries' => Industri::count(),
            'activePkl' => $activePklCount
        ];

        return Inertia::render('Guru/Dashboard', [
            'students' => $students,
            'stats' => $stats,
            'debug' => [
                'today' => $today,
                'pkls' => $pklData->map(function($item) {
                    return [
                        'mulai' => $item->mulai,
                        'selesai' => $item->selesai
                    ];
                })
            ]
        ]);
    }
}