@push('scripts')
    <script>
        $('#btn-previous').hide()
        $('#step-2').hide()
        $('#btn-save').hide()
        $('#btn-previous').click(function () {
            $('#step-1').show()
            $('#step-2').hide()
            $('#btn-next1').show()
            $('#btn-previous').hide()
            $('#btn-save').hide()
        })
        $('#btn-next1').click(function () {
            $('#step-1').hide()
            $('#step-2').show()
            $('#btn-next1').hide()
            $('#btn-previous').show()
            $('#btn-save').show()

            $.ajax({
                url: configs.routes.reservation_getsalle,
                data: {
                    typesalle: $('#typesalle').val(),
                    typejour: $('#typejour').val(),
                    'horaire_reservation': $('#reservation_horaire input[type=radio]:checked').val(),
                    mode: 'getlocal'
                },
                type: "GET",
                success: function (data) {
                    $('#locaux').html("")
                    $('#group_local').val(data.group_id)
                    $.each(data.locals, function (index, item) {
                        $('#locaux').append("<option value=" + item.id + ">" +item.libelle+
                            "</option>")
                    })
                },
                error: function (error) {

                }
            })
        })
        $('input[name=flexRadioDefault]:radio').change(function () {
            $.ajax({
                url: configs.routes.reservation_getsalle,
                data: {
                    periode: $('#periode').val(),
                    typejour: $('#typejour').val(),
                    horaire_reservation: $(this).val(),
                    mode: 'gethoraire'
                },
                type: "GET",
                success: function (data) {
                    $('#r_time').html("")
                    $('#r_time_end').html("")
                    $.each(data.begins, function (index, item) {
                        $('#r_time').append("<option>"+item+"</option>")

                    })
                    $.each(data.ends, function (index, item) {
                        $('#r_time_end').append("<option>"+item+"</option>")

                    })
                },
                error: function (error) {

                }
            })
        })
        $('#typejour').change(function () {
            $.ajax({
                url: configs.routes.reservation_getsalle,
                data: {
                    periode: $('#periode').val(),
                    typesalle: $('#typesalle').val(),
                    typejour: $(this).val(),
                    mode: 'gethoraire'
                },
                type: "GET",
                success: function (data) {
                    $('#r_time').html("")
                    $('#r_time_end').html("")
                    $.each(data.begins, function (index, item) {
                        $('#r_time').append("<option>"+item+"</option>")

                    })
                    $.each(data.ends, function (index, item) {
                        $('#r_time_end').append("<option>"+item+"</option>")

                    })
                },
                error: function (error) {

                }
            })
        })
        $('#contegeant').hide();
        $('#hors_contegeant').hide();
        $('#r_date').change(function () {
            $.ajax({
                url: configs.routes.reservation_getsalle,
                data: {
                    date: $(this).val(),
                    mode: 'gethoraire'
                },
                type: "GET",
                success: function (data) {
                    $('#jour_type').val(data.type_jour)
                    if (data.type_jour===1){
                        $('#contegeant').show();
                        $('#hors_contegeant').hide();


                    }else {
                        $('#contegeant').hide();
                        $('#hors_contegeant').show();
                    }
                    $('#r_time').html("")
                    $('#r_time_end').html("")
                    $.each(data.begins, function (index, item) {
                        $('#r_time').append("<option>"+item+"</option>")

                    })
                    $.each(data.ends, function (index, item) {
                        $('#r_time_end').append("<option>"+item+"</option>")

                    })
                },
                error: function (error) {

                }
            })
        })
        $('#add_line').click(function () {

            var qte = $('#qte').val();
            var id = $('#type_accessoire option:selected').val();
            var libelle = $('#type_accessoire option:selected').text();
            var idtd = "line_" + id;
            $("#table_accessoire>tbody:last").append("<tr id='" + idtd + "'><td>" +
                "<input class='checkbox hidden' type='checkbox' checked><span class='hidden' hidden>" + id + "</span></td>" +
                "<td>" + libelle + "</td><td>" + qte + "</td><td><a onclick='removeRow(" + id + ")' class='btn btn-sm btn-danger'>Del</a></td></tr>");
        })
        $('#btn-save').click(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
            jsonObj = [];
            $("#table_accessoire>tbody input[type=checkbox]:checked").each(function () {
                var row = $(this).closest('tr')[0];
                var id = row.cells[0].children[1].innerText;
                var quantity = row.cells[2].innerText;
                item = {};
                item['quantity'] = quantity;
                item['id'] = id;
                jsonObj.push(item)
            });
            console.log(JSON.stringify({data: jsonObj}))
            $.ajax({
                url: configs.routes.ajaxpostreservation,
                type: "POST",
                dataType: "JSON",
                data: JSON.stringify({
                    ob: jsonObj, local: $('#locaux  option:selected').val()
                    , periode: $('#periode option:selected').val(),end: $('#r_time_end').val(),
                    date_reservation: $('#r_date').val(),start: $('#r_time').val(),
                    group_local: $('#group_local').val(),
                    jour_type: $('#jour_type').val()
                }),
                success: function (data) {
                    console.log(data)
                    window.location=configs.routes.myreservation
                    setTimeout(function () {
                        $("#overlay").fadeOut(300);
                    }, 500);
                },
                error: function (err) {
                    alert("An error ocurred while loading data ...");
                    setTimeout(function () {
                        $("#overlay").fadeOut(300);
                    }, 500);
                }
            });
        })

        function removeRow(id) {
            line = "#line_" + id;
            $(line).remove();
        }
    </script>
