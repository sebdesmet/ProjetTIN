<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Liste;
use App\User;
use App\Tache;
use Faker\Provider\zh_TW\DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;


//use Illuminate\Http\Request;

class TODOController extends Controller{


    /**
     * @return $this
     */


    public function about()
    {
        return view('about');
    }

    protected $erreur = null;
    public function index(){



        if(Auth::check())
        {
            $log = Auth::user()->email;
            $todo = DB::table('listes')->where('name_user',$log )->get();

        }
        else{
            $todo = null;
        }
        //return view('index')->with('todo',$todo);

        return view('index', ['todo' => $todo , 'erreur' => $this->erreur]);
    }

    public function addListe(Request $req)
    {
        $param = $req::all();
        if($param['liste'] != "") {
            $tache = new \App\Liste();
            $tache->name_user = Auth::user()->email;
            $tache->name_liste = $param['liste'];
            $tache->description_liste = $param['description'];
            $tache->tache_acc = 0;
            $tache->tache_tot = 0;
            $tache->save();
            return redirect()->route('index');
        }
        else{
            return redirect()->route('index');
        }

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
        if($param['task'] != "" && strtotime($param['date']) != 0){

            $tache = new \App\Tache();
            $tache->name_user = Auth::user()->email;
            $tache->name_liste = $name_liste;
            $tache->etat_tache = "No";
            $tache->tache = $param['task'];
            $tache->date = $param['date'];
            $tache->save();
            // Update nombre de tâche de Liste
            $log = Auth::user()->email;
            $liste = new \App\Liste();
            $liste = Liste::where('name_liste', $name_liste)->where('name_user',$log)->first();
            $liste->tache_tot=($liste->tache_tot)+1;
            $liste->save();
            return redirect()->route('index');

        }

        else{


            //
            //$this->fail = 'erreur';
            //echo $this->fail ;
            if(Auth::check())
            {
                $log = Auth::user()->email;
                $todo = DB::table('listes')->where('name_user',$log )->get();

            }
            else{
                $todo = null;
            }
            $this->erreur="yes";
            return view('index', ['todo' => $todo , 'erreur' => $this->erreur]);
        }


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



    public function validetask($name_liste,$tache)
    {
        $log = Auth::user()->email;
        $table = new \App\Tache();
        $table = Tache::where('name_liste', $name_liste)->where('name_user',$log)->where('tache',$tache)->first();
        $table->etat_tache='valide';
        $table->save();
        $liste = new \App\Liste();
        $liste = Liste::where('name_liste', $name_liste)->where('name_user',$log)->first();
        $liste->tache_acc=($liste->tache_acc)+1;
        $liste->save();
        return redirect()->route('index');
    }

    public function editTask(Request $req,$name_liste,$tache)
    {


        $param = $req::all();

        if($param['task'] != "" && strtotime($param['date']) != 0){


            $log = Auth::user()->email;
            $liste = Tache::where('name_user',$log )->where('name_liste',$name_liste)->where('tache',$tache)->first();
            var_dump($liste);
            $liste->tache = $param['task'];
            $liste->date = $param['date'];
            $liste->save();

            return redirect()->route('index');
        }

        else{


            //
            //$this->fail = 'erreur';
            //echo $this->fail ;
            return redirect()->route('index');
        }


    }


    public function editList(Request $req,$name_liste)
    {


        $param = $req::all();

        if($param['liste'] != ""){


            $log = Auth::user()->email;
            $liste = Liste::where('name_user',$log )->where('name_liste',$name_liste)->first();
            $liste->name_liste = $param['liste'];
            $liste->description_liste = $param['description'];
            $liste->save();

            return redirect()->route('index');
        }

        else{


            return redirect()->route('index');
        }



    }

}