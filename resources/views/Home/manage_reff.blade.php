@extends('Layout.app')

@section('title', 'Referrables Code')

@php
    use App\Http\Controllers\Controller;
    use App\Http\Controllers\DashController;
@endphp

@section('content')
    <div class="col-lg-10">
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
                        <table id="datatable" class="table table-bordered table-hover text-center dataTable no-footer">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Code</th>
                                    <th>Status</th>
                                    <th>Users Count</th>
                                    <th>Registrar</th>
                                    <th>Created</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            @foreach ($reffs as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td><span class="align-middle badge fw-normal text-{{ Controller::statusColor($item->status) }} fs-6 blur Blur copy-trigger" data-copy="{{ $item->code }}">{{ $item->code }}</span></td>
                                    <td class="text-{{ Controller::statusColor($item->status) }}">{{ $item->status }}</td>
                                    <td>{{ DashController::UsersCreated($item->edit_id) }}</td>
                                    <td>{{ Controller::userUsername($item->registrar) }}</td>
                                    <td><i class="align-middle badge fw-normal text-dark fs-6">{{ Controller::timeElapsed($item->created_at) }}</i></td>
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

            $('.copy-trigger').click(async function() {
                const copy = $(this).data('copy');

                const code = await copyToClipboard(copy);

                let message = "";
                let icon = "error";

                switch (code) {
                    case 0:
                        message = `<b>Reff</b> ${copy} <b>Successfully Copied</b>`;
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