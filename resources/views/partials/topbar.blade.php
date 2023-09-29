<!-- Topbar header - style you can find in pages.scss -->
<header class="topbar" data-navbarbg="skin6">
  <nav class="navbar top-navbar navbar-expand-md">
    <div class="navbar-header" data-logobg="skin6">
      <!-- This is for the sidebar toggle which is visible on mobile only -->
      <a
        class="nav-toggler waves-effect waves-light d-block d-md-none"
        href="javascript:void(0)"
        ><i class="ti-menu ti-close"></i
      ></a>

      <!-- Logo -->
      <div class="navbar-brand">
        <!-- Logo icon -->
        <a href="{{ url('/') }}">
          <span class="logo-icon">
            <b>Sky</b>
          </span>
          <span class="logo-text">
            <b>Trans</b>
          </span>
        </a>
      </div>
      <!-- End Logo -->

      <!-- Toggle which is visible on mobile only -->
      <a
        class="topbartoggler d-block d-md-none waves-effect waves-light"
        href="javascript:void(0)"
        data-toggle="collapse"
        data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent"
        aria-expanded="false"
        aria-label="Toggle navigation"
        ><i class="ti-more"></i
      ></a>
    </div>
    <!-- End Logo -->

    <div class="navbar-collapse collapse" id="navbarSupportedContent">
      <!-- toggle and nav items -->
      <ul class="navbar-nav float-right ml-auto ml-3 pl-1">
        <!-- Notification -->
        <li class="nav-item dropdown">
          <a
            class="nav-link dropdown-toggle pl-md-3 position-relative"
            href="javascript:void(0)"
            id="bell"
            role="button"
            data-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false"
          >
            <span><i class="svg-icon icon-bell"></i></span>
            <span class="badge badge-primary notify-no rounded-circle"></span>
          </a>
          <div
            class="dropdown-menu dropdown-menu-right mailbox animated bounceInDown"
          >
            <ul class="list-style-none">
              <li>
                <div class="message-center notifications position-relative"></div>
              </li>
              <li>
                <a
                  class="nav-link pt-3 text-center text-dark"
                  href="/notifications"
                >
                  <strong>Lihat semua notifikasi</strong>
                  <i class="fa fa-angle-right"></i>
                </a>
              </li>
            </ul>
          </div>
        </li>
        <!-- End Notification -->
      </ul>

      <!-- Right side toggle and nav items -->
      <ul class="navbar-nav float-right">
        <!-- User profile -->

        <li class="nav-item dropdown">
          <a
            class="nav-link dropdown-toggle"
            href="javascript:void(0)"
            data-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false"
          >
            <i class="svg-icon icon-user"></i>
            <span class="ml-2 d-none d-lg-inline-block">
              <span class="text-dark">{{ Auth::user()->username }}</span>
            </span>

          </a>
          <div
            class="dropdown-menu dropdown-menu-right pt-2 user-dd animated flipInY"
          >
            <a class="dropdown-item" href="/setting"
              ><i class="svg-icon mr-2 ml-1 icon-settings"></i>Setting</a
            >
            <form action="/logout" method="post" class="d-inline">
              @csrf
              <button class="dropdown-item btn">
                <i class="svg-icon mr-2 ml-1 icon-logout"></i>Logout
              </button>
            </form>
          </div>
        </li>
      </ul>
    </div>
  </nav>
</header>
<!-- End Topbar header -->
