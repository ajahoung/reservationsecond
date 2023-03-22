<?php

namespace App\DataTables;

use App\Models\Gestionnaire;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Services\DataTable;

class PersonnelDataTable extends DataTable
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
    public function query(User $model)
    {
        return $model->newQuery()->where('user_type','=','admin')
            ->orWhere('user_type','=','super_admin');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('personnel-table')
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

            ['data' => 'email', 'name' => 'email', 'title' => 'Email'],
            ['data' => 'first_name', 'name' => 'First name', 'title' => 'First name'],
            ['data' => 'last_name', 'name' => 'Last name', 'title' => 'Last name'],
            ['data' => 'phone_number', 'name' => 'Phone', 'title' => 'Phone'],
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
        return 'Personnel_' . date('YmdHis');
    }
}
