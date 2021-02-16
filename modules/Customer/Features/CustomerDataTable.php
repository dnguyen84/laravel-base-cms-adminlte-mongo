<?php

namespace Modules\Customer\Features;

use Auth;
use Datatables;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class CustomerDataTable
{
    /**
     * DataTable only columns
     */
    protected $only = [
        'name',
        'email',
        'username',
        'nickname',
        'updatedAt',
        'action'
    ];

    /**
     * DataTable raw columns
     */
    protected $columns = [
        'name',
        'email',
        'username',
        'nickname',
        'updatedAt',
        'action'
    ];

    /**
     * Build datatable data
     * @example $datatable->build()->toJson();
     */
    public function build()
    {
        $this->user = Auth::user();

        $query = Setting::query();

        if (request()->input('filter') == 'trash') {
            $query->onlyTrashed();
        }

        $datatable = Datatables::from($query);
        $datatable->only($this->only);
        $datatable->rawColumns($this->columns);

        $datatable->editColumn('name', function(Customer $node) {
            if ($node->trashed()) {
                return $node->name;
            }
            return '<a class="" href="' . route('customers.edit', $node->id) . '">' . $node->name . '</a>';
        });

        $datatable->editColumn('value', function(Customer $node) {
            return $node->valueText;
        });

        $datatable->editColumn('status', function(Customer $node) {
            if ($node->trashed()) {
                return '<span class="label label-danger">Trash</span>';
            }
            if ($node->status) {
                return '<span class="label label-success">Enable</span>';
            } else {
                return '<span class="label label-danger">Disable</span>';
            }
        });

        $datatable->addColumn('action', function(Customer $node) {
            $html = '';

            if ($node->trashed()) {
                // Check for restore action
                if ($this->user->can('setting.delete', $node)) {
                    $html .= '<a class="btn btn-sm btn-default" data-toggle="modal" onclick="ui.restore(\'' . $node->id . '\')"><i class="fa fa-trash text-success"></i></a>';
                }
                return $html;
            }

            if ($this->user->can('setting.update')) {
                $html .= '<a href="' . route('customers.edit',  $node->id) . '" class="btn btn-sm btn-default btn-action"><i class="fa fa-edit text-success"></i></a>';
            }

            if ($this->user->can('setting.delete')) {
                $html .= '<a class="btn btn-sm btn-default" data-toggle="modal" onclick="ui.delete(\'' . $node->id . '\')" data-target="#delete-modal"><i class="fa fa-times text-red"></i></a>';
            }
            return $html;
        });

        $datatable->filter(function ($query) {
            if ($filter = request()->input('filter')) {
                if ($filter == 'active') {
                    $query->where('status', 1);
                }

                if ($filter == 'inactive') {
                    $query->where('status', 0);
                }

                if ($filter == 'startup') {
                    $query->where('startup', true);
                }
            }

            if ($search = request()->input('search.value')) {
                $field = 'name';
                $operator = 'like';

                if (Str::contains($search, ':')) {
                    list($field, $search) = explode(':', $search);
                }

                if ($field == 'id') {
                    $field = '_id';
                    $operator = '=';
                } else {
                    $search = '%' . $search . '%';
                }

                $field = trim($field);
                $search = trim($search);
                $query->where($field, $operator, $search);
            }
        });

        return $datatable;
    }
}