<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Industri;
use Illuminate\Http\Request;
use Inertia\Inertia;

class WelcomeController extends Controller
{
    public function index()
    {
        return Inertia::render('Welcome', [
            'stats' => [
                'totalStudents' => Siswa::count(),
                'totalIndustries' => Industri::count(),
                'satisfactionRate' => 97 
            ]
        ]);
    }
}