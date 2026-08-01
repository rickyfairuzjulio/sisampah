@extends('layouts.dashboard')

@section('header', 'Master Bank Sampah')

@section('content')
<div class="space-y-6">
    <!-- Header & Action Bar -->
    <div class="card card-body bg-gradient-to-r from-primary/10 via-surface to-background border border-primary/20 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-primary/10 border border-primary/30 rounded-2xl flex items-center justify-center text-primary text-xl shadow-soft">
                <i class="bi bi-buildings-fill"></i>
            </div>
            <div>
                <h1 class="text-xl font-bold text-text-primary tracking-tight">Master Bank Sampah</h1>
                <p class="text-xs font-semibold text-text-secondary mt-0.5">Kelola lokasi, unit operasional, dan peta sebaran Bank Sampah se-Indonesia</p>
            </div>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <a href="{{ route('admin.peta_sebaran') }}" class="btn btn-secondary !py-2.5 !px-4 text-xs">
                <i class="bi bi-geo-alt-fill text-primary"></i> Peta Sebaran
            </a>
            <a href="{{ route('admin.master_bank_sampah.create') }}" class="btn btn-primary !py-2.5 !px-4 text-xs">
                <i class="bi bi-plus-lg"></i> Tambah Bank Sampah
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <div class="stat-card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="stat-label">Total Unit</p>
                    <p class="stat-value text-primary mt-1">{{ number_format($stats['total']) }}</p>
                </div>
                <div class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center text-primary text-xl">
                    <i class="bi bi-buildings"></i>
                </div>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="stat-label">Aktif Operasional</p>
                    <p class="stat-value text-primary mt-1">{{ number_format($stats['aktif']) }}</p>
                </div>
                <div class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center text-primary text-xl">
                    <i class="bi bi-check-circle-fill"></i>
                </div>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="stat-label">Sedang Libur</p>
                    <p class="stat-value text-warning mt-1">{{ number_format($stats['libur']) }}</p>
                </div>
                <div class="w-10 h-10 rounded-xl bg-warning/10 flex items-center justify-center text-warning text-xl">
                    <i class="bi bi-pause-circle-fill"></i>
                </div>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="stat-label">Nonaktif</p>
                    <p class="stat-value text-danger mt-1">{{ number_format($stats['nonaktif']) }}</p>
                </div>
                <div class="w-10 h-10 rounded-xl bg-danger/10 flex items-center justify-center text-danger text-xl">
                    <i class="bi bi-x-circle-fill"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter & Search Section -->
    <div class="card card-body">
        <form action="{{ route('admin.master_bank_sampah.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-4">
            <div class="md:col-span-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, alamat, atau kecamatan..." class="form-input text-xs">
            </div>
            
            <div>
                <select name="status" class="form-select text-xs">
                    <option value="">Semua Status</option>
                    <option value="aktif" {{ request('status') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="libur" {{ request('status') === 'libur' ? 'selected' : '' }}>Libur</option>
                    <option value="nonaktif" {{ request('status') === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>

            <div>
                <select name="provinsi" class="form-select text-xs">
                    <option value="">Semua Provinsi</option>
                    @foreach($provinsiList as $prov)
                        <option value="{{ $prov }}" {{ request('provinsi') === $prov ? 'selected' : '' }}>{{ $prov }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-center gap-2">
                <button type="submit" class="btn btn-primary w-full !py-2.5 text-xs">
                    Filter Data
                </button>
                <a href="{{ route('admin.master_bank_sampah.index') }}" class="btn btn-secondary p-2.5 text-xs flex items-center justify-center" title="Reset Filter">
                    <i class="bi bi-arrow-counterclockwise text-base"></i>
                </a>
            </div>
        </form>
    </div>

    <!-- Table Data -->
    <div class="card">
        <div class="overflow-x-auto">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Unit Bank Sampah</th>
                        <th>Wilayah & Alamat</th>
                        <th>Kontak</th>
                        <th class="text-center">Nasabah</th>
                        <th class="text-center">Petugas</th>
                        <th class="text-center">Status</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bankSampahs as $bs)
                        <tr>
                            <td>
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl overflow-hidden bg-surface border border-border-color flex-shrink-0">
                                        <img src="{{ $bs->logo_url }}" class="w-full h-full object-cover" alt="{{ $bs->nama }}">
                                    </div>
                                    <div>
                                        <a href="{{ route('admin.master_bank_sampah.show', $bs->id) }}" class="font-bold text-text-primary hover:text-primary transition-colors text-xs block">
                                            {{ $bs->nama }}
                                        </a>
                                        <span class="text-[10px] text-text-muted font-mono">
                                            {{ $bs->jam_buka }} - {{ $bs->jam_tutup }} ({{ $bs->hari_operasional }})
                                        </span>
                                    </div>
                                </div>
                            </td>

                            <td class="max-w-xs">
                                <p class="font-bold text-text-primary truncate" title="{{ $bs->alamat }}">{{ $bs->alamat }}</p>
                                <p class="text-[10px] text-text-muted mt-0.5">
                                    {{ $bs->kecamatan ? 'Kec. ' . $bs->kecamatan . ', ' : '' }}{{ $bs->kabupaten ?? '' }} {{ $bs->provinsi ? '('.$bs->provinsi.')' : '' }}
                                </p>
                            </td>

                            <td>
                                <p class="font-bold text-text-secondary">{{ $bs->telepon ?: '-' }}</p>
                                <p class="text-[10px] text-text-muted">{{ $bs->email ?: '-' }}</p>
                            </td>

                            <td class="text-center">
                                <span class="chip chip-neutral">
                                    {{ $bs->nasabah_count }} Nsbh
                                </span>
                            </td>

                            <td class="text-center">
                                <span class="chip chip-neutral">
                                    {{ $bs->petugas_count }} Ptg
                                </span>
                            </td>

                            <td class="text-center">
                                @if($bs->status === 'aktif')
                                    <span class="chip chip-success">Aktif</span>
                                @elseif($bs->status === 'libur')
                                    <span class="chip chip-warning">Libur</span>
                                @else
                                    <span class="chip chip-error">Nonaktif</span>
                                @endif
                            </td>

                            <td class="text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.master_bank_sampah.edit', $bs->id) }}" class="w-8 h-8 rounded-lg bg-surface hover:bg-hover-bg text-text-secondary hover:text-text-primary border border-border-color flex items-center justify-center transition-colors" title="Edit Data & Lokasi">
                                        <i class="bi bi-pencil-square text-xs"></i>
                                    </a>

                                    <button onclick="toggleStatus({{ $bs->id }}, '{{ $bs->status === 'aktif' ? 'nonaktif' : 'aktif' }}')" class="w-8 h-8 rounded-lg bg-warning/10 hover:bg-warning/20 text-warning flex items-center justify-center transition-colors" title="Ubah Status">
                                        <i class="bi bi-arrow-repeat text-xs"></i>
                                    </button>

                                    <form action="{{ route('admin.master_bank_sampah.destroy', $bs->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus Bank Sampah ini?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-8 h-8 rounded-lg bg-danger/10 hover:bg-danger/20 text-danger flex items-center justify-center transition-colors" title="Hapus">
                                            <i class="bi bi-trash-fill text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-text-muted">
                                <div class="text-3xl mb-2">🏬</div>
                                <p class="font-bold text-sm text-text-secondary">Belum ada data Bank Sampah</p>
                                <p class="text-xs mt-1">Klik tombol "Tambah Bank Sampah" untuk mendaftarkan unit baru.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($bankSampahs->hasPages())
            <div class="p-4 border-t border-border-color">
                {{ $bankSampahs->links() }}
            </div>
        @endif
    </div>
</div>

<script>
    async function toggleStatus(id, newStatus) {
        try {
            const res = await fetch(`/admin/master-bank-sampah/${id}/toggle-status`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ status: newStatus })
            });
            const data = await res.json();
            if (data.success) {
                window.location.reload();
            } else {
                alert(data.message || 'Gagal mengubah status');
            }
        } catch(e) {
            alert('Terjadi kesalahan jaringan.');
        }
    }
</script>
@endsection
