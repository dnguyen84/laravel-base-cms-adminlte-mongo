@extends('layouts.admin')

@section('title', 'Permissions')
@section('description', 'Permissions listing')

@section('header')
    <h1>
        Permissions <small>Show module permissions</small>
    </h1>
    <div class="toolbar-item toolbar-primary">
        <div class="btn-group offset-right">
            @can('user.view')
            <a href="{{ route('users.index') }}" class="btn btn-default oc-icon-reply-all ion-ios-home"> @lang('backend::user.user')</a>
            @endcan
            @can('role.view')
            <a href="{{ route('roles.index') }}" class="btn btn-default oc-icon-reply-all ion-ios-home"> @lang('backend::user.role')</a>
            @endcan
            @can('perm.view')
            <a href="{{ route('perms.index') }}" class="btn btn-primary oc-icon-trash ion-ios-briefcase"> @lang('backend::user.perm')</a>
            @endcan
        </div>
    </div>
@endsection

@section('content:class', 'no-padding')
@section('content')
<div class="content row">
    <!-- Tab header -->
    <ul data-toggle="ajax-tab" class="nav nav-tabs profile" role="tablist">
        <li class=""><a href="{{ route('users.index') }}" data-toggle="tooltip" data-placement="right" title="Back to roles"><i class="ion ion-chevron-left"></i></a></li>
        <li class="active"><a role="tab" data-toggle="tab" class="active" href="#tab-general" data-target="#tab-general" data-type="">General</a></li>
    </ul>

    <!-- Tab content -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active fade in" id="tab-info">
            <div class="tab-content">
                <div class="panel infolist">
                    <!--
                    <div class="panel-default panel-heading">
                        <h4>Add Config</h4>
                    </div>
                    -->
                    <div class="panel-body">
                        <!-- Show datatables -->
                        <div class="box-body no-padding">
                            <table class="table table-condensed table-bordered table-hover">
                                <tbody>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>Module</th>
                                        @foreach($roles['columns'] as $column)
                                        <th class="text-center">{{ ucfirst($column) }}</th>
                                        @endforeach
                                    </tr>
                                    @php $i = 1; @endphp
                                    @foreach($roles['modules'] as $module => $perms)
                                    <tr>
                                        <td class="text-center">{{ $i++ }}.</td>
                                        <td>{{ ucfirst($module) }}</td>
                                        @foreach($roles['columns'] as $column)
                                        <td class="text-center">
                                            @isset($perms[$column])
                                            <span class="text-green" style="font-size:18px;"><i class="icon ion-ios-checkmark"></i></span>
                                            @else
                                            <span class="text-gray" style="font-size:18px;"><i class="icon ion-minus-circled"></i></span>
                                            @end
                                        </td>
                                        @endforeach
                                    </tr>
                                    @endforeach
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
@endsection
