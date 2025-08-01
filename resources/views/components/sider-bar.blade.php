<div>
    <aside class="app-navbar">
        <!-- begin sidebar-nav -->
        <div class="sidebar-nav scrollbar scroll_light">
            <ul class="metismenu " id="sidebarNav">
                <li><a href="{{route('admin.home')}}" aria-expanded="false"><i class="nav-icon ti ti-layout-grid2"></i><span class="nav-title"><strong>Dashboards</strong></span></a> </li>
                <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false"><i class="nav-icon ti ti-user"></i><span class="nav-title"><strong>Users</strong></span></a>
                    <ul aria-expanded="false">
                        <li> <a href="{{ route('admin.users.create') }}">Add</a> </li>
                        <li> <a href="{{ route('admin.users.index') }}">List</a> </li>
                    </ul>
                </li>
                <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false"><i class="nav-icon ti ti-archive"></i><span class="nav-title"><strong>Election</strong></span></a>
                    <ul aria-expanded="false">
                        <li> <a href="{{ route('admin.elections.create') }}">Add</a> </li>
                        <li> <a href="{{ route('admin.elections.index') }}">List</a> </li>
                    </ul>
                </li>
                <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false"><i class="nav-icon ti ti-trello"></i><span class="nav-title"><strong>Assembly</strong></span></a>
                    <ul aria-expanded="false">
                        <li> <a href="{{ route('admin.assembly.create') }}">Add</a> </li>
                        <li> <a href="{{ route('admin.assembly.index') }}">List</a> </li>
                    </ul>
                </li>
                <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false"><i class="nav-icon ti ti-agenda"></i><span class="nav-title"><strong>Political Party</strong></span></a>
                    <ul aria-expanded="false">
                        <li> <a href="{{ route('admin.political_parties.create') }}">Add</a> </li>
                        <li> <a href="{{ route('admin.political_parties.index') }}">List</a> </li>
                    </ul>
                </li>
                <li><a href="{{route('admin.candidates.index')}}" aria-expanded="false"><i class="nav-icon ti ti-id-badge"></i><span class="nav-title"><strong>Candidates</strong></span></a></li>
                <li><a href="#" aria-expanded="false"><i class="nav-icon ti ti-envelope"></i><span class="nav-title"><strong>Votes</strong></span></a></li>
            </ul>
        </div>
        <!-- end sidebar-nav -->
    </aside>
</div>