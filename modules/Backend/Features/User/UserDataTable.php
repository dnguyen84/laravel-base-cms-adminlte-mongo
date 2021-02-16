<?php

namespace Modules\Backend\Features\User;

use Auth;
use Datatables;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class UserDataTable
{
    /**
     * DataTable only columns
     */
    protected $only = [
        '_id', 
        'name', 
        'email', 
        'roles', 
        'status', 
        'action'
    ];

    /**
     * DataTable raw columns
     */
    protected $columns = [
        'name', 
        'roles', 
        'status', 
        'action'
    ];

    /**
     * Build datatable filter query
     */
    public function filter($query)
    {
        // Check for filter:type
        if ($type = request()->input('type')) {
            $query->where('roles', 'all', [$type]);
        }

        // Check for filter:search
        if ($search = request()->input('search.value')) {
            $field = 'search';
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
    }

    /**
     * Build datatable data
     * @example $datatable->build()->toJson();
     */
    public function build()
    {
        $query = User::query();

        $datatable = Datatables::from($query);
        $datatable->only($this->only);
        $datatable->rawColumns($this->columns);

        $datatable->editColumn('name', function(User $node) {
            return '<a class="" href="' . route('users.show', $node->_id) . '">' . $node->name . '</a>';
        });

        $datatable->editColumn('roles', function(User $node) {
            return $this->formatRoles($node);
        });

        $datatable->editColumn('status', function(User $node) {
            return $this->formatStatus($node);
        });

        $datatable->addColumn('action', function(User $node) {
            return $this->formatAction($node);
        });

        $datatable->filter(function ($query) {
            return $this->filter($query);
        });

        return $datatable;
    }

    protected function formatRoles(User $node)
    {
        $roles = $node->roles ?? [];

        sort($roles);

        $text = implode(',', $roles);

        // highlighting role filter
        $search = request()->input('type');
        if ($search) {
            $text = str_replace($search, '<strong class="text-red">' . $search . '</strong>', $text);
        }

        return $text;
    }

    protected function formatStatus(User $node)
    {
        return "<span class=\"label label-{$node->statusColor}\">{$node->statusName}</span>";
    }

    protected function formatAction(User $node)
    {
        // Show action buttons
        $html = '';

        // Check for edit action
        if (Auth::user()->can('user.update', $node)) {
            $html .= '<a href="' . route('users.edit',  $node->_id) . '" class="btn btn-sm btn-default btn-action" style="display:inline;padding:2px 5px 3px 5px;margin-right:5px;"><i class="fa fa-edit text-success"></i></a>';
        }

        // Check for delete action
        if (Auth::user()->can('user.delete', $node)) {
            $html .= '<form class="delete" method="POST" action="' . route('users.destroy', $node->_id) .'" accept-charset="UTF-8" style="display:inline">';
            $html .= '<input name="_method" type="hidden" value="DELETE">';
            $html .= csrf_field();
            $html .= '<button class="btn btn-sm btn-default" type="submit"><i class="fa fa-times text-red"></i></button>';
            $html .= '</form>';
        }

        return $html;
    }
}