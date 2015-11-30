
@extends('../master')

@section('content')
    @if($todo != null)
    @foreach($todo as $todo)
        <li><b>{{$todo->name_liste}} ({{$todo->tache_acc}}/{{$todo->tache_tot}})</b></li>

        <!-- Recupérer les tache de chaque liste -->
        <?php
        $log =  Auth::user()->email;
        $task = DB::table('taches')->where('name_user',$log )->where('name_liste',$todo->name_liste)->get();
        ?>
        @if($task != null)
            @foreach($task as $task)
                <li> {{$task->tache}}</li>
                <a href="{{ route('deleteTask',['name_liste'=>$todo->name_liste,'tache'=>$task->tache]) }}">Supprimer la tache</a></p>
                @endforeach
                @endif

        <!------------------>
        <h1> Ajoutez une nouvelle tache </h1>
        <form method="POST" action="{{ route('addTask',['name_liste'=>$todo->name_liste]) }}">
            {!! csrf_field() !!}

            <div>
                Tache
                <input type="text" name="task"/>
            </div>


            <div>
                <button type="submit">Ajouter la tache</button>
            </div>
        </form>
        <a href="{{ route('deleteListe',['name_liste'=>$todo->name_liste]) }}">Supprimer la liste</a></p>

    @endforeach
    @endif
    <!-- SI pas encore de tache -->

    @if(Auth::check())

        <h1> Ajoutez une nouvelle Liste </h1>
        <form method="POST" action="/addListe">
            {!! csrf_field() !!}

            <div>
                Tache
                <input type="text" name="liste"/>
            </div>


            <div>
                <button type="submit">Ajouter la Liste</button>
            </div>
        </form>

    @endif





    @endsection