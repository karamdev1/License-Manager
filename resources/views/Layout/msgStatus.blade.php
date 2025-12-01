@if($errors->any())
    <div class="alert alert-danger fade show" role="alert">
        {!! $errors->first() !!}
    </div>
@endif

@if (session()->has('msgSuccess'))
    <div class="alert alert-success fade show" role="alert">
        {!! session('msgSuccess') !!}
    </div>
@endif

@if (session()->has('msgSuccess2'))
    <div class="alert alert-success fade show" role="alert">
        {!! session('msgSuccess2') !!}
    </div>
@endif

@if (session()->has('msgWarning'))
    <div class="alert alert-warning fade show" role="alert">
        {!! session('msgWarning') !!}
    </div>
@endif

@if (session()->has('msgWarning2'))
    <div class="alert alert-warning fade show" role="alert">
        {!! session('msgWarning2') !!}
    </div>
@endif

@if (session()->has('msgInfo'))
    <div class="alert alert-primary fade show" role="alert">
        {!! session('msgInfo') !!}
    </div>
@endif

@if (session()->has('msgInfo2'))
    <div class="alert alert-primary fade show" role="alert">
        {!! session('msgInfo2') !!}
    </div>
@endif

@if (!$errors->any() && !session()->has('msgSuccess') && !session()->has('msgWarning') && !session()->has('msgInfo'))
    @auth
        @if (Route::currentRouteName() === 'keys')
            <div class="alert alert-primary fade show" role="alert">
                <strong>INFO</strong> · Search specify key by their (id, owner, app, key, duration, devices, registrar or price).
            </div>
        @else
            <div class="alert alert-secondary fade show" role="alert">
                Welcome {{ auth()->user()->name }}
            </div>
        @endif
    @else
        <div class="alert alert-secondary fade show" role="alert">
            {{ config('app.name') }}
        </div>
    @endauth
@endif
