@extends('layouts.admin')

@section('title', 'Settings')
@section('description', 'Settings management')

@section('header')
<h1>
    Configuration <small>Configuration management</small>
</h1>
@endsection

@section('content:class', 'no-padding')
@section('content')
<div class="content row">
    <!-- Tab header -->
    <ul data-toggle="ajax-tab" class="nav nav-tabs profile" role="tablist">
        <li><a href="{{ route('admin.index') }}" data-toggle="tooltip" data-placement="right" title="Back to dashboard"><i class="ion ion-chevron-left"></i></a></li>
        <li class="active"><a role="tab" data-toggle="tab" class="active" href="#tab-general" data-filter="">Setting </a></li>
        <li><a role="tab" data-toggle="tab" href="#" data-filter="active"><i class="fa fa-toggle-on text-success"></i>Active</a></li>
        <li><a role="tab" data-toggle="tab" href="#" data-filter="inactive"><i class="fa fa-toggle-off text-warning"></i>Disable</a></li>
        <li><a role="tab" data-toggle="tab" href="#" data-filter="trash"><i class="fa fa-toggle-off text-red"></i>Trash</a></li>
        <li><a role="tab" data-toggle="tab" href="#" data-filter="startup"><i class="fa fa-star-o text-info"></i>Startup</a></li>
        @can('setting.create')
        <button class="btn btn-primary btn-tab-header pull-right" data-toggle="modal" data-target="#add-modal">Add new</button>
        @endcan
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
                                        @foreach( $columns as $col )
                                        <th>{{ ucfirst($col) }}</th>
                                        @endforeach

                                        @if($actions)
                                        <th>Actions</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@can('setting.create')
<div class="modal fade" id="add-modal" role="dialog" aria-labelledby="config-modal-label">
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="config-modal-label">Add Config</h4>
        </div>
        <form action="{{ route('settings.store') }}" method="POST" id="role-add-form" novalidate="novalidate" accept-charset="UTF-8">
            @csrf
            <div class="modal-body">
                <div class="box-body">
                    <div class="form-group">
                        <label for="_id">Key* :</label>
                        <input class="form-control" placeholder="Enter config key, e.g: content.type" data-rule-maxlength="250" required="1" name="_id" type="text" value="" aria-required="true">
                    </div>
                    <div class="form-group">
                        <label for="description">Name* :</label>
                        <input class="form-control" placeholder="Enter config name, e.g: Content type defination" data-rule-maxlength="1000" cols="30" rows="3" name="name" required="1" aria-required="true">
                    </div>
                    <div class="form-group">
                        <label for="description">Format :</label>
                        <select class="form-control" required="1" data-placeholder="Select data format" rel="select2" name="format">
                            <option value="text">Text</option>
                            <option value="number">Number</option>
                            <option value="json">Json</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="data">Data* :</label>
                        <textarea class="form-control" placeholder="Enter config data" data-rule-maxlength="1000" cols="30" rows="3" name="value" required="1" aria-required="true"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="description">Status :</label>
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
@endcan

@endsection

@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('admin/plugins/datatables/datatables.min.css') }}"/>
@endpush

@push('scripts')
<script src="{{ asset('admin/plugins/autoresize/autosize.min.js') }}"></script>
<script src="{{ asset('admin/plugins/datatables/datatables.min.js') }}"></script>
<script>

/**
 * Handle table event
 */
var ui = ui || {};

/**
 * DataTable handle
 * @file config/index
 */
$(function () {
    ui.filter = '';
    ui.table = $("#example").DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            type: 'GET',
            url: '{{ route("settings.ajax") }}',
            data: (data) => {
                data.filter = ui.filter;
            }
        },
        language: {
            lengthMenu: "_MENU_",
            search: "_INPUT_",
            searchPlaceholder: "Search"
        },
        columns: [
            {data: "name", orderable: true},
            {data: "format", orderable: true},
            {data: "value", orderable: true},
            {data: "status", orderable: true},
            {data: "updated", orderable: true},
            {data: "action", orderable: false},
        ]
    });

    $("#role-add-form").validate({
        
    });

    $('[data-filter]').click(function() {
        ui.filter = $(this).data('filter');
        ui.table.ajax.reload();
    });

    /**
     * Add summary auto resize
     */
    autosize($('[name="value"]'));
});

ui.delete = function (id) {
    var pattern = '{{ route("settings.destroy", ":id") }}';
    var action = pattern.replace(':id', id);
    $("#delete-form").attr('action', action);
}

ui.restore = function (id) {
    var pattern = '{{ route("settings.restore", ":id") }}';
    var action = pattern.replace(':id', id);

    $.ajax({
        url: action,
        type: 'POST',
        dataType: 'json',
        data: {
            '_method': 'POST',
            '_token': '{{ csrf_token() }}',
        },
        success: function (data) {
            ui.message(data.message);
            ui.table.ajax.reload();
        }
    });
}

ui.submit = function () {
    $.ajax({
        url: $("#delete-form").attr('action'),
        type: 'POST',
        dataType: 'json',
        data: {
            '_method': 'DELETE',
            '_token': '{{ csrf_token() }}',
        },
        success: function (data) {
            ui.message(data.message);
            ui.table.ajax.reload();
        }
    });
}

</script>
@endpush

@alertjs