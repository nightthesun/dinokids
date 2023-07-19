<!doctype html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>DINOKIDS</title>
  <!-- Styles -->
  <link rel="icon" href="{{{ asset('imagenes/iconDin.png') }}}">
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  @yield('mi_estilo')
  <style>
    /**********LOGIN */
    .login,
    .login>div {
      height: 100%;
    }

    /***********************INPUT DE ARCHIVOS*********************************/
    a {
      text-decoration: none;
    }

    .file-input__input {
      width: 0.1px;
      height: 0.1px;
      opacity: 0;
      overflow: hidden;
      position: absolute;
      z-index: -1;
    }

    .file-input__label {
      cursor: pointer;
      border-radius: 4px;
      color: #fff;
      padding: 10px 12px;
      background-color: #355296;
    }

    html,
    body {
      height: 100%;
      background-color: #F6F7FC;
    }

    /***********************loading*********************************/
    .hide {
      transition: all 0.3s ease;
      display: none;

    }

    #load {
      position: fixed;
      padding: 0;
      margin: 0;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(255, 255, 255, 1);
      z-index: 100;
      text-align: center;
    }

    .vertical-center {
      margin: 0;
      position: absolute;
      top: 50%;
    }

    /*****************************SIDE BAR**************************/
    /*--------------------------side-controls------------------------------*/
    .sidebar-controls {
      width: 100%;
      bottom: 0;
      display: flex;
    }

    .sidebar-controls>a {
      flex-grow: 1;
      text-align: center;
      height: 30px;
      line-height: 30px;
      position: relative;
    }


    /*----------------page-wrapper----------------*/

    .page-wrapper {
      height: 100%;
    }

    @media screen and (min-width: 768px) {
      .statick-side {
        padding-left: 265px;
        padding-right: 15px;
      }
    }

    /*----------------toggeled sidebar----------------*/

    .page-wrapper.toggled .sidebar-wrapper {
      left: 0px;
    }

    @media screen and (min-width: 768px) {
      .page-wrapper.toggled .page-content {
        height: 100%;
      }
    }

    /*----------------Mostrar sidebar Button----------------*/
    #control {
      position: fixed;
      left: 10px;
      top: 5px;
      transition-delay: 0.3s;
    }

    #control a {
      position: relative;
      border-radius: 0 4px 4px 0px;
      width: 30px;
      padding-right: 5px;
      transition-delay: 0.3s;
    }

    .page-wrapper.toggled #control {
      left: -100px;
    }

    /*----------------sidebar-wrapper----------------*/

    .sidebar-wrapper {
      width: 250px;
      height: 100%;
      max-height: 100%;
      min-height: 100%;
      position: fixed;
      top: 0;
      left: -300px;
      z-index: 9999;
    }

    .sidebar-wrapper ul {
      list-style-type: none;
      padding: 0;
      margin: 0;
    }

    .sidebar-wrapper a {
      text-decoration: none;
    }

    /*----------------sidebar-content----------------*/

    .sidebar-content {
      max-height: calc(100% - 30px);
      height: calc(100% - 30px);
      overflow-y: auto;
      position: relative;
    }

    /*--------------------sidebar-brand----------------------*/

    .sidebar-wrapper .sidebar-brand {
      padding: 10px 20px;
      display: flex;
      align-items: center;
    }

    .sidebar-wrapper .sidebar-brand>.logo {
      flex-grow: 1;
    }

    .sidebar-wrapper .sidebar-brand #close-sidebar {
      cursor: pointer;
      font-size: 15px;
    }

    /*--------------------sidebar-header----------------------*/

    .sidebar-wrapper .sidebar-header {
      padding: 20px;
      overflow: hidden;
    }

    .sidebar-wrapper .sidebar-header .user-pic {
      float: left;
      width: 68px;
      height: 68px;
      padding: 2px;
      margin-right: 15px;
      overflow: hidden;
    }

    .sidebar-wrapper .sidebar-header .user-pic img {
      object-fit: cover;
      height: 100%;
      width: 100%;
    }

    .sidebar-wrapper .sidebar-header .user-info {
      float: left;
      overflow: hidden;
      white-space: nowrap;
      text-overflow: "-";
    }

    .sidebar-wrapper .sidebar-header .user-info>span {
      display: block;
    }

    .sidebar-wrapper .sidebar-header .user-info .user-role {
      font-size: 0.9rem;
    }

    /*----------------------sidebar-menu-------------------------*/

    .sidebar-wrapper .sidebar-menu {
      padding-bottom: 10px;
      padding-top: 10px;
    }

    .sidebar-wrapper .sidebar-menu ul li a {
      display: inline-block;
      width: 100%;
      text-decoration: none;
      position: relative;
      padding: 8px 30px 8px 5px;
    }

    .sidebar-wrapper .sidebar-menu ul li a i {
      font-size: 12px;
      width: 25px;
      height: 25px;
      line-height: 25px;
      text-align: center;

    }

    .sidebar-wrapper .sidebar-menu ul li a:hover>i::before {
      display: inline-block;
      animation: swing ease-in-out 0.5s 1 alternate;
    }

    .sidebar-wrapper .sidebar-menu .sidebar-dropdown>a:after {
      font-family: "Font Awesome 5 Free";
      font-weight: 900;
      content: "\f105";
      font-style: normal;
      display: inline-block;
      font-style: normal;
      font-variant: normal;
      text-rendering: auto;
      -webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
      text-align: center;
      background: 0 0;
      position: absolute;
      right: 15px;
      top: 9px;
    }

    .sidebar-wrapper .sidebar-menu .sidebar-dropdown .sidebar-submenu.mod ul {
      padding: 5px 0;
    }

    .sidebar-wrapper .sidebar-menu .sidebar-dropdown .sidebar-submenu.mod li {
      padding-left: 25px;
      font-size: 13px;
    }

    .sidebar-wrapper .sidebar-menu .sidebar-dropdown .sidebar-submenu li.route a:before {
      content: "";
      font-family: "Font Awesome 5 Free";
      font-weight: 400;
      font-style: normal;
      display: inline-block;
      text-align: center;
      text-decoration: none;
      -webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
      font-size: 8px;
    }

    .sidebar-wrapper .sidebar-menu ul li a span.label,
    .sidebar-wrapper .sidebar-menu ul li a span.badge {
      float: right;
      margin-top: 8px;
      margin-left: 5px;
    }

    .sidebar-wrapper .sidebar-menu .sidebar-dropdown .sidebar-submenu li a .badge,
    .sidebar-wrapper .sidebar-menu .sidebar-dropdown .sidebar-submenu li a .label {
      float: right;
      margin-top: 0px;
    }

    .sidebar-wrapper .sidebar-menu .sidebar-submenu {
      display: none;
    }

    .sidebar-wrapper .sidebar-menu .sidebar-dropdown.active>a:after {
      transform: rotate(90deg);
      right: 17px;
    }

    /*--------------------------side-footer------------------------------*/

    .sidebar-footer {
      position: absolute;
      width: 100%;
      bottom: 0;
      display: flex;
    }

    .sidebar-footer>a {
      flex-grow: 1;
      text-align: center;
      height: 30px;
      line-height: 30px;
      position: relative;
    }

    .sidebar-footer>a .notification {
      position: absolute;
      top: 0;
    }

    .badge-sonar {
      display: inline-block;
      background: #980303;
      border-radius: 50%;
      height: 8px;
      width: 8px;
      position: absolute;
      top: 0;
    }

    .badge-sonar:after {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      border: 2px solid #dbd4d4;
      opacity: 0;
      border-radius: 50%;
      width: 100%;
      height: 100%;
      animation: sonar 1.5s infinite;
    }

    /*--------------------------page-content-----------------------------*/

    .page-wrapper .page-content {
      display: block;
      width: 100%;
      height: 100%;
    }

    .page-wrapper .page-content {
      overflow-x: hidden;
    }




    /*-----------------------------chiller-theme-------------------------------------------------*/

    /* luz del sidebar--------------------------------------------------------------------------*/
    /* luz del sidebar--------------------------------------------------------------------------*/
    /* luz del sidebar--------------------------------------------------------------------------*/
    .chiller-theme .sidebar-wrapper {
      background: #222D32;/* fondo de sidebar*/
      box-shadow: 2px -2px 6px #575757;
    }

    .chiller-theme .sidebar-wrapper .sidebar-header,
    .chiller-theme .sidebar-wrapper .sidebar-menu,
    .chiller-theme .sidebar-wrapper .sidebar-controls {
      border-top: 1px solid #222D32;
    }
    /* color de la fuente*/
    .chiller-theme .sidebar-wrapper .sidebar-header .user-info .user-role,
    .chiller-theme .sidebar-wrapper .sidebar-menu ul li a,
    .chiller-theme .sidebar-footer>a {
      color: #F6F7FC;
    }

    .chiller-theme .sidebar-wrapper .sidebar-menu ul li:hover>a,
    .chiller-theme .sidebar-wrapper .sidebar-menu .sidebar-dropdown.active>a,
    .chiller-theme .sidebar-wrapper .sidebar-header .user-info,
    .chiller-theme .sidebar-footer>a:hover i {
      color: #F6F7FC; /* font de perfil*/
    }

    .page-wrapper.chiller-theme.toggled #close-sidebar {
      color: #F6F7FC;
    }

    .chiller-theme .sidebar-wrapper ul li:hover a i,
    .chiller-theme .sidebar-wrapper .sidebar-dropdown .sidebar-submenu li a:hover:before,
    .chiller-theme .sidebar-wrapper .sidebar-menu .sidebar-dropdown.active a i {
      color: #B40F7F;
      text-shadow: 0px 0px 5px #e60f0f; /*  sombra de del efecto hover*/
    }

    .chiller-theme .sidebar-footer {
      background: #1b1a1a;
      box-shadow: 0px -1px 2px #ffffff;
      border-top: 1px solid #ffffff;
    }

    .chiller-theme .sidebar-controls {
      background: #1b1a1a;
      box-shadow: 0px -1px 2px #ffffff;
      border-top: 1px solid #ffffff;
      border-bottom: 1px solid #ffffff;
    }

    .texto-luz {
      color: #F6F7FC;
      text-shadow: 0px 0px 5px rgb(214, 214, 214);
    }

    /****************CONTROLES FORM */
    .controles-form {
      position: fixed;
      bottom: 5px;
      left: 270px;
    }

    .controles-form-esq {
      position: fixed;
      bottom: 5px;
      left: 5px;
    }

    .controles-form-esq-der {
      position: fixed;
      bottom: 5px;
      right: 5px;
    }
  </style>
  @yield('estilo')
