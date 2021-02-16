@extends('layouts.admin')

@section('title', 'User update')
@section('description', 'User update')

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

@section('content')
<div class="row">
    <div class="col-sm-7 col-md-8 col-sm-right col-md-right">
        <!-- Show form create user -->
        <form id="user-form" action="{{ route('users.update', $node->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="panel infolist">
                <div class="panel-default panel-heading clearfix">
                    <h4 class="panel-title pull-left" style="padding-top: 5px;">@lang('backend::user.user update')</h4>
                    <div class="btn-group-0 pull-right">
                        <a href="{{ route('users.index') }}" class="btn btn-default btn-sm" style="margin-right: 10px;"> @lang('backend::user.cancel')</a>
                        <button type="submit" class="btn btn-primary btn-sm"> @lang('backend::user.update')</button>
                    </div>
                </div>
                <div class="panel-body">
                    
                    @alert

                    <div class="form-group">
                        <label for="code" class="col-md-2">@lang('backend::user.code') </label>
                        <div class="col-md-6 fvalue">
                            <input class="form-control" type="text" name="code" placeholder="@lang('backend::user.code text')" value="{{ old('code', $node->code) }}" data-rule-maxlength="250">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="col-md-2 required">@lang('backend::user.name') </label>
                        <div class="col-md-6 fvalue">
                            <input class="form-control" type="text" name="name" placeholder="@lang('backend::user.name text')" value="{{ old('name', $node->name) }}" data-rule-minlength="3" data-rule-maxlength="250" required="1">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email" class="col-md-2 required">@lang('backend::user.email') </label>
                        <div class="col-md-6 fvalue">
                            <input class="form-control" type="text" name="email" placeholder="@lang('backend::user.email text')" value="{{ old('email', $node->email) }}" data-rule-minlength="6" data-rule-maxlength="250" required="1">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="mobile" class="col-md-2">@lang('backend::user.mobile') </label>
                        <div class="col-md-6 fvalue">
                            <input class="form-control" type="text" name="mobile" placeholder="@lang('backend::user.mobile text')" value="{{ old('mobile', $node->mobile) }}" data-rule-minlength="6" data-rule-maxlength="250" required="1">
                        </div>
                    </div>

                    <!-- Check for user roles -->
                    <div class="form-group">
                        <label for="roles" class="col-md-2">@lang('backend::user.roles') </label>
                        <div class="col-md-6 fvalue">
                            <select class="form-control" data-placeholder="@lang('backend::user.roles text')" rel="select2" name="roles[]" multiple="multiple">
                                @foreach($roles as $role)
                                <option value="{{ $role->id }}" @if(in_array($role->id, $node->roles)) selected @endif>{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <!-- End: Check for user roles -->

                    <div class="form-group">
                        <label for="gender" class="col-md-2">@lang('backend::user.gender') </label>
                        <div class="col-md-6 fvalue">
                            <select class="form-control" required="1" data-placeholder="@lang('backend::user.gender text')" rel="select2" name="profile[gender]">
                                @foreach($collection['gender'] as $value => $name)
                                <option value="{{ $value }}" @if($value == old('profile.gender', $node->profile['gender'] ?? '')) selected @endif>{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group form-datepicker">
                        <label for="birthday" class="col-md-2">@lang('backend::user.birthday') </label>
                        <div class="col-md-6 fvalue">
                            <div class="input-group" id='datetimepicker'>
                                <input class="form-control" placeholder="@lang('backend::user.birthday text')" name="profile[birthday]" type="text" value="{{ old('profile.birthday', $node->profile['birthday'] ?? '') }}">
                                <span class="input-group-addon">
                                    <span class="fa fa-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Location section -->
                    <div class="form-group">
                        <label for="province" class="col-md-2">@lang('backend::user.province')</label>
                        <div class="col-md-6 fvalue">
                            <select id="select-province" name="location[province]" rel="select2">
                                @if ($node->location && isset($node->location['province']))
                                <option value="{{ $node->location['province'] }}" selected="selected">{{ $node->location['provinceText'] }}</option>
                                @endif
                            </select>
                            <input type="hidden" name="location[provinceText]" value="" />
                            <small class="form-text text-muted">@lang('backend::user.province guide')</small>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="district" class="col-md-2">@lang('backend::user.district')</label>
                        <div class="col-md-6 fvalue">
                            <select id="select-district" name="location[district]" rel="select2">
                                @if ($node->location && isset($node->location['district']))
                                <option value="{{ $node->location['district'] }}" selected="selected">{{ $node->location['districtText'] }}</option>
                                @endif
                            </select>
                            <input type="hidden" name="location[districtText]" value="" />
                            <small class="form-text text-muted">@lang('backend::user.district guide')</small>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="wards" class="col-md-2">@lang('backend::user.wards')</label>
                        <div class="col-md-6 fvalue">
                            <select id="select-wards" name="location[wards]" rel="select2">
                                @if ($node->location && isset($node->location['wards']))
                                <option value="{{ $node->location['wards'] }}" selected="selected">{{ $node->location['wardsText'] }}</option>
                                @endif
                            </select>
                            <input type="hidden" name="location[wardsText]" value="" />
                            <small class="form-text text-muted">@lang('backend::user.wards guide')</small>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="address" class="col-md-2">@lang('backend::user.address')</label>
                        <div class="col-md-6 fvalue">
                            <input class="form-control" type="text" name="location[address]" placeholder="@lang('backend::user.address text')" value="{{ old('location.address', $node->location['address'] ?? '') }}" data-rule-minlength="2" data-rule-maxlength="250">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="avatar" class="col-md-2">@lang('backend::user.avatar')</label>
                        <div class="col-md-6 fvalue">
                            @upload(['type' => 'avatar', 'vendor' => $node->id, 'name' => 'avatar', 'value' => $node->avatar->id, 'thumb' => $node->avatar->thumb])
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="cover" class="col-md-2">@lang('backend::user.cover')</label>
                        <div class="col-md-6 fvalue">
                            @upload(['type' => 'cover', 'vendor' => $node->id, 'name' => 'cover', 'value' => $node->cover->id, 'thumb' => $node->cover->thumb])
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="status" class="col-md-2 required">@lang('backend::user.status') </label>
                        <div class="col-md-6 fvalue">
                            <select class="form-control" data-placeholder="@lang('backend::user.status text')" rel="select2" name="status">
                                @foreach($collection['status'] as $value => $name)
                                <option value="{{ $value }}" @if($value == old('status', $node->status)) selected @endif>{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2"></label>
                        <div class="col-md-6 fvalue">
                            <button type="submit" class="btn btn-primary" style="margin-right:5px;">@lang('backend::user.save')</button>
                            <a class="btn btn-default" href="{{ route('users.index') }}">@lang('backend::user.cancel')</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <!-- End: Show form create user -->
    </div>

    <div class="col-sm-5 col-md-4">
        <!-- Show form change user password -->
        <form id="password-form" action="{{ route('users.password', $node->id) }}" method="POST">
            @csrf
            <div class="panel infolist">
                <div class="panel-default panel-heading clearfix">
                    <h4 class="panel-title pull-left" style="padding-top: 5px;">@lang('backend::user.password change')</h4>
                    <div class="btn-group-0 pull-right">
                        <button type="submit" class="btn btn-primary btn-sm"> @lang('backend::user.password change')</button>
                    </div>
                </div>
                <div class="panel-body">
                    
                    @alert()

                    <div class="form-group">
                        <label for="password" class="col-md-4 required">@lang('backend::user.password') </label>
                        <div class="col-md-8 fvalue">
                            <input class="form-control" placeholder="Enter new password" name="password" type="password" value="" data-rule-minlength="8" data-rule-maxlength="250" required="1" aria-required="true" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="comfirmation" class="col-md-4">@lang('backend::user.password confirm') :</label>
                        <div class="col-md-8 fvalue">
                            <input class="form-control" placeholder="Retype new password" name="password_confirmation" type="password" value="" data-rule-minlength="8" data-rule-maxlength="250" required="1" aria-required="true" autocomplete="off">
                        </div>
                    </div>
                </div>
                <!--
                <div class="panel-footer">
                    <button type="submit" class="btn btn-primary"><span class="fa fa-check-circle"></span> @lang('backend::user.password change')</button>
                </div>
                -->
            </div>
        </form>
        <!-- End: Show form change user password -->
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
        $("#user-form").validate({});
        $("#password-form").validate({});

        $("#datetimepicker").datetimepicker({
            format: 'YYYY-MM-DD',
            defaultDate: ''
        });

        $("#select-province").select2({
            cache: true,
            language: '{{ config("app.locale") }}',
            ajax: {
                dataType: 'json',
                url: '{{ route("locations.search") }}?type=P',
                type: 'GET',
                quietMillis: 50,
                data: function (params) {
                    return {
                        limit: 100,
                        term: params.term // Query text send to server
                    };
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                }
            }
        });

        $('#select-province').on('select2:select', function (e) {
            $('#select-district').val(null).trigger('change');
            $('#select-wards').val(null).trigger('change');
        });

        $("#select-district").select2({
            cache: true,
            language: '{{ config("app.locale") }}',
            ajax: {
                dataType: 'json',
                url: '{{ route("locations.search") }}?type=D',
                type: 'GET',
                quietMillis: 50,
                data: function (params) {
                    return {
                        parent: $('#select-province').val(),
                        limit: 100,
                        term: params.term // Query text send to server
                    };
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                }
            }
        });

        $('#select-district').on('select2:select', function (e) {
            $('#select-wards').val(null).trigger('change');
        });

        $("#select-wards").select2({
            cache: true,
            language: '{{ config("app.locale") }}',
            ajax: {
                dataType: 'json',
                url: '{{ route("locations.search") }}?type=W',
                type: 'GET',
                quietMillis: 50,
                data: function (params) {
                    return {
                        parent: $('#select-district').val(),
                        limit: 100,
                        term: params.term // Query text send to server
                    };
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                }
            }
        });
    });
    </script>
@endpush