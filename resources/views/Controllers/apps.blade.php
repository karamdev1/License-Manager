<section class="flex flex-col lg:flex-row gap-4 w-full items-stretch lg:justify-center lg:items-center">
    <div class="flex flex-col min-w-0">
        <div class="bg-dark rounded-t shadow px-5 py-2 flex justify-between items-center">
            <h1 class="text-sm lg:text-md text-white mb-0">
                Licenses Registrations History
            </h1>
            <button id="reloadBtn" 
                    class="bg-transparent text-white border border-white hover:border-transparent hover:bg-primary uppercase px-2 py-1 
                    rounded shadow transition duration-200 flex items-center gap-2">
                <i class="bi bi-arrow-clockwise"></i>
                Refresh
            </button>
        </div>

        <div class="overflow-auto relative scrollbar-thin scrollbar-thumb-gray-400 scrollbar-track-gray-200 bg-white rounded-b shadow p-5">
            <table class="w-full min-w-full divide-y divide-gray-200 " id="licenses_table">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-dark-text uppercase tracking-wider border border-gray-200">
                            ID
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-dark-text uppercase tracking-wider border border-gray-200">
                            User License
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-dark-text uppercase tracking-wider border border-gray-200">
                            Duration
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-dark-text uppercase tracking-wider border border-gray-200">
                            Registrar
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-dark-text uppercase tracking-wider border border-gray-200">
                            Devices
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-dark-text uppercase tracking-wider border border-gray-200">
                            Created
                        </th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</section>