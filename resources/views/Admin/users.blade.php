<section class="flex flex-col lg:flex-row gap-4 w-full items-stretch lg:justify-center lg:items-center">
    <div class="flex flex-col min-w-0 lg:w-[95%]">
        @php
            $usersTitle="
            <div class='flex justify-between items-center'>
                Users Registered

                <div class='flex gap-2'>
                    <button id='reloadBtnUsers' 
                            class='bg-transparent text-white border border-white hover:border-transparent hover:bg-primary uppercase px-2 py-1 
                            rounded shadow transition duration-200 flex items-center gap-2 text-[14px]'>
                        <i class='bi bi-arrow-clockwise'></i>
                        Refresh
                    </button>
                    <button id='createBtnUsers'
                            class='bg-transparent text-white border border-white hover:border-transparent hover:bg-primary uppercase px-2 py-1 
                            rounded shadow transition duration-200 flex items-center gap-2 text-[14px]'>
                        <i class='bi bi-person'></i>
                        User
                    </button>
                    <button id='blur-out-users' title='Eye Protect'
                            class='bg-secondary text-white hover:bg-secondary-darker uppercase px-2 py-1 
                            rounded shadow transition duration-200 flex items-center gap-2 text-[14px]'>
                        <i class='bi bi-eye-slash'></i>
                    </button>
                </div>
            </div>
            ";
        @endphp
        <x-card title="{!! $usersTitle !!}" class="w-full">
            <div class="overflow-auto relative scrollbar-thin scrollbar-thumb-gray-400 scrollbar-track-gray-200">
                <table class="w-full min-w-full divide-y divide-gray-200" id="users_table">
                    <thead class="bg-gray-50">
                        <tr class="border border-gray-200">
                            <th class="px-6 py-3 text-left text-sm font-medium text-dark-text uppercase tracking-wider">
                                #
                            </th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-dark-text uppercase tracking-wider">
                                Name
                            </th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-dark-text uppercase tracking-wider">
                                Username
                            </th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-dark-text uppercase tracking-wider">
                                Email
                            </th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-dark-text uppercase tracking-wider">
                                Saldo
                            </th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-dark-text uppercase tracking-wider">
                                Role
                            </th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-dark-text uppercase tracking-wider">
                                Reff
                            </th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-dark-text uppercase tracking-wider">
                                Registrar
                            </th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-dark-text uppercase tracking-wider">
                                Created
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