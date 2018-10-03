<nav class="nav justify-content-end" role="navigation">

    @include('oxygencms::admin.partials.language_select_dropdown')

    @auth
        <div class="nav dropdown">
            <a class="nav-link dropdown-toggle"
               id="navUserDropdown"
               data-toggle="dropdown"
               aria-haspopup="true"
               aria-expanded="false"
               title="{{ auth()->user()->email }}"
               href=""
            >
                {{ auth()->user()->name }}
            </a>

            <div class="dropdown-menu dropdown-menu-right text-right min-width" aria-labelledby="navUserDropdown">
                <a href="{{ route('user.profile', auth()->user()) }}"
                   class="dropdown-item nav-link"
                   title="view/edit your profile.."
                >
                    Profile <i class="fas fa-user-edit"></i>
                </a>

                <a href="{{ route('logout') }}"
                   class="dropdown-item nav-link"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                >
                    Logout <i class="fas fa-sign-out-alt"></i>
                </a>

                <form id="logout-form"
                      action="{{ route('logout') }}"
                      method="POST"
                      style="display: none;">
                      @csrf
                </form>
            </div>
        </div>
    @endauth
</nav>