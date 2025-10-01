<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ormawa;

class DashboardController extends Controller
{
    // public function index() {
    //     return view('dashboard.index');
    // }

    public function beranda() {
        $ormawa = Ormawa::all(); 
        return view('beranda.index', compact('ormawa'));
    }
}