</head>

<body>
  @auth
  <div id="load">
    <div class="spinner-border vertical-center" role="status">
      <span class="sr-only">Loading...</span>
    </div>
  </div>
  <div class="page-wrapper chiller-theme toggled" id="app">
    <main class="page-content @yield('static')">
      @yield('content')
    </main>
  </div>
  @else
  @yield('content')
  @endauth
  <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/echarts.min.js') }}"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      $("#sidebarCollapse").click(function() {
        $('#sidebar').toggleClass('active');
      });
      //CHAT
      $(".tile_redes .float").click(function() {
        $(this).html(
          $(this).html() == '<i class="fa fa-times my-float"></i>' ? '<i class="fa fa-comments my-float"></i' : '<i class="fa fa-times my-float"></i>');
        $(".tile_redes .soc").toggleClass("pad");
        $(".gfq-panel").removeClass('panel-active');
      });
      $('.gfq-badge').click(function() {
        $(".gfq-panel").toggleClass('panel-active');
        $(".gfq-panel2").removeClass('panel-active');
      });
      $("#load").hide();
    });
    /**************SIDEBAR*******/
    jQuery(function($) {
      $(".sidebar-dropdown.mod > a").click(function() {
        $(".sidebar-submenu.mod").slideUp(200);
        if (
          $(this)
          .parent()
          .hasClass("active")
        ) {
          $(".sidebar-dropdown.mod").removeClass("active");
          $(this)
            .parent()
            .removeClass("active");
        } else {
          $(".sidebar-dropdown.mod").removeClass("active");
          $(this)
            .next(".sidebar-submenu.mod")
            .slideDown(200);
          $(this)
            .parent()
            .addClass("active");
        }
      });

      $(".sidebar-dropdown.sub > a").click(function() {
        $(".sidebar-submenu.sub").slideUp(200);
        if (
          $(this)
          .parent()
          .hasClass("active")
        ) {
          $(".sidebar-dropdown.sub").removeClass("active");
          $(this)
            .parent()
            .removeClass("active");
        } else {
          $(".sidebar-dropdown.sub").removeClass("active");
          $(this)
            .next(".sidebar-submenu.sub")
            .slideDown(200);
          $(this)
            .parent()
            .addClass("active");
        }
      });

      $("#close-sidebar").click(function() {
        $(".page-wrapper").removeClass("toggled");
      });
      $("#show-sidebar").click(function() {
        $(".page-wrapper").addClass("toggled");
      });
    });
    $(".previous_page").click(function() {
      window.history.back();
    });
    $(".reload_page").click(function() {
      location.reload();
    });
  </script>
  @yield('mis_scripts')
</body>

</html>