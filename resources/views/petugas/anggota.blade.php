@extends('petugas.layouts')

@section('title', 'Data Anggota')

@section('content')

<div class="card-dashboard">
    <h5 class="mb-3">Data Anggota</h5>

    <table class="table">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $u)
            <tr>
                <td>{{ $u->name }}</td>
                <td>{{ $u->email }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
