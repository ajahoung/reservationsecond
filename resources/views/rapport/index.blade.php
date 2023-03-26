@push('scripts')
<script>
    $("#rapport_periode").hide()
    $('#type_rapport').change(function () {
        if($(this).val()==="rapport_salle"){
            $("#rapport_periode").hide()
            $("#rapport_salle").show()
        }else{
            $("#rapport_periode").show()
            $("#rapport_salle").hide()
        }

    })
</script>
@endpush

<x-app-layout :assets="$assets ?? []">
    <div class="row">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="header-title">
                    <h4 class="card-title">Rapport d'occupation</h4>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-md-3">
                        <label>Type rapport</label>
                        <select class="form-select" id="type_rapport">
                            <option>Choisir le type</option>
                            <option value="rapport_salle">Rapport par salle</option>
                            <option value="rapport_periode">Rapport par periode</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3" id="rapport_salle">
                        <label>Salles</label>
                        <select class="form-select" id="salle">
                            <option>Choisir une salle</option>
                            @foreach($locals as $local)
                            <option>{{$local->libelle}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-3" id="rapport_periode">
                        <label>Periode</label>
                        <select class="form-select" id="salle">
                            <option>Choisir une periode</option>
                            @foreach($locals as $local)
                                <option>{{$local->libelle}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 justify-content-end">
                        <a class="btn btn-success mt-4" id="btn_export" href="#">Exporter</a>
                    </div>
                </div>

            </div>
        </div>
    </div>

</x-app-layout>
