@extends('admin.layouts.main.app')

@section('content')
<div class="container">
    
    @if(session('success'))
        <div class="alert alert-success mt-2">{{ session('success') }}</div>
    @endif

    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0">Daftar Kota</h4>
            <form action="{{ route('admin.kota.index') }}" method="GET" class="d-flex">
                <input type="text" name="search" class="form-control me-2" placeholder="Cari Kota" value="{{ request()->get('search') }}">
                <button type="submit" class="btn btn-dark">
                    <i class="bi bi-search"></i> Cari
                </button>
            </form>
            <a href="{{ route('admin.kota.create') }}" class="btn btn-dark">
                <i class="bi bi-plus-circle me-1"></i> Tambah Kota
            </a>
        </div>
    
        <div class="card shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Nama Kota</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($kota as $item)
                                <tr>
                                    <td>{{ $item->nama_kota }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.kota.edit', $item->slug) }}" class="btn btn-sm btn-warning me-1">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </a>
                                        <form action="{{ route('admin.kota.destroy', $item->slug) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus kota ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger" type="submit">
                                                <i class="bi bi-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">Belum ada data kota.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <div class="card-footer d-flex justify-content-between">
        <div>
            Showing {{ $kota->firstItem() }} to {{ $kota->lastItem() }} of {{ $kota->total() }} entries
        </div>
        <div>
            {{ $kota->links() }}
        </div>
    </div>
    
</div>
@endsection
