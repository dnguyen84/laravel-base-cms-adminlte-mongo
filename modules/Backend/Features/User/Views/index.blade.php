@extends('layouts.admin')

@section('title', 'Users')
@section('description', 'Users listing')

@section('header')
    <h1>
        @lang('backend::user.user') <small>@lang('backend::user.user text')</small>
    </h1>
    <div class="toolbar-item toolbar-primary">
        <div class="btn-group offset-right">
            @can('user.view')
            <a href="{{ route('users.index') }}" class="btn btn-primary oc-icon-reply-all ion-ios-home"> @lang('backend::user.user')</a>
            @endcan
            @can('role.view')
            <a href="{{ route('roles.index') }}" class="btn btn-default oc-icon-reply-all ion-ios-home"> @lang('backend::user.role')</a>
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
    <!-- Tab header -->
    <ul data-toggle="ajax-tab" class="nav nav-tabs profile" role="tablist">
        <li class=""><a href="{{ route('users.index') }}" data-toggle="tooltip" data-placement="right" title="Back to dashboard"><i class="ion ion-chevron-left"></i></a></li>
        <li class="active"><a role="tab" data-toggle="tab" class="active" href="#tab-general" data-target="#tab-general" data-type=""><i class="fa fa-bars"></i> @lang('backend::user.user')</a></li>
        <li class=""><a role="tab" data-toggle="tab" href="#" data-target="#tab-publisher" data-type="publisher"><i class="fa fa-gift"></i> @lang('backend::user.publisher')</a></li>
        <li class=""><a role="tab" data-toggle="tab" href="#" data-target="#tab-sponsor" data-type="sponsor"><i class="fa fa-cart-plus"></i> @lang('backend::user.sponsor')</a></li>
        <li class=""><a role="tab" data-toggle="tab" href="#" data-target="#tab-school" data-type="school"><i class="fa fa-cart-plus"></i> @lang('backend::user.school')</a></li>
        <li class=""><a role="tab" data-toggle="tab" href="#" data-target="#tab-admin" data-type="admin"><i class="fa fa-users"></i> @lang('backend::user.admin')</a></li>
        <li class=""><a role="tab" data-toggle="tab" href="#" data-target="#tab-manager" data-type="manager"><i class="fa fa-users"></i> @lang('backend::user.manager')</a></li>
        @can('user.create')
        <a href="{{ route('users.create') }}" class="btn btn-success btn-tab-header btn-add-field pull-right"> @lang('backend::user.user new')</a>
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
                            <table id="example" class="table table-condensed table-bordered table-hover responsive">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>@lang('backend::user.name')</th>
                                        <th>@lang('backend::user.email')</th>
                                        <th>@lang('backend::user.roles')</th>
                                        <th class="text-center">@lang('backend::user.status')</th>
                                        <th>@lang('backend::user.action')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                        <!-- End: Show datatables -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
</div>

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
     * @file config/index
     */
    var filter = '';
    var table = null;

    $(function () {
        table = $("#example").DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                type: 'GET',
                url: cedu.route('/users/ajax'),
                data: (data) => {
                    data.type = filter;
                }
            },
            language: {
                lengthMenu: "_MENU_",
                search: "_INPUT_",
                searchPlaceholder: "Search"
            },
            lengthMenu: [ 20, 50, 75, 100 ],
            pageLength: 20,
            columns: [
                {data: "_id", orderable: true},
                {data: "name", orderable: true},
                {data: "email", orderable: true},
                {data: "roles", orderable: true},
                {data: "status", orderable: true},
                {data: "action", orderable: false},
            ]
        });

        // Event when user click to tab filter
        $('[data-type]').click(function() {
            filter = $(this).data('type');
            table.ajax.reload();
        });

        // Event for validate form
        $("#add-form").validate({
            
        });

        /**
         * Delete confirm
         */
        $(document).on('submit', '.delete', function() {
            return confirm('Are you sure ?');
        });
    });
    </script>
@endpush