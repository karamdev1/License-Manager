<nav class="flex flex-col gap-1">
    <h2 class="text-dark-text text-2xl md:hidden mb-3 font-bold text-center">{{ config('app.name') }}</h2>
    <h2 class="text-dark-text uppercase text-sm font-bold mt-2">Main</h2>
    <a href="#" @click.prevent="activePage='home'; sidebarOpen = false" 
        :class="activePage==='home' ? 'bg-primary text-white font-semibold' : 'text-dark-text hover:bg-gray-200'"
        class="px-4 py-2 rounded transition-colors duration-150"><i class="bi bi-house-fill"></i> Home</a>
    <a href="#" @click.prevent="activePage='apps'; sidebarOpen = false" 
        :class="activePage==='apps' ? 'bg-primary text-white font-semibold' : 'text-dark-text hover:bg-gray-200'"
        class="px-4 py-2 rounded transition-colors duration-150"><i class="bi bi-terminal-fill"></i> Apps</a>
    <a href="#" @click.prevent="activePage='licenses'; sidebarOpen = false" 
        :class="activePage==='licenses' ? 'bg-primary text-white font-semibold' : 'text-dark-text hover:bg-gray-200'"
        class="px-4 py-2 rounded transition-colors duration-150"><i class="bi bi-key-fill"></i> Licenses</a>
    @if (auth()->user()->role != "Reseller")
    <h2 class="text-dark-text uppercase text-sm font-bold mt-2">Admin</h2>
    <a href="#" @click.prevent="activePage='users'; sidebarOpen = false" 
        :class="activePage==='users' ? 'bg-primary text-white font-semibold' : 'text-dark-text hover:bg-gray-200'"
        class="px-4 py-2 rounded transition-colors duration-150"><i class="bi bi-person-fill"></i> Users</a>
    <a href="#" @click.prevent="activePage='reff'; sidebarOpen = false" 
        :class="activePage==='reff' ? 'bg-primary text-white font-semibold' : 'text-dark-text hover:bg-gray-200'"
        class="px-4 py-2 rounded transition-colors duration-150"><i class="bi bi-person-fill-add"></i> Referrables</a>
    <a href="#" @click.prevent="activePage='webui_settings'; sidebarOpen = false" 
        :class="activePage==='webui_settings' ? 'bg-primary text-white font-semibold' : 'text-dark-text hover:bg-gray-200'"
        class="px-4 py-2 rounded transition-colors duration-150"><i class="bi bi-gear-fill"></i> WebUI Settings</a>
    @endif
    <h2 class="text-dark-text text-sm font-bold mt-2"><i class="bi bi-person-circle"></i> {{ auth()->user()->name }}</h2>
    <a href="#" @click.prevent="activePage='settings'; sidebarOpen = false" 
        :class="activePage==='settings' ? 'bg-primary text-white font-semibold' : 'text-dark-text hover:bg-gray-200'"
        class="px-4 py-2 rounded transition-colors duration-150"><i class="bi bi-gear-fill"></i> Settings</a>
    <button type="button" class="px-4 py-2 rounded flex gap-1.5 text-red-600 hover:bg-gray-200 transition-colors duration-150" id="logoutBtn" @click.prevent="sidebarOpen = false">
        <i class="bi bi-box-arrow-right"></i> Logout
    </button>
</nav>