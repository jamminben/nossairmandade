<a href="#" class="dropdown-toggle" data-toggle="dropdown"><b>{{ \Illuminate\Support\Facades\Auth::user()->email }}</b> <span class="caret"></span></a>
<ul id="login-dp" class="dropdown-menu">
    <li>
        <div class="row">
            <div class="col-md-12">
                <form class="form" role="form" method="POST" action="{{ url('/logout') }}" accept-charset="UTF-8" id="login-nav">
                    @csrf
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">{{ __('page_top.logout.submit') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </li>
</ul>
