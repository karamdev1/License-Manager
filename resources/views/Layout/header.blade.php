<header>
  <nav class="bg-dark text-white shadow-sm">
    <div class="mx-0 md:mx-25 lg:mx-50 px-4 flex items-center justify-between h-14">
      <div class="flex items-center gap-6">
        <a href="/" class="flex items-center text-[20px]">
          <i class="bi bi-box px-3"></i> {{ config('app.name') }}
        </a>
      </div>

      <div class="md:hidden">
        <button @click="sidebarOpen = !sidebarOpen" class="p-2 rounded hover:bg-dark-3">
            <i class="bi text-2xl" :class="sidebarOpen ? 'bi-x-lg' : 'bi-list'"></i>
        </button>
      </div>
    </div>
  </nav>
</header>
