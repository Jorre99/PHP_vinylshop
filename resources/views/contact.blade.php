@extends('layouts.template')

@section('title', 'Contact us')

@section('main')
    <h1>Contact us</h1>
    @include('shared.alert')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (!session()->has('success'))
        <form action="/contact-us" method="post" novalidate>
            @csrf
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name"
                       class="form-control {{ $errors->first('name') ? 'is-invalid' : '' }}"
                       placeholder="Your name"
                       required
                       value="{{ old('name', 'Demo') }}">
                <div class="invalid-feedback">{{ $errors->first('name') }}</div>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email"
                       class="form-control {{ $errors->first('email') ? 'is-invalid' : '' }}"
                       placeholder="Your email"
                       required
                       value="{{ old('email', 'demo@example.com') }}">
                <div class="invalid-feedback">{{ $errors->first('email') }}</div>
            </div>
            <div class="form-group">
                <label for="contact">Contact</label>
                <select class="form-control {{ $errors->first('contact') ? 'is-invalid' : '' }}" name="contact" id="contact" required>
                    <option value="">Select a contact</option>
                    <option value="info">Info</option>
                    <option value="billing">Billing</option>
                    <option value="support">Support</option>
                </select>
                <div class="invalid-feedback">{{ $errors->first('contact') }}</div>
            </div>
            <div class="form-group">
                <label for="message">Message</label>
                <textarea name="message" id="message" rows="5"
                          class="form-control {{ $errors->first('message') ? 'is-invalid' : '' }}"
                          placeholder="Your message"
                          required
                          minlength="10">{{ old('message', "New message\nLorem ipsum") }}</textarea>
                <div class="invalid-feedback">{{ $errors->first('message') }}</div>
            </div>
            <button type="submit" class="btn btn-success">Send Message</button>
        </form>
    @endif
{{--    <h1>I'm  {{ $name }}</h1>--}}
{{--    <p>You can contact me at--}}
{{--        <a href="mailto:{{ env('MAIL_FROM_ADDRESS') }}">--}}
{{--            {{ env('MAIL_FROM_ADDRESS') }}--}}
{{--        </a>--}}
{{--    </p>--}}

@endsection

@section('css_after')
    <style>
       #success_button{
           display: none;
       }
    </style>
@endsection

