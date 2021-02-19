{{-- session key = success --}}
@if (session()->has('success'))
    <div class="alert alert-success alert-dismissable">
        <button id="success_button" type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
        <p>{!! session()->get('success') !!}</p>
    </div>
@endif

{{-- session key = danger --}}
@if (session()->has('danger'))
    <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
        <p>{!! session()->get('danger') !!}</p>
    </div>
@endif

