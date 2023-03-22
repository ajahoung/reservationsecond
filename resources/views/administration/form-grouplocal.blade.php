{{ Form::open(['url' => 'config/storegrouplocal','method' => 'post']) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-6">
            <label class="form-label">Libelle</label>
            {{ Form::text('libelle', old('libelle'), ['class' => 'form-control','id' => 'firstname', 'placeholder' => '', 'required']) }}
        </div>
        <div class="form-group col-md-6">
            <label class="form-label">Horaire de reservation</label>
            {{ Form::select('horaire_reservation', array('08h25-15h45'=>'08h25-15h45','16h00-22h30'=>"16h00-22h30"),'08h25-15h45', ['class' => 'form-select','id' => 'lastname', 'required']) }}
        </div>
        <div class="form-group col-md-6">
            <label class="form-label">Type de Jour</label>
            {{ Form::select('type_jour', ["1"=>"Jours scolaires",
                                    "2"=>"Jours feriés",
                                    "3"=>"Weekends",
                                    "4"=>"Congés"],"Selectionnez un type de jour", ['class' => 'form-select','id' => 'lastname', 'required']) }}
        </div>

        <div class="form-group col-md-6">
            <label class="form-label">Type de salle</label>
            {{ Form::select('type_salle', $salles,null, ['class' => 'form-select','id' => 'lastname', 'required']) }}
        </div>
    </div>

</div>
<div class="modal-footer">
    <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Save</button>
    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
</div>
{{ Form::close() }}
