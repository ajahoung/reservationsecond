Hi, {{ $name }}
{{$content}}
Date de reservation: {{$reservation->date_reservation->format('Y-m-d h:i')}}
Periode de reservation: {{$reservation->start}} - {{$reservation->end}}
Status de reservation: {{$reservation->status}}
