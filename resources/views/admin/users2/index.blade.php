@extends('layouts.template')

@section('title', 'Users (advanced)')

@section('main')
    <h1>Users (advanced)</h1>
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
                                data-name="{{ $user->name }}"
                                data-email="{{ $user->email }}"
                                data-active="{{ $user->active }}"
                                data-admin="{{ $user->admin }}">
                                <div class="btn-group btn-group-sm">
                                    <a href="#!" id="edit" class="btn btn-outline-success btn-edit" data-toggle="tooltip" title="Edit {{ $user->name }}">
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
    @include('admin.users2.modal')
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
            $('tbody').on('click', '.btn-edit', function () {
                // Get data attributes from td tag
                let id = $(this).closest('td').data('id');
                let name = $(this).closest('td').data('name');
                let email = $(this).closest('td').data('email');
                let active = $(this).closest('td').data('active');
                let admin = $(this).closest('td').data('admin');
                // Update the modal
                $('.modal-title').text(`Edit ${name}`);
                $('form').attr('action', `/admin/users2/${id}`);
                $('#name').val(name);
                $('#email').val(email);
                if(active===1){
                    $('#active').prop('checked', true);
                }
                if (active===0){
                    $('#active').prop('checked', false);
                }
                if(admin===1){
                    $('#admin').prop('checked', true);
                }
                if (admin===0){
                    $('#admin').prop('checked', false);
                }
                $('input[name="_method"]').val('put');
                // Show the modal
                $('#modal-user').modal('show');
            });
            $('#modal-user form').submit(function (e) {
                // Don't submit the form
                e.preventDefault();
                // Get the action property (the URL to submit)
                let action = $(this).attr('action');
                // Serialize the form and send it as a parameter with the post
                let pars = $(this).serialize();
                console.log(pars);
                // Post the data to the URL
                $.post(action, pars, 'json')
                    .done(function (data) {
                        console.log(data);
                        // show success message
                        VinylShop.toast({
                            type: data.type,
                            text: data.text
                        });
                        // Hide the modal
                        $('#modal-user').modal('hide');
                        if (data.active === 1) {
                            var text1 = '<i class="fas fa-check"></i>';
                        }
                        else{
                            var text1 = "";
                        }
                        if (data.admin === 1) {
                            var text2 = '<i class="fas fa-check"></i>';
                        }
                        else{
                            var text2 = "";
                        }
                        $('td[data-id=' + data.id + ']').closest('tr').replaceWith(`<tr>
                            <td>${data.id}</td>
                            <td>${data.name}</td>
                            <td>${data.email}</td>
                            <td>${text1}</td>
                            <td>${text2}</td>
                        <td data-id="${data.id}"
                                data-name="${data.name}"
                                data-email="${data.email}"
                                data-active="${data.active}"
                                data-admin="${data.admin}">
                                <div class="btn-group btn-group-sm">
                                    <a href="#!" id="edit" class="btn btn-outline-success btn-edit" data-toggle="tooltip" title="Edit ${data.name}">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="#!" class="btn btn-outline-danger btn-delete" id="delete" data-toggle="tooltip" title="Delete ${data.name}">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>`);

                    })
                    .fail(function (e) {
                        console.log('error', e);
                        // e.responseJSON.errors contains an array of all the validation errors
                        console.log('error message', e.responseJSON.errors);
                        // Loop over the e.responseJSON.errors array and create an ul list with all the error messages
                        let msg = '<ul>';
                        $.each(e.responseJSON.errors, function (key, value) {
                            msg += `<li>${value}</li>`;
                        });
                        msg += '</ul>';
                        // show the errors
                        VinylShop.toast({
                            type: 'error',
                            text: msg
                        });

                    });

            });
        });

        function deleteUser(id) {
            let pars = {
                '_token': '{{ csrf_token() }}',
                '_method': 'delete'
            };
            $.post(`/admin/users2/${id}`, pars, 'json')
                .done(function (data) {
                    console.log('data', data);
                    VinylShop.toast({
                        type: data.type,
                        text: data.text,
                        layout: "topCenter"
                    });
                    $('td[data-id=' + id + ']').closest('tr').remove();
                })
                .fail(function (e) {
                    console.log('error', e);
                });

        }
    </script>

@endsection
