<ul class="navbar-nav bg-gradient-light sidebar sidebar-light accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('home')}}">
        <div class="sidebar-brand-icon rotate-n-15">
           <img src="{{asset('assets/img/logo.png')}}" class="img-fluid img-profile" width="50">
        </div>
        <div class="sidebar-brand-text mx-3">Baux Miliatires</div>
    </a>
    <hr class="sidebar-divider my-0">
    <li class="nav-item @yield('home-active')">
        <a class="nav-link" href="{{route('home')}}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Accueil</span></a>
    </li>
    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        Pages
    </div>
    <li class="nav-item @yield('militaire-active')">
        <a class="nav-link" href="/dashboard/militaires">
            <i class="fas fa-fw fa-user-shield"></i>
            <span>Militaires</span></a>
    </li>
    <li class="nav-item @yield('grade-active')">
        <a class="nav-link" href="/dashboard/grades-militaires">
            <i class="fas fa-fw fa-user-graduate"></i>
        <span>Grades</span></a>
    </li>
    <li class="nav-item @yield('logement-active')">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-house-damage"></i>
            <span>Logements</span>
        </a>
        <div id="collapseTwo" class="collapse @yield('logement-show')" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item @yield('type_l-active')" href="/dashboard/type-de-logemets">Type De Logements</a>
                <a class="collapse-item @yield('l_actuel-active')" href="{{route('logement.home')}}">Logements Actuels</a>
                <a class="collapse-item @yield('l_ancien-active')" href="{{route('ancienL.home')}}">Anciens Logements</a>
            </div>
        </div>
    </li>
    <li class="nav-item @yield('proprietaire-active')">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
            <i class="fas fa-fw fa-wrench"></i>
            <span>Propriétaires</span>
        </a>
        <div id="collapseUtilities" class="collapse @yield('proprietaire-show')" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item @yield('active_pListe')" href="{{route('proprio.home')}}">Liste Propriétaires</a>
                <a class="collapse-item @yield('active_compte')" href="{{route('compte.home')}}">Comptes Propriétaires</a>
            </div>
        </div>
    </li>
    <li class="nav-item @yield('emplacement-active')">
        <a class="nav-link" href="/dashboard/emplacements">
            <i class="fas fa-fw fa-map-marker"></i>
            <span>Emplacements</span></a>
    </li>
    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        Administration
    </div>
    <li class="nav-item @yield('users-active')">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
            <i class="fas fa-fw fa-users-cog"></i>
            <span>Utilisateurs Mangement</span>
        </a>
        <div id="collapsePages" class="collapse @yield('users-show')" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item @yield('user')" href="{{route('user.home')}}">Utilsateurs</a>
                <a class="collapse-item @yield('role')" href="{{route('habilitations.index')}}">Niveau Habilétés</a>
            </div>
        </div>
    </li>
    <hr class="sidebar-divider d-none d-md-block">
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
