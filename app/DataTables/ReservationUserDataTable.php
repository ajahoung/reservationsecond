<?php

namespace App\DataTables;

use App\Models\Account;
use App\Models\GroupLocal;
use App\Models\Reservation;
use App\Models\ReservationUser;
use App\Models\User;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ReservationUserDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->editColumn('created_at', function ($query) {
                return date('Y/m/d', strtotime($query->created_at));
            })
            ->editColumn('status', function ($query) {
                $status = 'PENDING';
                switch ($query->status) {
                    case 'ACCEPTED':
                        $status = 'primary';
                        break;
                    case 'DENIED':
                        $status = 'danger';
                        break;
                    case 'PENDING':
                        $status = 'dark';
                        break;
                }
                return '<span class="text-capitalize badge bg-' . $status . '">' . $query->status . '</span>';
            })
            ->editColumn('user.account', function ($query) {
                $account = User::query()->firstWhere('id', '=', $query->user_id);
                return $account->first_name . ' ' . $account->last_name;
            })
            ->editColumn('local_group.typejour', function ($query) {
                $group = GroupLocal::query()->find($query->group_local_id);
                //$typejour = $group->type_jour_id;
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
                $group = GroupLocal::query()->where('parent_id','=','0')->find($query->group_local_id);
                $typesalle = $group->typesalle;
                return $typesalle->type;
            })
            ->addColumn('action', function ($query) {
                if ($query->status == 'PENDING') {
                    return '<div class="btn-group-sm"><a class="btn btn-sm btn-danger" href="' . route('deletereservation', ['id' => $query->id]) . '">Supprimer</a></div>';
                } elseif ($query->status == 'DENIED'){
                    return '<div class="btn-group-sm"><a class="btn btn-sm btn-primary"  onclick=getComment("'.$query->id.'") data-bs-toggle="modal" data-bs-target="#comment-reservation">Commentaire</a></div>';
                } else {
                    return '';
                }

            })
            ->rawColumns(['action', 'status']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Reservation $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Reservation $model)
    {
        $user_id =auth()->user()->id ;
        return $model->newQuery()
            ->where('parent_id','=','0')
            ->where('user_id', '=', $user_id)
            ->with(['user', 'local','periode'])->orderByDesc('id');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('reservationuser-table')
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
            ['data' => 'periode.libelle', 'name' => 'Periode', 'title' => 'Periode'],
            ['data' => 'user.account', 'name' => 'User', 'title' => 'User'],
            ['data' => 'start', 'name' => 'Heure debut', 'title' => 'Heure debut'],
            ['data' => 'end', 'name' => 'Heure de fin', 'title' => 'Heure de fin'],
            ['data' => 'local_group.typejour', 'name' => 'Type jour', 'title' => 'Type jour'],
            ['data' => 'local_group.typesalle', 'name' => 'Type salle', 'title' => 'Type salle'],
            ['data' => 'local.libelle', 'name' => 'Local', 'title' => 'Local'],
            ['data' => 'date_reservation', 'name' => 'Date de reservation', 'title' => 'Date de reservation'],
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
        return 'ReservationUser_' . date('YmdHis');
    }
}
