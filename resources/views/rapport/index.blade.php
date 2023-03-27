@push('scripts')
<script>
    $("#rapport_periode").hide()
    $('#type_rapport').change(function () {
        if($(this).val()==="rapport_salle"){
            $('#c_type').val("c_salle");
            $("#rapport_periode").hide()
            $("#rapport_salle").show()
        }else{
            $('#c_type').val("c_periode");
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
                <form method="post">
                    {{csrf_field()}}
                <div class="row">
                    <input type="hidden" id="c_type" name="c_type">
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
                        <select class="form-select" id="salle" name="salle">
                            <option value="all_salle">Toutes les salles</option>
                            @foreach($locals as $local)
                            <option value="{{$local->id}}">{{$local->libelle}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-3" id="rapport_periode">
                        <label>Periode</label>
                        <select class="form-select" name="periode" id="salle">
                            <option value="all_periode">Toutes les periodes</option>
                            @foreach($periodes as $periode)
                                <option value="{{$periode->id}}">{{$periode->libelle}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label class="">Date de debut</label>
                        <input class="form-control" type="date" name="date_debut">
                    </div>
                    <div class="form-group col-md-3">
                        <label>Date de fin</label>
                        <input class="form-control" type="date" name="date_fin">
                    </div>
                    <div class="col-md-2 justify-content-end">
                        <button type="submit" class="btn btn-success mt-4" id="btn_export" href="#">Exporter</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>

</x-app-layout>
