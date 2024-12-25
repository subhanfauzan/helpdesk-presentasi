<!-- Left Sidebar End -->
<header id="page-topbar" class="ishorizontal-topbar" style="color: white;">
  <div class="navbar-header">
    <div class="d-flex">
      <button type="button" class="btn btn-sm px-3 font-size-16 d-lg-none header-item" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
        <i class="fa fa-fw fa-bars"></i>
      </button>

      <div class="topnav">
        <nav class="navbar navbar-expand-lg topnav-menu">
          <div class="collapse navbar-collapse" id="topnav-menu-content">
            <ul class="navbar-nav">
              @php
              $menus = Session::get('user_app')['menu'];
              @endphp
              @foreach($menus as $datas => $value)
              @php
              if( $value !== end( $menus ) ) {
              @endphp
              <li class="nav-item navi dropdown">
                <a class="nav-link dropdown-toggle arrow-none" href="#" data-bs-toggle="dropdown" id="topnav-{{ substr($datas,0,3) }}" role="button">
                  <i class='{{ $value[0]->m_menu_icon_menu }}'></i>
                  <span data-key="t-{{ substr($datas,0,3) }}">{{$datas}}</span>
                  <div class="arrow-down"></div>
                </a>
                <div class="dropdown-menu navi" aria-labelledby="topnav-{{ substr($datas,0,3) }}">
                  @php
                  for($i = 0; $i < count($value); $i++){ @endphp <a href="{{url($value[$i]->m_sub_menu_url_sub_menu)}}" class="dropdown-item" data-key="t-{{ substr($value[$i]->m_sub_menu_nama_sub_menu,0,3) }}">{{$value[$i]->m_sub_menu_nama_sub_menu}}</a>

                    @php
                    }
                    @endphp
                </div>
              </li>
              @php
              }
              @endphp
              @endforeach

              @if(Session::get('user_app')['unitId'] == "PBD200")
              <!-- <li class="nav-item navi dropdown">
                <a class="nav-link dropdown-toggle arrow-none" href="#" data-bs-toggle="dropdown" id="topnav-kinerja" role="button">
                  <i class='bx bx-line-chart'></i>
                  <span data-key="t-kinerja">Laporan Kinerja</span>
                  <div class="arrow-down"></div>
                </a>
                <div class="dropdown-menu navi" aria-labelledby="topnav-kinerjati">
                  <a href="{{url('kinerja_pegawai/index')}}" class="dropdown-item" data-key="t-kinerjati">Laporan Kinerja TI</a>
                </div>
              </li> -->
              <!-- <li class="nav-item navi dropdown">
                <a class="nav-link dropdown-toggle arrow-none" href="#" data-bs-toggle="dropdown" id="topnav-repositori" role="button">
                  <i class='bx bxs-file-archive'></i>
                  <span data-key="t-repositori">Repositori</span>
                  <div class="arrow-down"></div>
                </a>
                <div class="dropdown-menu navi" aria-labelledby="topnav-repositori">
                  <a href="{{url('repositori/index')}}" class="dropdown-item" data-key="t-repositori">Repositori</a>
                </div>
              </li> -->
              @else
              @endif
              @php
              $about = end($menus);
              $key = array_key_last($menus);
              @endphp
              <li class="nav-item navi dropdown">
                <a class="nav-link dropdown-toggle arrow-none" href="#" data-bs-toggle="dropdown" id="topnav-{{ substr($key,0,3) }}" role="button">
                  <i class='{{ $about[0]->m_menu_icon_menu }}'></i>
                  <span data-key="t-{{ substr($key,0,3) }}">{{$key}}</span>
                  <div class="arrow-down"></div>
                </a>
                <div class="dropdown-menu navi" aria-labelledby="topnav-{{ substr($key,0,3) }}">
                  @php
                  for($i = 0; $i < count($about); $i++){ @endphp <a href="{{url($about[$i]->m_sub_menu_url_sub_menu)}}" class="dropdown-item" data-key="t-{{ substr($about[$i]->m_sub_menu_nama_sub_menu,0,3) }}">{{$about[$i]->m_sub_menu_nama_sub_menu}}</a>
                    @php
                    }
                    @endphp
                </div>
              </li>
            </ul>
          </div>
        </nav>
      </div>
    </div>
    <div class="d-flex" id="logo3" style="height: 60%;">
      <div class="d-inline-flex me-2 logowrapper2">
        <img style="object-fit:cover" src="{{asset('public/image/bumn1.png')}}" alt="">
      </div>
      <div class="d-inline-flex me-2 logowrapper">
        <img style="object-fit:cover" src="{{asset('public/image/petro_logo_bubble.png')}}" alt="">
      </div>
      <div class="d-inline-flex me-2 logowrapper">
        <img style="object-fit:cover" src="{{asset('public/image/pi.png')}}" alt="">
      </div>
    </div>
    <div class="d-flex dropdown">
      @php
      $notifs = getMiniNotif(Session::get('user_app')['username']);
      @endphp
      {{-- <ul class="navbar-nav">
        <li class="nav-item dropdown"> --}}
          <button class="btn header-item text-start d-flex align-items-center dropdown-toggle" id="notifButton" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class='bx bxs-bell fs-5'></i><span class="badge bg-danger" id="notifBadge" style="padding-top: 0px !important;">{{ $notifs['count'] }}</span>
          </button>
          <ul class="dropdown-menu navi notif w-75">
            @if ($notifs['notif']->count())
            @foreach ($notifs['notif'] as $notif )
            <li class="dropdown-item-text notif-item">
              <a class="text-light" href="{{ url('issues/getPutSessionTiketIssuesSearch') }}?id_notif={{ $notif->aidi }}&tiket_issues={{ $notif->tiket_issue }}">{!! $notif->notifikasi !!}</a>
              <small class="text-light d-block">{{ $notif->created_at }}</small>
            </li>
            @endforeach
            @else
            <p class="text-center notif-item">Semua notifikasi telah dibaca.</p>
            @endif
            <hr class="dropdown-divider notif-item">
            <a class="dropdown-item text-center text-light notif-item allnotif" href="{{url('notifikasi/index')}}">Lihat semua ({{ $notifs['count'] - 5 < 0 ? 0 : $notifs['count'] - 5 }})</a>
          </ul>
        {{-- </li>
      </ul> --}}
      {{-- <p class="d-inline-flex my-auto text-end" style="margin-right: -10px; color:#1f2951;">Hi, </p> --}}
      <?php
      $session_get_foto = Session::get('user_app')['foto'];
      if ($session_get_foto != NULL) {
        $foto_url = $session_get_foto;
      } else {
        // $foto_url = asset('public/assets/images/users/avatar-1.jpg');
        $foto_url = asset('public/image/avatar_superman.jpg');
      }
      ?>
      <div class="dropdown d-flex">
        <button type="button" class="btn header-item user text-start d-flex align-items-center" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <img class="rounded-circle header-profile-user" src="{{$foto_url}}" alt="Header Avatar">
        </button>
        <div class="dropdown-menu navi dropdown-menu-end pt-0 text-center ">
          <div class="rounded-circle mx-auto my-1 allnotif" style="overflow: hidden; height:90px; width: 90px;">
            <img style="width: 90px; border: 2px solid white;border-radius: 50%;" src="{{$foto_url}}" alt="">
          </div>
          <p class="dropdown-item text-center allnotif">
            {{ Session::get('user_app')['nama'] }}
            <br>
            ( {{ Session::get('user_app')['username'] }} )
          </p>
          <hr>
          <button id="btnLogout" name="btnLogout" type="button" class="dropdown-item allnotif"><i class='bx bx-log-out font-size-18 align-middle me-1'></i> <span class="align-middle">Logout</span></button>
        </div>
      </div>
    </div>
  </div>
</header>