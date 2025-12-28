<section class="flex flex-col lg:flex-row gap-4 w-full items-stretch lg:justify-center lg:items-center">
    <div class="flex flex-col min-w-0 lg:w-[95%]">
        @php
            $licensesTitle="
            <div class='flex justify-between items-center'>
                Licenses Registered

                <div class='flex gap-2'>
                    <button id='reloadBtnLicenses' 
                            class='bg-transparent text-white border border-white hover:border-transparent hover:bg-primary uppercase px-2 py-1 
                            rounded shadow transition duration-200 flex items-center gap-2 text-[14px]'>
                        <i class='bi bi-arrow-clockwise'></i>
                        Refresh
                    </button>
                    <button id='createBtnLicenses'
                            class='bg-transparent text-white border border-white hover:border-transparent hover:bg-primary uppercase px-2 py-1 
                            rounded shadow transition duration-200 flex items-center gap-2 text-[14px]'>
                        <i class='bi bi-key'></i>
                        License
                    </button>
                </div>
            </div>
            ";
        @endphp
        <x-card title="{!! $licensesTitle !!}" class="w-full">
            <div class="overflow-auto relative scrollbar-thin scrollbar-thumb-gray-400 scrollbar-track-gray-200">
                <table class="w-full min-w-full divide-y divide-gray-200" id="licenses_table">
                    <thead class="bg-gray-50">
                        <tr class="border border-gray-200">
                            <th class="px-6 py-3 text-left text-sm font-medium text-dark-text uppercase tracking-wider">
                                #
                            </th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-dark-text uppercase tracking-wider">
                                User Licenses
                            </th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-dark-text uppercase tracking-wider">
                                Devices
                            </th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-dark-text uppercase tracking-wider">
                                Duration
                            </th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-dark-text uppercase tracking-wider">
                                Created
                            </th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-dark-text uppercase tracking-wider">
                                Price
                            </th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-dark-text uppercase tracking-wider">
                                Action
                            </th>
                        </tr>
                    </thead>
                </table>
            </div>
        </x-card>
    </div>
</section>

<script>
    let licenses_table = null;

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

    function initLicensesTable() {
        if (licenses_table) return;

        licenses_table = $('#licenses_table').DataTable({
            processing: true,
            responsive: true,
            deferLoading: 0,
            order: [[0,'desc']],
            ajax: {
                url: "{{ route('api.licenses.registrations') }}",
                method: "POST",
            },
            columns: [
                { data: 'id' },
                { data: 'owner' },
                { data: 'app' },
                { data: 'user_key' },
                { data: 'devices' },
                { data: 'duration' },
                { data: 'created' },
                { data: 'registrar' },
                { data: 'price' },
                {
                    data: 'edit_id',
                    render: function(data, type, row) {
                        let url = `{{ route('api.licenses.registrations') }}/${data}`;
                        return `
                        <button type="button" class="btn btn-outline-danger btn-sm resetApiKey" data-id="${data}"><i class="bi bi-bootstrap-reboot"></i></button>
                        <a href='${url}' class="btn btn-outline-dark btn-sm"><i class="bi bi-pencil-square"></i></a>
                        `;
                    }
                }
            ],
            columnDefs: [
                { targets: [4], searchable: false },
                { targets: [0, 3, 5, 6, 8], searchable: true },
                { targets: [1, 2, 7], visible: false, searchable: true },
                { orderable: false, targets: -1 }
            ],
            scrollX: true,
            stripeClasses: [],
            createdRow: function (row, data, dataIndex) {
                $(row).find('td').removeClass('p-3').addClass('px-6 py-3 text-center text-sm font-semibold text-dark-text border border-gray-200');
            },
            language: {
                processing: `
                    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2
                                bg-primary text-white px-4 py-2 rounded shadow z-50">
                        Processing...
                    </div>
                `
            }
        });
    }

    function LicensesTableReload() {
        if (licenses_table) {
            licenses_table.ajax.reload(null, false);
        }
    }

    $(document).ready(function () {
        $('#reloadBtnLicenses').on('click', function () {
            LicensesTableReload();
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

        $(document).on('click', '.resetApiKey', function() {
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

                    const url = ""

                    $.ajax({
                        url: `${url}/${id}`,
                        type: "GET",
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            if (response.status == 0) {
                                showPopup('Success', response.message);
                                LicensesTableReload();
                            } else {
                                showPopup('Error', response.message);
                            }
                        },
                        error: function (xhr) {
                            showPopup('Error', xhr.responseJSON.message);
                        }
                    });

                    table.ajax.reload(null, false);
                }
            });
        });

        $(document).on('click', '.copy-trigger', async function() {
            const copy = $(this).data('copy');

            const code = await copyToClipboard(copy);

            let message = "";
            let type = "error";

            switch (code) {
                case 0:
                    message = `<b>License</b> ${copy} <b>Successfully Copied</b>`;
                    type = "success";
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

            Toast.fire({
                html: message,
                icon: type,
            });
        });
    });
</script>