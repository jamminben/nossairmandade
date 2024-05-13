@extends('_mail.email_template')

@section('main-content')

    Mail from: <?php echo $name; ?><br>
    Email: <?php echo $email; ?><br>
    Subject: <?php echo $mailsubject; ?><br>
    Message: <br>
    <?php echo $mailmessage; ?>
    <br>

@endsection
