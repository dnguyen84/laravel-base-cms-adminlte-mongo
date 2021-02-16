@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('admin/css/animate.css') }}"/>
@endpush

@push('scripts')
<script src="{{ asset('admin/js/bootstrap-notify.min.js') }}"></script>
<script>
/**
 * Alert with notification
 */
$(function () {

@if ($message = Session::get('success'))
    /**
     * Show success messages
     */
    $.notify({
        message: '{!! $message !!}',
    }, {
        type: 'success',
        placement: {
            from: "bottom",
            align: "right"
        },
        animate: {
            enter: 'animated fadeInUp',
            exit: 'animated fadeOutDown'
        },
    });
@endif

@if (count($errors) > 0)
    /**
     * Show error messages
     */
    $.notify({
        message: '<h4><i class="ion ion-sad"></i> Alert</h4>' + 
            'Có vấn đề với dữ liệu bạn nhập, vui lòng kiểm tra lại' +
            '<ul>' +
            @foreach($errors->all() as $error)
                '<li>' +
                    '{{ $error }}' +
                '</li>' +
            @endforeach
            '</ul>'
    },{
        type: 'danger',
        placement: {
            from: "bottom",
            align: "right"
        },
        animate: {
            enter: 'animated fadeInUp',
            exit: 'animated fadeOutDown'
        },
    });
@endif

});
</script>
@endpush