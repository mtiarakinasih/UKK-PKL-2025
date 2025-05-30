<?php

namespace App\Http\Controllers;

use App\Models\Industri;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Log;

class IndustriController extends Controller
{
    public function index(Request $request)
    {
        Log::info('Industri index method called');
        
        $search = $request->input('search');
        
        $query = Industri::query();
        
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('bidang_usaha', 'like', "%{$search}%")
                  ->orWhere('alamat', 'like', "%{$search}%");
            });
        }
        
        $industries = $query->orderBy('nama')
                           ->paginate(9)
                           ->withQueryString();
        
        return Inertia::render('Siswa/Industri', [
            'industries' => $industries,
            'filters' => [
                'search' => $search ?? ''
            ]
        ]);
    }
    
    public function show($id)
    {
        $industri = Industri::findOrFail($id);
        
        return Inertia::render('Siswa/IndustriDetail', [
            'industri' => $industri
        ]);
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'bidang_usaha' => 'required|string|max:255',
            'alamat' => 'required|string',
            'kontak' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|string|max:255',
        ]);
        
        Industri::create($validated);
        
        return redirect()->route('siswa.industri')->with('message', 'Industri berhasil ditambahkan');
    }
    
    public function getIndustries(Request $request)
    {
        $search = $request->input('search', '');
        
        return Industri::where('nama', 'like', "%{$search}%")
                      ->orWhere('bidang_usaha', 'like', "%{$search}%")
                      ->orderBy('nama')
                      ->limit(10)
                      ->get(['id', 'nama', 'bidang_usaha']);
    }
}