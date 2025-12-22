<header>
  <nav class="bg-dark text-white shadow-sm">
    <div class="mx-0 md:mx-25 lg:mx-50 px-4 flex items-center justify-between h-14">
      <div class="flex items-center gap-6">
        <a href="/" class="flex items-center text-[20px]">
          <i class="bi bi-box px-3"></i> {{ config('app.name') }}
        </a>
      </div>

      @auth
      <div class="hidden md:flex relative" x-data="{ open: false }">
        <button @click="open = !open"
                class="p-2 text-white hover:text-gray-300 cursor-pointer text-[16px] flex gap-1 items-center">
          <i class="bi bi-person-circle"></i> {{ auth()->user()->name }}
          <i class="bi bi-caret-down-fill text-[8px]"></i>
        </button>

        <div x-show="open"
             x-transition
             x-cloak
             @click.away="open = false"
             class="absolute top-14 left-0 bg-white text-black items-baseline rounded shadow-md flex flex-col z-50 min-w-max py-1">
            
          <a href="{{ config('messages.settings.source_link') }}" class="px-4 py-1 hover:bg-gray-200 w-full">
            <i class="bi bi-{{ strtolower(config('messages.settings.source')) }}"></i> {{ config('messages.settings.source') }}
          </a>
          <div class="border-t border-gray-200 my-1 w-full"></div>
          <p class="px-4 py-1 hover:bg-gray-200 w-full">
            {{ auth()->user()->name }} ({{ auth()->user()->username }})
          </p>
          @if (auth()->user()->role != "Reseller")
          <a href="{{ route('admin.users.index')}}" class="px-4 py-1 hover:bg-gray-200 w-full">
            <i class="bi bi-person"></i> Manage Users
          </a>
          <a href="{{ route('admin.referrable.index') }}" class="px-4 py-1 hover:bg-gray-200 w-full">
            <i class="bi bi-person-add"></i> Manage Referrable Code
          </a>
          @endif
          <a href="{{ route('settings.index') }}" class="px-4 py-1 hover:bg-gray-200 w-full">
            <i class="bi bi-gear"></i> Settings
          </a>
          @if (auth()->user()->role != "Reseller")
          <a href="{{ route('settings.webui.index') }}" class="px-4 py-1 hover:bg-gray-200 w-full">
            <i class="bi bi-gear"></i> Web UI Settings
          </a>
          @endif
          <div class="border-t border-gray-200 my-1 w-full"></div>
          <button type="button" class="px-4 py-1 w-full text-red-600 hover:bg-gray-200 flex items-center gap-1.5 cursor-pointer justify-start" id="logoutBtn">
            <i class="bi bi-box-arrow-left w-4 text-center"></i> Logout
          </button>
          <form action="{{ route('logout') }}" method="post" id="logoutForm"></form>
        </div>
      </div>
      @endauth

      <div class="md:hidden">
        <button @click="sidebarOpen = !sidebarOpen" class="p-2 rounded hover:bg-dark-3">
            <i class="bi text-2xl" :class="sidebarOpen ? 'bi-x-lg' : 'bi-list'"></i>
        </button>
      </div>
    </div>
  </nav>
</header>
