<div class="sidebar" :class="{'sidebar-hidden': sidebarHidden}">

    <!-- show / hide the sidebar -->
    <a class="sidebar-toggler" title="Toggle the side bar"
       @click.prevent="sidebarHidden = !sidebarHidden"
    >
        <i class="fas fa-times hide-icon"></i>
        <i class="fas fa-eye fa-dark show-icon"></i>
    </a>

    <!-- Site logo -->
    <a href="{{ url('/') }}" title="Homepage">
        <img src="{{ asset('images/oxy-logo.png') }}"
             alt="{{ config('app.name', 'Oxygen') }}"
             class="img-fluid o-sidebar-logo"
        >
    </a>

    <!-- Navigation -->
    <nav class="nav flex-column" role="navigation">
        <!-- Dashboard -->
        <a class="nav-link {{ activeIfPath('admin') }}"
           href="{{ route('admin.dashboard') }}"
        >
            <i class="fas fa-tachometer-alt"></i>Dashboard
        </a>

        <!-- Pages -->
        <a class="nav-link {{ activeIfPath('admin/page*') }}"
           href="{{ route('page.index') }}"
        >
            <i class="fas fa-file-signature"></i>Pages
        </a>

        <!-- Phrases -->
        <a class="nav-link {{ activeIfPath('admin/phrase*') }}"
           href="{{ route('phrase.index') }}"
        >
            <i class="fas fa-language"></i>Phrases
        </a>

        <!-- Blocks -->
        <a class="nav-link {{ activeIfPath('admin/block*') }}"
           href="{{ route('block.index') }}"
        >
            <i class="fas fa-th-large"></i>Blocks
        </a>

        <!-- Menus -->
        <a class="nav-link {{ activeIfPath('admin/menu*') }}"
           href="{{ route('menu.index') }}"
        >
            <i class="fas fa-bars"></i>Menus
        </a>

        <!-- Users -->
        <a class="nav-link {{ activeIfPath('admin/user*') }}"
           href="{{ route('user.index') }}"
        >
            <i class="fas fa-users"></i>Users
        </a>

        <!-- Roles -->
        <a class="nav-link {{ activeIfPath('admin/role*') }}"
           href="{{ route('role.index') }}"
        >
            <i class="fas fa-users-cog"></i>Roles
        </a>

        <!-- Permissions -->
        <a class="nav-link {{ activeIfPath('admin/permission*') }}"
           href="{{ route('permission.index') }}"
        >
            <i class="fas fa-shield-alt"></i>Permissions
        </a>

        {{--<span class="nav-section-title">Authentication</span>--}}
    </nav>
</div>