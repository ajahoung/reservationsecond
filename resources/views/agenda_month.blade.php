@push('scripts')
    <script src="{{asset('js/guest/calendar.min.js')}}"></script>
    <script src="{{asset('js/guest/guest.js')}}"></script>
    <script>
        $('#salle_select').change(function () {

            $("#calenda_month").html("")
            $("#calenda_month").append("<div id=\"calendar_month\" class=\"calendar-s\"></div>");
            let calendarEl = document.getElementById('calendar_month');

            let calendar1 = new FullCalendar.Calendar(calendarEl, {
                selectable: true,
                plugins: ["timeGrid", "dayGrid", "list", "interaction"],
                timeZone: "UTC",
                defaultView: "dayGridMonth",
                contentHeight: "auto",
                eventLimit: true,
                dayMaxEvents: 4,
                header: {
                    left: "prev,next today",
                    center: "title",
                    right: "dayGridMonth,timeGridWeek,timeGridDay,listWeek"
                },
                dateClick: function (info) {
                    $('#schedule-start-date').val(info.dateStr)
                    $('#schedule-end-date').val(info.dateStr)
                    console.log(info.dateStr)
                    window.location=configs.routes.startreservation+"?date="+info.dateStr;
                },
                events:configs.routes.calendarevent+"?local="+$(this).val()
            });

            calendar1.render();

        })
        $('#groupsalle').change(function () {
            $.ajax({
                url: configs.routes.reservation_getsalle,
                data: {
                    groupe: $(this).val(),
                    periode: $('#periode').val(),
                    typejour: $('#typejour').val(),
                    horaire_reservation: $(this).val(),
                    mode: 'getsalle'
                },
                type: "GET",
                success: function (data) {
                    $('#salle_select').html("")
                    $('#salle_select').append("<option> Choisir une salle</option>");
                    $.each(data.locals, function (index, item) {
                        $('#salle_select').append("<option value="+item.id+">"+item.libelle+"</option>")

                    })
                },
                error: function (error) {

                }
            })
        })
    </script>
