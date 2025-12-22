<nav class="flex flex-col gap-1">
    <a href="#" @click.prevent="activePage='home'" 
        :class="activePage==='home' ? 'bg-primary text-white font-semibold' : 'text-gray-700 hover:bg-gray-100'"
        class="px-4 py-2 rounded transition-colors duration-150">Home</a>
    <a href="#" @click.prevent="activePage='licenses'" 
        :class="activePage==='licenses' ? 'bg-primary text-white font-semibold' : 'text-gray-700 hover:bg-gray-100'"
        class="px-4 py-2 rounded transition-colors duration-150">Licenses</a>
    <a href="#" @click.prevent="activePage='users'" 
        :class="activePage==='users' ? 'bg-primary text-white font-semibold' : 'text-gray-700 hover:bg-gray-100'"
        class="px-4 py-2 rounded transition-colors duration-150">Users</a>
    <a href="#" @click.prevent="activePage='settings'" 
        :class="activePage==='settings' ? 'bg-primary text-white font-semibold' : 'text-gray-700 hover:bg-gray-100'"
        class="px-4 py-2 rounded transition-colors duration-150">Settings</a>
</nav>