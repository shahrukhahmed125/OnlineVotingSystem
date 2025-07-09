<div>
    <div class="d-flex align-items-center justify-content-between">
        <div class="mr-1">
            @if (Auth::user()->HasRole('admin'))
                <h4 class="text-white mb-0">{{ Str::title(Auth::user()->name) }}</h4>
                <small class="text-white">Admin</small>
            @elseif(Auth::user()->HasRole('manager'))
                <h4 class="text-white mb-0">{{ Str::title(Auth::user()->name) }}</h4>
                <small class="text-white">Manager</small>
            @elseif(Auth::user()->HasRole('candidate'))
                <h4 class="text-white mb-0">{{ Str::title(Auth::user()->name) }}</h4>
                <small class="text-white">Candidate</small>
            @elseif(Auth::user()->HasRole('user'))
                <h4 class="text-white mb-0">{{ Str::title(Auth::user()->name) }}</h4>
                <small class="text-white">User</small>
            @endif
        </div>
        <a href="{{ route('logout') }}" class="text-white font-20 tooltip-wrapper" data-toggle="tooltip"
            data-placement="top" title="" data-original-title="Logout"> <i class="zmdi zmdi-power"></i></a>
    </div>
</div>
