@extends('layouts.template')
@section('page','/ Data Surat / Tambah')
@section('content')
<div class="container">
    <form action="{{ route('guru.data.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if ($errors->any())
        <ul class="alert alert-danger">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
        @endif

        <p class="">Kehadiran:</p>
        <input type="hidden" value="{{ $results->id }}" name="letter_id">
        <table class="table table-striped table-bordered">
            <tr>
                <th>Nama</th>
                <th>Peserta (Ceklis jika ya)</th>
            </tr>
            @foreach ($results['recipients'] as $item)
            <tr>
                <td>{{ $item['name'] }}</td>
                <td>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" value="{{ $item['id'] }}" id="flexCheckChecked" name="presence_recipients[]">
                    </div>
                </td>
            </tr>
            @endforeach
        </table>


        <div class="form-group">
            <label for="exampleFormControlTextarea1">Isi Surat</label>
            <textarea id="myeditorinstance" name="notes"></textarea>
        </div>

        <button type="submit" class="btn btn-primary float-right">Submit</button>
    </form>
</div>

@endsection
