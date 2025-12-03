@extends('Layout.app')

@section('title', 'Licenses')

@php
    use App\Http\Controllers\LicenseController;
    use App\Http\Controllers\Controller;
@endphp

@section('content')
    <div class="col-lg-10">
        @include('Layout.msgStatus')
        <div class="card shadow-sm">
            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                Licenses Registered
                <div class="d-flex align-items-center gap-2">
                    <a href="{{ route('licenses.generate') }}" class="btn btn-outline-light btn-sm"><i class="bi bi-key"></i> LICENSE</a>
                    <button class="btn btn-secondary btn-sm ms-1" id="blur-out" data-bs-toggle="tooltip" data-bs-placement="top" title="Eye Protect"><i class="bi bi-eye-slash"></i></button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    @if ($licenses->isNotEmpty())
                        <table id="datatable" class="table table-bordered table-hover text-center dataTable no-footer" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Owner</th>
                                    <th>App</th>
                                    <th>User Licenses</th>
                                    <th>Devices</th>
                                    <th>Duration</th>
                                    <th>Created</th>
                                    <th>Registrar</th>
                                    <th>Price</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            @foreach ($licenses as $item)
                                @php
                                    if ($item->owner == NULL) {
                                        $owner = "N/A";
                                    } else {
                                        $owner = $item->owner;
                                    }

                                    $price = number_format(LicenseController::licensePriceCalculator($item->app->price, $item->max_devices, $item->duration));
                                    $raw_price = LicenseController::licensePriceCalculator($item->app->price, $item->max_devices, $item->duration);

                                    if ($raw_price < 10000) {
                                        $price = $price;
                                    } else if ($raw_price >= 10000 && $raw_price < 1000000) {
                                        $price = number_format($raw_price / 1000) . 'k';
                                    } else if ($raw_price >= 1000000 && $raw_price < 1000000000) {
                                        $price = number_format($raw_price / 1000000) . 'm';
                                    } else if ($raw_price >= 1000000000 && $raw_price < 1000000000000) {
                                        $price = number_format($raw_price / 1000000000) . 'b';
                                    } else if ($raw_price >= 1000000000000) {
                                        $price = number_format($raw_price / 1000000000000) . 't';
                                    } else {
                                        $price = "N/A";
                                    }
                                @endphp
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $owner }}</td>
                                    <td>{{ $item->app->name ?? 'N/A' }}</td>
                                    <td><span class="align-middle badge fw-normal text-{{ Controller::statusColor($item->status) }} fs-6 blur Blur px-3 copy-trigger" data-copy="{{ $item->license }}">{{ $item->license }}</span></td>
                                    <td><span class="align-middle badge fw-normal text-white bg-dark fs-6">{{ LicenseController::DevicesHooked($item->devices) }}/{{ $item->max_devices ?? 'N/A' }}</span></td>
                                    <td class="text-{{ LicenseController::RemainingDaysColor(LicenseController::RemainingDays($item->expire_date)) }}">{{ LicenseController::RemainingDays($item->expire_date) }}/{{ $item->duration ?? 'N/A' }} Days</td>
                                    <td><i class="align-middle badge fw-normal text-dark fs-6">{{ Controller::timeElapsed($item->created_at) ?? 'N/A' }}</i></td>
                                    <td>{{ Controller::userUsername($item->registrar) }}</td>
                                    <td title="{{ $raw_price . $currency }}">{{ $price . $currency }}</td>
                                    <td>
                                        <button type="button" class="btn btn-outline-danger btn-sm resetApiKey" data-id="{{ $item->edit_id }}">
                                            <i class="bi bi-bootstrap-reboot"></i>
                                        </button>

                                        <a href={{ route('licenses.edit', ['id' => $item->edit_id]) }} class="btn btn-outline-dark btn-sm">
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
                                    <th colspan="10"><span class="align-middle badge text-dark fs-6 fw-normal">There are no <strong>licenses</strong> to show</span></th>
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
                    { targets: [4], searchable: false },
                    { targets: [0, 3, 5, 6, 8], searchable: true },
                    { targets: [1, 2, 7], visible: false, searchable: true },
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

            $('.resetApiKey').click(function() {
                const id = $(this).data('id');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "Are you sure you want to reset the license?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, reset'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Toast.fire({
                            icon: 'info',
                            title: 'Please wait...'
                        })

                        window.location.href = `/licenses/resetApiKey/${id}`;
                    }
                });
            });

            $('.copy-trigger').click(async function() {
                const copy = $(this).data('copy');

                const code = await copyToClipboard(copy);

                let message = "";
                let icon = "error";

                switch (code) {
                    case 0:
                        message = `<b>License</b> ${copy} <b>Successfully Copied</b>`;
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