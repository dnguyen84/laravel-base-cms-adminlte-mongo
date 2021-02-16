@extends('layouts.admin')

@section('title', 'User view')
@section('description', 'User view')

@section('content')
    <style type="text/css">
        .channel-cover { height: 176px; }
        .channel-profile {}
        .channel-information {
            background-color: #fafafa !important;
        }
        .channel-information .desc i.fa {margin-right: 5px;}
        .channel-container {}
        .channel-title {
            font-size: 2.4rem;
            font-weight: 400;
            line-height: 3rem;
            width: 70vw;
        }
        .panel.infolist .form-group {
            border-bottom: 1px dashed #f3f4f5;
        }
        .profile2 .profile-icon {
            width: 80px;
            height: 80px;
        }
    </style>
    <div id="page-content" class="profile2">
        <!-- Header information section -->
        @if(isset($node->cover->src))
        <div class="channel-cover bg-primary clearfix" style="background-image: url({{ $node->cover->src }}?type=cover);background-repeat: no-repeat; background-position: center center; background-size: 100%;">
        @else
        <div class="bg-primary clearfix">
        @end
            <!-- channel cover inner -->
        </div>

        <div class="channel-information clearfix">
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-4">
                        @if($node->avatar->thumb)
                            @if($node->avatar->width > $node->avatar->height)
                            <div class="profile-icon text-primary" style="background-image: url({{ $node->avatar->thumb }});background-repeat: no-repeat; background-position: center center; background-size: auto 80px;"></div>
                            @else
                            <div class="profile-icon text-primary" style="background-image: url({{ $node->avatar->thumb }});background-repeat: no-repeat; background-position: center center; background-size: 80px auto;"></div>
                            @end
                        @else
                        <div class="profile-icon text-primary"><i class="ion ion-ribbon-a"></i></div>
                        @end
                    </div>
                    <div class="col-md-8">
                        <h4 class="channel-title">{{ $node->name }}</h4>
                        <p class="desc"><i class="fa fa-phone"></i>  {{ $node->mobile }}</p>
                        <p class="desc"><i class="fa fa-envelope-o"></i>  {{ $node->email }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-7">
                <div class="dats1">&nbsp;</div>
                <div class="dats1">&nbsp;</div>
                <div class="dats1"><i class="fa fa-map-marker"></i> {{ $node->address }}</div>
            </div>
            <div class="col-md-1 actions">
            </div>
        </div>

        <!-- Tab header -->
        <ul data-toggle="ajax-tab" class="nav nav-tabs profile" role="tablist">
            <li class=""><a href="{{ route('users.index') }}" data-toggle="tooltip" data-placement="right" title="Back to users"><i class="ion ion-chevron-left"></i></a></li>
            <li class="active"><a role="tab" data-toggle="tab" class="active" href="#tab-general-info" data-target="#tab-info"> @lang('backend::user.general')</a></li>
            <li class=""><a role="tab" data-toggle="tab" href="#tab-access" data-target="#tab-access"> @lang('backend::user.access')</a></li>
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
                                <label for="id" class="col-md-2">@lang('backend::user.code') :</label>
                                <div class="col-md-10 fvalue">{{ $node->id }}</div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-md-2">@lang('backend::user.name') :</label>
                                <div class="col-md-10 fvalue">{{ $node->name }}</div>
                            </div>
                            <div class="form-group">
                                <label for="email" class="col-md-2">@lang('backend::user.email') :</label>
                                <div class="col-md-10 fvalue">
                                    <a href="mailto:{{ $node->email }}">{{ $node->email }}</a>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="email" class="col-md-2">@lang('backend::user.mobile') :</label>
                                <div class="col-md-10 fvalue">
                                    <a href="tel:{{ $node->mobile }}" target="_blank">{{ $node->mobile }}</a>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="roles" class="col-md-2">@lang('backend::user.roles') :</label>
                                <div class="col-md-10 fvalue">
                                    @foreach($node->roles as $item)
                                    <a href="{{ route('roles.show', $item) }}" class="label label-primary">{{ $item }}</a>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Profile section -->
                            <div class="form-group">
                                <label for="gender" class="col-md-2">@lang('backend::user.gender') :</label>
                                <div class="col-md-10 fvalue">{{ $node->profile['gender'] ?? 'N/A' }}</div>
                            </div>

                            <div class="form-group">
                                <label for="gender" class="col-md-2">@lang('backend::user.birthday') :</label>
                                <div class="col-md-10 fvalue">{{ $node->profile['birthday'] ?? 'N/A' }}</div>
                            </div>
                            
                            <!-- Location -->
                            @isset($node->location['province'])
                            <div class="form-group">
                                <label for="province" class="col-md-2">@lang('backend::user.province') :</label>
                                <div class="col-md-10 fvalue">
                                    {{ $node->location['provinceText'] }}
                                    <a target="_blank" class="pull-right btn btn-xs btn-primary btn-circle" href="https://www.google.com/maps?q={{ str_replace(' ', '+', $node->location['provinceText']) }}" data-toggle="tooltip" data-placement="left" title="" data-original-title="@lang('backend::user.show on google map')"><i class="fa fa-map-marker"></i></a>
                                </div>
                            </div>
                            @endisset

                            @isset($node->location['district'])
                            <div class="form-group">
                                <label for="district" class="col-md-2">@lang('backend::user.district') :</label>
                                <div class="col-md-10 fvalue">
                                    {{ $node->location['districtText'] }}
                                    <a target="_blank" class="pull-right btn btn-xs btn-primary btn-circle" href="https://www.google.com/maps?q={{ str_replace(' ', '+', $node->location['districtText']) }}" data-toggle="tooltip" data-placement="left" title="" data-original-title="@lang('backend::user.show on google map')"><i class="fa fa-map-marker"></i></a>
                                </div>
                            </div>
                            @endisset

                            @isset($node->location['wards'])
                            <div class="form-group">
                                <label for="wards" class="col-md-2">@lang('backend::user.wards') :</label>
                                <div class="col-md-10 fvalue">
                                    {{ $node->location['wardsText'] }}
                                    <a target="_blank" class="pull-right btn btn-xs btn-primary btn-circle" href="https://www.google.com/maps?q={{ str_replace(' ', '+', $node->location['wardsText']) }}" data-toggle="tooltip" data-placement="left" title="" data-original-title="@lang('backend::user.show on google map')"><i class="fa fa-map-marker"></i></a>
                                </div>
                            </div>
                            @endisset

                            @isset($node->location['address'])
                            <div class="form-group">
                                <label for="address" class="col-md-2">@lang('backend::user.address') :</label>
                                <div class="col-md-10 fvalue">
                                    {{ $node->location['address'] }}
                                    <a target="_blank" class="pull-right btn btn-xs btn-primary btn-circle" href="https://www.google.com/maps?q={{ str_replace(' ', '+', $node->location['address']) }}" data-toggle="tooltip" data-placement="left" title="" data-original-title="@lang('backend::user.show on google map')"><i class="fa fa-map-marker"></i></a>
                                </div>
                            </div>
                            @endisset

                            <div class="form-group">
                                <label for="created" class="col-md-2">@lang('backend::user.avatar') :</label>
                                <div class="col-md-6 fvalue">
                                    <div class="uploaded_image">
                                        @if ($node->avatar->thumb)
                                        <img src="{{ $node->avatar->thumb }}">
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="created" class="col-md-2">@lang('backend::user.cover') :</label>
                                <div class="col-md-6 fvalue">
                                    <div class="uploaded_image">
                                        @if ($node->cover->thumb)
                                        <img src="{{ $node->cover->thumb }}">
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="status" class="col-md-2">Status :</label>
                                <div class="col-md-10 fvalue">
                                    <span class="label label-{{ $collection['colors'][$node->status] }}">{{ $collection['status'][$node->status] }}</span>
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
                            <h4>@lang('backend::user.permissions')</h4>
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
                                                @isset($node->perms[$module . '.' . $column])
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

@push('scripts')
    <script>
    /**
     * Change password validate form
     * @file users/show
     */
    $(function () {
        $("#password-form").validate({});
    });
    </script>
@endpush