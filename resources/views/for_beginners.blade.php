@extends('layouts.app')

@section('header_title')
    Portuguese for Beginners
@endsection

@section('page_title')
    <h2 class="small display_table_cell_md">Portuguese for Beginners</h2>
@endsection

@section('content')
    <div class="col-sm-10">
        <h5>
            Our brother Ollie in the UK has put together these beautiful documents to help beginners with Portuguese
            pronunciation, vocabulary, and the basic prayers.  They're a big help for anyone new to the Daime or who
            is looking for a new perspective on the Portuguese language.  If you find these helpful, head on over to Ollie's
            website and send him some love: <a href="http://www.ollieframe.uk ">http://www.ollieframe.uk</a>.
        </h5>

        <ul class="list1 no-bullets">
            <li>
                <a href="{{ url('/media/ollie_guide/PORTUGUESE FOR DAIMISTAS e-BOOK.pdf') }}" target="_blank">
                    <i class="fas fa-download"></i> PORTUGUESE FOR DAIMISTAS e-BOOK.pdf
                </a><br>
                <p>This version is suitable for reading in an eBook reader.</p>
            </li>
            <li>
                <a href="{{ url('/media/ollie_guide/PORTUGUESE FOR DAIMISTAS PRINT FORMAT.pdf') }}" target="_blank">
                    <i class="fas fa-download"></i> PORTUGUESE FOR DAIMISTAS PRINT FORMAT.pdf
                </a><br>
                <p>This version is suitable for printing and binding.</p>
            </li>
            <li>
                <a href="{{ url('/media/ollie_guide/Print Instructions for Daimista book.odt') }}" target="_blank">
                    <i class="fas fa-download"></i> Print Instructions for Daimista book.odt
                </a><br>
                <p>Instructions for how to print the document so it is usable.</p>
            </li>
        </ul>
    </div>
@endsection
