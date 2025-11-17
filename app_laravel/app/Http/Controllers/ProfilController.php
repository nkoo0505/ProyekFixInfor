<?php

namespace App\Http\Controllers;
use App\Models\Profil;
use Illuminate\Http\Request;

class ProfilController extends Controller
{

    public function create()
    {
        return view('ormawa.create');
    }
               

    public function show(Profil $profil)
    {
        return view('profil.show', compact('profil'));
    }
          
}


