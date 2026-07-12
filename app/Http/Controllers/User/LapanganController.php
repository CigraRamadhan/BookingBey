<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Lapangan;
use Illuminate\Http\Request;

class LapanganController extends Controller
{
    public function index(Request $request)
    {
        $query = Lapangan::query();

        if ($request->filled('search')) {
            $keyword = $request->search;

            $query->where(function ($q) use ($keyword) {
                $q->where('nama_lapangan', 'like', "%{$keyword}%")
                    ->orWhere('lokasi', 'like', "%{$keyword}%")
                    ->orWhere('jenis', 'like', "%{$keyword}%");
            });
        }

        $lapangans = $query->latest()->get();

        return view('user.lapangan.index', compact('lapangans'));
    }

    public function show($id)
    {
        $lapangan = Lapangan::findOrFail($id);
        return view('user.lapangan.show', compact('lapangan'));
    }
}