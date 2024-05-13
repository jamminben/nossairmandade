@extends('layouts.app')

@section('header_title')
    {{ __('pagetitles.hinarios.personal.header_title') }}
@endsection

@section('page_title')
    <h2 class="small display_table_cell_md">{{ __('pagetitles.hinarios.personal.page_title') }}</h2>
@endsection

@section('content')
    <div class="col-sm-7 col-md-7 col-lg-7">
        <p>{{ __('hinarios.personal.page_description') }}</p><br>
        @if (\Illuminate\Support\Facades\Session::has('success'))
            <div class="alert alert-success" role="alert">
                <button type="button" class="close" data-dismiss="alert">
                    <span aria-hidden="true">×</span>
                    <span class="sr-only">{{ __('universal.close') }}</span>
                </button>
                <strong>{{ \Illuminate\Support\Facades\Session::get('success') }}</strong>
            </div><br>
        @endif
        @if (\Illuminate\Support\Facades\Session::has('error'))
            <div class="alert alert-danger" role="alert">
                <button type="button" class="close" data-dismiss="alert">
                    <span aria-hidden="true">×</span>
                    <span class="sr-only">{{ __('universal.close') }}</span>
                </button>
                <strong>{{ \Illuminate\Support\Facades\Session::get('error') }}</strong>
            </div><br>
        @endif
        <ul class="list1 no-bullets no-top-border personal-hinario-list">
            @foreach ($hinarios as $hinario)
                <li>
                    <h4><a href="{{ url('/user-hinario/' . $hinario->code) }}">{{ $hinario->getName($hinario->original_language_id) }}</a></h4>
                    <div class="personal-hinario-actions">
                        <a href="{{ url('/delete-personal-hinario/' .$hinario->id) }}" onclick="return confirm('{{ __('hinarios.personal.delete_confirm') }}');"><i class="fas fa-trash-alt"></i></a>
                        <a href="{{ url('/edit-personal-hinario/' .$hinario->id) }}"><i class="fas fa-edit"></i></a>
                        <a href="{{ url($hinario->getSlug()) }}" target="_blank"><i class="fas fa-eye"></i></a>
                    </div>
                    <p>{{ __('hinarios.personal.link_label') }} <a href="{{ url($hinario->getSlug()) }}" target="_blank">{{ url($hinario->getSlug()) }}</a></p>
                </li>
            @endforeach
        </ul>
    </div>
    <div class="col-sm-3 col-md-3 col-lg-3">
        <form action="{{ url('/create-personal-hinario') }}" method="POST">
            @csrf
            <div class="form-group-sm">
                <div class="form-group" style="text-align: center;">
                    <p>{{ __('hinarios.personal.new_hinario_form_header') }}</p>
                    <label for="hinario_name" class="sr-only">{{ __('hinarios.personal.new_hinario_form_header') }}</label>
                    <input type="text" name="hinario_name" placeholder="{{ __('hinarios.personal.hinario_name_placeholder') }}" value="">
                </div>
            </div>
            <div class="form-group-sm">
                <div class="feedback-form-button">
                    <button type="submit" class="theme_button color4 margin_0">{{ __('hinarios.personal.new_hinario_form_create') }}</button>
                </div>
            </div>
        </form>
    </div>
@endsection
