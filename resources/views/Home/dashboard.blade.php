@extends('Layout.app')

@section('title', 'Dashboard')

@php
    use App\Http\Controllers\Controller;
@endphp

@section('content')
    <div class="col-lg-12">
        @include('Layout.msgStatus')
        <div class="row">
            <div class="col-lg-4">
                <div class="card mb-5">
                    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                        Keys Registration
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="card mb-5">
                    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                        Apps Registration
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card mb-5">
                    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                        Information
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-hover mb-3">
                            <li class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                Name
                                <span class="badge text-dark fw-bold">{{ auth()->user()->name }}</span>
                            </li>
                            <li class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                Permissions
                                <span class="badge text-dark fw-bold">{{ auth()->user()->permissions }}</span>
                            </li>
                        </ul>
                        <ul class="list-group">
                            <li class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                Login Time
                                <span id="login-timer" class="badge text-dark fw-semibold" data-logintime="{{ $loginTime ? $loginTime->toIso8601String() : null }}"></span>
                            </li>
                        </ul>
                        <ul class="list-group">
                            <li class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                Auto Logout
                                <span id="expiry-timer" class="badge text-dark fw-semibold" data-expiry="{{ $expiryTime }}"></span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function updateLoginTime() {
            const timerElem = document.getElementById('login-timer');
            const loginTimeStr = timerElem.getAttribute('data-logintime');

            if (!loginTimeStr) {
                timerElem.textContent = 'never logged in';
                return 60000;
            }

            const loginTime = new Date(loginTimeStr).getTime();
            if (isNaN(loginTime)) {
                timerElem.textContent = 'invalid date';
                return 60000;
            }

            const now = Date.now();
            const diff = Math.floor((now - loginTime) / 1000);

            let display = '';
            if (diff < 60) {
                display = diff + ' seconds ago';
            } else if (diff < 3600) {
                const minutes = Math.floor(diff / 60);
                display = `${minutes} minutes ago`;
            } else if (diff < 86400) {
                const hours = Math.floor(diff / 3600);
                display = `${hours} hours ago`;
            } else {
                const days = Math.floor(diff / 86400);
                display = `${days} days ago`;
            }

            timerElem.textContent = display;

            if (diff < 60) return 1000;
            else if (diff < 3600) return 30000;
            else return 300000;
        }

        function updateExpiryTime() {
            const expiryElem = document.getElementById('expiry-timer');
            const expiryStr = expiryElem.getAttribute('data-expiry');

            if (!expiryStr) {
                expiryElem.textContent = 'no expiry';
                return 60000;
            }

            const expiryTime = new Date(expiryStr).getTime();
            if (isNaN(expiryTime)) {
                expiryElem.textContent = 'invalid expiry';
                return 60000;
            }

            const now = Date.now();
            let diff = Math.floor((expiryTime - now) / 1000);

            if (diff <= 0) {
                expiryElem.textContent = 'expired';
                return 60000;
            }

            let display = '';
            if (diff < 60) {
                display = `in ${diff} seconds`;
            } else if (diff < 3600) {
                const minutes = Math.floor(diff / 60);
                display = `in ${minutes} minutes`;
            } else if (diff < 86400) {
                const hours = Math.floor(diff / 3600);
                display = `in ${hours} hours`;
            } else {
                const days = Math.floor(diff / 86400);
                display = `in ${days} days`;
            }

            expiryElem.textContent = display;

            if (diff < 60) return 1000;
            else if (diff < 3600) return 30000;
            else return 300000;
        }

        function startExpiryTimer() {
            const interval = updateExpiryTime();
            setTimeout(startExpiryTimer, interval);
        }

        function startLoginTimer() {
            const interval = updateLoginTime();
            setTimeout(startLoginTimer, interval);
        }

        startExpiryTimer();
        startLoginTimer();
    </script>
@endsection