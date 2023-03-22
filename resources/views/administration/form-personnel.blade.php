{{ Form::open(['url' => 'personnels/store','method' => 'post']) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-6">
            <label class="form-label">First name</label>
            {{ Form::text('first_name', old('first_name'), ['class' => 'form-control','id' => 'firstname', 'placeholder' => '', 'required']) }}
        </div>
        <div class="form-group col-md-6">
            <label class="form-label">Last name</label>
            {{ Form::text('last_name', old('last_name'), ['class' => 'form-control','id' => 'lastname', 'placeholder' => '', 'required']) }}
        </div>
        <div class="form-group col-md-6">
            <label class="form-label">Email</label>
            {{ Form::text('email', old('email'), ['class' => 'form-control','id' => 'email', 'placeholder' => '', 'required']) }}
        </div>
        <div class="form-group col-md-6">
            <label class="form-label">Phone</label>
            {{ Form::text('phone_number', old('phone_number'), ['class' => 'form-control','id' => 'phone_number', 'placeholder' => '', 'required']) }}
        </div>
        <div class="form-group col-md-6">
            <label class="form-label">Adresse</label>
            {{ Form::text('address', old('address'), ['class' => 'form-control','id' => 'address', 'placeholder' => '', 'required']) }}
        </div>
        <div class="form-group col-md-6">
            <label class="form-label">Roles</label>
            {{ Form::select('user_type', array('admin'=>"ROLE_ADMIN",'super_admin'=>"ROLE_SUPERADMIN"),'ROLE_MANAGER', ['class' => 'form-select','id' => 'lastname', 'required']) }}
        </div>
    </div>

</div>
<div class="modal-footer">
    <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Save</button>
    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
</div>
{{ Form::close() }}
