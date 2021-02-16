@extends('layouts.admin')

@section('title', 'Roles')
@section('description', 'Roles management')

@section('header')
    <h1>
        Roles <small>roles management</small>
    </h1>
    <div class="toolbar-item toolbar-primary">
        <div class="btn-group offset-right">
            @can('user.view')
            <a href="{{ route('users.index') }}" class="btn btn-default oc-icon-reply-all ion-ios-home"> @lang('backend::user.user')</a>
            @endcan
            @can('role.view')
            <a href="{{ route('roles.index') }}" class="btn btn-primary oc-icon-reply-all ion-ios-home"> @lang('backend::user.role')</a>
            @endcan
            @can('perm.view')
            <a href="{{ route('perms.index') }}" class="btn btn-default oc-icon-trash ion-ios-briefcase"> @lang('backend::user.perm')</a>
            @endcan
        </div>
    </div>
@endsection

@section('content:class', 'no-padding')
@section('content')

<div class="content row">
    @alert
    
    <!-- Tab header -->
    <ul data-toggle="ajax-tab" class="nav nav-tabs profile" role="tablist">
        <li class=""><a href="{{ route('users.index') }}" data-toggle="tooltip" data-placement="right" title="Back to user"><i class="ion ion-chevron-left"></i></a></li>
        <li class="active"><a role="tab" data-toggle="tab" class="active" href="#tab-general" data-target="#tab-general" data-type="">General</a></li>
        @can('role.create')
        <button class="btn btn-success btn-tab-header btn-add-field pull-right" data-toggle="modal" data-target="#AddModal">Add Role</button>
        @end
    </ul>

    <!-- Tab content -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="tab-general">
            <div class="tab-content">
                <div class="panel infolist">
                    <div class="panel-body">
                        <!-- Show datatables -->
                        <div class="box-body no-padding">
                            <table id="example" class="table table-condensed table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Level</th>
                                        <th>Status</th>
                                        <th>Created</th>
                                        <th>Updated</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach( $nodes as $k => $item )
                                    <tr id="row-{{ $item->id }}">
                                        <td class="text-center">{{ $k + 1 }}.</td>
                                        <td>{{ $item->id }}</td>
                                        <td>
                                        <a href="{{ route('roles.show', $item->id) }}">{{ $item->name }}</a>
                                        </td>
                                        <td>{{ $item->about }}</td>
                                        <td>{{ $item->level }}</td>
                                        <td>
                                            @if($item->status)
                                            <span class="label label-success">Enable</span>
                                            @else
                                            <span class="label label-danger">Disable</span>
                                            @endif
                                        </td>
                                        <td>{{ $item->created }}</td>
                                        <td>{{ $item->updated }}</td>
                                        <td>
                                            @can('role.update')
                                            <a href="{{ route('roles.edit', $item->id) }}#tab-access" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>
                                            @end

                                            @can('role.view')
                                            <a href="{{ route('roles.show', $item->id) }}#tab-access" class="btn btn-primary btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-street-view"></i></a>
                                            @end

                                            @can('role.delete')
                                            <a class="btn btn-danger btn-xs" data-toggle="modal" onclick="ui.delete('{{ $item->id }}')" data-target="#delete-modal"><i class="fa fa-times"></i></a>
                                            @end
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- End: Show datatable -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@can('role.create')
<!-- Show create form modal -->
<div class="modal fade" id="AddModal" role="dialog" aria-labelledby="configModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="configModalLabel">Add Role</h4>
            </div>
            <form action="{{ route('roles.store') }}" method="POST" id="node-add-form" novalidate="novalidate" accept-charset="UTF-8">
                @csrf
                <div class="modal-body">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="_id">Id* :</label>
                            <input class="form-control" placeholder="Enter role id" data-rule-maxlength="250" required="1" name="_id" type="text" value="" aria-required="true">
                        </div>
                        <div class="form-group">
                            <label for="name">Name* :</label>
                            <input class="form-control" placeholder="Enter role name" data-rule-maxlength="250" required="1" name="name" type="text" value="" aria-required="true">
                        </div>
                        <div class="form-group">
                            <label for="description">Description* :</label>
                            <textarea class="form-control" placeholder="Enter role description" data-rule-maxlength="1000" cols="30" rows="3" name="about" required="1" aria-required="true"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="level">Level :</label>
                            <input class="form-control" placeholder="Enter role level" data-rule-maxlength="3" required="1" name="level" type="number" value="" aria-required="true">
                        </div>
                        <div class="form-group">
                            <label for="status">Status :</label>
                            <select class="form-control" required="1" data-placeholder="Select status" rel="select2" name="status">
                                <option value="0">Disable</option>
                                <option value="1" selected="selected">Enable</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <input class="btn btn-success" type="submit" value="Submit">
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End: Show create form modal -->
@endcan

<!-- Show delete confirm -->
<div id="delete-modal" class="modal fade text-danger" role="dialog">
    <div class="modal-dialog ">
        <!-- Modal content-->
        <form action="" id="delete-form" method="POST" accept-charset="UTF-8">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title text-center">Delete confirmation</h4>
                </div>
                <div class="modal-body">
                    @csrf
                    @method('DELETE')
                    <p class="text-center">Are you sure want to delete ?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger" data-dismiss="modal" onclick="ui.submit()">Delete</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- End: show delete confirm -->

@endsection

@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/plugins/datatables/datatables.min.css') }}"/>
@endpush

@push('scripts')
    <script src="{{ asset('admin/plugins/datatables/datatables.min.js') }}"></script>
    <script>
    /**
     * DataTable handle
     * @file roles/index
     */
    var table = null;

    $(function () {
        table = $("#example").DataTable({
            processing: false,
            serverSide: false, // Disable server request data 
            paging: false,
            searching: false,
            language: {
                lengthMenu: "_MENU_",
                search: "_INPUT_",
                searchPlaceholder: "Search"
            },
            columnDefs: [ { orderable: false, targets: [-1] }],
        });

        $("#node-add-form").validate({
            
        });
    });

    var ui = ui || {};

    /**
     * Form delete action
     */
    ui.role = '';
    ui.delete = function(id) 
    {
        ui.role = id;

        console.log('[roles] delete ', id);
        var pattern = '{{ route("roles.destroy", ":id") }}';
        var action  = pattern.replace(':id', id);
        $("#delete-form").attr('action', action);
    }

    ui.submit = function()
    {
        $.ajax({
            url: $("#delete-form").attr('action'),
            type: 'POST',
            dataType: 'json',
            data: {
                '_method': 'DELETE',
                '_token': '{{ csrf_token() }}',
            },
            success: function (data) {
                console.log('[roles] reload table', ui.role);
                table.row("#row-" + ui.role).remove().draw();
                ui.message(data.message);
            }
        });
    }
    </script>
@endpush