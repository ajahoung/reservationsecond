<?php

namespace App\Http\Controllers;

use App\DataTables\ReservationDataTable;
use App\DataTables\ReservationUserDataTable;
use App\DataTables\ReservationWaitingDataTable;
use App\Helpers\AuthHelper;
use App\Helpers\DateTimeHelper;
use App\Helpers\DurationHelper;
use App\Models\CaseAgenda;
use App\Models\Commentaire;
use App\Models\Gestionnaire;
use App\Models\GroupLocal;
use App\Models\JourFerie;
use App\Models\LineTypeAccessoire;
use App\Models\Local;
use App\Models\Periode;
use App\Models\Reservation;
use App\Models\TypeAccessoire;
use App\Models\TypeJour;
use App\Models\TypeSalle;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    /*
 * Dashboard Pages Routs
 */
    public function index(Request $request)
    {
        $assets = ['chart', 'animation', 'calender'];
        if (!is_null($request->get('date_start'))) {
            $date_start = $request->get('date_start');
        } else {
            $date_start = date("Y-m-d");
        }
        $day = new \DateTime($date_start);
        $month = $day->format('m');
        $number = cal_days_in_month(CAL_GREGORIAN, $month, $day->format('y'));
        $headers = [];
        $header_weeks = [];
        $header_days = [];
        $bodys = [];
        $body_weeks = [];
        $body_days = [];
        for ($i = 1; $i <= $number; $i++) {
            $id_var = getdate(mktime(1, 1, 1, $month, $i, $day->format('y')));
            $headers[] = [
                'day' => DateTimeHelper::getDayByNumber($id_var['wday']),
                'number' => $i,
            ];
        }
        for ($j = 0; $j <= 6; $j++) {
            $day_i = DateTimeHelper::daysOfWeekXML($date_start)[$j];
            $daym_ = new \DateTime($day_i);
            $id_var = getdate(mktime(1, 1, 1, $daym_->format('m'), $daym_->format('d'), $day->format('y')));
            $header_weeks[] = [
                'day' => DateTimeHelper::getDayByNumber($id_var['wday']),
                'number' => $day_i,
            ];
        }
        $groupes = GroupLocal::all();
        $salles = Local::all();
        foreach ($salles as $salle) {
            $line_reservation = [];
            $line_reservation_week = [];
            $line_reservation_day = [];
            for ($i = 1; $i <= $number; $i++) {
                $date_array = getdate(mktime(1, 1, 1, $month, $i, $day->format('y')));
                $date_jour_end = date('Y-m-d', mktime(23, 0, 0, $month, $i, $day->format('y')));
                $date_jour = date('Y-m-d', mktime(0, 0, 0, $month, $i, $day->format('y')));
                $reservations = Reservation::query()
                    ->where('status', '!=', Reservation::DENIED)
                    ->where('local_id', '=', $salle->id)
                    ->where('date_reservation', '>=', $date_jour)
                    ->where('date_reservation', '<', $date_jour . ' 23:00:00')
                    ->orderBy('start','asc')
                    ->get();
                $line_reservation[] = [
                    'dayi' => DateTimeHelper::getWeekDay(new \DateTime($date_jour)),
                    'day' => $date_jour_end,
                    'date_jour' => $date_jour,
                    'agenda' => $reservations,
                ];
            }
            for ($j = 0; $j <= 6; $j++) {
                $day_i = DateTimeHelper::daysOfWeekXML($date_start)[$j];
                $reservations = Reservation::query()
                    ->where('status', '!=', Reservation::DENIED)
                    ->where('local_id', '=', $salle->id)
                    ->where('date_reservation', '>=', $day_i)
                    ->where('date_reservation', '<', $day_i . ' 23:00:00')
                    ->orderBy('start','asc')->get();
                $line_reservation_week[] = [
                    'dayi' => DateTimeHelper::getWeekDay(new \DateTime($day_i)),
                    'day' => $date_jour_end,
                    'date_jour' => $day_i,
                    'agenda' => $reservations,
                ];
            }

            for ($k = 0; $k < 1; $k++) {
                $day_i = $date_start;
                $reservations_ = Reservation::query()->where('status', '!=', Reservation::DENIED)
                    ->where('local_id', '=', $salle->id)
                    ->where('date_reservation', '>=', $day_i)
                    ->where('date_reservation', '<', $day_i . ' 23:00:00')
                    ->orderBy('start','asc')->get();
                $line_reservation_day[] = [
                    'dayi' => DateTimeHelper::getWeekDay(new \DateTime($day_i)),
                    'day' => $date_jour_end,
                    'date_jour' => $day_i,
                    'agenda' => $reservations_,
                ];
            }
            $bodys[] = [
                'line' => $salle->libelle,
                'line_id' => $salle->id,
                'occupations' => $line_reservation
            ];
            $body_weeks[] = [
                'line' => $salle->libelle,
                'line_id' => $salle->id,
                'occupations' => $line_reservation_week
            ];
            $body_days[] = [
                'line' => $salle->libelle,
                'line_id' => $salle->id,
                'occupations' => $line_reservation_day
            ];
        }
        return view('index', ["date_start" => $date_start,
            "headers" => $headers,
            "bodys" => $bodys,
            "groupes" => $groupes,
            "salles" => $salles,
            "header_weeks" => $header_weeks,
            "body_weeks" => $body_weeks,
            "body_days" => $body_days,
            compact('assets'),
            'week' => $day->format('W'),
            'month' => $number]);
    }

    public function agenda_month(Request $request)
    {
        $assets = ['chart', 'animation', 'calender'];
        $salle = $request->request->get('local', 1);
        $groupes = GroupLocal::all();
        $salles = TypeSalle::all();
        $day = new \DateTime($request->request->get('date_start'));
        $month = $day->format('m');
        return view('agenda_month', ["date_start" => $request->request->get('date_start'), "groupes" => $groupes, "salle" => $salle, 'assets' => $assets, compact('assets'), 'month' => $month]);
    }

    public function agenda_week(Request $request)
    {
        $assets = ['chart', 'animation', 'calender'];
        $salle = $request->request->get('local', 1);
        $groupes = GroupLocal::all();
        $salles = TypeSalle::all();
        $day = new \DateTime($request->request->get('date_start'));
        $month = $day->format('m');
        return view('agenda_week', ["date_start" => $request->request->get('date_start'), "groupes" => $groupes, "salle" => $salle, 'assets' => $assets, compact('assets'), 'month' => $month]);
    }

    public function agenda_day(Request $request)
    {
        $assets = ['chart', 'animation', 'calender'];
        $salle = $request->request->get('local', 1);
        $groupes = GroupLocal::all();
        $salles = TypeSalle::all();
        $day = new \DateTime($request->request->get('date_start'));
        $month = $day->format('m');
        return view('agenda_day', ["date_start" => $request->request->get('date_start'), "groupes" => $groupes, "salle" => $salle, 'assets' => $assets, compact('assets'), 'month' => $month]);
    }

    /*
     * Dashboard Pages Routs
     */
    public function dashboard(Request $request)
    {
        $assets = ['chart', 'animation', 'calender'];
        if ($request->ajax()) {
            $data = Reservation::query()->where('status', '=', Reservation::ACCEPTED)
                ->whereDate('start', '>=', $request->start)
                ->whereDate('end', '>=', $request->end)
                ->get(['id', 'start', 'end', 'libelle']);
            return response()->json($data);
        }
        return view('dashboards.dashboard', compact('assets'));
    }

    public function calendarevent(Request $request)
    {
        $events = [];
        $reservations = Reservation::query()
            ->where('local_id', '=', $request->request->get('local'))
            ->where('status', '=', Reservation::ACCEPTED)
            ->get();
        foreach ($reservations as $reservation) {
            if ($reservation->status == "PENDING") {
                $color = 'rgba(235,153,27,0.2)';
                $text_color = 'rgba(235,153,27,1)';
            } elseif ($reservation->status == "ACCEPTED") {
                $color = 'rgba(8,130,12,0.2)';
                $text_color = 'rgba(8,130,12,1)';
            } else {
                $color = 'rgba(235,153,27,0.2)';
                $text_color = 'rgba(235,153,27,1)';
            }
            $dateime = new \DateTime($reservation->date_reservation);

            $events[] = [
                'title' => "R_ " . $request->request->get('local') . $reservation->local->libelle,
                'start' => $dateime->format('Y-m-d') . ' ' . $reservation->start,
                'end' => $dateime->format('Y-m-d') . ' ' . $reservation->end,
                'textColor' => $text_color,
                'backgroundColor' => $color,
                'borderColor' => $text_color
            ];
        }
        return response()->json($events);
    }

    /*
     * Pages Routs
     */
    public function addreservation(Request $request)
    {
        $accessoires = TypeAccessoire::all();
        $typesalles = TypeSalle::all();
        $typejours = TypeJour::all();
        $periodes = Periode::all();
        return view('my.addreservation', ["periodes" => $periodes, "typesalles" => $typesalles,
            "accessoires" => $accessoires, "typejours" => $typejours,'date'=>date('Y-m-d')]);
    }

    public function addreservation_home(Request $request)
    {
        $accessoires = TypeAccessoire::all();
        $typesalles = TypeSalle::all();
        $typejours = TypeJour::all();
        $periodes = Periode::all();
        $date_ = $request->get('date');
        if ($date_<date('Y-m-d')){
            return redirect()->route('index')->with('error','Impossible d\'effectuer une reservation a cette date');
        }
        $conge = JourFerie::query()->where('date_debut', '<=', $date_)
            ->where('date_fin', '>=', $date_)->first();
        if (is_null($conge)) {
            $type_jour = 1;
            $heure_debuts = [
                '08:25', '09:15', '10:05', '10:55',
                '11:45', '12:35', '13:25', '14:15', '15:05',
                '------------ Fin des cours en matinée ------------',
                '16:30', '17:30', '18:30', '19:30', '20:30', '21:30',
            ];
            $heure_fins = [
                '09:15', '10:05', '10:55',
                '11:45', '12:35', '13:25', '14:15', '15:05',
                '------------ Fin des cours en matinée ------------',
                '17:30', '18:30', '19:30', '20:30', '21:30', '22:30',
            ];
        } else {
            $type_jour = 2;
            $heure_debuts = [
                '08:25', '09:25', '10:25', '11:25',
                '12:25', '13:25', '14:25', '15:25', '16:25', '17:25', '18:25',
                '19:25', '20:25', '21:25', '22:25',
            ];
            $heure_fins = [
                '09:25', '10:25', '11:25',
                '12:25', '13:25', '14:25', '15:25', '16:25', '17:25', '18:25',
                '19:25', '20:25', '21:25', '22:25',
            ];
        }
        return view('my.addreservation_home', ["date" => $date_,
            'conge' => $conge,
            "periodes" => $periodes,
            "typesalles" => $typesalles,
            "accessoires" => $accessoires,
            "heurefins" => $heure_fins,
            "heuredebuts" => $heure_debuts,
            "type_jour" => $type_jour,
            "typejours" => $typejours]);
    }

    public function startreservation(Request $request)
    {
        $date = $request->get('date');
        $accessoires = TypeAccessoire::all();
        $typesalles = TypeSalle::all();
        $typejours = TypeJour::all();
        $periodes = Periode::all();
        return view('my.addreservation', ["periodes" => $periodes, "typesalles" => $typesalles, "accessoires" => $accessoires, "typejours" => $typejours]);

    }

    public function ajaxgetsalle(Request $request)
    {
        $salle = $request->get('typesalle');
        $typejour = $request->get('typejour');
        if ($request->get('mode') == "getlocal") {
            $horaire = $request->get('horaire_reservation');
            $start=$request->get('start');
            $end=$request->get('end');
            $date_reservation=$request->get('date');
            $reservation=Reservation::query()->where('start','=',$start)
               // ->where('end','=',$end)
                ->where('date_reservation', '=', $date_reservation. ' 00:00:00')
                //->where('date_reservation', '<', $date_reservation . ' 23:00:00')
                ->first();
            $group = GroupLocal::query()->firstWhere('type_salle_id', '=', $salle)
                ->where('type_jour_id', '=', $typejour)->getModel();
            $locals = $group->locals()->get()->toArray();
            if(!is_null($reservation)){
              $locals=  array_filter($locals,function ($tem) use ($reservation){
                 // return in_array($tem,res)
                    return $tem ==$reservation->local();
                });
            }

            return response()->json([
                'locals' => $locals,
                'exemple'=>$reservation,
                'group_id' => $group->id,
            ]);
        } elseif ($request->get('mode') == "getsalle") {
            $group = GroupLocal::query()->find($request->get('groupe'))->getModel();
            $locals = $group->locals;
            return response()->json([
                'locals' => $locals,
            ]);
        } else {
            $date_ = $request->get('date');
            $conge = JourFerie::query()->where('date_debut', '<=', $date_)
                ->where('date_fin', '>=', $date_)->first();
            if (is_null($conge)) {
                $type_jour = 1;
                $heure_debuts = [
                    '08:25', '09:15', '10:05', '10:55',
                    '11:15', '12:05', '12:55', '14:05',
                    '------------ Fin des cours en matinée ------------',
                    '16:00', '17:00', '18:00', '19:00', '20:00', '21:00',
                ];
                $heure_fins = [
                    '09:15', '10:05', '10:55',
                    '11:15', '12:05', '12:55', '14:05','15:05',
                    '------------ Fin des cours en matinée ------------',
                    '17:00', '18:00', '19:00', '20:00', '21:00', '22:00',
                ];
            } else {
                $type_jour = 2;
                $heure_debuts = [
                    '08:25', '09:25', '10:25', '11:25',
                    '12:25', '13:25', '14:25', '15:25', '16:25', '17:25', '18:25',
                    '19:25', '20:25', '21:25', '22:25',
                ];
                $heure_fins = [
                    '09:25', '10:25', '11:25',
                    '12:25', '13:25', '14:25', '15:25', '16:25', '17:25', '18:25',
                    '19:25', '20:25', '21:25', '22:25',
                ];
            }
            return response()->json([
                'begins' => $heure_debuts,
                'ends' => $heure_fins,
                'type_jour' => $type_jour
            ]);
        }

    }

    public function getCrenneaux($crenau, $typejour)
    {
        if ($typejour == 1) {
            return [
                '08:25', '09:15', '10:05', '10:55',
                '11:45', '12:35', '13:25', '14:15', '15:05',
                '------------ Fin des cours en matinée ------------',
                '16:30', '17:30', '18:30', '19:30', '20:30', '21:30',
            ];
        } else {
            return [
                '08:25', '09:25', '10:25', '11:25',
                '12:25', '13:25', '14:25', '15:25', '16:25', '17:25', '18:25',
                '19:25', '20:25', '21:25', '22:25',
            ];
        }

        /* if ($crenau == "08h25-15h45") {
             return [
                 '08:25', '09:15', '10:05', '11:55',
                 '12:45', '13:35', '14:25',
             ];
         } else {
             return [
                 '16:00', '17:00', '18:00', '19:00',
                 '20:00', '21:00',
             ];
         }*/
    }

    public function getCrenneauxEnd($crenau, $typejour)
    {
        if ($typejour == 1) {
            return [
                '09:15', '10:05', '10:55',
                '11:45', '12:35', '13:25', '14:15', '15:05',
                '------------ Fin des cours en matinée ------------',
                '17:30', '18:30', '19:30', '20:30', '21:30', '22:30',
            ];
        } else {
            return [
                '09:25', '10:25', '11:25',
                '12:25', '13:25', '14:25', '15:25', '16:25', '17:25', '18:25',
                '19:25', '20:25', '21:25', '22:25',
            ];
        }

    }

    public function ajaxpostreservation(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $user_id = $request->user()->id;
        $ob = $data['ob'];
        $date_time=new \DateTime($data['date_reservation']);
        if (DateTimeHelper::getWeekDay($date_time)==5||DateTimeHelper::getWeekDay($date_time)==6){
            Session::flash('error', 'Impossible de faire la reservation aprés l\'heure!');
            $res=[
                'status'=>false,
                'message'=>'Impossible : Reservation impossible les weekends'
            ];
            return response()->json($res);
        }
        if ($data['date_reservation']<=date('Y-m-d')){
            if ($data['start']<=date('h:i')){
                Session::flash('error', 'periode incorrecte!');
                $res=[
                    'status'=>false,
                    'message'=>'Impossible : periode incorrecte'.date('h:i')
                ];
                return response()->json($res);
            }

        }
        $reservation = Reservation::query()
            ->where('local_id','=',$data['local'])
            ->where('start','=',$data['start'])
            ->where('end','=',$data['end'])
            ->where('date_reservation','=',$data['date_reservation'])
            ->first();
        if (is_null($reservation)){
            $reservation = new Reservation();
            $reservation->local_id = $data['local'];
            $reservation->start = $data['start'];
            $reservation->group_local_id = $data['group_local'];
            $reservation->user_id = $user_id;

            $reservation->periode_id = $data['periode'];
            $date_ = new \DateTime($data['date_reservation']);
            $reservation->end = $data['end'];
            $reservation->libelle = "RESERV " . $data['start'] . "-" . $data['end'];
            $reservation->status = "PENDING";
            $reservation->parent_id = 0;
            if ($data['jour_type'] == 1) {
                $reservation->contegent = "Periode contegeant";
            } else {
                $reservation->contegent = "Periode non contegeant";
            }

            $reservation->date_reservation = $date_;
            $reservation->save();
            for ($i = 0; $i < sizeof($ob); ++$i) {
                $line_accessoire = new LineTypeAccessoire();
                $quantity = $ob[$i]['quantity'];
                $line_accessoire->reservation_id = $reservation->id;
                $line_accessoire->type_accessoire_id = $ob[$i]['id'];
                $line_accessoire->nombre = $quantity;
                $accessoire=TypeAccessoire::query()->find($ob[$i]['id']);
              /*  $accessoire->update([
                    'quantite' => $accessoire->quantite - $quantity
                ]);*/
                $line_accessoire->save();
            }
            Session::flash('success', 'Reservation enregistrée avec success!');
            $res=[
                'status'=>true,
                'message'=>'Reservation enregistrée avec success'
            ];

                     $this->sendMail($reservation);
        }else{
            Session::flash('error', 'reservation deja enregistre!');
            $res=[
                'status'=>false,
                'message'=>'Impossible : reservation deja enregistre'
            ];
        }

        return response()->json($res);
    }

    public function myreservation(ReservationUserDataTable $dataTable)
    {
        $pageTitle = "Mes reservations";
        $auth_user = AuthHelper::authSession();
        $assets = ['data-table'];
        $headerAction = '';
        return $dataTable->render('global.datatable', compact('pageTitle', 'auth_user', 'assets', 'headerAction'));

    }

    public function waitreservation(ReservationWaitingDataTable $dataTable)
    {
        $pageTitle = "Reservations en attente";
        $auth_user = AuthHelper::authSession();
        $assets = ['data-table'];
        $headerAction = '';
        return $dataTable->render('global.datatable', compact('pageTitle', 'auth_user', 'assets', 'headerAction'));

    }

    public function activatereservation($id, Request $request)
    {
        $reservation = Reservation::query()->find($id);
        $gestionnaire = Gestionnaire::query()->firstWhere('user_id', '=', $request->user()->id);
        $line_accessoires = LineTypeAccessoire::query()->where('reservation_id', '=', $id)->get();
        foreach ($line_accessoires as $line_accessoire) {
            $accessoire = TypeAccessoire::query()->find($line_accessoire->type_accessoire_id);
            if ($accessoire->quantite < $line_accessoire->nombre) {
                return redirect()->route('listreservation')->withErrors("Quantité " . $accessoire->libelle . " insuffissant pour cette reservation." . " Disponible " . $accessoire->quantite);
            } else {
                $accessoire->update([
                    'quantite' => $accessoire->quantite - $line_accessoire->nombre
                ]);
            }
        }
      $bool=  $reservation->update([
            'status' => Reservation::ACCEPTED,
            'gestionnaire_id' => is_null($gestionnaire) ? null : $gestionnaire->id
        ]);
       $int = DurationHelper::getCreanneauBetwennTimes($reservation->start, $reservation->end);
        for ($i = 1; $i < $int; $i++) {
            $begin = DurationHelper::addCrenneau($reservation->start, $i);
            $agenda = CaseAgenda::query()->where('date_jour', '=', $reservation->date_reservation)
                // ->where('type_jour_id', '=', $reservation->local_group->type_jour_id)
                ->where('heure_debut', '=', $begin)->first();

           /* if (is_null($agenda)) {
                $agenda = CaseAgenda::create([
                    "date_jour" => $reservation->date_reservation,
                    "libelle_jour" => date('D', strtotime($reservation->date_reservation)),
                    "heure_debut" => $begin,
                    "created_at" => new \DateTime('now'),
                    //"type_jour_id" => $reservation->local_group->type_jour_id,
                    "type_jour_id" => null,
                ]);
            }
            $reservation->agenda()->sync($agenda);*/
        }
        if ($bool){
            $this->generateReservation($reservation);
            $this->sendMailUpdate($reservation);
        }

        return redirect()->route('listreservation')->withSuccess('Update successful!');
    }

    public function generateReservation(Reservation $reservation){
        $periode=Periode::query()->find($reservation->periode_id);
        $day_reservation=new \DateTime($reservation->date_reservation);
        $current_month=$day_reservation->format('m');
        $current_year=$day_reservation->format('Y');
        $current_day=$day_reservation->format('d');
        $id_var = getdate(mktime(1, 1, 1, $current_month, $current_day, $current_day));
        $current_week=$day_reservation->format('w');
        $numero_jour=$id_var['wday'];
        if ($periode->frequence==1){//mois
            for ($i=$current_month;$i<12;$i++){
                $day=$current_year.'-'.$i.'-'.$current_day;
                $validDay=DurationHelper::validateDate($day);
                if (!$validDay){
                    $day=$current_year.'-'.$i.'-'.$current_day-1;
                }
                $conge = JourFerie::query()->where('date_debut', '<=', $day)
                    ->where('date_fin', '>=', $day)->first();

                if ($conge) {
                    $contegent = "Periode contegeant";
                } else {
                    $contegent = "Periode non contegeant";
                }

                Reservation::create([
                    'date_reservation'=>$day,
                    'contegent'=>$contegent,
                    'libelle'=>$reservation->libelle,
                    'end'=>$reservation->end ,
                    'periode_id'=>$reservation->periode_id,
                    'user_id'=>$reservation->user_id,
                    'start'=>$reservation->start,
                    'group_local_id'=>$reservation->group_local_id,
                    'local_id'=>$reservation->local_id,
                    'parent_id'=>$reservation->id,
                    'status'=>$reservation->status,
                ]);
            }
        }elseif ($periode->frequence==2){//semaine
            for ($i=$current_week;$i>0;$i++){
                $date=new \DateTime();
                $date->setISODate($current_year,$i,$numero_jour);
                $conge = JourFerie::query()->where('date_debut', '<=', $date)
                    ->where('date_fin', '>=', $date)->first();
                if ($conge) {
                    $contegent = "Periode contegeant";
                } else {
                    $contegent = "Periode non contegeant";
                }
                Reservation::create([
                    'date_reservation'=>$date,
                    'contegent'=>$contegent,
                    'libelle'=>$reservation->libelle,
                    'end'=>$reservation->end ,
                    'periode_id'=>$reservation->periode_id,
                    'user_id'=>$reservation->user_id,
                    'start'=>$reservation->start,
                    'group_local_id'=>$reservation->group_local_id,
                    'local_id'=>$reservation->local_id,
                    'status'=>$reservation->status,
                ]);
            }
        }elseif ($periode->frequence==3){//jour
            $number_day=$day_reservation->format('z')+1;
            for ($i=$number_day;$i<365;$i++){
                $date=\DateTime::createFromFormat('z Y',$i.' '.$current_year);
                $conge = JourFerie::query()->where('date_debut', '<=', $date)
                    ->where('date_fin', '>=', $date)->first();
                if ($conge) {
                    $contegent = "Periode contegeant";
                } else {
                    $contegent = "Periode non contegeant";
                }
                Reservation::create([
                    'date_reservation'=>$date,
                    'contegent'=>$contegent,
                    'libelle'=>$reservation->libelle,
                    'end'=>$reservation->end ,
                    'periode_id'=>$reservation->periode_id,
                    'user_id'=>$reservation->user_id,
                    'start'=>$reservation->start,
                    'group_local_id'=>$reservation->group_local_id,
                    'local_id'=>$reservation->local_id,
                    'status'=>$reservation->status,
                ]);
            }

        }elseif ($periode->frequence==4){//weekend
            $number_day=$day_reservation->format('z')+1;
            for ($i=$number_day;$i<365;$i++){
                $date=\DateTime::createFromFormat('Y z',$current_year.' '.$i);

                $conge = JourFerie::query()->where('date_debut', '<=', $date)
                    ->where('date_fin', '>=', $date)->first();
                $id_var = getdate(mktime(1, 1, 1, $date->format('m'), $date->format('d'), $date->format('y')));
                if ($conge) {
                    $contegent = "Periode contegeant";
                } else {
                    $contegent = "Periode non contegeant";
                }
                if ($id_var['wday']===6||$id_var['wday']===0){
                    Reservation::create([
                        'date_reservation'=>$date,
                        'contegent'=>$contegent,
                        'libelle'=>$reservation->libelle,
                        'end'=>$reservation->end ,
                        'periode_id'=>$reservation->periode_id,
                        'user_id'=>$reservation->user_id,
                        'start'=>$reservation->start,
                        'group_local_id'=>$reservation->group_local_id,
                        'local_id'=>$reservation->local_id,
                        'status'=>$reservation->status,
                    ]);
                }

            }
        }else{

        }
    }
    public function annulerreservation(Request $request)
    {
        $reservation = Reservation::query()->find($request->get('reservation_id'));

        $gestionnaire = Gestionnaire::query()->firstWhere('user_id', '=', $request->user()->id);
        $commentaire = Commentaire::create([
            'message' => $request->get('message'),
            'reservation_id' => $reservation->id,
            'gestionnaire_id' => is_null($gestionnaire) ? null : $gestionnaire->id
        ]);
        $reservation->update([
            'status' => Reservation::DENIED,
            'gestionnaire_id' => is_null($gestionnaire) ? null : $gestionnaire->id
        ]);
        $this->sendMailUpdate($reservation);
        return redirect()->route('listreservation')->withSuccess('Update successful!');
    }

    public function deletereservation($id, Request $request)
    {
        $reservation = Reservation::query()->find($id);
        $lines = LineTypeAccessoire::query()->where('reservation_id', '=', $id)->get();
        foreach ($lines as $line) {
            $line->deleteOrFail();
        }
        $reservation->deleteOrFail();

        return redirect()->route('myreservation')->withSuccess('Delete successful!');
    }

    public function commentairereservation(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $reservation = Reservation::query()->find($request['reservation']);
        $comment = Commentaire::query()->where('reservation_id', '=', $request['reservation'])->first();
        return response()->json(
            $comment
        );
    }
    public function verifyQuantity(Request $request)
    {
        $quantity=$request->get('quantity');
        $id=$request->get('id');
        $type = TypeAccessoire::query()->find($id);
        if ($type->quantite<$quantity){
            $res=[
                'status'=>false,
                'quantity'=>$type->quantite
            ];
        }else{
            $res=[
                'status'=>true,
                'quantity'=>$type->quantite
            ];
        }
       return response()->json(
            $res
        );
    }
    public function listreservation(ReservationDataTable $dataTable)
    {
        $pageTitle = "Liste des reservations";
        $auth_user = AuthHelper::authSession();
        $assets = ['data-table'];
        $headerAction = '';
        return $dataTable->render('global.datatable', compact('pageTitle', 'auth_user', 'assets', 'headerAction'));

    }


    public function signup(Request $request)
    {
        return view('auth.register');
    }

    public function confirmmail(Request $request)
    {
        return view('auth.confirm-mail');
    }

    public function lockscreen(Request $request)
    {
        return view('auth.lockscreen');
    }

    public function recoverpw(Request $request)
    {
        return view('auth.recoverpw');
    }

    public function userprivacysetting(Request $request)
    {
        return view('auth.user-privacy-setting');
    }


    public function sendMail(Reservation $reservation)
    {
        $group=GroupLocal::query()->find($reservation->group_local_id);
        $gestionnaires=$group->gestionnaires;
        $receives=[];
        foreach ($gestionnaires as $gestionnaire){
            $data_ = array('name' => $gestionnaire->account->first_name,
                'content' => "Nouvelle reservation effectue par ".$reservation->user->first_name,
                'reservation'=>$reservation);

            Mail::send(['text' => 'mail'], $data_, function ($message) use ($gestionnaire) {
                $message->to($gestionnaire->account->email, $gestionnaire->account->first_name)->subject("Creation reservation");
                $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
            });
        }
     /*   Mail::to($receives)
            ->cc($reservation->user())
            ->send(new \App\Mail\reservation($reservation));*/

    }
    public function sendMailUpdate(Reservation $reservation)
    {

            $data_ = array('name' => $reservation->user->first_name,
                'content' => "Votre reservation a changé de status".$reservation->user->first_name,
                'reservation'=>$reservation);

            Mail::send(['text' => 'mailupdate'], $data_, function ($message) use ($reservation) {
                $message->to($reservation->user->email, $reservation->user->first_name)->subject("Modification reservation");
                $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
            });


    }

}
