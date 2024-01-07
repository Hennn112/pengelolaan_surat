@extends('layouts.template')
@section('page','/ Data Surat / Lihat')
@section('content')
<style>
    .btn-back {
        width: fit-content;
        padding: 8px 15px;
        color: #666;
        /* background: #666; */
        border-radius: 5px;
        text-decoration: none;
    }

    .container-2{
        border: 1px solid rgba(128, 128, 128, 0.466);
        padding: 20px;
        margin: 20px auto 100px auto;
        width: 780px;
        background: #fff;
    }

    .cont-info{
        margin-top: 13px;
        margin-left: 17px;
        width: 290px;
    }

    .cont-contact{
        margin-top: 18px;

        margin-left: 11%;
        text-align: right;
    }

    hr,h2,p{
        padding: 0;
        margin: 0;
    }

    .cont-info-hr{
        height: 2px;
        border: none;
        background-color: black;
        margin: 10px 0;
        font-weight: bold;
    }

    .hr-1{
        height: 1px;
        border: none;
        background-color: black;
        margin: 10px 0;
        font-weight: bold;
    }

    .tanggal{
        display: flex;
        justify-content: end;
        margin-top: 19px;
        margin-right: 20px;
    }

    .head-let{
        margin: 21px 25px;
        justify-content: space-between;
    }

    .peserta{
        margin-top:32px;
    }

    .main-content{
        margin: 40px 25px;

    }

    .hrmt-kami{
        margin-top: 40px;
        display: flex;
        justify-content: end;
        text-align: center;
    }



</style>

@if ($data->Result !== null )
<div class="container-2">
    <div id="content">
        <div class="img">
            <img src="{{ asset('assets/wikrama-logo.png') }}" alt="" width="120">
        </div>
        <div class="cont-info">
            <h2>SMK WIKRAMA BOGOR<hr class="cont-info-hr"></h2>
            <p>Bisnis dan Manajemen<br>Teknologi Informasi dan Komunikasi<br>Pariwisata</p>
        </div>
        <div class="cont-contact">
            <p>
                Jl. Raya Wangun Kel. Sindangsari Bogor<br>
                Telp/Faks: (021)-8121848<br>
                e-mail: prohumasi@smkwikrama.sch.id<br>
                Website: www.smkwikrama.sch.id
            </p>
        </div>
    </div><hr class="hr-1">
    <div class="tanggal">
        <p>
            @php
            setlocale(LC_ALL, 'IND');
            @endphp
            {{ Carbon\Carbon::parse($data['created_at'])->formatLocalized('%d %B %Y') }}
        </p>
    </div>
    <div class="head-let">
        <div class="about-let">
            No: {{ $data['letter']['letter_code'] }}<br>
            Hal: <b>{{ $data['letter_perihal'] }}</b>
        </div>
        <div class="for-let">
            Kepada<br>Yth. Bapak/Ibu Terlampir<br>di Tempat
        </div>
    </div>

    <div class="main-content">
        {!! $data['content'] !!}
        <div class="peserta">
            Peserta:
            <ol>
                @foreach ($data['recipients'] as $item)
                <li>{{ $item['name'] }}</li>
                @endforeach
            </ol>

        </div>
        <div class="hrmt-kami">

            <p>
                Hormat Kami,<br>
                Kepala SMK Wikrama Bogor<br><br><br><br><br><br>
                <span>(............................................)</span>
            </p>

        </div>
    </div>

</div>
@if ($data['attachment'])
    <div class="main-content card p-3 mb-5">
        <div class="mb-3">
            <h3>
                <center>lampiran</center>
            </h3>
            <img class="img-fluid" src="{{ asset('storage/img/' . $data['attachment']) }}" alt="">
        </div>
    </div>
    @endif
    <div class="main-content card p-3 mb-5">
        <div class="mb-3">
            <p>Peserta Rapat yang Hadir:</p><br>

            <table class="table table-striped table-bordered">
                <tr>
                    <th>No. </th>
                    <th>Peserta</th>
                    <th>Kehadiran</th>
                </tr>
                @foreach ($data['recipients'] as $count => $person)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td> {{ $person['name'] }}</td>
                        <td>{{ isset($rslt[0]['presence_recipients'][$count]['name']) ? '✅' : '❌' }}</td>
                    </tr>
                @endforeach
            </table>

        </div>
        @if ($rslt->isNotEmpty())
            <div class="mb-3">
                <p class=" mb-2">Ringkasan: </p>
                {!! $rslt[0]['notes'] !!}
            </div>
        @endif
        <div class="mb-3">
            <p class=" mb-2">Notulis: <i>{{ $data['user']['name'] }}</i></p>

        </div>

    </div>
@else

<div class="container-2">
    <div id="content">
        <div class="img">
            <img src="{{ asset('assets/wikrama-logo.png') }}" alt="" width="120">
        </div>
        <div class="cont-info">
            <h2>SMK WIKRAMA BOGOR<hr class="cont-info-hr"></h2>
            <p>Bisnis dan Manajemen<br>Teknologi Informasi dan Komunikasi<br>Pariwisata</p>
        </div>
        <div class="cont-contact">
            <p>
                Jl. Raya Wangun Kel. Sindangsari Bogor<br>
                Telp/Faks: (021)-8121848<br>
                e-mail: prohumasi@smkwikrama.sch.id<br>
                Website: www.smkwikrama.sch.id
            </p>
        </div>
    </div><hr class="hr-1">
    <div class="tanggal">
        <p>
            @php
            setlocale(LC_ALL, 'IND');
            @endphp
            {{ Carbon\Carbon::parse($data['created_at'])->formatLocalized('%d %B %Y') }}
        </p>
    </div>
    <div class="head-let">
        <div class="about-let">
            No: {{ $data['letter']['letter_code'] }}<br>
            Hal: <b>{{ $data['letter_perihal'] }}</b>
        </div>
        <div class="for-let">
            Kepada<br>Yth. Bapak/Ibu Terlampir<br>di Tempat
        </div>
    </div>

    <div class="main-content">
        {!! $data['content'] !!}
        <div class="peserta">
            Peserta:
            <ol>
                @foreach ($data['recipients'] as $item)
                <li>{{ $item['name'] }}</li>
                @endforeach
            </ol>

        </div>
        <div class="hrmt-kami">

            <p>
                Hormat Kami,<br>
                Kepala SMK Wikrama Bogor<br><br><br><br><br><br>
                <span>(............................................)</span>
            </p>

        </div>
    </div>

</div>
@endif
@endsection
