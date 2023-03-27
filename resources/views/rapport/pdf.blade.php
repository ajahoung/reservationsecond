<html>
<head>
    <title>Rapport d'occupation</title>
    <style>
        @page {
            header: tocHTMLFooterEven; /* display <htmlpageheader name="MyCustomHeader"> on all pages */
            footer: tocHTMLFooterEven; /* display <htmlpagefooter name="MyCustomFooter"> on all pages */

        }
        .col-md-4 {
            position: relative;
            width: 100%;
            padding-right: 1px;
            padding-left: 1px;
        }

        .col-md-4 {
            -ms-flex: 0 0 33.333333%;
            flex: 0 0 33.333333%;
            max-width: 33.333333%;
        }

        .col-md-6 {
            width: 300px;
            position: relative;
            min-height: 1px;
            padding-right: 15px;
            padding-left: 15px;
        }
        table {font-family: 'DejaVu Sans Condensed'; font-size: 9pt; line-height: 1.2;
            margin-top: 2pt; margin-bottom: 5pt;
            border-collapse: collapse; }

        thead {	font-weight: bold; vertical-align: bottom; }
        tfoot {	font-weight: bold; vertical-align: top; }
        thead td { font-weight: bold; }
        tfoot td { font-weight: bold; }

        .headerrow td, .headerrow th { background-gradient: linear #b7cebd #f5f8f5 0 1 0 0.2;  }
        .footerrow td, .footerrow th { background-gradient: linear #b7cebd #f5f8f5 0 1 0 0.2;  }

        th {	font-weight: bold;
            vertical-align: top;
            padding-left: 2mm;
            padding-right: 2mm;
            padding-top: 0.5mm;
            padding-bottom: 0.5mm;
        }

        td {	padding-left: 2mm;
            vertical-align: top;
            padding-right: 2mm;
            padding-top: 0.5mm;
            padding-bottom: 0.5mm;
            font-size: 15px;
        }

        th p { margin:0pt;  }
        td p { margin:0pt;  }

        table.widecells td {
            padding-left: 5mm;
            padding-right: 5mm;
        }
        table.tallcells td {
            padding-top: 3mm;
            padding-bottom: 3mm;
        }


        .row{
            margin-right: 1px;
            margin-left: 1px;
        }
        .grad{
            border: 1px solid #ffffff;
            background-color: #ffffff;
        }
        h4 {
            font-family: sans;
            font-weight: bold;
            margin-top: 1em;
            margin-bottom: 0.5em;
        }
        div_{
            padding:3px;
        }
        p{
            font-size: 13px;
            margin: 1px;
        }
        .bpmTopic{
            border: #333333 solid 1px;
            width: 100%;
        }
        .headtable{
            background-color: #1e2b37;
            color: #f6fffe;
        }
        .bpmTopic td, .bpmTopic th  {	border-top: 1px solid #333;border-right: 1px solid #333333 }
        .bpmTopicC td, .bpmTopicC th  {	border-top: 1px solid #333; }
        .bpmTopnTail td, .bpmTopnTail th  {	border-top: 1px solid #FFFFFF; }
        .bpmTopnTailC td, .bpmTopnTailC th  {	border-top: 1px solid #FFFFFF; }
    </style>
</head>
<body>
<h1>{{ $title }} Du {{$begin}} à {{$end}}</h1>
<p>{{ $date }}</p>
<table  class="table bpmTopic" style="width: 100%;">
    <thead class="th-head">
    <tr>
    <th style="width: 20%;">Local</th>
    <th style="width: 15%;">Date</th>
        <th style="width: 15%;">H.debut</th>
        <th style="width: 15%;">H.fin</th>
    <th style="width: 20%;">Utilisateur</th>
    <th style="width: 15%;">Status</th></tr>
    </thead>
    <tbody>
    @foreach($reservations as $reservation)
    <tr>
        <td>{{$reservation->local->libelle}}</td>
        <td>{{$reservation->date_reservation}}</td>
        <td>{{$reservation->start}}</td>
        <td>{{$reservation->end}}</td>
        <td>{{$reservation->user->first_name}} {{$reservation->user->last_name}}</td>
        <td>{{$reservation->status}}</td>
    </tr>
    @endforeach
    </tbody>

</table>
</body>
</html>
