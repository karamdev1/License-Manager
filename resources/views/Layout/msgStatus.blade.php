@auth
    @if (Route::currentRouteName() === 'licenses')
        <div class="bg-secondary-light border border-gray-300 rounded-md shadow-md px-4 py-5">
            <B>INFO</B> · Search specify licenses by their info.
        </div>
    @elseif (Route::currentRouteName() === 'apps')
        <div class="bg-secondary-light border border-gray-300 rounded-md shadow-md px-4 py-5">
            <B>INFO</B> · Search specify apps by their info.
        </div>
    @elseif (Route::currentRouteName() === 'admin.users')
        <div class="bg-secondary-light border border-gray-300 rounded-md shadow-md px-4 py-5">
            <B>INFO</B> · Search specify users by their info.
        </div>
    @elseif (Route::currentRouteName() === 'admin.referrable')
        <div class="bg-secondary-light border border-gray-300 rounded-md shadow-md px-4 py-5">
            <B>INFO</B> · Search specify reffs by their info.
        </div>
    @elseif (Route::currentRouteName() === 'admin.users.history.user')
        <div class="bg-secondary-light border border-gray-300 rounded-md shadow-md px-4 py-5">
            <B>INFO</B> · Search specify users history by their info.
        </div>
    @else
        <div class="bg-secondary-light border border-gray-300 rounded-md shadow-md px-4 py-5">
            Welcome {{ auth()->user()->name }}
        </div>
    @endif
@else
    <div class="bg-secondary-light border border-gray-300 rounded-md shadow-md px-4 py-5">
        {{ config('app.name') }}
    </div>
@endauth