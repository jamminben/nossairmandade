<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<div class="center">
    <img src="{{ url('/images/print/pdf_logo.jpg') }}" width="80%" max-height="80%">
    <br>
    <br>
    <br>
    <br>
    <br>
</div>
<div class="center">
    <p>printed from nossairmandade.com</p>
</div>
<div class="center">
    <p>
        {{ \App\Services\GlobalFunctions::getCurrentLanguage() == \App\Enums\Languages::ENGLISH ? date('F j, Y') : date('d-m-Y') }}</p>
</div>
</body>
</html>
