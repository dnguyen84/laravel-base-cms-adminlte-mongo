@extends('layouts.admin')

@section('title', 'Role edit')
@section('description', 'Role edit')

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
        <li class=""><a href="{{ route('roles.index') }}" data-toggle="tooltip" data-placement="right" title="Back to roles"><i class="ion ion-chevron-left"></i></a></li>
        <li class="active"><a role="tab" data-toggle="tab" class="active" href="#tab-general-info" data-target="#tab-info">General</a></li>
        <li class=""><a role="tab" data-toggle="tab" href="#tab-access" data-target="#tab-access">Access</a></li>
    </ul>

    <!-- Tab content -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active fade in" id="tab-info">
            <div class="tab-content">
                <div class="panel infolist">
                    <div class="panel-default panel-heading">
                        <h4>General</h4>
                    </div>
                    <div class="panel-body">
                        <!-- Show save errors message -->
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <!-- End: Show errors message -->
                        
                        <!-- Form: role edit -->
                        <form action="{{ route('roles.update', $node->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="id" class="col-md-2">ID :</label>
                                <div class="col-md-6 fvalue">{{ $node->id }}</div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-md-2">Name :</label>
                                <div class="col-md-6 fvalue">
                                    <input class="form-control" placeholder="Enter role name" data-rule-maxlength="250" required="1" name="name" type="text" value="{{ $node->name }}" aria-required="true">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="description" class="col-md-2">Description :</label>
                                <div class="col-md-6 fvalue">
                                    <textarea class="form-control" style="height:150px" name="about" placeholder="Enter role description">{{ $node->about }}</textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="level" class="col-md-2">Level :</label>
                                <div class="col-md-6 fvalue">
                                    <input class="form-control" placeholder="Enter role level" data-rule-maxlength="3" required="1" name="level" type="number" value="{{ $node->level }}" aria-required="true">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="status" class="col-md-2">Status :</label>
                                <div class="col-md-6 fvalue">
                                    {!! Form::select('status', ['0' => 'Disable', '1' => 'Enable'], $node->status, ['class' => 'form-control', 'rel' => 'select2']) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="created" class="col-md-2">Created :</label>
                                <div class="col-md-6 fvalue">{{ $node->created }}</div>
                            </div>

                            <div class="form-group">
                                <label for="updated" class="col-md-2">Updated :</label>
                                <div class="col-md-6 fvalue">{{ $node->updated }}</div>
                            </div>

                            <div class="form-group">
                                <label for="updated" class="col-md-2"></label>
                                <div class="col-md-6 fvalue">
                                    <button type="submit" class="btn btn-primary" style="margin-right: 10px;">Save</button>
                                    <a href="{{ route('roles.index') }}" class="btn btn-warning">Back</a>
                                </div>
                            </div>
                        </form>
                        <!-- End: Form role edit -->
                    </div>
                </div>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane fade in bg-white" id="tab-access">
            <div class="tab-content">
                <div class="panel infolist">                        
                    <div class="panel-default panel-heading">
                        <h4>Permissions</h4>
                    </div>
                    <div class="panel-body">
                        <!-- Show save errors message -->
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <!-- End: Show errors message -->

                        <!-- Show datatables -->
                        <div class="box-body no-padding">
                            <form action="{{ route('roles.update', $node->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <table class="table table-roles table-condensed table-bordered table-hover">
                                    <tbody>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th>
                                                <input type="checkbox" class="perm-event" data-target=".table-roles .perms-module">&nbsp;
                                                Module
                                            </th>
                                            @foreach($roles['columns'] as $column)
                                            <th class="text-center">
                                                <input type="checkbox" class="perm-event perm-column" data-target=".table-roles .module-perm-{{ $column }} input">&nbsp;
                                                {{ ucfirst($column) }}
                                            </th>
                                            @endforeach
                                        </tr>
                                        @php $i = 1; @endphp
                                        @foreach($roles['modules'] as $module => $perms)
                                        <tr>
                                            <td class="text-center">{{ $i++ }}.</td>
                                            <td>
                                                <input type="checkbox" class="perm-event perms-module perms-{{ $module }}" data-target=".table-roles .module-{{ $module }} input">&nbsp;
                                                {{ ucfirst($module) }}
                                            </td>
                                            @foreach($roles['columns'] as $column)
                                            <td class="module-{{ $module }} module-perm-{{ $column }} text-center">
                                                @isset($roles['modules'][$module][$column])
                                                {!! Form::checkbox("perms[$module][$column]", 1, isset($node->modules[$module][$column])) !!}
                                                @else
                                                <span class="text-gray" style="font-size:18px;"><i class="icon ion-minus-circled"></i></span>
                                                @end
                                            </td>
                                            @endforeach
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="form-group">
                                    <div class="col-md-6 fvalue" style="margin-left: -15px;">
                                        <button type="submit" class="btn btn-primary" style="margin-right: 10px;">Save</button>
                                        <a href="{{ route('roles.index') }}" class="btn btn-warning">Back</a>
                                    </div>
                                </div>
                            </form>
                            <!-- End: Form role edit -->
                        </div>
                        <!-- End: Show datatables -->
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>
@endsection

@push('scripts')
    <script>
    /**
     * Add perms event click
     * @file roles/edit
     */
    $(function () {
        $('.perm-event').change(function() {
            var target = $(this).data('target');
            var status = $(this).prop('checked');
            
            $(target).prop('checked', status).trigger('change');

            // Check for click to all module, active column
            if (target.indexOf('perms-module') > 0) {
                $('.table-roles .perm-column').prop('checked', status)
            }
        });
    });
    </script>
@endpush