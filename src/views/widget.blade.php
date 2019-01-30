<div class="card card-default roller_shutter_widget roller_shutter_{{$sensor->id}}">
    <div class="card-header">
        <h5 class="card-title">{{$widget->name}} <a href="{{url('/SSRollerShutter/widget/'.$widget->id)}}"><i class="fa fa-cogs pull-right" aria-hidden="true"></i></a></h5>
    </div>
    <div class="card-body text-center" data-sensor-id="{{$sensor->id}}">
        <h4>{{$config->state->name}}</h4>
        <img class="img-responsive" style="max-height: 100px; margin: 0 auto;" src="{{$config->state->image}}">
        <div class="text-center">
            <div class="btn-group" role="group" aria-label="...">
                <form action="{{url('/SSRollerShutter/open')}}" method="post" class="form_shutter_open">
                    {{csrf_field()}}
                    <input type="hidden" name="sensor" value="{{$sensor->id}}">
                    <input type="hidden" name="widget" value="{{$widget->id}}">
                </form>
                <form action="{{url('/SSRollerShutter/close')}}" method="post" class="form_shutter_close">
                    {{csrf_field()}}
                    <input type="hidden" name="sensor" value="{{$sensor->id}}">
                    <input type="hidden" name="widget" value="{{$widget->id}}">
                </form>
                <form action="{{url('/SSRollerShutter/stop')}}" method="post" class="form_shutter_stop">
                    {{csrf_field()}}
                    <input type="hidden" name="sensor" value="{{$sensor->id}}">
                    <input type="hidden" name="widget" value="{{$widget->id}}">
                </form>
                <button type="button" class="btn btn-sm btn-danger" data-form-type="form_shutter_close"><i class="fa fa-arrow-down"></i> Fermer</button>
                <button type="button" class="btn btn-sm btn-warning" data-form-type="form_shutter_stop"><i class="fa fa-pause"></i> Stop</button>
                <button type="button" class="btn btn-sm btn-success" data-form-type="form_shutter_open">Ouvrir <i class="fa fa-arrow-up"></i></button>
            </div>
        </div>
        <hr>
    </div>
</div>
