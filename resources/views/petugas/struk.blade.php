<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Struk Pengembalian</title>
    <style>
        body {
            font-family: monospace;
            font-size: 11px;
        }
        

        .container {
            max-width: 100%;
            border: none;
            padding: 5px;
        }
        

        .title {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .subtitle {
            text-align: center;
            font-size: 11px;
            color: #666;
            margin-bottom: 15px;
        }

        .line {
            border-top: 1px dashed #aaa;
            margin: 10px 0;
        }

        .row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }

        .label {
            color: #666;
        }

        .value {
            font-weight: 500;
        }

        .total {
            font-size: 14px;
            font-weight: bold;
            color: #e11d48;
        }

        .footer {
            text-align: center;
            margin-top: 15px;
            font-size: 11px;
            color: #888;
        }
        .title {
            text-align: center;
            font-weight: bold;
            font-size: 13px;
        }

        .row {
            display: flex;
            justify-content: space-between;
            font-size: 11px;
        }

        .line {
            border-top: 1px dashed black;
            margin: 6px 0;
        }

    </style>
</head>
<body>

<div class="container">

    <div class="title">📚 PERPUSTAKAAN</div>
    <div class="subtitle">Struk Pengembalian Buku</div>

    <div class="line"></div>

    <div class="row">
        <div class="label">Nama</div>
        <div class="value">{{ $data->user->name }}</div>
    </div>

    <div class="row">
        <div class="label">Email</div>
        <div class="value">{{ $data->user->email }}</div>
    </div>

    <div class="line"></div>

    <div class="row">
        <div class="label">Buku</div>
        <div class="value">{{ $data->buku->judul }}</div>
    </div>

    <div class="row">
        <div class="label">Pinjam</div>
        <div class="value">{{ \Carbon\Carbon::parse($data->tanggal_pinjam)->format('d M Y') }}</div>
    </div>

    <div class="row">
        <div class="label">Batas</div>
        <div class="value">{{ \Carbon\Carbon::parse($data->batas_kembali)->format('d M Y') }}</div>
    </div>

    <div class="row">
        <div class="label">Kembali</div>
        <div class="value">{{ \Carbon\Carbon::parse($data->tanggal_kembalikan)->format('d M Y') }}</div>
    </div>

    <div class="line"></div>

    <div class="row total">
        <div>Total Denda</div>
        <div>Rp {{ number_format($data->denda,0,',','.') }}</div>
    </div>

    <div class="line"></div>

    <div class="footer">
        Terima kasih 🙏<br>
        Simpan struk ini sebagai bukti
    </div>

</div>

</body>
</html>