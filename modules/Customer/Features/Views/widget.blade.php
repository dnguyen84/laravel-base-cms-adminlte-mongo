<div class="modal fade" id="setting-modal" role="dialog" aria-labelledby="setting-modal-label">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="setting-modal-label">{{ $setting->name ?: 'Setting' }}</h4>
            </div>
            <form action="{{ route('settings.update', $setting->id) }}" method="POST" id="setting-form" novalidate="novalidate" accept-charset="UTF-8">
                @csrf
                @method('PUT')
                <input name="_id" type="hidden" value="{{ $setting->id }}" />
                <div class="modal-body">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="name">Name* :</label>
                            <input class="form-control" placeholder="Enter config name, e.g: Content type defination" data-rule-maxlength="1000" cols="30" rows="3" name="name" value="{{ $setting->name }}" required="1" aria-required="true">
                        </div>
                        <div class="form-group">
                            <label for="format">Format :</label>
                            {!! Form::select('format', ['text' => 'Text', 'number' => 'Number', 'json' => 'Json'], $setting->format, ['class' => 'form-control', 'rel' => 'select2']); !!}
                        </div>
                        <div class="form-group">
                            <label for="value">Data* :</label>
                            <textarea class="form-control" placeholder="Enter config data" data-rule-maxlength="1000" cols="30" rows="{{ $setting->format == 'json' ? 10 : 3 }}" name="value" required="1" aria-required="true">{{ $setting->valueText }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="startup">Startup :</label>
                            {!! Form::select('startup', ['0' => 'No', '1' => 'Yes'], $setting->startup, ['class' => 'form-control', 'rel' => 'select2']) !!}
                        </div>
                        <div class="form-group">
                            <label for="status">Status :</label>
                            {!! Form::select('status', ['Disable', 'Enable'], $setting->status, ['class' => 'form-control', 'rel' => 'select2']); !!}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <input class="btn btn-success" type="submit" value="Save" />
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(function () {
    $("#setting-form").validate({
        
    });

    $('#setting-form').attr('action', function() {
        return $(this).attr('action') + '?callback=' + location.href;
    });
});
</script>
@endpush