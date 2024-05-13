<?php

return [

    'body' => '
        <p>
            As you may have noticed, there have been some changes around here...
        </p>
        <p>
            Here is a list of the major changes I have made to the site recently. As I add new features and updates, I will try to keep this list up to date.
        </p>
        <p>
            If you think of something you would like the site to have, don\'t hesitate to <a href="' . url('/contact') .'"> let me know</a>.
        </p>
        <ul class = "list1">
            <li>
                <h4>
                    Printable PDFs for all hinários
                </h4>
                <p>
                    At the top of each page of the hymnbook there is a link called "Printable version". Clicking this button will render a PDF of the entire
                    hinário.
                </p>
            </li>
            <li>
                <h4>
                    Personal hinários
                </h4>
                <p>
                    If you are logged in, you can create your own hinários. Every hymn should have a small menu next to the
                    name that allows you to add the hymn to any of your personal hinário. You can share links to your hinário,
                    print PDFs and listen to them just like any other hinário.
                </p>
            </li>
            <li>
                <h4>
                    Built-in audio players
                </h4>
                <p>
                    There are now audio players embedded in any hinário or hymn page for which I have recordings.
                </p>
            </li>
            <li>
                <h4>
                    "Like" recordings
                </h4>
                <p>
                    Logged-in users can enjoy recordings. The most liked recordings will be displayed at the top.
                </p>
            </li>
            <li>
                <h4>
                    New account system
                </h4>
                <p>
                    So far, creating a new account has been a manual process for me. Some time ago, I lost the ability to create new accounts, which left the entire system in Limbo. I apologize to anyone who wants an account and did not get one. Now you can make your own, without having to wait.
                </p>
            </li>
            <li>
                <h4>
                    Feedback
                </h4>
                <p>
                    Now, logged-in users can leave comments for any hinário, hymn or person page. If you see something that is not right, let me know with the small form at the bottom right of the page.
                </p>
            </li>
            <li>
                <h4>
                    Search
                </h4>
                <p>
                    The search function - which used to be available only to logged in users - is now available to everyone.
                </p>
            </li>
            <li>
                <h4>
                    Localization
                </h4>
                <p>
                    It turns out that many of my visitors come from Brazil. I\'m trying to make the site as accessible as
                    possible in English and Portuguese. It is configured to add other languages very easily. If you would
                    like to contribute to this effort with some help with translations, <a href="' . url('/contact') .'">get in touch</a>!
                </p>
            </li>
            <li>
                <h4>
                    New logo
                </h4>
                <p>
                    I used a new logo for the website. Here\'s a closer look:
                </p>
                <img src="/images/nossairmandade_logo.png" alt="New logo">
            </li>
            <li>
                <h4>
                    More to come
                </h4>
                <p>
                    I will work on the new website, always trying to improve it. Keep your eyes peeled for new features.
                </p>
            </li>
        </ul>',

];
