<div>
    <aside class="app-navbar">
        <!-- begin sidebar-nav -->
        <div class="sidebar-nav scrollbar scroll_dark">
            <ul class="metismenu" id="sidebarNav">

                <li class="nav-static-title">Main</li>
                <li class="{{ request()->routeIs('admin.home') ? 'active' : '' }}">
                    <a href="{{ route('admin.home') }}" aria-expanded="false">
                        <i class="nav-icon ti ti-layout-grid2"></i>
                        <span class="nav-title">Dashboards</span>
                    </a>
                </li>

                <li class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <a class="has-arrow" href="javascript:void(0)" aria-expanded="{{ request()->routeIs('admin.users.*') ? 'true' : 'false' }}">
                        <i class="nav-icon ti ti-user"></i>
                        <span class="nav-title">Users</span>
                    </a>
                    <ul aria-expanded="{{ request()->routeIs('admin.users.*') ? 'true' : 'false' }}">
                        <li class="{{ request()->routeIs('admin.users.create') ? 'active' : '' }}">
                            <a href="{{ route('admin.users.create') }}">Add</a>
                        </li>
                        <li class="{{ request()->routeIs('admin.users.index') ? 'active' : '' }}">
                            <a href="{{ route('admin.users.index') }}">List</a>
                        </li>
                    </ul>
                </li>

                <li class="{{ request()->routeIs('admin.elections.*') ? 'active' : '' }}">
                    <a class="has-arrow" href="javascript:void(0)" aria-expanded="{{ request()->routeIs('admin.elections.*') ? 'true' : 'false' }}">
                        <i class="nav-icon ti ti-archive"></i>
                        <span class="nav-title">Election</span>
                    </a>
                    <ul aria-expanded="{{ request()->routeIs('admin.elections.*') ? 'true' : 'false' }}">
                        <li class="{{ request()->routeIs('admin.elections.create') ? 'active' : '' }}">
                            <a href="{{ route('admin.elections.create') }}">Add</a>
                        </li>
                        <li class="{{ request()->routeIs('admin.elections.index') ? 'active' : '' }}">
                            <a href="{{ route('admin.elections.index') }}">List</a>
                        </li>
                    </ul>
                </li>

                <li class="{{ request()->routeIs('admin.assembly.*') ? 'active' : '' }}">
                    <a class="has-arrow" href="javascript:void(0)" aria-expanded="{{ request()->routeIs('admin.assembly.*') ? 'true' : 'false' }}">
                        <i class="nav-icon ti ti-trello"></i>
                        <span class="nav-title">Assembly</span>
                    </a>
                    <ul aria-expanded="{{ request()->routeIs('admin.assembly.*') ? 'true' : 'false' }}">
                        <li class="{{ request()->routeIs('admin.assembly.create') ? 'active' : '' }}">
                            <a href="{{ route('admin.assembly.create') }}">Add</a>
                        </li>
                        <li class="{{ request()->routeIs('admin.assembly.index') ? 'active' : '' }}">
                            <a href="{{ route('admin.assembly.index') }}">List</a>
                        </li>
                    </ul>
                </li>

                <li class="{{ request()->routeIs('admin.political_parties.*') ? 'active' : '' }}">
                    <a class="has-arrow" href="javascript:void(0)" aria-expanded="{{ request()->routeIs('admin.political_parties.*') ? 'true' : 'false' }}">
                        <i class="nav-icon ti ti-agenda"></i>
                        <span class="nav-title">Political Party</span>
                    </a>
                    <ul aria-expanded="{{ request()->routeIs('admin.political_parties.*') ? 'true' : 'false' }}">
                        <li class="{{ request()->routeIs('admin.political_parties.create') ? 'active' : '' }}">
                            <a href="{{ route('admin.political_parties.create') }}">Add</a>
                        </li>
                        <li class="{{ request()->routeIs('admin.political_parties.index') ? 'active' : '' }}">
                            <a href="{{ route('admin.political_parties.index') }}">List</a>
                        </li>
                    </ul>
                </li>

                <li class="{{ request()->routeIs('admin.candidates.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.candidates.index') }}" aria-expanded="false">
                        <i class="nav-icon ti ti-id-badge"></i>
                        <span class="nav-title">Candidates</span>
                    </a>
                </li>

                <li class="nav-static-title">Results</li>
                <li class="{{ request()->routeIs('admin.votes.*') ? 'active' : '' }}">
                    <a class="has-arrow" href="javascript:void(0)" aria-expanded="{{ request()->routeIs('admin.votes.*') ? 'true' : 'false' }}">
                        <i class="nav-icon ti ti-bar-chart-alt"></i>
                        <span class="nav-title">Top Results</span>
                    </a>
                    <ul aria-expanded="{{ request()->routeIs('admin.votes.*') ? 'true' : 'false' }}">
                        <li class="{{ request()->routeIs('admin.votes.top_candidates') ? 'active' : '' }}">
                            <a href="{{ route('admin.votes.top_candidates') }}">Candidates</a>
                        </li>
                        <li class="{{ request()->routeIs('admin.votes.by_party') ? 'active' : '' }}">
                            <a href="{{ route('admin.votes.by_party') }}">Parties</a>
                        </li>
                    </ul>
                </li>

                <li class="{{ request()->routeIs('admin.votes.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.votes.index') }}" aria-expanded="false">
                        <i class="nav-icon ti ti-envelope"></i>
                        <span class="nav-title">All Votes</span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- end sidebar-nav -->
    </aside>
</div>