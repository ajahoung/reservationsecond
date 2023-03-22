{{ Form::open(['url' => 'config/storetypesalle','method' => 'post']) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-12">
            <label class="form-label">Type</label>
            {{ Form::text('type', old('type'), ['class' => 'form-control','id' => 'type', 'placeholder' => '', 'required']) }}
        </div>
    </div>

</div>
<div class="modal-footer">
    <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Save</button>
    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
</div>
{{ Form::close() }}
