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
                        <table id="datatable" class="table table-bordered table-hover text-center dataTable no-footer" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Licenses Count</th>
                                    <th>Created</th>
                                    <th>Registrar</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            @foreach ($apps as $item)
                                @php
                                    $price = number_format($item->price);
                                    $raw_price = $item->price;

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

                                    $licensesCount = 0;

                                    foreach($item->licenses as $license) {
                                        $licensesCount += 1;
                                    }
                                @endphp
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td><span class="align-middle badge fw-normal text-{{ Controller::statusColor($item->status) }} fs-6 px-3">{{ $item->name }}</span></td>
                                    <td title="{{ number_format($raw_price) }}">{{ $price . $currency }}</td>
                                    <td>{{ number_format($licensesCount) }} License</td>
                                    <td><i class="align-middle badge fw-normal text-dark fs-6">{{ Controller::timeElapsed($item->created_at) }}</i></td>
                                    <td>{{ Controller::userUsername($item->registrar) }}</td>
                                    <td>
                                        <button type="button" class="btn btn-outline-dark btn-sm copy-trigger" data-name="{{ $item->name }}" data-copy="{{ $item->app_id }}">
                                            <i class="bi bi-clipboard"></i>
                                        </button>

                                        <a href={{ route('apps.edit', ['id' => $item->edit_id]) }} class="btn btn-outline-dark btn-sm">
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
                    { targets: -1, searchable: false },
                    { targets: [0, 1, 2, 4], searchable: true },
                    { targets: [5], visible: false, searchable: true },
                    { orderable: false, targets: -1 }
                ]
            });

            $('.copy-trigger').click(async function() {
                const copy = $(this).data('copy');
                const name = $(this).data('name');

                const code = await copyToClipboard(copy);

                let message = "";
                let icon = "error";

                switch (code) {
                    case 0:
                        message = `<b>App</b> ${name} <b>App ID Successfully Copied</b>`;
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