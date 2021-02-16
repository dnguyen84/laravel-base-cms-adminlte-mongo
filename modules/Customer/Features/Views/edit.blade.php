@extends('layouts.admin')

@section('title', 'Config edit')
@section('description', 'Config edit')

@section('header')
<h1>
    Configuration
    <small>Configuration management</small>
</h1>
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12 col-md-8">
        <!-- Form: config edit -->
        <form action="{{ route('settings.update', $node->id) }}" method="POST">
            @csrf
            @alert
            @method('PUT')
            
            <div class="box box-label without-border">
                <div class="box-header with-border">
                    <h3 class="box-title">Update setting</h3>
                    <div class="box-tools">
                        <a href="{{ route('settings.index') }}" class="btn btn-default btn-sm" style="margin-right: 10px;"> Cancel</a>
                        <button type="submit" class="btn btn-primary btn-sm" style="margin-right: 6px;"> Update</button>
                    </div>
                </div>

                <div class="box-body">
                    <div class="form-group">
                        <label for="name">Name :</label>
                        <input class="form-control" name="name" placeholder="Setting name" value="{{ $node->name }}" />
                    </div>

                    <div class="form-group">
                        <label for="format">Format :</label>
                        {!! Form::select('format', ['text' => 'Text', 'number' => 'Number', 'json' => 'Json'], $node->format, ['class' => 'form-control', 'rel' => 'select2']); !!}
                        <small class="form-text text-muted">Select data format: text, number, json</small>
                    </div>

                    <div class="form-group">
                        <label for="data">Value :</label>
                        <textarea class="form-control" rows="10" name="value" placeholder="Setting data">{{ $node->valueText }}</textarea>
                        <small class="form-text text-muted">Setting data with format: text, number, json</small>
                    </div>

                    <div class="form-group">
                        <label for="startup">Startup :</label>
                        {!! Form::select('startup', ['0' => 'No', '1' => 'Yes'], $node->startup, ['class' => 'form-control', 'rel' => 'select2']) !!}
                        <small class="form-text text-muted">Load setting on startup</small>
                    </div>

                    <div class="form-group">
                        <label for="status">Status :</label>
                        {!! Form::select('status', ['0' => 'Disable', '1' => 'Enable'], $node->status, ['class' => 'form-control', 'rel' => 'select2']) !!}
                    </div>

                    <div class="form-group">
                        <label for="created">Created :</label>
                        <div class="fvalue">{{ $node->created }}</div>
                    </div>

                    <div class="form-group">
                        <label for="updated">Updated :</label>
                        <div class="fvalue">{{ $node->updated }}</div>
                    </div>
                </div>
            </div>
        </form>
        <!-- End: Form config edit -->
    </div>
</div>
@endsection
