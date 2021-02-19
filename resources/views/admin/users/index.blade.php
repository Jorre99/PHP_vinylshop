@extends('layouts.template')

@section('title', 'Users')

@section('main')
<h1>Users</h1>
<form method="get" action="/admin/users" id="searchForm">
    <div class="row" >
        <div class="col-sm-7 mb-2">
            <label for="user">Filter Name or Email</label>
            <input type="text" class="form-control" name="user" id="user"
                   value="{{ request()->user }}" placeholder="Filter Name Or Email">
        </div>
        <div class="col-sm-5 mb-2">
            <label for="order">Sort by</label>
            <select class="form-control" name="order" id="order">
                <option value="%">ID (1 => ...)</option>
                <option value="nameA" {{ (request()->order ==  'nameA' ? 'selected' : '') }}>Name (A => Z)</option>
                <option value="nameZ" {{ (request()->order ==  'nameZ' ? 'selected' : '') }}>Name (Z => A)</option>
                <option value="emailA" {{ (request()->order ==  'emailA' ? 'selected' : '') }}>Email (A => Z)</option>
                <option value="emailZ" {{ (request()->order ==  'emailZ' ? 'selected' : '') }}>Email (Z => A)</option>
                <option value="notActive" {{ (request()->order ==  'notActive' ? 'selected' : '') }}>Not active</option>
                <option value="admin" {{ (request()->order ==  'admin' ? 'selected' : '') }}>Admin</option>
            </select>
        </div>
    </div>
</form>
@if ($users->count() == 0 )
<div class="alert alert-danger alert-dismissible fade show">
    Can't find any user with <b>'{{ request()->user }}'</b> in the name/ email.
    <button type="button" class="close" data-dismiss="alert">
        <span>&times;</span>
    </button>
</div>
@else
@include('shared.alert')
<div class="table-responsive">
    <table class="table">
        <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Email</th>
            <th>Active</th>
            <th>Admin</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
        <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            @if ($user->active === 1)
            <td><i class="fas fa-check"></i></td>
            @else
            <td></td>
            @endif
            @if ($user->admin === 1)
            <td><i class="fas fa-check"></i></td>
            @else
            <td></td>
            @endif
            @if($user->id === $huidige_user->id)
            <td data-id="{{ $user->id }}"
                data-name="{{ $user->name }}">
                <div class="btn-group btn-group-sm">
                    <button id="edit" class="btn btn-outline-success btn-edit" style="cursor:not-allowed;" disabled>
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn btn-outline-danger btn-delete" id="delete" style="cursor:not-allowed;" disabled>
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </td>
            @else
            <td data-id="{{ $user->id }}"
                data-name="{{ $user->name }}">
                <div class="btn-group btn-group-sm">
                    <a href="/admin/users/{{$user->id}}/edit" id="edit" class="btn btn-outline-success btn-edit" data-toggle="tooltip" title="Edit {{ $user->name }}">
                        <i class="fas fa-edit"></i>
                    </a>
                    <a href="#!" class="btn btn-outline-danger btn-delete" id="delete" data-toggle="tooltip" title="Delete {{ $user->name }}">
                        <i class="fas fa-trash"></i>
                    </a>
                </div>
            </td>
            @endif
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endif

{{ $users->links() }}
@endsection

@section('script_after')
<script>
    $(function () {
        $('#user').blur(function () {
            $('#searchForm').submit();
        });

        $('#order').blur(function () {
            $('#searchForm').submit();
        });
        if({{ $user->id }}==={{ $huidige_user->id }}){
            $('#edit').attr('disabled');
            $('#delete').attr('disabled');
        }

        $('tbody').on('click', '.btn-delete', function () {
            let id = $(this).closest('td').data('id');
            let name = $(this).closest('td').data('name');
            let text = `<p>Delete the user <b>${name}</b>?</p>`;
            let type = 'warning';
            let btnText = 'Delete user';
            let btnClass = 'btn-success';
            let modal = new Noty({
                type: type,
                text: text,
                buttons: [
                    Noty.button(btnText, `btn ${btnClass}`, function () {
                        deleteUser(id);
                        modal.close();
                    }),
                    Noty.button('Cancel', 'btn btn-secondary ml-2', function () {
                        modal.close();
                    })
                ]
            }).show();
        });
    });
    function deleteUser(id) {
        let pars = {
            '_token': '{{ csrf_token() }}',
            '_method': 'delete'
        };
        $.post(`/admin/users/${id}`, pars, 'json')
            .done(function (data) {
                console.log('data', data);
                VinylShop.toast({
                    type: data.type,
                    text: data.text,
                    layout: "topCenter"
                });
            })
            .fail(function (e) {
                console.log('error', e);
            });
        $('td[data-id=' + id + ']').closest('tr').remove();
    }

</script>

@endsection
