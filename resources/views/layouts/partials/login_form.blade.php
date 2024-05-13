<a href="#" class="dropdown-toggle" data-toggle="dropdown"><b>{{ __('page_top.login.login') }}</b> <span class="caret"></span></a>
<ul id="login-dp" class="dropdown-menu">
    <li>
        <div class="row">
            <div class="col-md-12">
                <form class="form" role="form" method="POST" action="{{ url('/login') }}" accept-charset="UTF-8" id="login-nav">
                    @csrf
                    <div class="form-group">
                        <label class="sr-only" for="email">{{ __('page_top.login.email') }}</label>
                        <input name="email" type="email" class="form-control" id="email" placeholder="{{ __('page_top.login.email') }}" required>
                    </div>
                    <div class="form-group">
                        <label class="sr-only" for="password">{{ __('page_top.login.password') }}</label>
                        <input name="password" type="password" class="form-control" id="password" placeholder="{{ __('page_top.login.password') }}" required>

                        <div class="row text-center">
                            <div class="col-sm-1 text-right"></div>
                            <div class="col-sm-10 text-right">
                                <input name="remember" type="checkbox" id="remember" value="remember">
                                <label for="remember">{{ __('page_top.login.remember') }}</label>
                            </div>
                        </div>

                        <div class="help-block text-right"><a href="{{ url('password/reset') }}">{{ __('page_top.login.forgot') }}</a></div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">{{ __('page_top.login.submit') }}</button>
                    </div>
                </form>
            </div>
            <div class="bottom text-center">
                {{ __('page_top.login.need') }} <a href="{{ url('register') }}"><b>{{ __('page_top.login.needLink') }}</b></a>
            </div>
        </div>
    </li>
</ul>
