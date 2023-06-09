@push('scripts')

@endpush

<x-app-layout :assets="$assets ?? []">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Edit periode: {{$periode->libelle}}</h4>
                    </div>
                </div>
                {{ Form::open(['url' => 'periode/'.$periode->id.'/edit','method' => 'post']) }}
                <div class="card-body px-3">

                    <div class="row">
                        <div class="form-group col-md-12">
                            <label class="form-label">Libelle</label>
                            {{ Form::text('libelle', $periode->libelle, ['class' => 'form-control','id' => 'libelle', 'placeholder' => "", 'required']) }}
                        </div>
                    </div>
                    <h4>Frequence de repetition</h4>

                    <div class="row mt-3">
                        <div class="form-group col-md-3">
                            <input type="radio" value="3" name="frequence" {{$periode->frequence==3? 'checked': ''}}>
                           {{-- {{ Form::radio('frequence',old('frequence',3),  ['class' => 'form-control','id' => 'libelle', 'placeholder' => "", 'required']) }}--}}
                            <label class="form-label">Chaque Jour</label>
                        </div>
                        <div class="form-group col-md-3">
                            <input  type="radio" value="2" name="frequence" {{$periode->frequence==2? 'checked': ''}}>
                            {{--{{ Form::radio('frequence',old('frequence',2), ['class' => 'form-control','id' => 'libelle', 'placeholder' => "", 'required']) }}--}}
                            <label class="form-label">Chaque Semaine</label>
                        </div>
                        <div class="form-group col-md-3">
                            <input  type="radio" value="1" name="frequence" {{$periode->frequence==1? 'checked': ''}}>
                          {{--  {{ Form::radio('frequence', old('frequence',1), ['class' => 'form-control','id' => 'libelle', 'placeholder' => "", 'required']) }}--}}
                            <label class="form-label">Chaque mois</label>
                        </div>
                        <div class="form-group col-md-3">
                            <input  type="radio" value="4" name="frequence" {{$periode->frequence==4? 'checked': ''}}>
                           {{-- {{ Form::radio('frequence', old('frequence',4), ['class' => 'form-control','id' => 'libelle', 'placeholder' => "", 'required']) }}--}}
                            <label class="form-label">Tous les Weekends</label>
                        </div>
                        <div class="form-group col-md-3">
                            <input  type="radio" value="5" name="frequence" {{$periode->frequence==5? 'checked': ''}}>
                          {{--  {{ Form::radio('frequence', old('frequence',5), ['class' => 'form-control','id' => 'libelle', 'placeholder' => "", 'required']) }}--}}
                            <label class="form-label">Sans periodicité</label>
                        </div>

                     </div>

                </div>
                <div class="card-footer">
                    <button type="submit" class="col-md-2 btn btn-primary" data-bs-dismiss="modal">Save</button>
                    <a  href="{{route('config.indexperiode')}}" type="button" class="col-md-2 btn btn-danger" >Cancel</a>

                </div>{{ Form::close() }}
            </div>
        </div>

    </div>

</x-app-layout>
