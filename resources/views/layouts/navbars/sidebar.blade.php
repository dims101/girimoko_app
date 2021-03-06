<div class="sidebar" data-color="azure" data-background-color="white" data-image="{{ asset('material') }}/img/sidebar-1.jpg">
  <!--
      Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

      Tip 2: you can also add an image using data-image tag
  -->
  <div class="logo">
    <a href="/" class="simple-text logo-normal">
      {{ __('Girimoko Tracking System') }}
    </a>
	<!-- <a href="#"><img style="width: 100px;" src="/material/img/girimoko.jpeg" class="simple-text logo-normal"></a> -->
  </div>
  <div class="sidebar-wrapper">
    <ul class="nav">
      <li class="nav-item{{ $activePage == 'dashboard' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('home') }}">
          <i class="material-icons">dashboard</i>
            <p>{{ __('Dashboard') }}</p>
        </a>
      </li>
      <li class="nav-item{{ $activePage == 'summary' ? ' active' : '' }}">
        <a class="nav-link" href="/summary">
          <i class="material-icons">content_paste</i>
            <p>{{ __('Summary') }}</p>
        </a>
      </li>
      <li class="nav-item{{ $activePage == 'delivery' ? ' active' : '' }}">
        <a class="nav-link" href="/delivery">
          <i class="material-icons">local_shipping</i>
            <p>{{ __('DDS Delivery Report') }}</p>
        </a>
      </li>
      @if(auth()->user()->level == "admin" or auth()->user()->level == "Super Admin") 
      <!-- <li class="nav-item{{ $activePage == 'dashboard_admin' ? ' active' : '' }}">
        <a class="nav-link" href="/home">
          <i class="material-icons">admin_panel_settings</i>
            <p>{{ __('Panel Admin') }}</p>
        </a>
      </li> -->
      @if (auth()->user()->username == "girimoko" or auth()->user()->username == "admin")
      <li class="nav-item{{ $activePage == 'register' ? ' active' : '' }}">
        <a class="nav-link" href="/register">
          <i class="material-icons">add</i>
            <p>{{ __('Tambah pengguna') }}</p>
        </a>
      </li>
      @endif
      <li class="nav-item{{ $activePage == 'dealer' ? ' active' : '' }}">
        <a class="nav-link" href="/dealer">
          <i class="material-icons">home</i>
            <p>{{ __('Dealer') }}</p>
        </a>
      </li>
      @if (auth()->user()->username == "girimoko" or auth()->user()->username == "admin")
      <li class="nav-item{{ $activePage == 'import_excel' ? ' active' : '' }}">
        <a class="nav-link" href="/awb/excel">
          <i class="material-icons">upload_file</i>
            <p>{{ __('Import File Excel') }}</p>
        </a>
      </li>
      @endif
      @if (auth()->user()->username != "girimoko"  )
      <li class="nav-item{{ $activePage == 'tracking' ? ' active' : '' }}">
        <a class="nav-link" href="/tracking">
          <i class="material-icons">trending_up</i>
            <p>{{ __('Tracking') }}</p>
        </a>
      </li>
      @endif
      @endif
      
      <!-- <li class="nav-item{{ $activePage == 'notifications' ? ' active' : '' }}">
        <a class="nav-link" href="">
          <i class="material-icons">notifications</i>
          <p>{{ __('Notifications') }}</p>
        </a>
      </li>
      <li class="nav-item{{ $activePage == 'language' ? ' active' : '' }}">
        <a class="nav-link" href="">
          <i class="material-icons">language</i>
          <p>{{ __('RTL Support') }}</p>
        </a>
      </li> -->
   
    </ul>
  </div>
</div>