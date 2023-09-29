<!-- Left Sidebar - style you can find in sidebar.scss  -->
<aside class="left-sidebar" data-sidebarbg="skin6">
  <!-- Sidebar scroll-->
  <div class="scroll-sidebar" data-sidebarbg="skin6">
    <!-- Sidebar navigation-->
    <nav class="sidebar-nav">
      <ul id="sidebarnav">
        <li @class(['sidebar-item', 'selected' => Request::is('/')])>
          <a
          @class(['sidebar-link', 'active' => Request::is('/')])
            href="/"
            aria-expanded="false"
            ><i class="icon-home"></i
            ><span class="hide-menu">Dashboard</span></a
          >
        </li>

        <li class="list-divider"></li>

        <li class="nav-small-cap"><span class="hide-menu">Menu</span></li>

        <li @class(['sidebar-item', 'selected' => Request::is('registration*')])>
          <a
            @class(['sidebar-link', 'active' => Request::is('registration*')])
            href="/registration"
            aria-expanded="false"
            ><i class="icon-notebook"></i
            ><span class="hide-menu">Registrasi</span></a
          >
        </li>

        <li @class(['sidebar-item', 'selected' => Request::is('deliveries*')])>
          <a
            @class(['sidebar-link', 'active' => Request::is('deliveries*')])
            href="/deliveries"
            aria-expanded="false"
            ><i class="icon-arrow-right-circle"></i
            ><span class="hide-menu">Pengiriman</span></a
          >
        </li>

        <li @class(['sidebar-item', 'selected' => Request::is('requests*')])>
          <a
            @class(['sidebar-link', 'active' => Request::is('requests*')])
            href="/requests"
            aria-expanded="false"
            ><i class="icon-share-alt"></i
            ><span class="hide-menu">Pengajuan</span></a
          >
        </li>

        <li class="list-divider"></li>

        <li class="nav-small-cap"><span class="hide-menu">Master</span></li>

        <li @class(['sidebar-item', 'selected' => Request::is('materials*')])>
          <a
            @class(['sidebar-link', 'active' => Request::is('materials*')])
            href="/materials"
            aria-expanded="false"
            ><i class="icon-social-dropbox"></i
            ><span class="hide-menu">Material</span></a
          >
        </li>

        @can('admin')
          <li @class(['sidebar-item', 'selected' => Request::is('companies*')])>
            <a
              @class(['sidebar-link', 'active' => Request::is('companies*')])
              href="/companies"
              ria-expanded="false"
              ><i class="icon-briefcase"></i
              ><span class="hide-menu">Company</span></a
            >
          </li>

          <li @class(['sidebar-item', 'selected' => Request::is('users*')])>
            <a
              @class(['sidebar-link', 'active' => Request::is('users*')])
              href="/users"
              ria-expanded="false"
              ><i class="icon-user"></i
              ><span class="hide-menu">User</span></a
            >
          </li>
        @endcan

        <li @class(['sidebar-item', 'selected' => Request::is('vehicles*')])>
          <a
            @class(['sidebar-link', 'active' => Request::is('vehicles*')])
            href="/vehicles"
            aria-expanded="false"
            ><i class="icon-paper-plane"></i
            ><span class="hide-menu">Kendaraan</span></a
          >
        </li>


        <li @class(['sidebar-item', 'selected' => Request::is('drivers*')])>
          <a
            @class(['sidebar-link', 'active' => Request::is('drivers*')])
            href="/drivers"
            aria-expanded="false"
            ><i class="icon-people"></i
            ><span class="hide-menu">Driver</span></a
          >
        </li>

        <li class="list-divider"></li>

        <li class="sidebar-item">
          <form action="/logout" method="post" class="d-inline">
            @csrf
            <button
              class="sidebar-link btn"
              aria-expanded="false"
              ><i class="icon-logout"></i
                ><span class="hide-menu">Logout</span></a
              >
            </button>
          </form>
        </li>
      </ul>
    </nav>
    <!-- End Sidebar navigation -->
  </div>
  <!-- End Sidebar scroll-->
</aside>
<!-- End Left Sidebar - style you can find in sidebar.scss  -->
