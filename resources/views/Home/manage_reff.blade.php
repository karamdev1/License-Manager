@extends('Layout.app')

@section('title', 'Referrables Code')

@php
    use App\Http\Controllers\Controller;
    use App\Http\Controllers\DashController;
@endphp

@section('content')
    <div class="col-lg-12">
        @include('Layout.msgStatus')
        <div class="card mb-5">
            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                Referrables Registered
                <div class="d-flex align-items-center gap-2">
                    <a class="btn btn-outline-light btn-sm" href={{ route('admin.referrable.generate') }}><i class="bi bi-person-add"></i> REFF</a>
                    <button class="btn btn-secondary btn-sm ms-1" id="blur-out" data-bs-toggle="tooltip" data-bs-placement="top" title="Eye Protect"><i class="bi bi-eye-slash"></i></button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    @if ($reffs->isNotEmpty())
                        <table id="datatable" class="table table-sm table-bordered table-hover text-center" style="width:100%">
                            <thead>
                                <tr>
                                    <th><span class="align-middle badge fw-semibold text-dark fs-6">#</span></th>
                                    <th><span class="align-middle badge fw-semibold text-dark fs-6">Code</span></th>
                                    <th><span class="align-middle badge fw-semibold text-dark fs-6">Status</span></th>
                                    <th><span class="align-middle badge fw-semibold text-dark fs-6">Users Count</span></th>
                                    <th><span class="align-middle badge fw-semibold text-dark fs-6">Registrar</span></th>
                                    <th><span class="align-middle badge fw-semibold text-dark fs-6">Created</span></th>
                                    <th><span class="align-middle badge fw-semibold text-dark fs-6">Action</span></th>
                                </tr>
                            </thead>
                            @foreach ($reffs as $item)
                                <tr>
                                    <td><span class="align-middle badge fw-semibold text-dark fs-6">{{ $item->id }}</span></td>
                                    <td><span class="align-middle badge fw-semibold text-{{ Controller::statusColor($item->status) }} fs-6 blur Blur">{{ $item->code }}</span></td>
                                    <td><span class="align-middle badge fw-semibold text-{{ Controller::statusColor($item->status) }} fs-6">{{ $item->status }}</span></td>
                                    <td><span class="align-middle badge fw-semibold text-dark fs-6">{{ DashController::UsersCreated($item->edit_id) }}</span></td>
                                    <td><span class="align-middle badge fw-semibold text-dark fs-6">{{ Controller::userUsername($item->registrar) }}</span></td>
                                    <td><i class="align-middle badge fw-semibold text-dark fs-6">{{ Controller::timeElapsed($item->created_at) }}</i></td>
                                    <td>
                                        <a href={{ route('admin.referrable.edit', ['id' => $item->edit_id]) }} class="btn btn-outline-dark btn-sm">
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
                                    <th colspan="7"><span class="align-middle badge text-dark fs-6 fw-normal">There are no <strong>referrables</strong> to show</span></th>
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
                    { targets: [5, 6], searchable: false },
                    { targets: [0, 1, 2, 3, 4], searchable: true },
                    { orderable: false, targets: -1 }
                ]
            });

            $("#blur-out").click(function() {
                if ($(".Blur").hasClass("blur")) {
                    $(".Blur").removeClass("blur");
                    $("#blur-out").html(`<i class="bi bi-eye"></i>`);
                } else {
                    $(".Blur").addClass("blur");
                    $("#blur-out").html(`<i class="bi bi-eye-slash"></i>`);
                }
            });
        });
    </script>
@endsection