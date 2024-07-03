<nav class="mainmenu_wrapper">
    <ul class="mainmenu nav sf-menu">
        <li>
            <a href="{{ url('/') }}">@lang('nav.home')</a>
        </li>
        <li class="{{ (Route::currentRouteName() === 'users.index' || 'roles.index' || 'permissions.index' ) ? 'active' : '' }}">
            <a href="{{route('users.index') }}">User Management</a>
            <ul>
                <li><a href="{{route('users.index') }}">Users</a></li>
                <li><a href="{{route('roles.index') }}">Roles</a></li>
                <li><a href="{{route('permissions.indexHinarios') }}">Hinario Permissions</a></li>
                <li><a href="{{route('permissions.indexPersons') }}">Person Permissions</a></li>
            </ul>
        </li>
        <li>
            <a href="{{ url('admin/enter-hymn') }}">Hymn</a>
            <ul>
                <li>
                    <a href="{{ url('admin/enter-hymn') }}">Enter New Hymn</a>
                </li>
                <li>
                    <a href="{{ url('admin/load-hymn') }}">Edit Hymn</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="{{ url('admin/edit-hinario') }}">Hinario</a>
        </li>
        <li>
            <a href="{{ url('admin/edit-person') }}">Person</a>
        </li>
        <li>
            <a href="{{ url('admin/edit-book') }}">Books</a>
        </li>
        <li>
            <a href="{{ url('admin/edit-link') }}">Links</a>
        </li>
        <li>
            <a href="{{ url('admin/edit-musician-files') }}">Musician Resource Files</a>
        </li>
        <li>
            <a href="{{ url('admin/move-hymn-files') }}">Move Hymn Files</a>
        </li>
        <li>
            <a href="{{ url('admin/generate-hinario-zip-files') }}">Generate Hinario Zips</a>
        </li>
        <li>
            <a href="{{ url('admin/import-people-audio-files') }}">Import People Audio Files</a>
        </li>
    </ul>
</nav>
<!-- eof main nav -->
