@extends('layouts.dashboard')

@section('title', 'pemesanan')

@section('content')
    {{-- Navbar --}}
  

    {{-- Hero --}}
    <!-- Potongan body bagian FORM -->
    <section class="py-12 bg-gray-50">
        <div class="max-w-4xl mx-auto px-4">
            @if (session('success'))
                <div class="mb-6 rounded-lg bg-green-100 border border-green-300 text-green-800 px-5 py-4">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="mb-6 rounded-lg bg-red-100 border border-red-300 text-red-800 px-5 py-4">
                    {{ session('error') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="mb-6 rounded-lg bg-red-100 border border-red-300 text-red-800 px-5 py-4">
                    <strong class="font-semibold">Oops!</strong> Ada kesalahan:
                    <ul class="list-disc list-inside mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('pemesanan.submit') }}" method="POST"
                class="bg-white shadow-lg rounded-xl p-8 space-y-8">
                @csrf

                <!-- Info Penerbangan -->
                <div class="text-gray-800 space-y-3">
                    <!-- Logo Maskapai -->
                    <div class="grid grid-cols-3 gap-6 items-center">
                        <div class="flex justify-center">
                            @if ($penerbangan->pesawat && $penerbangan->pesawat->maskapai && $penerbangan->pesawat->maskapai->logo)
                                <img src="{{ asset('images/' . $penerbangan->pesawat->maskapai->logo) }}"
                                    alt="Logo Maskapai"
                                    class="w-32 h-32 object-contain rounded-full border-2 border-gray-500">
                            @else
                                <p class="text-red-600">Logo Tidak Tersedia</p>
                            @endif
                        </div>

                        <!-- Kiri: 3 informasi pertama -->
                        <div class="space-y-3">
                            <p class="flex items-center gap-2">
                                <span class="material-icons text-purple-600">flight_takeoff</span>
                                <strong>{{ $penerbangan->bandaraAsal ? $penerbangan->bandaraAsal->nama_bandara : 'Tidak Ditemukan' }}</strong>
                            </p>
                            <!-- Bandara Tujuan -->
                            <p class="flex items-center gap-2">
                                <span class="material-icons text-indigo-600">flight_land</span>
                                <strong>{{ $penerbangan->bandaraTujuan ? $penerbangan->bandaraTujuan->nama_bandara : 'Tidak Ditemukan' }}</strong>
                            </p>

                            <!-- Maskapai -->
                            <p class="flex items-center gap-2">
                                <span class="material-icons text-yellow-600">airplanemode_active</span>
                                <strong>{{ $penerbangan->pesawat && $penerbangan->pesawat->maskapai ? $penerbangan->pesawat->maskapai->nama_maskapai : 'Tidak Ditemukan' }}</strong>
                            </p>
                        </div>

                        <!-- Kanan: 3 informasi terakhir -->
                        <div class="space-y-3">
                            <p class="flex items-center gap-2">
                                <span class="material-icons text-blue-600">price_check</span>
                                <strong>Rp {{ number_format($penerbangan->harga_dewasa) }}</strong>
                            </p>
                            <!-- Jumlah Penumpang -->
                            <p class="flex items-center gap-2">
                                <span class="material-icons text-orange-500">people</span>
                                <strong>{{ $jumlahPenumpang }}</strong>
                            </p>

                            <!-- Total Harga -->
                            <p class="flex items-center gap-2 text-lg font-semibold">
                                <span class="material-icons text-green-600">attach_money</span>
                                Rp {{ number_format($penerbangan->harga_dewasa * $jumlahPenumpang) }}
                            </p>
                        </div>
                    </div>
                </div>




                <!-- Data Pemesan -->
                <div class="space-y-4 border border-gray-200 rounded-lg p-6 bg-gray-50">
                    <h3 class="text-lg font-bold text-gray-700">Data Pemesan</h3>

                    <div class="flex items-center gap-6">
                        <label class="flex items-center gap-2">
                            <input type="radio" name="gender_pemesan" value="L" required class="accent-blue-600">
                            <span>Tuan</span>
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="radio" name="gender_pemesan" value="P" required class="accent-pink-500">
                            <span>Nyonya</span>
                        </label>
                    </div>
                    @error('gender_pemesan')
                        <p class="text-sm text-red-500">{{ $message }}</p>
                    @enderror

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <input type="text" name="nama_pemesan" placeholder="Nama Lengkap" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                        <input type="email" name="email_pemesan" placeholder="Email" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                        <input type="number" name="telp_pemesan" placeholder="No. Telepon" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>

                <!-- Data Penumpang -->
                @for ($i = 0; $i < $jumlahPenumpang; $i++)
                    <div class="space-y-4 border border-gray-200 rounded-lg p-6 bg-gray-50">
                        <h3 class="text-lg font-bold text-gray-700">Data Penumpang {{ $i + 1 }}</h3>

                        <div class="flex items-center gap-6">
                            <label class="flex items-center gap-2">
                                <input type="radio" name="penumpang[{{ $i }}][gender]" value="L"
                                    required class="accent-blue-600">
                                <span>Tuan</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="penumpang[{{ $i }}][gender]" value="P"
                                    required class="accent-pink-500">
                                <span>Nyonya</span>
                            </label>
                        </div>
                        @error("penumpang.$i.gender")
                            <p class="text-sm text-red-500">{{ $message }}</p>
                        @enderror

                        <input type="text" name="penumpang[{{ $i }}][nama]"
                            placeholder="Nama Lengkap Penumpang {{ $i + 1 }}" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                        @error("penumpang.$i.nama")
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                @endfor

                <!-- Hidden Inputs -->
                <input type="hidden" name="penerbangan_id" value="{{ $penerbangan->id }}">
                <input type="hidden" name="jumlah_penumpang" value="{{ $jumlahPenumpang }}">

                <!-- Submit Button -->
                <div class="text-end">
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg transition duration-200">
                        Pesan Tiket
                    </button>
                </div>
            </form>
        </div>
    </section>



@endsection
