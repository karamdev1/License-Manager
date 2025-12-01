@extends('Layout.app')

@section('title', 'Apps')

@php
    use App\Http\Controllers\Controller;
@endphp

@section('content')
    <div class="col-lg-10">
        @include('Layout.msgStatus')
        <div class="card shadow-sm">
            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                Apps Registered
                <div class="d-flex align-items-center gap-2">
                    <a href="{{ route('apps.generate') }}" class="btn btn-outline-light btn-sm"><i class="bi bi-terminal"></i> APP</a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    @if ($apps->isNotEmpty())
                        <table id="datatable" class="table table-sm table-bordered table-hover text-center" style="width:100%">
                            <thead>
                                <tr>
                                    <th><span class="align-middle badge fw-semibold text-dark fs-6">#</span></th>
                                    <th><span class="align-middle badge fw-semibold text-dark fs-6">Name</span></th>
                                    <th><span class="align-middle badge fw-semibold text-dark fs-6">Price</span></th>
                                    <th><span class="align-middle badge fw-semibold text-dark fs-6">Created</span></th>
                                    <th><span class="align-middle badge fw-semibold text-dark fs-6">Registrar</span></th>
                                    <th><span class="align-middle badge fw-semibold text-dark fs-6">Action</span></th>
                                </tr>
                            </thead>
                            @foreach ($apps as $app)
                                <tr>
                                    <td><span class="align-middle badge fw-semibold text-dark fs-6">{{ $loop->iteration }}</span></td>
                                    <td><span class="align-middle badge fw-semibold text-dark fs-6">{{ $app->name }}</span></td>
                                    <td><span class="align-middle badge fw-semibold text-dark fs-6">{{ number_format($app->price) . $currency }}</span></td>
                                    <td><span class="align-middle badge fw-semibold text-dark fs-6">{{ Controller::timeElapsed($app->created_at) }}</span></td>
                                    <td><span class="align-middle badge fw-semibold text-dark fs-6">{{ Controller::userUsername($app->registrar) }}</span></td>
                                    <td>
                                        <a href={{ route('apps.edit', ['id' => $app->edit_id]) }} class="btn btn-outline-dark btn-sm">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    @else
                        <table class="table table-sm table-bordered table-hover text-center">
                            <thead>
                                <tr>
                                    <th colspan="6"><span class="align-middle badge text-dark fs-6 fw-normal">There are no <strong>apps</strong> to show</span></th>
                                </tr>
                            </thead>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#datatable').DataTable({
                pageLength: 10,
                lengthChange: true,
                ordering: true,
                order: [[0,'desc']],
                columnDefs: [
                    { orderable: false, targets: -1 }
                ]
            });
        });
    </script>
@endsection