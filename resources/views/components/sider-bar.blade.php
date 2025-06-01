<div>
    <aside class="app-navbar">
        <!-- begin sidebar-nav -->
        <div class="sidebar-nav scrollbar scroll_light">
            <ul class="metismenu " id="sidebarNav">
                <li><a href="app-chat.html" aria-expanded="false"><i class="nav-icon ti ti-rocket"></i><span class="nav-title">Dashboards</span></a> </li>
                <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false"><i class="nav-icon ti ti-calendar"></i><span class="nav-title">Election</span></a>
                    <ul aria-expanded="false">
                        <li> <a href="{{ route('admin.elections.create') }}">Add</a> </li>
                        <li> <a href="{{ route('admin.elections.index') }}">List</a> </li>
                    </ul>
                </li>
                <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false"><i class="nav-icon ti ti-calendar"></i><span class="nav-title">Assembly</span></a>
                    <ul aria-expanded="false">
                        <li> <a href="{{ route('admin.assembly.create') }}">Add</a> </li>
                        <li> <a href="{{ route('admin.assembly.index') }}">List</a> </li>
                    </ul>
                </li>
                <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false"><i class="nav-icon ti ti-calendar"></i><span class="nav-title">Political Party</span></a>
                    <ul aria-expanded="false">
                        <li> <a href="{{ route('admin.political_parties.create') }}">Add</a> </li>
                        <li> <a href="{{ route('admin.political_parties.index') }}">List</a> </li>
                    </ul>
                </li>
                <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false"><i class="nav-icon ti ti-calendar"></i><span class="nav-title">Candidates</span></a>
                    <ul aria-expanded="false">
                        <li> <a href="{{ route('admin.candidates.create') }}">Add</a> </li>
                        <li> <a href="{{ route('admin.candidates.index') }}">List</a> </li>
                    </ul>
                </li>
                <li><a href="mail-inbox.html" aria-expanded="false"><i class="nav-icon ti ti-email"></i><span class="nav-title">Mail</span></a> </li>
            </ul>
        </div>
        <!-- end sidebar-nav -->
    </aside>
</div>