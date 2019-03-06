@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <h1>SSRollerShutter configuration
                    <small>{{$widget->name}}</small>
                </h1>
                <hr>
            </div>
        </div>
        <div class="row d-flex justify-content-around">
            <div class="col-3">
                <div class="card-container">
                    <div class="card-icon card-power"><i class="fa fa-4x fa-bolt text-center"></i></div>
                    <div class="card-title text-center">
                        <button class="btn btn-success">Courant</button>
                    </div>
                    <div class="card-figures row">
                        <div class="col-md-12">
                            <span class="figures text-center">{{$last_current}}</span>
                            <span class="figures-label text-center">Watts</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="card-container">
                    <div class="card-icon card-blue"><i class="fa fa-4x fa-thermometer-half text-center"></i></div>
                    <div class="card-title text-center">
                        <button class="btn btn-success">Température</button>
                    </div>
                    <div class="card-figures row">
                        <div class="col-md-12">
                            <span class="figures text-center">{{$last_temp}}</span>
                            <span class="figures-label text-center">°C</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <hr>
            </div>
            <div class="col-auto">
                <a class="btn btn-primary btn-lg" href="{{url('/SSRollerShutter/calibrate/'.$sensor->id)}}">Lancer le
                    calibrage</a>
            </div>
            <div class="col">
                <div class="card">
                    <h4 class="card-header">Ajouter une action</h4>
                    <div class="card-body">
                        <form method="post" action="{{url('SSRollerShutter/addCommande/'.$sensor->id)}}">
                            {{csrf_field()}}
                            <div class="form-group row">
                                <label for="nom" class="col-sm-4 col-form-label">Nom de la commande</label>
                                <div class="col-sm-8">
                                    <input type="text" name="nom" class="form-control" id="nom"
                                           placeholder="Fermer volet chambre">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="commande" class="col-sm-4 col-form-label">Commande</label>
                                <div class="col-sm-8">
                                    <select class="form-control" id="commande" name="commande">
                                        <option value="29">Ouvrir le volet</option>
                                        <option value="30">Fermer le volet</option>
                                    </select>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Créer la commande</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
