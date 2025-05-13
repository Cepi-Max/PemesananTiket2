<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Tiket Pesawat</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #ffffff; padding: 20px;">

    <div style="max-width: 600px; margin: 0 auto; margin-top: 24px; border: 1px solid #c3dafe; border-radius: 12px; padding: 24px; font-family: sans-serif;">
    {{-- Header: Logo dan Info Maskapai --}}
    <div style="display: table; width: 100%; margin-bottom: 16px;">
        <div style="display: table-row">
            <div style="display: table-cell; vertical-align: middle;">
                @php
                    $logoPath = public_path('images/' . $pesanan->penerbangan->pesawat->maskapai->logo);
                @endphp
                <img src="file://{{ $logoPath }}" alt="Logo Maskapai" style="width: 64px; height: auto; margin-right: 12px; float: left;">
                <div style="margin-left: 80px;">
                    <h2 style="font-size: 20px; font-weight: bold; color: #1d4ed8; margin: 0;">
                        {{ $pesanan->penerbangan->pesawat->maskapai->nama }}
                    </h2>
                    <p style="font-size: 12px; color: #4b5563; margin: 0;">
                        {{ $pesanan->penerbangan->kode_penerbangan }}
                    </p>
                </div>
            </div>
            <div style="display: table-cell; vertical-align: middle; text-align: right;">
                <p style="font-size: 12px; color: #6b7280; margin: 0;">Kode Booking:</p>
                <p style="font-size: 16px; font-weight: bold; color: #1e40af; margin: 0;">
                    {{ $pesanan->kode_booking }}
                </p>
            </div>
        </div>
    </div>

    <hr style="margin: 20px 0; border: 1px solid #c3dafe;" />

    {{-- Tabel Data Penumpang dan Penerbangan --}}
    <table style="width: 100%; font-size: 14px; color: #1e40af; margin-bottom: 20px;" cellspacing="0" cellpadding="5">
        <tr>
            <td width="50%">
                <p style="font-size: 12px; color: #6b7280; margin: 0;">Nama Penumpang</p>
                <p style="font-size: 16px; font-weight: bold; margin: 0;">
                    @foreach ($pesanan->detailPenumpangs as $penumpang)
                        {{ $penumpang->nama_penumpang }}<br>
                    @endforeach
                </p>
            </td>
            <td width="50%">
                <p style="font-size: 12px; color: #6b7280; margin: 0;">Tanggal Penerbangan</p>
                <p style="font-size: 16px; font-weight: bold; margin: 0;">
                    {{ \Carbon\Carbon::parse($pesanan->penerbangan->tanggal_penerbangan)->format('d M Y') }}
                </p>
            </td>
        </tr>
        <tr>
            <td>
                <p style="font-size: 12px; color: #6b7280; margin: 0;">Kota Asal</p>
                <p style="font-size: 16px; font-weight: bold; margin: 0;">
                    {{ $pesanan->penerbangan->bandaraAsal->kota->nama_kota }}
                </p>
            </td>
            <td>
                <p style="font-size: 12px; color: #6b7280; margin: 0;">Kota Tujuan</p>
                <p style="font-size: 16px; font-weight: bold; margin: 0;">
                    {{ $pesanan->penerbangan->bandaraTujuan->kota->nama_kota }}
                </p>
            </td>
        </tr>
        <tr>
            <td>
                <p style="font-size: 12px; color: #6b7280; margin: 0;">Bandara Keberangkatan</p>
                <p style="font-size: 16px; font-weight: bold; margin: 0;">
                    {{ $pesanan->penerbangan->bandaraAsal->nama_bandara }}
                </p>
            </td>
            <td>
                <p style="font-size: 12px; color: #6b7280; margin: 0;">Bandara Kedatangan</p>
                <p style="font-size: 16px; font-weight: bold; margin: 0;">
                    {{ $pesanan->penerbangan->bandaraTujuan->nama_bandara }}
                </p>
            </td>
        </tr>
    </table>

    <hr style="margin: 20px 0; border: 1px solid #c3dafe;" />

    {{-- Footer Note --}}
    <table style="width: 100%;">
        <tr>
            <td style="font-size: 12px; color: #6b7280;">
                Harap tiba di bandara 90 menit sebelum keberangkatan.
            </td>
            <td style="text-align: right; font-size: 14px; font-weight: bold; color: #1d4ed8;">
                Tiket Telah Dibayar
            </td>
        </tr>
    </table>
</div>

</body>
</html>
