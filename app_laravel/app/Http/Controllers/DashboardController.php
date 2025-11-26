<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ormawa;
use App\Models\Kegiatan;

class DashboardController extends Controller
{
    // public function index() {
    //     return view('dashboard.index');
    // }

    public function beranda() {
       $ormawa = Ormawa::all();

        // 🔹 Ambil kegiatan terbaru (misalnya 10 terakhir berdasarkan tanggal mulai)
        $kegiatan = Kegiatan::orderBy('tanggal_mulai', 'desc')->take(10)->get();

        // 🔹 Kirim keduanya ke view
        return view('beranda.index', compact('ormawa', 'kegiatan'));
    }
}
