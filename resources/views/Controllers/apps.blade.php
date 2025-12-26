<section class="flex flex-col lg:flex-row gap-4 w-full items-stretch lg:justify-center lg:items-center">
    <div class="flex flex-col min-w-0 lg:w-[95%]">
        <div class="bg-dark rounded-t shadow px-5 py-2 flex justify-between items-center">
            <h1 class="text-md text-white mb-0">
                Apps Registered
            </h1>
            <button id="reloadBtnApps" 
                    class="bg-transparent text-white border border-white hover:border-transparent hover:bg-primary uppercase px-2 py-1 
                    rounded shadow transition duration-200 flex items-center gap-2">
                <i class="bi bi-arrow-clockwise"></i>
                Refresh
            </button>
        </div>

        <div class="overflow-auto relative scrollbar-thin scrollbar-thumb-gray-400 scrollbar-track-gray-200 bg-white rounded-b shadow p-5">
            <table class="w-full min-w-full divide-y divide-gray-200" id="apps_table">
                <thead class="bg-gray-50">
                    <tr class="border border-gray-200">
                        <th class="px-6 py-3 text-left text-sm font-medium text-dark-text uppercase tracking-wider">
                            #
                        </th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-dark-text uppercase tracking-wider">
                            Name
                        </th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-dark-text uppercase tracking-wider">
                            Price
                        </th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-dark-text uppercase tracking-wider">
                            Licenses
                        </th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-dark-text uppercase tracking-wider">
                            Created
                        </th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-dark-text uppercase tracking-wider">
                            Registrar
                        </th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-dark-text uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</section>

<script>
    let apps_table = null;

    function initAppsTable() {
        if (apps_table) return;

        apps_table = $('#apps_table').DataTable({
            processing: true,
            responsive: true,
            ajax: "{{ route('api.private.apps.registrations') }}",
            columns: [
                { data: 'id' },
                { data: 'name' },
                { data: 'price' },
                { data: 'licenses' },
                { data: 'registrar' },
                { data: 'created' },
                {
                    data: 'ids',
                    render: function(data, type, row) {
                        let url = `https://license.192.168.10.22.nip.io/apps/${data[0]}`;
                        return `
                        <button type="button" class="btn btn-outline-dark btn-sm copy-trigger" data-copy="${data[1]}" data-name="${data[2]}"><i class="bi bi-clipboard"></i></button>
                        <a href='${url}' class="btn btn-outline-dark btn-sm"><i class="bi bi-pencil-square"></i></a>
                        `;
                    }
                },
            ],
            columnDefs: [
                { targets: [4], searchable: false },
                { targets: [0, 1, 2, 3], searchable: true },
                { targets: [5], visible: false, searchable: true },
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

    function AppsTableReload() {
        if (apps_table) {
            apps_table.ajax.reload(null, false);
        }
    }

    $(document).ready(function () {
        $('#reloadBtnApps').on('click', () => {
            AppsTableReload();
        });
    });
</script>