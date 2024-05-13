@extends('layouts.app')

@section('header_title')
    {{ __('pagetitles.norms_and_rituals.header_title') }}
@endsection

@section('page_title')
    <h2 class="small display_table_cell_md">{{ __('pagetitles.norms_and_rituals.page_title') }}</h2>
@endsection

@section('content')
    <div class="col-sm-10">

        <div class="pronunciation-rule">
            <h4>NOTE: These rules are set in stone.</h4>
            <p>Well, not really.  But they do apply almost all of the time.  It will be much easier if you practice using them every time.</p>
        </div>

        <div class="pronunciation-rule">
            <a name="section1">
                <h4>Nasal sounds.  No, not blowing your nose.</h4>
            </a>
            <p>Several letters and sounds in Brazilian Portuguese are nasalized.  Nasalized sounds are formed in the back of your mouth and in your nose and sinuses.  You do this by making the sound with your mouth and nose open.  It sort of sounds like "ng", only vowelier.  Pretend you know what that means.</p>
        </div>

        <div class="pronunciation-rule">
            <a name="section2">
                <h4>Rule 1: The Final "M"</h4>
            </a>
            <p>In Brazilian Portuguese, a lot of words end with the letter <em>m</em>.  When they do, the final <em>m</em> is not pronounced.  Instead, the vowel that preceeds the final <em>m</em> is nasalized.  Try this:  say "Mensagem" like you would in English.  See how the final m sounds like an <em>m</em>?  In Brazilian Portuguese, this is incorrect!  Now try saying it again, but keep your mouth open for the whole last syllable.  Notice the difference.  Instead of "Mensagem", it should sound more like "Mensajehng".  If it did, you're getting it!  If not, try saying "Mensajehng".  Now you're closer!</p>
            <p>Words that end in <em>em</em>, <em>om</em>, and <em>im</em> work like the example above.  Here are some words to practice:</p>
            <ul>
                <li>assim ("asseehng")</li>
                <li>em ("ehng")</li>
                <li>com ("kohng")</li>
                <li>Virgem ("Virjehng")</li>
            </ul><br />
            <p>Words that end in <em>am</em> are a little different.  Instead of "ahng", they sound a little more like "ow".  They are still nasalized, which gives a little "ng" sound to them.  Here are some words to practice:</p>
            <ul>
                <li>Juramidam ("Juramidow")</li>
                <li>levaram ("levarow")</li>
            </ul><br />
            <p>This rule takes a little practice, but don't worry, you'll get plenty of opportunity.  Once you get it, it makes the transitions between words much easier, because you don't have to close your mouth between syllables in phrases like, "O Mestre assim não ensinou" (Padrinho Valdete &#35;39).</p>
            <p>One last thing: <em>m</em>s in the middle of words and at the begining are pronounced like they are in English.</p>
        </div>

        <div class="pronunciation-rule">
            <a name="section3">
                <h4>Rule 2: Oooooo!  Eeeeee!</h4>
            </a>
            <p>When a word ends in <em>o</em>, the <em>o</em> sounds like <em>-oo</em>.  When a word ends in <em>e</em>, the <em>e</em> sounds like <em>-ee</em>.  This includes the words "o" and "e" (which mean "it" and "and").  Pretty simple, right?  Careful, though.  A word that ends in <em>&#233;</em> sounds like it ends with <em>-ay</em>.  So the phrase "E &#233;" (which means "and is") sounds like "Ee ay".  Practice words:</p>
            <ul>
                <li>como ("co-moo")</li>
                <li>pe&#231;o ("peh-soo")</li>
                <li>examine ("ex-ahm-ee-nee")</li>
                <li>neste ("nes-tchee")</li>
                <li>de ("djee")</li>
            </ul><br />
            <p>Confused about those last two?  Read on...</p>
        </div>

        <div class="pronunciation-rule">
            <a name="section4">
                <h4>Rule 3: Djee whizz!  Whatcha doing'?</h4>
            </a>
            <p>Any time the letter <em>d</em> is followed by the <em>-ee</em> sound, it is pronounced "djee" (like the "gee" in "Gee whiz!").  When the letter <em>t</em> is followed by the <em>-ee</em> sound, it sounds like "chee" (like "cheese").  Practice words:</p>
            <ul>
                <li>pedi ("peh-djee")</li>
                <li>verdade ("veh-dah-djee")</li>
                <li>de ("djee")</li>
            </ul>
        </div>

        <div class="pronunciation-rule">
            <a name="section5">
                <h4>Rule 3b: Mind your djees and tchees!</h4>
            </a>
            <p>Anywhere it appears in a word, <em>di</em> is always pronounced 'djee'.  Likewise, <em>ti</em> is always pronounced 'tchee'.  This is different than <em>de</em> and <em>te</em> from rule 3, which only apply at the end of the word.  Practice words:</p>
            <ul>
                <li>bendito ("ben-djee-too")</li>
                <li>batizado ("bah-tchee-zah-doo")</li>
                <li>direitinho ("djee-reh-tcheen-yoo")</li>
            </ul>
            <p>How about that last one?  One Rule 2 and two Rule 3b's!</p>
        </div>

        <div class="pronunciation-rule">
            <a name="section6">
                <h4>Rule 4: Who you calling a diphthong!?</h4>
            </a>
            <p>A <em>diphthong</em> is a combination of letters that are considered to be one letter and are all pronounced as one sound.  Brazilian Portuguese has a few diphthongs that are nasalized:</p>
            <ul>
                <li><em>&#227;o</em> - pronounced like a nasalized <em>-ow</em>.  Not <em>-owwww</em> or <em>-aaaooow</em>, just <em>-ow</em>.</li>
                <li><em>&#245;e</em> - pronounced like a nasalized <em>-oy</em>.</li>
                <li>In the words "muito" and "muita", the <em>-ui</em> sound is pronounced <em>-ween</em>.  "Mweentoo"</li>
            </ul><br />
            <p>It's important to remember that a diphthong is considered to be one letter.  So words that end in <em>&#227;o</em> aren't subject to Rule 2 even though they look like they end in <em>o</em>.</p>
        </div>

        <div class="pronunciation-rule">
            <a name="section7">
                <h4>Rule 5: Crrrazy for the letter "R"</h4>
            </a>
            <p>The letter <em>r</em> has some different pronunciations in Brazilian Portuguese:</p>
            <ul>
                <li><em>R</em> at the beginning of a word sounds like <em>h</em>.  "Rogando" is pronounced "Hogandoo".</li>
                <li><em>RR</em> (double <em>r</em>) also sounds like <em>h</em>.  "Terra" sounds like "Teh-hah".</li>
                <li><em>R</em> at the end of a word sounds like, yes, you guessed it, <em>h</em>.  "Rezar" is pronounced "Hayzah".</li>
            </ul><br />
        </div>

        <div class="pronunciation-rule">
            <a name="section8">
                <h4>More Rules?</h4>
            </a>
            <p>Are there more rules?  Of course!  But by the time you master these, you will probably be catching on to the others naturally.  If not, ask some of the people in your church who seem to know what they're doing.  They probably know more than I do!</p>
        </div>

    </div>
@endsection
