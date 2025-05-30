<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use App\Models\PKL;
use App\Models\Industri;
use App\Models\Siswa;
use App\Models\Guru;
use Illuminate\Support\Facades\Auth;

class PklController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $user = Auth::user();
        $hasExistingPkl = false;
        
        if ($user->role === 'siswa') {
            $siswa = $this->getSiswaByEmail($user->email);
            if ($siswa) {
                $hasExistingPkl = PKL::where('siswa_id', $siswa->id)->exists();
            }
        }

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
                'guru' => $pkl->guru ? $pkl->guru->nama : null,
            ];
        });

        $industries = Industri::select('id', 'nama', 'bidang_usaha')
                         ->orderBy('nama')
                         ->get();
                         
        $gurus = Guru::select('id', 'nama')
                 ->orderBy('nama')
                 ->get();

        return Inertia::render('Siswa/Dashboard', [
            'pkls' => $pkls,
            'industries' => $industries,
            'gurus' => $gurus,
            'hasExistingPkl' => $hasExistingPkl,
            'filters' => [
                'search' => $search,
            ],
        ]);
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'industri_id' => 'required|exists:industris,id',
            'guru_id' => 'required|exists:gurus,id',
            'mulai' => 'required|date',
            'selesai' => 'required|date|after_or_equal:mulai',
        ]);
        
        $user = Auth::user();
        
        $siswa = Siswa::where('email', $user->email)->first();
        
        if (!$siswa) {
            $temporaryNis = 'TMP' . $user->id . time();
            
            $siswa = Siswa::create([
                'nama' => $user->name,
                'email' => $user->email,
                'nis' => $temporaryNis,
                'gender' => 'L',
                'alamat' => '-',
                'kontak' => '-'
            ]);
        }
        
        $existingPkl = PKL::where('siswa_id', $siswa->id)->first();
        if ($existingPkl) {
            return back()->withErrors(['message' => 'Kamu sudah memiliki data PKL']);
        }
        
        PKL::create([
            'siswa_id' => $siswa->id,
            'industri_id' => $validated['industri_id'],
            'guru_id' => $validated['guru_id'],
            'mulai' => $validated['mulai'],
            'selesai' => $validated['selesai'],
        ]);
        
        return redirect()->route('siswa.dashboard')->with('message', 'Data PKL berhasil ditambahkan');
    }
    
    private function getSiswaByEmail($email)
    {
        return Siswa::where('email', $email)->first();
    }
}