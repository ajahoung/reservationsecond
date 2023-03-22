<?php


namespace App\DataTables;


use App\Models\Gestionnaire;
use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Services\DataTable;

class GestionnaireDataTable extends DataTable
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
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param Gestionnaire $model
     * @return Builder
     */
    public function query(Gestionnaire $model)
    {
        /*        $model = Personnel::query()->with('account');
                return $this->applyScopes($model);*/
        return $model->newQuery()->with(['account']);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('gestionnaire-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(0)
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
            ['data' => 'id', 'name' => 'id', 'title' => 'ID'],

            ['data' => 'account.email', 'name' => 'email', 'title' => 'Email'],
            ['data' => 'account.first_name', 'name' => 'First name', 'title' => 'First name'],
            ['data' => 'account.last_name', 'name' => 'Last name', 'title' => 'Last name'],
            ['data' => 'account.phone_number', 'name' => 'Phone', 'title' => 'Phone'],
            ['data' => 'created_at', 'name' => 'Date creation', 'title' => 'Date creation'],

        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'gestionnaire_' . date('YmdHis');
    }
}
