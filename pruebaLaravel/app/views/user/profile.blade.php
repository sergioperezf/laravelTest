@extends("layout")
@section("content")
  <h2>Hello {{ Auth::user()->username }}</h2>
  <p>Full Name: {{Auth::user()->name}} {{Auth::user()->lastname}}</p>
  <p>Phone number: {{Auth::user()->phone}}</p>
  <p>Birthday: {{Auth::user()->birthday}}</p>
  <p>Picture: {{Auth::user()->picture_id}}</p>
  {{link_to('edit', "Edit", $attributes = array(), $secure = null)}}
@stop