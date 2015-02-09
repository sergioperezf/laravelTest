@extends("layout")
@section("content")
<h2>Hello {{ Auth::user()->username }}</h2>
<p>Full Name: {{Auth::user()->name}} {{Auth::user()->lastname}}</p>
<p>Phone number: {{Auth::user()->phone}}</p>
<p>Birthday: {{Auth::user()->birthday}}</p>
<p>Picture:</p>
<div class="col-md-4">
    @if(Picture::find(Auth::user()->picture_id))
    <img style="width: 100%" src="{{Picture::find(Auth::user()->picture_id)->path}}" />
    @else
    Not set
    @endif
</div>
<div class="clearfix"></div><br/>
{{link_to('edit', "Edit profile", $attributes = array(), $secure = null)}}
@stop