@extends('layouts.app')

@section('header_title')
    Signing Off...
@endsection

@section('page_title')
    <h2 class="small display_table_cell_md">This is hard.</h2>
@endsection

@section('content')
    <div class="col-sm-8" data-animation="scaleAppear">
    
    
    <p>Dear Nossa Irmandade community,</p>

<p>When I began working on nossairmandade.com back in 2010, there were almost no other online resources for the study of the Santo Daime hymns.  I felt called to create this website to support my own study and my community here in the Pacific Northwest of the United States of America.  Little did I know that the community of users would become global and that fully 2/3 of the site's users would be in Brazil.  At its peak, the site has received as many as 1,000 unique individual visitors in a day.  That's a lot of daimistas!</p>

<p>It's been a lot of work over a long time to keep the site running.  In addition to the financial costs, there has been a large demand for my time and energy.  I always brought to the work an awareness that this was a way I could be of service for the doctrine and the people who have given me so much.  I was happy to follow this calling for the last 12 years.</p>

<p>Now the time has come for me to shift my energy and effort to other things.  As of now the site will no longer be active.  I know this is a disappointment for some of you that have come to rely on the site for your study.  I hope you are able to find other resourcess - there are now many.  CEFLI and ICEFLU both have official sites with words and recordings.  Youtube has a myriad of recordings and even sing-along guides.  Soundcloud has many, many Daime hymns in its system.  Many churches around the world are developing their own sites.  And I'm sure there are more in the works all the time.  In short, where once there were no other options, there is now an abundance.</p>

<p>I want to thank each and every one of you for using the site over the years.  Every time I heard someone say that it helped them, I felt fulfilled in my mission.  The personal connections I have made through my role in running the site are a treasure to me.  It has been a joy and a labor of love.  If you have benefitted from using the site, please know that the vibrations of joy and gratitude resonate in all directions.  I am deeply touched to have made something that helped people.</p>

<p>I also want to apologize to the many people I have let down over the years by over-committing to work I could not do.  I know I have disapointed many of you by making promises I could not keep.  Whatever my intentions and desires, I should have done better at managing my time and effort and at saying no when I simply couldn't fit it all in.</p>

<p>And so for now I say farewell and bons trabalhos to you all.  I am adding a contact form at the bottom of this page in case you need to reach me.  I don't know how long it will remain active.  If you need any particular thing, please don't hesitate to ask and I will do my best (and say no if I have to!).</p>

<p>Sending lots of love and light and a big hug,</p>

<p>Ben</p>
    
    
    
        @if (\Illuminate\Support\Facades\Session::has('success'))
            <div class="alert alert-success" role="alert">
                <button type="button" class="close" data-dismiss="alert">
                    <span aria-hidden="true">×</span>
                    <span class="sr-only">{{ __('universal.close') }}</span>
                </button>
                <strong>{{ \Illuminate\Support\Facades\Session::get('success') }}</strong>
            </div><br>
        @endif
        <form class="contact_form row columns_padding_10" method="post">
            @csrf
            <div class="col-sm-6">
                <div class="form-group bottommargin_0">
                    <label for="name">
                        {{ __('contact.formElements.fullName') }}
                        <span class="required">*</span>
                    </label>
                    <input type="text" aria-required="true" size="30" value="" name="name" id="name" class="form-control" placeholder="{{ __('contact.formElements.fullName') }}*">
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group bottommargin_0">
                    <label for="email">
                        {{ __('contact.formElements.email') }}
                        <span class="required">*</span>
                    </label>
                    <input type="email" aria-required="true" size="30" value="" name="email" id="email" class="form-control" placeholder="{{ __('contact.formElements.email') }}*">
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group bottommargin_0">
                    <label for="subject">
                        {{ __('contact.formElements.subject') }}
                        <span class="required">*</span>
                    </label>
                    <input type="text" aria-required="true" size="30" value="" name="subject" id="subject" class="form-control" placeholder="{{ __('contact.formElements.subject') }}*">
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group bottommargin_0">
                    <label for="message">
                        {{ __('contact.formElements.text') }}
                        <span class="required">*</span>
                    </label>
                    <textarea aria-required="true" rows="5" cols="45" name="message" id="message" class="form-control" placeholder="{{ __('contact.formElements.text') }}*"></textarea>
                </div>
            </div>
            <div class="col-sm-12 center">
                
                <div class="row">
                    <div class="contact-form-submit topmargin_10 text-center">
                        <button type="submit" id="contact_submit" name="contact_submit" class="theme_button color4 min_width_button margin_0">{{ __('contact.formElements.submit') }}</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!--.col-* -->
    
@endsection