@endpush

<x-app-layout :assets="$assets ?? []">
    <input id="jour_type" type="hidden">
    <div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h3 class="card-title">Nouvelle reservation</h3>
                        </div>
                    </div>
                    <div class="card-body px-3">
                        <h4 class="badge badge-lg btn-success" id="contegeant">Reservation pendant periode contengeant </h4>
                        <h4 class="badge badge-lg btn-danger" id="hors_contegeant">Reservation pendant periode hors contengeant </h4>
                        <div class="row" id="step-1">
                            <div class="col-md-4">
                                <label class="form-label" for="r_time">Date de reservation: </label>
                                <input type="date" class="form-control" id="r_date">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Periode: <span class="text-danger">*</span></label>
                                <select class="form-select" id="periode">
                                    @foreach($periodes as $periode)
                                        <option data-label="{{ $periode->libelle }}"
                                                value="{{ $periode->id }}">{{ $periode->libelle }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4 mt-2">
                                <label class="form-label">Type de salle: <span class="text-danger">*</span></label>
                                <select class="form-select" id="typesalle">
                                    <option>selectionnez type salle</option>
                                    @foreach($typesalles as $salle)
                                        <option value="{{ $salle->id }}">{{ $salle->type }}</option>
                                    @endforeach
                                </select>
                            </div>
                     {{--       <div class="form-group col-md-6 mt-2">
                                <label class="form-label">Type de jours: <span class="text-danger">*</span></label>
                                <select class="form-select" id="typejour">
                                    <option>selectionnez type jour</option>
                                    <option value="1">Jours scolaires</option>
                                    <option value="2">Jours feriés</option>
                                    <option value="3">Weekends</option>
                                    <option value="4">Congés</option>
                                </select>
                            </div>--}}
                          {{--  <h5>Horaire de reservation</h5>
                            <div class="col-md-12 mt-2 mb-3">
                                <div class="form-check col-md-4"><input class="form-check-input"  value="08h25-15h45" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                                    <label class="form-check-label" for="flexRadioDefault1">08h25-15h45</label> </div>
                                <div class="form-check col-md-4"><input class="form-check-input"  value="16h00-22h30" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                                    <label class="form-check-label" for="flexRadioDefault1">16h00-22h30</label> </div>
                            </div>--}}

                            <div class="col-md-6">
                                <label class="form-label" for="r_time">Heure de debut: </label>
                                <select class="form-select" id="r_time">
                                </select>
                                {{--<input type="time" class="form-control" id="r_time_begin">--}}
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="r_time">Heure de fin: </label>
                                <select class="form-select" id="r_time_end">
                                </select>
                               {{-- <input type="time" class="form-control" id="r_time_end">--}}
                            </div>
                        </div>
                        <div class="row px-3" id="step-2">
                            <h5>Locaux disponibles</h5>
                            <input id="group_local" type="hidden">
                            <div id="locaux_" class="row px-3 pt-3">
                                <select class="form-select" id="locaux">
                                </select>
                            </div>
                            <h5 class="mt-3">Accessoires</h5>
                            <div class="mt-3 row">
                                <div class="col-md-3">
                                    <label class="form-label">Type d'accessoire</label>
                                    <select class="form-select" id="type_accessoire">
                                        @foreach($accessoires as $accessoire)
                                            <option data-label="{{ $accessoire->libelle }}"
                                                    value="{{ $accessoire->id }}">{{ $accessoire->libelle }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label" for="exampleInputcolor">Quantite </label>
                                    <input type="text" class="form-control" id="qte">
                                </div>
                                <div class="col-md-3 mt-3">
                                    <button class="btn btn-success btn-sm mt-2" id="add_line">
                                        Ajouter
                                    </button>
                                </div>
                            </div>
                            <table class="mt-3 table table-bordered px-3" id="table_accessoire">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Accessoire</th>
                                    <th>Quantité</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>

                    </div>
                    <div class="card-footer align-content-end px-3">
                        <button class="btn btn-success" id="btn-next1">
                            Next
                        </button>
                        <button class="btn btn-warning" id="btn-previous">
                            Previous
                        </button>
                        <button class="btn btn-success" id="btn-save">
                            Save
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
