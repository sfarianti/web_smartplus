@props(['title' => null, 'header' => null, 'breadcrumb' => null])

@extends('layouts.app')

@section('content')
    {{ $slot }}
@endsection
