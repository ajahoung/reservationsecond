<?php

namespace App\DataTables;

use App\Models\JourFerie;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class JourFerieDataTable extends DataTable
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
               <a class="btn btn-sm btn-success" href="' . route('congeferieedit', ['id' => $query->id]) . '">Modifier</a>
                 <a class="btn btn-sm btn-danger" href="' . route('congeferiedelete', ['id' => $query->id]) . '">Supprimer</a></div>';

            })
            ->rawColumns(['action', 'status']);;
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\JourFerie $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(JourFerie $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('jourferie-table')
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
            Column::make('date_debut'),
            Column::make('date_fin'),
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
        return 'JourFerie_' . date('YmdHis');
    }
}
