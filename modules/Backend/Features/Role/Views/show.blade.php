@extends('layouts.admin')

@section('title', 'Role view')
@section('description', 'Role view')

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
        <li class="active"><a role="tab" data-toggle="tab" class="active" href="#tab-general-info" data-target="#tab-info"> General</a></li>
        <li class=""><a role="tab" data-toggle="tab" href="#tab-access" data-target="#tab-access"> Access</a></li>
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
                        <div class="form-group">
                            <label for="id" class="col-md-2">ID :</label>
                            <div class="col-md-10 fvalue">{{ $node->id }}</div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-md-2">Name :</label>
                            <div class="col-md-10 fvalue">{{ $node->name }}</div>
                        </div>
                        <div class="form-group">
                            <label for="description" class="col-md-2">Description :</label>
                            <div class="col-md-10 fvalue">{{ $node->about }}</div>
                        </div>

                        <div class="form-group">
                            <label for="status" class="col-md-2">Status :</label>
                            <div class="col-md-10 fvalue">
                                @if($node->status == 1)
                                <span class="label label-success">Enable</span>
                                @else
                                <span class="label label-danger">Disable</span>
                                @end
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="created" class="col-md-2">Created :</label>
                            <div class="col-md-10 fvalue">{{ $node->created }}</div>
                        </div>

                        <div class="form-group">
                            <label for="updated" class="col-md-2">Updated :</label>
                            <div class="col-md-10 fvalue">{{ $node->updated }}</div>
                        </div>
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
                                            @isset($node->modules[$module][$column])
                                            <span class="text-green" style="font-size:18px;"><i class="icon ion-ios-checkmark"></i></span>
                                            @elseif(isset($perms[$column]))
                                            <span class="text-red" style="font-size:18px;"><i class="icon ion-ios-close"></i></span>
                                            @else
                                            <span class="text-gray" style="font-size:18px;"><i class="icon ion-minus-circled"></i></span>
                                            @endif
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
