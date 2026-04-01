@extends('kepala.layouts')

@section('title', 'Data Buku')

@section('content')

<h3>Data Buku</h3>

<div class="card-box mt-3">

    <table class="table">
        <thead>
            <tr>
                <th>Judul</th>
                <th>Penulis</th>
                <th>Stok</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Laskar Pelangi</td>
                <td>Andrea Hirata</td>
                <td>10</td>
            </tr>
        </tbody>
    </table>

</div>

@endsection
