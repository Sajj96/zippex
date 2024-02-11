<?php

namespace App\DataTables;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ProductsDataTable extends DataTable
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
            ->addColumn('image', function ($row) {
                return '<img src="'.$row->image_path.'" width="48" alt="Product img">';
            })
            ->addColumn('category', function ($row) {
                return $row->categoryName;
            })
            ->addColumn('created_on', function ($row) {
                return date('M d Y', strtotime($row->created_at));
            })
            ->addColumn('action', function($row){
                return '
                    <div class="d-flex">
                        <a href="'.route("product.show",$row->id).'" class="btn btn-primary btn-sm"><i class="zmdi zmdi-eye"></i></a>
                        <a href="'.route("product.edit",$row->id).'" class="btn btn-primary btn-sm"><i class="zmdi zmdi-edit"></i></a>
                        <form class="delete-form" action="'.route("product.delete").'" method="POST">
                            <input type="hidden" name="_token" value="'.csrf_token().'">
                            <input type="hidden" value="'.$row->id.'" name="product_id">
                            <button type="submit" class="btn btn-danger btn-sm"><i class="zmdi zmdi-delete"></i></button>
                        </form>
                    </div>
                ';
            })
            ->rawColumns(['action', 'image'])
            ->startsWithSearch()
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Product $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('products-table')
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
            Column::make('image'),
            Column::make('name'),
            Column::make('category'),
            Column::make('price'),
            Column::make('quantity'),
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
        return 'Products_' . date('YmdHis');
    }
}
