@extends('layouts.template')

@section('title', 'Create new record')

@section('main')
    <h1>Create new record</h1>
    <form action="/admin/records" method="post">
        @include('admin.records.form')
    </form>
@endsection

@section('script_after')
    @include('admin.records.script')
@endsection