@endpush
<x-app-layout layout="simple" :assets="$assets ?? []">
    <span class="uisheet screen-darken"></span>
    <input type="hidden" id="salle_id" value="{{$salle}}">
    <input type="hidden" id="date_start" value="{{$date_start}}">
    <div class="header" style="background-color:
    #f0841f;background-size: cover; background-repeat: no-repeat; height: 20vh;position: relative;">
        <div class="main-img">
        </div>
        <div class="container">
            <nav class="nav navbar navbar-expand-lg navbar-light top-1 rounded" style="background-color: transparent">
                <div class="container-fluid">
                    <a class="navbar-brand mx-2" href="#">
                        <svg width="30" class="text-primary" viewBox="0 0 30 30" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <rect x="-0.757324" y="19.2427" width="28" height="4" rx="2"
                                  transform="rotate(-45 -0.757324 19.2427)" fill="currentColor"></rect>
                            <rect x="7.72803" y="27.728" width="28" height="4" rx="2"
                                  transform="rotate(-45 7.72803 27.728)" fill="currentColor"></rect>
                            <rect x="10.5366" y="16.3945" width="16" height="4" rx="2"
                                  transform="rotate(45 10.5366 16.3945)" fill="currentColor"></rect>
                            <rect x="10.5562" y="-0.556152" width="28" height="4" rx="2"
                                  transform="rotate(45 10.5562 -0.556152)" fill="currentColor"></rect>
                        </svg>
                        <h5 class="logo-title">Collège St-Michel de Bruxelles Système de réservation de salles</h5>
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-2"
                            aria-controls="navbar-2" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbar-2">
                        <ul class="navbar-nav ms-auto mb-2 mb-lg-0 d-flex align-items-start">
                            <li class="nav-item">
                                @if(auth()->user()!=null)
                                    <a class="btn btn-success" aria-current="page" href="{{ route('dashboard') }}">
                                        <svg width="22" viewBox="0 0 24 24" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path opacity="0.4"
                                                  d="M16.0756 2H19.4616C20.8639 2 22.0001 3.14585 22.0001 4.55996V7.97452C22.0001 9.38864 20.8639 10.5345 19.4616 10.5345H16.0756C14.6734 10.5345 13.5371 9.38864 13.5371 7.97452V4.55996C13.5371 3.14585 14.6734 2 16.0756 2Z"
                                                  fill="currentColor"></path>
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                  d="M4.53852 2H7.92449C9.32676 2 10.463 3.14585 10.463 4.55996V7.97452C10.463 9.38864 9.32676 10.5345 7.92449 10.5345H4.53852C3.13626 10.5345 2 9.38864 2 7.97452V4.55996C2 3.14585 3.13626 2 4.53852 2ZM4.53852 13.4655H7.92449C9.32676 13.4655 10.463 14.6114 10.463 16.0255V19.44C10.463 20.8532 9.32676 22 7.92449 22H4.53852C3.13626 22 2 20.8532 2 19.44V16.0255C2 14.6114 3.13626 13.4655 4.53852 13.4655ZM19.4615 13.4655H16.0755C14.6732 13.4655 13.537 14.6114 13.537 16.0255V19.44C13.537 20.8532 14.6732 22 16.0755 22H19.4615C20.8637 22 22 20.8532 22 19.44V16.0255C22 14.6114 20.8637 13.4655 19.4615 13.4655Z"
                                                  fill="currentColor"></path>
                                        </svg>
                                        Dashboard
                                    </a>
                                @else
                                    <a class="btn btn-success" aria-current="page" href="{{ route('login') }}">
                                        <svg width="22" viewBox="0 0 24 24" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                  d="M17.0105 14.6013C17.4245 14.6013 17.7605 14.2653 17.7605 13.8513V11.9993C17.7605 11.5853 17.4245 11.2493 17.0105 11.2493H11.3185C10.9945 10.1823 10.0125 9.39827 8.84051 9.39827C7.40651 9.39827 6.23951 10.5653 6.23951 11.9993C6.23951 13.4343 7.40651 14.6013 8.84051 14.6013C10.0125 14.6013 10.9945 13.8173 11.3185 12.7493H13.4305V13.8513C13.4305 14.2653 13.7665 14.6013 14.1805 14.6013C14.5945 14.6013 14.9305 14.2653 14.9305 13.8513V12.7493H16.2605V13.8513C16.2605 14.2653 16.5965 14.6013 17.0105 14.6013ZM7.66551 1.99927H16.3345C19.7225 1.99927 21.9995 4.37727 21.9995 7.91627V16.0833C21.9995 19.6223 19.7225 21.9993 16.3335 21.9993H7.66551C4.27651 21.9993 1.99951 19.6223 1.99951 16.0833V7.91627C1.99951 4.37727 4.27651 1.99927 7.66551 1.99927ZM7.73861 12.0002C7.73861 11.3922 8.23361 10.8982 8.84061 10.8982C9.44761 10.8982 9.94261 11.3922 9.94261 12.0002C9.94261 12.6072 9.44761 13.1012 8.84061 13.1012C8.23361 13.1012 7.73861 12.6072 7.73861 12.0002Z"
                                                  fill="currentColor"></path>
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
    <div class="row m-3">
        <div class="calendar col-md-2">
            <main>
                <div class="calendar-wrapper" id="calendar-wrapper"></div>
            </main>
        </div>

        <div class="col-lg-10">
            <div class="row justify-content-end">
                <div class="col-md-3">
                    <label class="form-label">Groupe salles</label>
                    <select class="form-select" id="groupsalle">
                        @foreach($groupes as $periode)
                            <option data-label="{{ $periode->libelle }}"
                                    value="{{ $periode->id }}">{{ $periode->libelle }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Salles</label>
                    <select class="form-select" id="salle_select">
                   {{--     @foreach($salles as $salle)
                            <option data-label="{{ $salle->libelle }}"
                                    value="{{ $salle->id }}">{{ $salle->type }}
                            </option>
                        @endforeach--}}
                    </select>
                </div>
                <div class="col-md-4">
                    <div class="btn-group">
                        <a class="btn btn-success" id="btn_day" href="{{route('agenda_day',['local'=>$salle,'date_start'=>$date_start])}}">Jour</a>
                        <a class="btn btn-success" id="btn_week" href="{{route('agenda_week',['local'=>$salle,'date_start'=>$date_start])}}">Semaine</a>
                        <a class="btn btn-active" id="btn_month" href="{{route('agenda_month',['local'=>$salle,'date_start'=>$date_start])}}">Mois</a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card  ">
                        <div class="card-body">
                            <div id="calenda_month">
                                <div id="calendar_month" class="calendar-s"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
