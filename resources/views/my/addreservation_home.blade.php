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
                    typejour: $('#jour_type').val(),
                    date: $('#r_date').val(),
                    start: $('#r_time').val(),
                    end: $('#r_time_end').val(),
                    'horaire_reservation': $('#reservation_horaire input[type=radio]:checked').val(),
                    mode: 'getlocal'
                },
                type: "GET",
                success: function (data) {
                    $('#locaux').html("")
                    $('#group_local').val(data.group_id)
                    $.each(data.locals, function (index, item) {
                       /* $('#locaux').append(
                            ' <div class="form-check col-md-4">\n' +
                            ' <input class="form-check-input" type="radio" name="local" value="' + item.id + '" id="local1">\n' +
                            ' <label class="form-check-label" for="local1">' + item.libelle + '</label></div>'
                        );*/
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
              /*      $('#reservation_horaire').html("")
                    $.each(data, function (index, item) {
                        $('#reservation_horaire').append(
                            ' <div class="form-check col-md-4">' +
                            '<input class="form-check-input"  value="' + item.horaire_reservation + '" type="radio" name="flexRadioDefault" id="flexRadioDefault1">\n' +
                            '<label class="form-check-label" for="flexRadioDefault1">' + item.horaire_reservation + '</label> </div>'
                        );
                    })*/
                },
                error: function (error) {

                }
            })
        })
        $('#add_line').click(function () {
            $('#status_accessoire').text('')
            var qte = $('#qte').val();
            var id = $('#type_accessoire option:selected').val();
            var libelle = $('#type_accessoire option:selected').text();
            var idtd = "line_" + id;
            $.ajax({
                url: configs.routes.verifyquantity,
                data: {
                    id: id,
                    quantity: qte,
                },
                type: "GET",
                success: function (data) {

                    if(data.status){
                        $("#table_accessoire>tbody:last").append("<tr id='" + idtd + "'><td>" +
                            "<input class='checkbox hidden' type='checkbox' checked><span class='hidden' hidden>" + id + "</span></td>" +
                            "<td>" + libelle + "</td><td>" + qte + "</td><td><a onclick='removeRow(" + id + ")' class='btn btn-sm btn-danger'>Del</a></td></tr>");

                    }else{
                        $('#status_accessoire').text('Quantité disponible: '+data.quantity)
                    }

                },
                error: function (error) {

                }
            })

            /*    $("#table_accessoire>tbody:last").append("<tr id='" + idtd + "'><td>" +
                    "<input class='checkbox hidden' type='checkbox' checked><span class='hidden' hidden>" + id + "</span></td>" +
                    "<td>" + libelle + "</td><td>" + qte + "</td><td><a onclick='removeRow(" + id + ")' class='btn btn-sm btn-danger'>Del</a></td></tr>");
           */
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

<x-app-layout layout="simple" :assets="$assets ?? []">
    <span class="uisheet screen-darken"></span>
    <div class="header" style="background-size: cover; background-repeat: no-repeat; height: 20vh;position: relative;">
        <div class="main-img">

        </div>
        <div class="container">
            <nav class="nav navbar navbar-expand-lg navbar-light top-1 rounded">
                <div class="container-fluid">
                    <a class="navbar-brand mx-2" href="#">
                        <svg width="30" class="text-primary" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="-0.757324" y="19.2427" width="28" height="4" rx="2" transform="rotate(-45 -0.757324 19.2427)" fill="currentColor"></rect>
                            <rect x="7.72803" y="27.728" width="28" height="4" rx="2" transform="rotate(-45 7.72803 27.728)" fill="currentColor"></rect>
                            <rect x="10.5366" y="16.3945" width="16" height="4" rx="2" transform="rotate(45 10.5366 16.3945)" fill="currentColor"></rect>
                            <rect x="10.5562" y="-0.556152" width="28" height="4" rx="2" transform="rotate(45 10.5562 -0.556152)" fill="currentColor"></rect>
                        </svg>
                        <h5 class="logo-title">{{env('APP_NAME')}}</h5>
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-2" aria-controls="navbar-2" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbar-2">
                        <ul class="navbar-nav ms-auto mb-2 mb-lg-0 d-flex align-items-start">
                            <li class="nav-item">
                                @if(auth()->user()!=null)
                                    <a class="btn btn-success" aria-current="page" href="{{ route('dashboard') }}">
                                        <svg width="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path opacity="0.4" d="M16.0756 2H19.4616C20.8639 2 22.0001 3.14585 22.0001 4.55996V7.97452C22.0001 9.38864 20.8639 10.5345 19.4616 10.5345H16.0756C14.6734 10.5345 13.5371 9.38864 13.5371 7.97452V4.55996C13.5371 3.14585 14.6734 2 16.0756 2Z" fill="currentColor"></path>
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M4.53852 2H7.92449C9.32676 2 10.463 3.14585 10.463 4.55996V7.97452C10.463 9.38864 9.32676 10.5345 7.92449 10.5345H4.53852C3.13626 10.5345 2 9.38864 2 7.97452V4.55996C2 3.14585 3.13626 2 4.53852 2ZM4.53852 13.4655H7.92449C9.32676 13.4655 10.463 14.6114 10.463 16.0255V19.44C10.463 20.8532 9.32676 22 7.92449 22H4.53852C3.13626 22 2 20.8532 2 19.44V16.0255C2 14.6114 3.13626 13.4655 4.53852 13.4655ZM19.4615 13.4655H16.0755C14.6732 13.4655 13.537 14.6114 13.537 16.0255V19.44C13.537 20.8532 14.6732 22 16.0755 22H19.4615C20.8637 22 22 20.8532 22 19.44V16.0255C22 14.6114 20.8637 13.4655 19.4615 13.4655Z" fill="currentColor"></path>
                                        </svg>
                                        Dashboard
                                    </a>
                                @else
                                    <a class="btn btn-success" aria-current="page" href="{{ route('login') }}">
                                        <svg width="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M17.0105 14.6013C17.4245 14.6013 17.7605 14.2653 17.7605 13.8513V11.9993C17.7605 11.5853 17.4245 11.2493 17.0105 11.2493H11.3185C10.9945 10.1823 10.0125 9.39827 8.84051 9.39827C7.40651 9.39827 6.23951 10.5653 6.23951 11.9993C6.23951 13.4343 7.40651 14.6013 8.84051 14.6013C10.0125 14.6013 10.9945 13.8173 11.3185 12.7493H13.4305V13.8513C13.4305 14.2653 13.7665 14.6013 14.1805 14.6013C14.5945 14.6013 14.9305 14.2653 14.9305 13.8513V12.7493H16.2605V13.8513C16.2605 14.2653 16.5965 14.6013 17.0105 14.6013ZM7.66551 1.99927H16.3345C19.7225 1.99927 21.9995 4.37727 21.9995 7.91627V16.0833C21.9995 19.6223 19.7225 21.9993 16.3335 21.9993H7.66551C4.27651 21.9993 1.99951 19.6223 1.99951 16.0833V7.91627C1.99951 4.37727 4.27651 1.99927 7.66551 1.99927ZM7.73861 12.0002C7.73861 11.3922 8.23361 10.8982 8.84061 10.8982C9.44761 10.8982 9.94261 11.3922 9.94261 12.0002C9.94261 12.6072 9.44761 13.1012 8.84061 13.1012C8.23361 13.1012 7.73861 12.6072 7.73861 12.0002Z" fill="currentColor"></path>
                                        </svg>
                                        S'identifier
                                    </a>
                                @endif
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </div>
    <div class="container">
        <input value="{{$type_jour}}"  id="jour_type" type="hidden">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h3 class="card-title">Nouvelle reservation</h3>
                        </div>
                    </div>
                    <div class="card-body px-3">
                        @if(is_null($conge))
                            <h4 class="badge badge-lg btn-success">Reservation pendant periode contingent </h4>
                        @else
                        <h4 class="badge badge-lg btn-danger">Reservation pendant periode hors contingent:
                            {{$conge->libelle}} </h4>
                        @endif
                        <div class="row" id="step-1">
                            <div class="col-md-6" hidden>
                                <label class="form-label" for="r_time">Date de reservation: </label>
                                <input type="date" value="{{$date}}" class="form-control" id="r_date">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Periode: <span class="text-danger">*</span></label>
                                <select class="form-select" id="periode">
                                    @foreach($periodes as $periode)
                                        <option data-label="{{ $periode->libelle }}"
                                                value="{{ $periode->id }}">{{ $periode->libelle }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6 mt-2">
                                <label class="form-label">Type de salle: <span class="text-danger">*</span></label>
                                <select class="form-select" id="typesalle">
                                    <option>selectionnez type salle</option>
                                    @foreach($typesalles as $salle)
                                        <option value="{{ $salle->id }}">{{ $salle->type }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="r_time">Heure de debut: </label>
                                <select class="form-select" id="r_time">
                                    <option>selectionnez heure de debut</option>
                                    @foreach($heuredebuts as $heure)
                                        <option value="{{ $heure }}">{{ $heure }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="r_time">Heure de fin: </label>
                                <select class="form-select" id="r_time_end">
                                    <option>selectionnez heure de fin</option>
                                    @foreach($heurefins as $heure)
                                        <option value="{{ $heure }}">{{ $heure }}</option>
                                    @endforeach
                                </select>
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
                                <div class="col-md-3 mt-3">
                                <span class="badge-danger btn-danger" id="status_accessoire"></span>
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
