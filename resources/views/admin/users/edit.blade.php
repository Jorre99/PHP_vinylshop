@extends('layouts.template')

@section('title', 'Edit user')

@section('main')
    <h1>Edit user: {{ $user->name }}</h1>
    <form action="/admin/users/{{ $user->id }}" method="post">
        @method('put')
        @csrf
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name"
                   class="form-control @error('name') is-invalid @enderror"
                   placeholder="Name"
                   value="{{ old('name', $user->name) }}">
            @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <label for="email" style="padding-top: 20px;">Email</label>
            <input type="email" name="email" id="email"
                   class="form-control @error('email') is-invalid @enderror"
                   placeholder="Email"
                   minlength="3"
                   required
                   value="{{ old('email', $user->email) }}">
            @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div class="row" style="padding-top: 20px;">
                <div class="col">
                    <input type="checkbox" id="active" name="active" value='1' {{ old('admin', $user->active)? 'checked="checked"':null }}>
                    <label for="active">Active</label><br>
                </div>
                <div class="col" >
                    <input type="checkbox" id="admin" name="admin" value='1' {{ old('admin', $user->admin)? 'checked="checked"':null }}>
                    <label for="admin">Admin</label><br>
                </div>
            </div>

        </div>
        <button type="submit" class="btn btn-success">Save user</button>
    </form>
@endsection
