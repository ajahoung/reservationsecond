<?php


namespace App\Http\Controllers;


use App\Models\Local;
use App\Models\Periode;
use App\Models\Reservation;
use Barryvdh\DomPDF\Facade\Pdf;
use Symfony\Component\HttpFoundation\Request;

class RapportController extends Controller
{

    public function index(Request $request)
    {
       $locals=Local::all();
        $periodes=Periode::all();
       if ($request->getMethod()=="POST"){
           $salle=$request->get("salle");
           if (is_null($request->get('date_debut'))){
               $begin=date('Y/m/d');
               $end=date('Y/m/d');
           }else{
               $begin=$request->get('date_debut');
               $end=$request->get('date_fin');
           }

           $c_type=$request->get('c_type');
           if ($c_type=="c_salle"){
               if ($salle=="all_salle"){
                   $reservations = Reservation::query()
                       ->leftJoin('local','local.id','=','local_id')
                       ->where('status', '=', Reservation::ACCEPTED)
                       ->where('date_reservation', '>=', $begin)
                       ->where('date_reservation', '<', $end . ' 23:00:00')->get();
               }
               else{
                   $reservations = Reservation::query()
                       ->leftJoin('local','local.id','=','local_id')
                       ->where('status', '=', Reservation::ACCEPTED)
                       ->where('local_id', '=', $salle)
                       ->where('date_reservation', '>=', $begin)
                       ->where('date_reservation', '<', $end . ' 23:00:00')->get();
               }
           }else{
               $periode=$request->get("periode");
               if ($periode=="all_periode"){
                   $reservations = Reservation::query()
                       ->leftJoin('local','local.id','=','local_id')
                       ->where('status', '=', Reservation::ACCEPTED)
                       ->where('date_reservation', '>=', $begin)
                       ->where('date_reservation', '<', $end . ' 23:00:00')->get();
               }
               else{
                   $reservations = Reservation::query()
                       ->leftJoin('local','local.id','=','local_id')
                       ->where('status', '=', Reservation::ACCEPTED)
                       ->where('periode_id', '=', $periode)
                       ->where('date_reservation', '>=', $begin)
                       ->where('date_reservation', '<', $end . ' 23:00:00')->get();
               }
           }

           $data = [
               'title' => 'Rapport d occupation',
               'date' => date('m/d/Y'),
               'begin'=>$begin,
               'end'=>$end,
               'reservations'=>$reservations
           ];

           $pdf = PDF::loadView('rapport.pdf', $data);

           return $pdf->download('codesolutionstuff.pdf');
       }
        return view('rapport.index', [
            "locals"=>$locals,
            'periodes'=>$periodes
        ]); }
}
