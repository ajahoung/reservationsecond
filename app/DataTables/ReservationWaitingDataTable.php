<?php

namespace App\DataTables;

use App\Models\Account;
use App\Models\GroupLocal;
use App\Models\Reservation;
use App\Models\ReservationWaiting;
use App\Models\User;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ReservationWaitingDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {        return datatables()
        ->eloquent($query)
        ->editColumn('created_at', function($query) {
            return date('Y/m/d',strtotime($query->created_at));
        })
        ->editColumn('status', function($query) {
            $status = 'PENDING';
            switch ($query->status) {
                case 'ACCEPTED':
                    $status = 'primary';
                    break;
                case 'REFUSED':
                    $status = 'danger';
                    break;
                case 'PENDING':
                    $status = 'dark';
                    break;
            }
            return '<span class="text-capitalize badge bg-'.$status.'">'.$query->status.'</span>';
        })
        ->editColumn('local_group.typejour', function ($query) {
            $group = GroupLocal::query()->find($query->group_local_id);
            switch ($group->type_jour_id){
                case 1:
                    $typejour="Jours scolaire";
                    break;
                case 2:
                    $typejour="Jours feriés";
                    break;
                case 3:
                    $typejour="Weekends";
                    break;
                case 4:
                    $typejour="Congés";
                    break;

            }
            return $typejour;
        })
        ->editColumn('local_group.typesalle', function ($query) {
            $group = GroupLocal::query()->find($query->group_local_id);
            $typesalle = $group->typesalle;
            return $typesalle->type;
        })
        ->editColumn('user.account', function($query) {
            $account=User::query()->find($query->user_id);
            return $account->first_name.' '.$account->last_name;
        })
        ->addColumn('action', function ($query){
            if ($query->status == 'PENDING'){
                return '<div class="btn-group-sm"><a class="btn btn-sm btn-success" href="'.route('activatereservation',['id'=>$query->id]).'">Valider</a>
                 <a class="btn btn-sm btn-danger" onclick=getId("'.$query->id.'") data-bs-toggle="modal"  data-bs-target="#refused-reservation">Refuser</a></div>';
            }else{
                return '';
            }

        })
        ->rawColumns(['action','status']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Reservation $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Reservation $model)
    {
        return $model->newQuery()
            ->where('status','=','PENDING')
            ->with(['user','user:first_name','local','periode']);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('reservationwaiting-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(1)
                    ->buttons(
                        Button::make('create'),
                        Button::make('export'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    );
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            ['data' => 'status', 'name' => 'status', 'title' => 'Status'],
            Column::make('libelle'),
           // ['data' => 'periode.libelle', 'name' => 'Periode', 'title' => 'Periode'],
            ['data' => 'user.account', 'name' => 'user.first_name', 'title' => 'User'],
            ['data' => 'start', 'name' => 'start', 'title' => 'Heure debut'],
            ['data' => 'end', 'name' => 'end', 'title' => 'Heure de fin'],
            ['data' => 'local_group.typejour', 'name' => 'group_local_id', 'title' => 'Type jour'],
            ['data' => 'local_group.typesalle', 'name' => 'group_local_id', 'title' => 'Type salle'],
            ['data' => 'local.libelle', 'name' => 'local.libelle', 'title' => 'Local'],
            ['data' => 'date_reservation', 'name' => 'date_reservation', 'title' => 'Date reservation'],
            ['data' => 'periode.libelle', 'name' => 'periode_id', 'title' => 'Periodicite'],
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->searchable(false)
                ->width(60)
                ->addClass('text-center hide-search'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'ReservationWaiting_' . date('YmdHis');
    }
}
