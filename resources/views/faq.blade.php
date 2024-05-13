@extends('layouts.app')

@section('header_title')
    {{ __('pagetitles.faq.header_title') }}
@endsection

@section('page_title')
    <h2 class="small display_table_cell_md">{{ __('pagetitles.faq.page_title') }}</h2>
@endsection

@section('content')
    <div class="col-xs-10">
        <h4>{{ __('faq.intro') }}</h4>
        <div id="accordion" class="panel-group collapse-unstyled">
            <div class="panel">
                <h4 class="poppins"> <a data-toggle="collapse" data-parent="#accordion" href="#collapse1" class="collapsed">
                        {!! __('faq.questions.1.question') !!}
                    </a> </h4>
                <div id="collapse1" class="panel-collapse collapse">
                    <div class="panel-content">{!! __('faq.questions.1.answer') !!}</div>
                </div>
            </div>
            <!-- .panel -->

            <div class="panel">
                <h4 class="poppins"> <a data-toggle="collapse" data-parent="#accordion" href="#collapse2" class="collapsed">
                        {!! __('faq.questions.2.question') !!}
                    </a> </h4>
                <div id="collapse2" class="panel-collapse collapse">
                    <div class="panel-content">{!! __('faq.questions.2.answer') !!}</div>
                </div>
            </div>
            <!-- .panel -->

            <div class="panel">
                <h4 class="poppins"> <a data-toggle="collapse" data-parent="#accordion" href="#collapse3" class="collapsed">
                        {!! __('faq.questions.3.question') !!}
                    </a> </h4>
                <div id="collapse3" class="panel-collapse collapse">
                    <div class="panel-content">{!! __('faq.questions.3.answer') !!}</div>
                </div>
            </div>
            <!-- .panel -->

            <div class="panel">
                <h4 class="poppins"> <a data-toggle="collapse" data-parent="#accordion" href="#collapse4" class="collapsed">
                        {!! __('faq.questions.4.question') !!}
                    </a> </h4>
                <div id="collapse4" class="panel-collapse collapse">
                    <div class="panel-content">{!! __('faq.questions.4.answer') !!}</div>
                </div>
            </div>
            <!-- .panel -->

            <div class="panel">
                <h4 class="poppins"> <a data-toggle="collapse" data-parent="#accordion" href="#collapse5" class="collapsed">
                        {!! __('faq.questions.5.question') !!}
                    </a> </h4>
                <div id="collapse5" class="panel-collapse collapse">
                    <div class="panel-content">{!! __('faq.questions.5.answer') !!}</div>
                </div>
            </div>
            <!-- .panel -->

        </div>
    </div>
@endsection
