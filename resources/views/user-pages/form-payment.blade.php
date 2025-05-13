@extends('layouts.dashboard')

@section('content')
<h2>Daftar Pembayaran yang Menunggu Konfirmasi</h2>

<table class="table table-striped">
    <thead>
        <tr>
            <th>User</th>
            <th>Bukti Pembayaran</th>
            <th>Status Pembayaran</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($payments as $payment)
            <tr>
                <td>{{ $payment->pesanTiket->user->name }}</td>
                <td>
                    <img src="{{ asset('storage/payment_proofs/'.$payment->payment_proof) }}" width="100" class="img-thumbnail">
                </td>
                <td>{{ ucfirst($payment->payment_status) }}</td>
                <td>
                    <form action="{{ route('admin.payment.update', $payment->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <button type="submit" name="status" value="approved" class="btn btn-success btn-sm">Approve</button>
                        <button type="submit" name="status" value="rejected" class="btn btn-danger btn-sm">Reject</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
