{{ Form::open(['url' => 'config/storejourferie','method' => 'post','app_title'=>"jour ferie"]) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-12">
            <label class="form-label">Libelle</label>
            {{ Form::text('libelle', old('libelle'), ['class' => 'form-control','id' => 'libelle', 'placeholder' => '', 'required']) }}
        </div>
        <div class="form-group col-md-12">
            <label class="form-label">Date debut</label>
            {{ Form::Date('datedebut', old('datedebut'), ['class' => 'form-control','id' => 'datejour', 'placeholder' => '', 'required']) }}
        </div>
        <div class="form-group col-md-12">
            <label class="form-label">Date fin</label>
            {{ Form::Date('datefin', old('datefin'), ['class' => 'form-control','id' => 'datefin', 'placeholder' => '', 'required']) }}
        </div>
        <div class="form-group col-md-12">
            {{ Form::checkbox('Active', old('Active'), ['class' => 'form-control','id' => 'Active', 'placeholder' => '', 'required']) }}
            <label class="form-label">Active</label></div>
    </div>

</div>
<div class="modal-footer">
    <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Save</button>
    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
</div>
{{ Form::close() }}
