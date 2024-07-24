@extends('layouts.app')

@section('header_title')
    {{ __('pagetitles.home.header_title') }}
@endsection

@section('page_title')
    <h2 class="small display_table_cell_md">{{ __('pagetitles.home.page_title') }}</h2>
@endsection

@section('content')



    <!-- Message from Ben -->
    <div class="row center">

        <div class="col-md-10 col-sm-10 col-lg-10">

            <p>Hello,</p>

<p>Welcome to nossairmandade.com</p>

            <p>This site is intended to serve as a support for the global Daime community.  There are now many branches to our beautiful tree, each with their own mission and ideas about how the Daime should be used and represented.  It is not our intention to favor one branch over another but to offer support and representation to whoever is walking the path.</p>

            <p>If you are part of a group that is not represented correctly on this site, please use our <a href="{{ url('contact') }}">Contact Page</a> to let us know.  We will correct the situation as quickly as we can.</p>

            <p>If your group or hinário is not on the site and you would like it to be, please use our <a href="{{ url('contact') }}">Contact Page</a> to request that it be added.</p>

            <p>If you feel called to support the continued existence and growth of this site, please consider a donation via our <a href="{{ url('donate') }}">Donation Page</a>.</p>

            <p>Thank you for being here and we hope this site is a help to you in your studies and participation in the Daime.</p>

            <p>With much love and a big hug,</p>

            <p>The nossairmandade.com team</p>

        </div>
    </div>

@endsection
