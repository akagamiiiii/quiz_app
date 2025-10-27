<header class="text-gray-600 body-font bg-blue-200">
  <div class="container mx-auto flex flex-wrap p-5 flex-col md:flex-row items-center">
    <a href="{{ route('admin.top') }}" class="flex title-font font-medium items-center text-gray-900 mb-4 md:mb-0">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-10 h-10 text-white p-2 bg-indigo-500 rounded-full" viewBox="0 0 24 24">
        <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"></path>
      </svg>
      <span class="ml-3 text-xl">管理画面</span>
    </a>
    <form method="POST" action="{{ route('logout') }}" class="md:ml-auto">
      @csrf
      <button
        :href="route('logout')"
                    onclick="event.preventDefault();
                                this.closest('form').submit();"
          class="inline-flex items-center text-white bg-gray-700 border-0 py-1 px-3 focus:outline-none hover:bg-gray-800 rounded text-base mt-4 md:mt-0"
      >ログアウト
      </button>
    </form>
  </div>
</header>

{{-- <header class="header">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <div class="header-container">
    <a class="header-logo">
      <svg class="header-icon">...</svg>
      <span class="header-title">管理画面</span>
    </a>

    <form method="POST" action="{{ route('logout') }}" class="header-logout">
        @csrf
        <button
          :href="route('logout')"
                onclick="event.preventDefault();
                            this.closest('form').submit();"
        >ログアウト
          <svg class="header-logout-icon"></svg>
        </button>
    </form>
  </div>
</header> --}}