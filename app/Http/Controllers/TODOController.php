<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Liste;
use App\User;
use App\Tache;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

//use Illuminate\Http\Request;

class TODOController extends Controller{


    /**
     * @return $this
     */
    public function index(){


        //$todo = Todo::all();
        //$todo = $todo->fetch();
        if(Auth::check())
        {
            $log = Auth::user()->email;
            $todo = DB::table('listes')->where('name_user',$log )->get();

        }
        else{
            $todo = null;
        }


        return view('index')->with('todo',$todo);
    }

    public function addListe(Request $req)
    {
        $param = $req::all();

        $tache = new \App\Liste();
        $tache->name_user = Auth::user()->email;
        $tache->name_liste = $param['liste'];
        $tache->description_liste = "Lol";
        $tache->tache_acc = 0;
        $tache->tache_tot = 0;
        $tache->save();
        return redirect()->route('index');
    }

    public function deleteListe($name_liste)
    {
        $log = Auth::user()->email;
        $liste = DB::table('listes')->where('name_user',$log )->where('name_liste',$name_liste)->delete();
        $liste = DB::table('taches')->where('name_user',$log )->where('name_liste',$name_liste)->delete();
        return redirect()->route('index');
    }

    public function addTask(Request $req,$name_liste)
    {
        $param = $req::all();
        $tache = new \App\Tache();
        $tache->name_user = Auth::user()->email;
        $tache->name_liste = $name_liste;
        $tache->etat_tache = "No";
        $tache->tache = $param['task'];
        $tache->date = date('Y-m-d H:i:s');
        $tache->save();
        // Update nombre de tâche de Liste
        $log = Auth::user()->email;
        $liste = new \App\Liste();
        $liste = Liste::where('name_liste', $name_liste)->where('name_user',$log)->first();
        $liste->tache_tot=($liste->tache_tot)+1;
        $liste->save();


        return redirect()->route('index');

    }


    public function deletetask($name_liste,$tache)
    {
        $log = Auth::user()->email;
        $liste = DB::table('taches')->where('name_user',$log )->where('name_liste',$name_liste)->where('tache',$tache)->delete();
        $liste = new \App\Liste();
        $liste = Liste::where('name_liste', $name_liste)->where('name_user',$log)->first();
        $liste->tache_tot=($liste->tache_tot)-1;
        $liste->save();

        return redirect()->route('index');
    }





}