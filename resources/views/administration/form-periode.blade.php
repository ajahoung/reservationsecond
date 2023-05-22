{{ Form::open(['url' => 'config/storeperiode','method' => 'post']) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-12">
            <label class="form-label">Libelle</label>
            {{ Form::text('libelle', old('libelle'), ['class' => 'form-control','id' => 'type', 'placeholder' => '', 'required']) }}
        </div>
    </div>
        <h4>Frequence de repetition</h4>

        <div class="row mt-3">
            <div class="form-group col-md-3">
                <input type="radio" value="3" name="frequence">
                {{-- {{ Form::radio('frequence',old('frequence',3),  ['class' => 'form-control','id' => 'libelle', 'placeholder' => "", 'required']) }}--}}
                <label class="form-label">Chaque Jour</label>
            </div>
            <div class="form-group col-md-3">
                <input  type="radio" value="2" name="frequence">
                {{--{{ Form::radio('frequence',old('frequence',2), ['class' => 'form-control','id' => 'libelle', 'placeholder' => "", 'required']) }}--}}
                <label class="form-label">Chaque Semaine</label>
            </div>
            <div class="form-group col-md-3">
                <input  type="radio" value="1" name="frequence">
                {{--  {{ Form::radio('frequence', old('frequence',1), ['class' => 'form-control','id' => 'libelle', 'placeholder' => "", 'required']) }}--}}
                <label class="form-label">Chaque mois</label>
            </div>
            <div class="form-group col-md-3">
                <input  type="radio" value="4" name="frequence">
                {{-- {{ Form::radio('frequence', old('frequence',4), ['class' => 'form-control','id' => 'libelle', 'placeholder' => "", 'required']) }}--}}
                <label class="form-label">Tous les Weekends</label>
            </div>
            <div class="form-group col-md-3">
                <input  type="radio" value="5" name="frequence">
                {{--  {{ Form::radio('frequence', old('frequence',5), ['class' => 'form-control','id' => 'libelle', 'placeholder' => "", 'required']) }}--}}
                <label class="form-label">Sans periodicité</label>
            </div>


    </div>

</div>
<div class="modal-footer">
    <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Save</button>
    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
</div>
{{ Form::close() }}
