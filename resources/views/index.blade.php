
@extends('../master')

@section('content')
    <!-- Javascript -->


    @if($todo != null)
    @foreach($todo as $todo)
        <div id="conteneur">
        <div id="nom_liste"><b>{{$todo->name_liste}} ({{$todo->tache_acc}}/{{$todo->tache_tot}})</b></div>
            <div id=desc">
                <b>Description :</b> <br>
                {{$todo->description_liste}}
            </div>

        <!-- Recupérer les tache de chaque liste -->
        <?php

        $log =  Auth::user()->email;
        $task = DB::table('taches')->where('name_user',$log )->where('name_liste',$todo->name_liste)->get();
        $date = date('Y/m/d h:i:s a', time());
            $cant_valide_anymore='false'
        ?>
        @if($task != null)

            @foreach($task as $task)

                <div id="nom_tache"> <li>{{$task->tache}}

                <!-- On regarde si la tâche est validée ou pas -->
                    <?php $cant_valide_anymore='false'?>
                @if($task->etat_tache == 'valide')
                        <img src="http://localhost/img/valider.png" width="15px" height="15px">
                        <br>
                            Date de validation : <?php echo $task->updated_at ?>
                        <?php $cant_valide_anymore='true'?>
                    @endif

                    <!-- On regarde si la date n'est pas expirée -->



                        @if($task->etat_tache != 'valide' && strtotime($task->date) < strtotime($date))

                        <img src="http://localhost/img/error.png" width="15px" height="15px">


                        @else
                            <br>
                            Date critique : <?php echo $task->date ?>

                    @endif



                </div>

                        <!------------------>
                    @if($cant_valide_anymore != 'true')


                            <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal" id="btn_up">
                        Update tache
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel">Modifier une tache</h4>
                                </div>
                                <form method="POST" action="{{ route('editTask',['name_liste'=>$todo->name_liste,'tache'=>$task->tache]) }}">
                                    {!! csrf_field() !!}
                                    <div class="modal-body">
                                        <!-- Formulaire -->



                                        <div>
                                            Tache
                                            <input type="text" name="task" value="<?php echo $task->tache ?>"/>
                                            <input type="date" name="date" value="<?php echo $task->date ?>"/>
                                        </div>


                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                <a href="{{ route('deleteTask',['name_liste'=>$todo->name_liste,'tache'=>$task->tache]) }}" class="mod" >Supprimer</a>

                <a href="{{ route('valideTask',['name_liste'=>$todo->name_liste,'tache'=>$task->tache]) }}"  class="mod">Valider</a>


                @endif



                @endforeach
                @endif

        <!------------------>



        <h1> Ajoutez une nouvelle tache </h1>
        <form method="POST" action="{{ route('addTask',['name_liste'=>$todo->name_liste]) }}">
            {!! csrf_field() !!}

            <div>
                Tache
                <input type="text" name="task"/>
                <input type="date" name="date"/>
            </div>
            @if($erreur == 'yes')
                <font color="red">Vous devez remplir tout les champs!</font>

            @endif

            <div>
                <button type="submit">Ajouter la tache</button>
                <!-- DATE -->


            </div>
        </form>

        <a href="{{ route('deleteListe',['name_liste'=>$todo->name_liste]) }}">Supprimer la liste</a></p>










                    <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal2" id="btn_ls">
                        Update liste
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel">Modifier une liste</h4>
                                </div>
                                <form method="POST" action="{{ route('editList',['name_liste'=>$todo->name_liste]) }}">
                                    {!! csrf_field() !!}
                                    <div class="modal-body">
                                        <!-- Formulaire -->



                                        <div>
                                            Liste :
                                            <input type="text" name="liste" value="<?php echo $todo->name_liste ?>"/> <br>
                                            Description : <br>
                                            <textarea name="description" rows="7" cols="30"><?php echo $todo->description_liste ?></textarea>
                                        </div>


                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>



                    <br>
                    Liste cree le : <?php echo $todo->created_at ?>











        </div>
    @endforeach
    @endif
    <!-- SI pas encore de tache -->
<div id="liste">
    @if(Auth::check())

        <h1> Ajoutez une nouvelle Liste </h1>
        <form method="POST" action="/addListe">
            {!! csrf_field() !!}

            <div>
                Liste
                <input type="text" name="liste"/>
            </div>
            <div>
                Description : <br>
                <textarea id="txtArea" name="description" rows="7" cols="30"></textarea>
            </div>

            <div>
                <button type="submit">Ajouter la Liste</button>
            </div>
        </form>

    @endif


</div>


    @endsection