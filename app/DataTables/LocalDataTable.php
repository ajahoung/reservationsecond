<?php

namespace App\DataTables;

use App\Models\GroupLocal;
use App\Models\Local;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class LocalDataTable extends DataTable
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
            ->addColumn('action', function ($query) {

                return '<div class="btn-group btn-group-sm">
               <a class="btn btn-sm btn-success" href="' . route('localedit', ['id' => $query->id]) . '">Modifier</a>
                 <a class="btn btn-sm btn-danger" href="' . route('localdelete', ['id' => $query->id]) . '">Supprimer</a></div>';

            })
            ->rawColumns(['action', 'status']);;

    }

    /**
     * Get query source of dataTable.
     *
     * @param Local $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $model = Local::query()->with('group_locals');
        return $this->applyScopes($model);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('local-table')
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
            Column::make('id'),
            Column::make('libelle'),
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
        return 'Local_' . date('YmdHis');
    }
}
