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

        <div class="col-md-8 col-sm-8 col-lg-8">
            
            <p>Hello,</p>

<p>As you might have noticed, nossairmandade.com is back online.  When I made the difficult decision to close the site, I did so with the assumption that - while many people use the site each day - it wouldn't have much of an impact on your life.  I figured there were other resources available and I never heard from very many people that the site was important to them.  Clearly, I was incorrect.</p>

<p>I have received a flood of messages of love and support since I closed the site.  It has become clear that the site is very important to a lot of people.  I wish I had known that sooner.  I am sorry for the interruption of access to this resource.</p>

<p>Moving ahead, there are some big problems to solve.  They fall into three major categories:</p>

<p>1) Financial need</p>

<p>It costs a minimum of $100 USD per month to keep the site running.  I paid this out of my pocket for the first 10 years with some very generous donations by a small number of people to help along the way.  \The site is now funded by generous donations from various organizations and individuals.  Please visit the Donate page if you are considering helping in this way.</p>

<p>2) Technical help</p>

<p>I created nossairmandade.com myself using the tools and skills I possess.  It runs on a LAMP stack, which means a Linux and Apache server, a MySQL database, and Php as the language the site is written in.  I used a Php framework called Laravel when I redid the site in 2020.  If any of that means anything to you and you are able to contribute in terms of site maintenance and updates, please get in touch with me.  I can't do this stuff alone anymore and would love some help.</p>

<p>3) Hymn updates and additions</p>

<p>There is a never-ending flow of new hymns being received - one of the most beautiful and meaningful aspects of our beloved doctrine.  In addition, my versions of the hymns often contain errors, typos, etc.  I have spent countless hours entering and updating hymns and I'm feeling a little finished with that work.  For the site to continue to live and grow, I need help with managing that data.  If you are available for that kind of work, please get in touch!</p>

<p>All three of these areas need support and active participation for the site to succeed.  I am interested in putting together teams to help with each of them.  So please reach out if you are interested in taking a role in nossairmandade.com's future.  Two weeks ago I didn't think it had one.  You all have asked that it be so, and now comes the work.  I haven't managed a project like this before, I haven't been able to collaborate with anyone on the site, and it's all feeling both inspiring and overwhelming.</p>

<p>Thank you so much for all of the love and support.  It has been an emotional week receiving all of your messages.  I have read them all.  I will do my best to continue to make the site available.</p>

<p>With much love,</p>

<p>Ben</p>
            
        </div>

        <div class="col-md-2 col-sm-2 col-lg-2">
            <div class="person_bio">
                <div class="avatar">
                    <img src="images/ben.jpg" alt="">
                </div>

                <div class="person_name grey">
                    Ben Tobias
                </div>
                <span class="small-text highlight4">
						{{ __('home.bens_role') }}
                </span>
            </div>
        </div>

@endsection
