@extends("layout")

@section("app")

    <router-view name="nav"></router-view>
    <router-view></router-view>

    <h1>@{{ rooo }}</h1>

@endsection