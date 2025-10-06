<header class="header">
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
</header>