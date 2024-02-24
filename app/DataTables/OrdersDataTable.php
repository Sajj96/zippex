<?php

namespace App\DataTables;

use App\Models\Order;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class OrdersDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('user', function ($row) {
                return $row->userName;
            })
            ->addColumn('address', function ($row) {
                return $row->userAddress;
            })
            ->addColumn('created_on', function ($row) {
                return date('M d Y', strtotime($row->created_at));
            })
            ->addColumn('status', function ($row) {
                if ($row->status == 0) {
                    return '<span class="badge badge-warning mr-2">Pending</span>';
                } else if ($row->status == 2) {
                    return '<span class="badge badge-success mr-2">Confirmed</span>';
                } else {
                    return '<span class="badge badge-danger mr-2">Cancelled</span>';
                }
            })
            ->addColumn('action', function ($row) {
                return '
                    <div class="d-flex">
                        <a href="' . route("order.show", $row->id) . '" class="btn btn-primary btn-sm"><i class="zmdi zmdi-eye"></i></a>
                        <form class="delete-form" action="' . route("order.delete") . '" method="POST">
                            <input type="hidden" name="_token" value="' . csrf_token() . '">
                            <input type="hidden" value="' . $row->id . '" name="order_id">
                            <button type="submit" class="btn btn-danger btn-sm"><i class="zmdi zmdi-delete"></i></button>
                        </form>
                    </div>
                ';
            })
            ->rawColumns(['action', 'status'])
            // ->startsWithSearch()
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Order $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('orders-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(1)
            ->selectStyleSingle()
            ->buttons([
                Button::make('excel'),
                Button::make('csv'),
                Button::make('pdf')
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('id')
                ->data('DT_RowIndex'),
            Column::make('code'),
            Column::make('user'),
            Column::make('address'),
            Column::make('status'),
            Column::make('created_on'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(80)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Orders_' . date('YmdHis');
    }
}
