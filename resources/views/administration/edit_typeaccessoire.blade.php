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
                {{ Form::open(['url' => 'typeaccessoire/'.$local->id.'/edit','method' => 'post']) }}
                <div class="card-body px-3">

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label class="form-label">Libelle</label>
                            {{ Form::text('libelle', old('libelle',$local->libelle), ['class' => 'form-control','id' => 'libelle', 'placeholder' => $local->libelle, 'required']) }}
                        </div>
                        <div class="form-group col-md-6">
                            <label class="form-label">Quantité</label>
                            {{ Form::text('quantite', old('quantite',$local->quantite), ['class' => 'form-control','id' => 'type', 'placeholder' => '', 'required']) }}
                        </div>
                    </div>
                    <div class="row">
                     </div>

                </div>
                <div class="card-footer">
                    <button type="submit" class="col-md-2 btn btn-primary" data-bs-dismiss="modal">Save</button>
                    <a href="{{route('config.indextypeaccessoire')}}" type="button" class="col-md-2 btn btn-danger" >Cancel</a>

                </div>{{ Form::close() }}
            </div>
        </div>

    </div>

</x-app-layout>
