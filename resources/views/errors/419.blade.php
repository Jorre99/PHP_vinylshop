@extends('layouts.template')

@section('main')
    <h3 class="text-center my-5">419 | <span class="text-black-50">{{ $exception->getMessage() ?: 'CSRF token mismatch' }}</span></h3>
    @include('errors.buttons')
@endsection

@section('script_after')
    <script>
        // Go back to the previous page
        $('#back').click(function () {
            window.history.back();
        });
    </script>
@endsection
