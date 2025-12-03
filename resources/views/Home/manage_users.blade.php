@extends('Layout.app')

@section('title', 'Users')

@php
    use App\Http\Controllers\Controller;
@endphp

@section('content')
    <div class="col-lg-10">
        @include('Layout.msgStatus')
        <div class="card shadow-sm mb-5">
            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                Users Registered
                <div class="d-flex align-items-center gap-2">
                    <a class="btn btn-outline-light btn-sm" href={{ route('admin.users.history') }}><i class="bi bi-person"></i> HISTORY</a>
                    <a class="btn btn-outline-light btn-sm" href={{ route('admin.users.generate') }}><i class="bi bi-person"></i> USER</a>
                    <button class="btn btn-secondary btn-sm ms-1" id="blur-out" data-bs-toggle="tooltip" data-bs-placement="top" title="Eye Protect"><i class="bi bi-eye-slash"></i></button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    @if ($users->isNotEmpty())
                        <table id="datatable" class="table table-bordered table-hover text-center dataTable no-footer">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Username</th>
                                    <th>Saldo</th>
                                    <th>Role</th>
                                    <th>Reff</th>
                                    <th>Registrar</th>
                                    <th>Created</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            @foreach ($users as $item)
                                @php
                                    if ($item->referrable != NULL) {
                                        $reff_status = Controller::statusColor($item->referrable->status);
                                        $reff_code = Controller::censorText($item->referrable->code);
                                    } else {
                                        $reff_status = 'dark';
                                        $reff_code = "N/A";
                                    }

                                    $saldo = Controller::saldoData($item->saldo, $item->role);
                                @endphp
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td class="text-{{ Controller::statusColor($item->status) }}">{{ $item->name }}</td>
                                    <td><span class="align-middle badge fw-normal text-{{ Controller::statusColor($item->status) }} fs-6 blur Blur copy-trigger" data-copy="{{ $item->username }}">{{ $item->username }}</span></td>
                                    <td class="text-{{ $saldo[1] }}">{{ $saldo[0] }}</td>
                                    <td class="text-{{ Controller::permissionColor($item->role) }}">{{ $item->role }}</td>
                                    <td class="text-{{ $reff_status }}">{{ $reff_code }}</td>
                                    <td>{{ Controller::userUsername($item->registrar) }}</td>
                                    <td><i class="align-middle badge fw-normal text-dark fs-6">{{ Controller::timeElapsed($item->created_at) }}</i></td>
                                    <td>
                                        <a href={{ route('admin.users.wallet', ['id' => $item->user_id]) }} class="btn btn-outline-dark btn-sm">
                                            <i class="bi bi-wallet"></i>
                                        </a>

                                        <a href={{ route('admin.users.history.user', ['id' => $item->user_id]) }} class="btn btn-outline-dark btn-sm">
                                            <i class="bi bi-person"></i>
                                        </a>

                                        <a href={{ route('admin.users.edit', ['id' => $item->user_id]) }} class="btn btn-outline-dark btn-sm">
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
                                    <th colspan="9"><span class="align-middle badge text-dark fs-6 fw-normal">There are no <strong>users</strong> to show</span></th>
                                </tr>
                            </thead>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        async function copyToClipboard(text) {
            if (navigator.clipboard && window.isSecureContext) {
                try {
                    await navigator.clipboard.writeText(text);
                    return 0;
                } catch (e) {
                    return 1;
                }
            }

            let exitCode = 3;

            const temp = document.createElement("textarea");
            temp.value = text;
            document.body.appendChild(temp);
            temp.select();

            try {
                if (document.execCommand("copy")) {
                    exitCode = 0;
                } else {
                    exitCode = 2;
                }
            } catch (e) {
                exitCode = 2;
            }

            document.body.removeChild(temp);
            return exitCode;
        }

        $(document).ready(function() {
            $('#datatable').DataTable({
                pageLength: 10,
                lengthChange: true,
                ordering: true,
                order: [[0,'desc']],
                columnDefs: [
                    { targets: [7, 8], searchable: false },
                    { targets: [0, 1, 2, 4, 5, 6], searchable: true },
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

            $('.copy-trigger').click(async function() {
                const copy = $(this).data('copy');

                const code = await copyToClipboard(copy);

                let message = "";
                let icon = "error";

                switch (code) {
                    case 0:
                        message = `<b>User</b> ${copy} <b>Successfully Copied</b>`;
                        icon = "success";
                        break;
                    case 1:
                        message = "Clipboard API failed.";
                        break;
                    case 2:
                        message = "Fallback copy failed.";
                        break;
                    case 3:
                        message = "Clipboard API not available (HTTP or insecure context).";
                        break;
                }

                Swal.fire({
                    title: icon === "success" ? "Success" : "Failed",
                    html: message,
                    icon: icon,
                    showConfirmButton: true,
                });
            });
        });
    </script>
@endsection