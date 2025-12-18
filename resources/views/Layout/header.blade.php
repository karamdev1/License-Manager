<header>
  <nav class="bg-dark text-white shadow-sm">
    <div class="container mx-auto px-29.5 flex items-center justify-between h-14">
      <a href="/" class="flex items-center text-white text-[20px]">
        <i class="bi bi-box px-3.5"></i> {{ config('app.name') }}
      </a>

      <button
        id="themeToggle"
        class="relative w-14 h-7 bg-gray-300 dark:bg-gray-700 rounded-full transition"
      >
        <span
          id="themeDot"
          class="absolute left-1 top-1 w-5 h-5 bg-white rounded-full transition-transform"
        ></span>
      </button>
    </div>
  </nav>
</header>