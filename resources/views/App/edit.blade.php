@extends('Layout.app')

@section('title', 'Apps')

@section('content')
    <div class="col-lg-7">
        @include('Layout.msgStatus')
        <div class="card mb-5">
            <div class="card-header text-center text-white bg-dark">
                App Editing · {{ $app->name }}
            </div>
            <div class="card-body">
                <form action={{ route('apps.edit.post') }} method="post" id="updateForm">
                    @csrf
                    <input type="hidden" name="edit_id" id="edit_id" required value="{{ $app->edit_id }}">

                    <div class="form-group mb-3">
                        <label for="id" class="form-label">App ID</label>
                        <input type="text" name="id" id="id" class="form-control" required placeholder="App ID (Leave Empty for Random)" value="{{ $app->app_id }}">
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group mb-3">
                                <label for="name" class="form-label">App Name</label>
                                <input type="text" name="name" id="name" class="form-control" required placeholder="App Name" value="{{ $app->name }}">
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="">-- Select Status --</option>
                                    <option value="Active" class="text-success" @if ($app->status == 'Active') selected @endif>Active</option>
                                    <option value="Inactive" class="text-danger" @if ($app->status == 'Inactive') selected @endif>Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="price" class="form-label">Price</label>
                        <input type="text" name="price" id="price" class="form-control" required placeholder="Price Per Month" value="{{ $app->price }}">
                    </div>

                    <div class="form-group">
                        <button type="button" class="btn btn-outline-secondary mt-2" id="updateBtn">Update</button>

                        <button type="button" class="btn btn-outline-secondary mt-2" id="deleteBtn">Delete</button>

                        <button type="button" class="btn btn-outline-secondary mt-2" id="deleteKeysBtn">Delete Keys</button>
                        
                        <button type="button" class="btn btn-outline-secondary mt-2" id="deleteKeysMeBtn">Delete User Keys</button>
                    </div>
                </form>
                <form action={{ route('apps.delete') }} method="post" id="deleteForm">
                    @csrf
                    <input type="hidden" name="edit_id" id="edit_id" required value="{{ $app->edit_id }}">
                </form>
                <form action={{ route('apps.delete.keys') }} method="post" id="deleteKeysForm">
                    @csrf
                    <input type="hidden" name="edit_id" id="edit_id" required value="{{ $app->edit_id }}">
                </form>
                <form action={{ route('apps.delete.keys.me') }} method="post" id="deleteKeysMeForm">
                    @csrf
                    <input type="hidden" name="edit_id" id="edit_id" required value="{{ $app->edit_id }}">
                </form>
            </div>
        </div>
        <p class="text-muted text-center">
            <a href="{{ route('apps') }}" class="py-1 px-2 bg-white text-muted"><small><i class="bi bi-arrow-left"></i> Back to Apps</small></a>
        </p>
    </div>

    <script>
        document.getElementById('updateBtn').addEventListener('click', function() {
            Swal.fire({
                title: 'Are you sure?',
                text: "Are you sure you want to edit the app?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, edit'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('updateForm').submit();
                }
            });
        });

        document.getElementById('deleteBtn').addEventListener('click', function() {
            Swal.fire({
                title: 'Are you sure?',
                text: "Are you sure you want to delete the app?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('deleteKeys').submit();
                }
            });
        });

        document.getElementById('deleteKeysBtn').addEventListener('click', function() {
            Swal.fire({
                title: 'Are you sure?',
                text: "Are you sure you want to delete all the keys from the app?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('deleteKeysForm').submit();
                }
            });
        });

        document.getElementById('deleteKeysMeBtn').addEventListener('click', function() {
            Swal.fire({
                title: 'Are you sure?',
                text: "Are you sure you want to delete all your keys from the app?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('deleteKeysMeForm').submit();
                }
            });
        });
    </script>
@endsection