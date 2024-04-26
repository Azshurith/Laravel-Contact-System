<div class="row">
    <div class="col-sm-9">
        <h1>{{ $title }}</h1>
    </div>
    <div class="col-sm-3">
        <span><a href="{{ route('contact.create') }}">Add Contact</a></span> |
        <span><a href="{{ route('contact.index') }}">Contacts</a></span> |
        <span><a href="{{ route('logout') }}">Logout</a></span>
        @if ($title == 'Contacts')
            <div class="form-group">
                <input type="text" id="search" class="form-control" placeholder="Search...">
            </div>
        @endif
    </div>
</div>
