@extends("layout")
@section("content")
<link href="{{ asset('assets/css/datepicker.css') }}" rel="stylesheet">
<script src="{{ asset('assets/js/datepicker.js') }}"></script>
<link href="{{ asset('assets/css/image-picker.css') }}" rel="stylesheet">
<script src="{{ asset('assets/js/image-picker.min.js') }}"></script>
<script src="{{ asset('assets/js/masonry.pkgd.min.js') }}"></script>
<style>
    .thumbnail { width: 25%; }
    #fit-width .masonry {
        margin: 0 auto;
    }
</style>
{{ Form::open(array('id'=>'mainForm')) }}
{{ Form::label("name", "First Name") }}
{{ Form::text('name', Auth::user()->name, array('class'=>'form-control')) }}
{{ Form::label("lastname", "Last Name") }}
{{ Form::text("lastname", Auth::user()->lastname,  array('class'=>'form-control')) }}
{{ Form::label("phone", "Phone number") }}
{{ Form::text("phone", Auth::user()->phone,  array('class'=>'form-control')) }}
{{ Form::label("birthday", "Birthday") }}
{{ Form::text("birthday", Auth::user()->birthday,  array('class'=>'form-control', 'id'=>'dp')) }}
<label for="picture">Picture</label> 
<span id="delete" style="display: none">
    <input type="button" onclick="deleteSelected()" value="Delete selected"/>
    <input type="button" onclick="setForAddition()" value="Cancel"/>
</span>
<span style="float: right">
    <span id="addLink"><a href="#" onclick="$('#file').click()">Add picture...</a></span> | 
    <span><a href="#" onclick=" setForDeletion()">Delete pictures...</a></span>
</span>
<select id="picture" class=" masonry image-picker" name="picture_id[]">
    @foreach($pictures as $picture)
    <option data-img-src="{{$picture->path}}" value="{{$picture->id}}"></option>
    @endforeach
</select>
{{ Form::submit("Save") }}
{{ Form::close() }}
<div style="display: none" id="fileup">
    {{ Form::open(array('action' => 'PictureController@upload', 'files' => true, 'id'=>'fileForm')) }}
    {{ Form::file('file', array('id'=>'file', 'onchange' => 'uploadFile()')) }}
    {{ Form::close() }}
</div>

<script>
    $(function () {
        reloadFromServer = function (data) {
            if (data.status === 'OK') {
                $('#picture')
                        .find('option')
                        .remove();
                $.each(data, function (key, value) {
                    if (key !== "status" && key !== "message") {
                        $('#picture').append(
                                $("<option></option>")
                                .attr("value", key)
                                .attr('data-img-src', value)
                                );
                    }
                });
            } else if (data.status === 'FAILED') {
                alert(data.message)
            }
            setForAddition();
        }
        uploadFile = function () {
            var formData = new FormData($('#fileForm')[0]);
            $.ajax({
                type: "POST",
                contentType: false,
                processData: false,
                url: $("#fileForm").attr("action"),
                data: formData,
                dataType: 'json',
                success: reloadFromServer
            });
        };


        deleteSelected = function () {
            var formData = new FormData($('#mainForm')[0]);
            $.ajax({
                type: "POST",
                contentType: false,
                processData: false,
                url: "{{URL::route("picture/delete")}}",
                data: formData,
                dataType: 'json',
                success: reloadFromServer
            });
        }
        updateImages = function () {
            $("#picture").imagepicker();
            var container = jQuery("#picture").next("ul");
            container.imagesLoaded(function () {
                container.masonry({
                    isFitWidth: true,
                    itemSelector: ".thumbnail"
                });
            });
        }
        ;
        setForDeletion = function () {
            $("#addLink").hide()
            $("#delete").show()
            $("#picture").attr('multiple', 'multiple');
            updateImages()
        };
        setForAddition = function () {
            $("#addLink").show()
            $("#picture").removeAttr('multiple');
            updateImages()
            $("#delete").hide()
        };
        updateImages();
        $('#dp').datepicker({
            format: 'yyyy-mm-dd',
            todayBtn: 'linked'
        });
    });
</script>
@stop