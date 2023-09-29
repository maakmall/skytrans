<!DOCTYPE html>
<html dir="ltr" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title') | Sky Trans</title>

    <!-- Favicon icon -->
    <link
      rel="icon"
      type="image/png"
      sizes="16x16"
      href="/assets/images/ks.png"
    />

    <!-- Custom CSS -->
    <link href="/assets/css/style.css" rel="stylesheet" />
    @stack('style')
  </head>

  <body>
    <!-- Preloader - style you can find in spinners.css -->
    <div class="preloader">
      <div class="lds-ripple">
        <div class="lds-pos"></div>
        <div class="lds-pos"></div>
      </div>
    </div>

    <!-- Main Wrapper - style you can find in pages.scss -->
    <div
      id="main-wrapper"
      data-theme="light"
      data-layout="vertical"
      data-navbarbg="skin6"
      data-sidebartype="full"
      data-sidebar-position="fixed"
      data-header-position="fixed"
      data-boxed-layout="full"
    >
      @include('partials.topbar')

      @include('partials.sidebar')

      <!-- Page wrapper  -->
      <div class="page-wrapper min-vh-100">
        <div class="page-breadcrumb">
          <div class="row">
            <div class="col-7 align-self-center">
              <h3
                class="page-title text-truncate text-dark font-weight-medium mb-1"
              >
                @yield('title')
              </h3>
            </div>
          </div>
        </div>

        <!-- Container fluid  -->
        <div class="container-fluid">
          @yield('content')
        </div>

      </div>
      <!-- End Page wrapper  -->

    </div>
    <!-- End Main Wrapper -->

    <!-- All Jquery -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <!-- apps -->
    <script src="/assets/js/app-style-switcher.min.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/0.6.10/js/min/perfect-scrollbar.jquery.min.js" integrity="sha512-ebNY0qErbAT1m/mtiUXFcDVRcG30XEKR/Qf6fiMY6U7MRFX65rzscgev7iaKIJJGbzLpRhZjq/CfglRckLHN7Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!--Custom JavaScript -->
    <script src="/assets/js/custom.js"></script>

    @stack('script')
  </body>
</html>
