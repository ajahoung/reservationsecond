{{ Form::open(['url' => 'config/storetypeaccessoire','method' => 'post']) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-6">
            <label class="form-label">Libelle</label>
            {{ Form::text('libelle', old('libelle'), ['class' => 'form-control','id' => 'type', 'placeholder' => '', 'required']) }}
        </div>
        <div class="form-group col-md-6">
            <label class="form-label">Quantité</label>
            {{ Form::text('quantite', old('quantite'), ['class' => 'form-control','id' => 'type', 'placeholder' => '', 'required']) }}
        </div>
    </div>

</div>
<div class="modal-footer">
    <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Save</button>
    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
</div>
{{ Form::close() }}
