@push('scripts')

@endpush

<x-app-layout :assets="$assets ?? []">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Edit local: {{$local->libelle}}</h4>
                    </div>
                </div>
                {{ Form::open(['url' => 'local/'.$local->id.'/edit','method' => 'post']) }}
                <div class="card-body px-3">

                    <div class="row">
                        <div class="form-group col-md-12">
                            <label class="form-label">Libelle</label>
                            {{ Form::text('libelle', old('libelle',$local->libelle), ['class' => 'form-control','id' => 'libelle', 'placeholder' => $local->libelle, 'required']) }}
                        </div>
                        <div class="form-group col-md-12">
                            <label class="form-label">Groupes locaux</label>
                            <select name="group_locals[]" multiple class="form-select">
                                @foreach($values as $type)
                                    <option data-aos="{{json_encode($local->group_locals->toArray())}}" value="{{$type->id}}" {{in_array($type->id,$local->group_locals->toArray())?'selected':''}}>
                                        {{$type->libelle}}</option>
                                @endforeach
                            </select>
                            {{--{{ Form::select('group_local', $values,null, ['multiple'=>'multiple','name'=>'group_locals[]','class' => 'form-select','id' => 'lastname', 'required']) }}--}}
                        </div>
                    </div>
                    <div class="row">
                     </div>

                </div>
                <div class="card-footer">
                    <button type="submit" class="col-md-2 btn btn-primary" data-bs-dismiss="modal">Save</button>
                    <a href="{{route('config.indexlocal')}}" type="button" class="col-md-2 btn btn-danger" >Cancel</a>

                </div>{{ Form::close() }}
            </div>
        </div>

    </div>

</x-app-layout>
