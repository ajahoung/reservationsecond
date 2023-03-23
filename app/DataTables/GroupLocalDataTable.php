<?php

namespace App\DataTables;

use App\Models\GroupLocal;
use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class GroupLocalDataTable extends DataTable
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
            ->editColumn('type_jour_id', function ($query) {
                if ($query->type_jour_id==1){
                    return "Jours scolaire";
                }else{
                    return "Congés & Féries";
                }

            });
    }

    /**
     * Get query source of dataTable.
     *
     * @return Builder
     */
    public function query()
    {
        $model = GroupLocal::query()
            ->with('typesalle');
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
                    ->setTableId('grouplocal-table')
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
            Column::make('libelle'),
            Column::make('typesalle.type'),
           // ['data' => 'typesalle.type', 'name' => 'Type de salle', 'title' => 'Type de salle'],
            ['data' => 'type_jour_id', 'name' => 'Type de jour', 'title' => 'Type de jour'],
            Column::make('horaire_reservation'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'GroupLocal_' . date('YmdHis');
    }
}
