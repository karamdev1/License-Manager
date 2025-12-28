<section class="flex flex-col lg:flex-row gap-4 w-full items-stretch">
    <div class="flex flex-col min-w-0 lg:flex-3">
        @php
            $homeLicenseTitle="
            <div class='flex justify-between items-center'>
                Registrations History

                <button id='reloadBtnDashboard'
                        class='bg-transparent text-white border border-white hover:border-transparent hover:bg-primary uppercase px-2 py-1 
                        rounded shadow transition duration-200 flex items-center gap-2 text-[14px]'>
                    <i class='bi bi-arrow-clockwise'></i>
                    Refresh
                </button>
            </div>
            ";
        @endphp
        <x-card title="{!! $homeLicenseTitle !!}">
            <div class="overflow-auto relative scrollbar-thin scrollbar-thumb-gray-400 scrollbar-track-gray-200">
                <table class="w-full min-w-full divide-y divide-gray-200" id="home_table">
                    <thead class="bg-gray-50">
                        <tr class="border border-gray-200">
                            <th class="px-6 py-3 text-left text-xs font-medium text-dark-text uppercase tracking-wider">
                                #
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-dark-text uppercase tracking-wider">
                                User License
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-dark-text uppercase tracking-wider">
                                Duration
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-dark-text uppercase tracking-wider">
                                Registrar
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-dark-text uppercase tracking-wider">
                                Devices
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-dark-text uppercase tracking-wider">
                                Created
                            </th>
                        </tr>
                    </thead>
                </table>
            </div>
        </x-card>
    </div>

    <div class="flex flex-col min-w-0 lg:flex-2 xl:flex-1">
        <x-card title="<p class='text-center'>Information</p>" class="w-full max-w-xs">
            <ul class="mb-2">
                <li class="bg-white hover:bg-gray-200 rounded-t px-5 py-2 flex justify-between align-middle border border-gray-200">
                    Name
                    <span class="text-sm text-dark">{{ auth()->user()->name }}</span>
                </li>
                <li class="bg-white hover:bg-gray-200 px-5 py-2 flex justify-between align-middle border border-gray-200">
                    Roles
                    <span class="text-sm text-{{ permissionColor(auth()->user()->role) }}">{{ auth()->user()->role }}</span>
                </li>
                <li class="bg-white hover:bg-gray-200 rounded-b px-5 py-2 flex justify-between align-middle border border-gray-200">
                    Saldo
                    @php $saldo = saldoData(auth()->user()->saldo, auth()->user()->role); @endphp
                    <span class="text-sm text-{{ $saldo[1] }}">{{ $saldo[0] }}</span>
                </li>
            </ul>
            <ul class="mb-2">
                <li class="bg-white hover:bg-gray-200 rounded-t px-5 py-2 flex justify-between align-middle border border-gray-200">
                    Login Time
                    <span id="login-timer" class="text-sm text-dark-text" data-logintime="{{ $loginTime ? $loginTime->toIso8601String() : null }}"></span>
                </li>
                <li class="bg-white hover:bg-gray-200 rounded-b px-5 py-2 flex justify-between align-middle border border-gray-200">
                    Auto Logout
                    <span id="expiry-timer" class="text-sm text-dark-text" data-expiry="{{ $expiryTime }}"></span>
                </li>
            </ul>
        </x-card>
    </div>
</section>