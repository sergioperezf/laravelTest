@extends("layout")
@section("content")
<link href="{{ asset('assets/css/datepicker.css') }}" rel="stylesheet">
<script src="{{ asset('assets/js/datepicker.js') }}"></script>
{{ Form::open() }}
{{ Form::label("name", "First Name") }}
{{ Form::text('name', Auth::user()->name, array('class'=>'form-control')) }}
{{ Form::label("lastname", "Last Name") }}
{{ Form::text("lastname", Auth::user()->lastname,  array('class'=>'form-control')) }}
{{ Form::label("phone", "Phone number") }}
{{ Form::text("phone", Auth::user()->phone,  array('class'=>'form-control')) }}
{{ Form::label("birthday", "Birthday") }}
{{ Form::text("birthday", Auth::user()->birthday,  array('class'=>'form-control', 'id'=>'dp')) }}
{{ Form::submit("Save") }}
{{ Form::close() }}
<script>
$(function () {
    $('#dp').datepicker({
        format: 'mm-dd-yyyy',
        todayBtn: 'linked'
    });
});
</script>
@stop