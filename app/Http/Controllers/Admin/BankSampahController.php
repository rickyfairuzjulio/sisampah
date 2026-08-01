<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BankSampah;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BankSampahController extends Controller
{
    /**
     * Display a listing of Bank Sampah units with search, filter, sorting, pagination.
     */
    public function index(Request $request)
    {
        $query = BankSampah::withCount(['nasabah', 'petugas', 'transactions']);

        // Search Filter
        if ($request->filled('search')) {
            $query->search($request->input('search'));
        }

        // Status Filter
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // Wilayah Filters
        if ($request->filled('provinsi')) {
            $query->where('provinsi', 'like', '%' . $request->input('provinsi') . '%');
        }
        if ($request->filled('kabupaten')) {
            $query->where('kabupaten', 'like', '%' . $request->input('kabupaten') . '%');
        }
        if ($request->filled('kecamatan')) {
            $query->where('kecamatan', 'like', '%' . $request->input('kecamatan') . '%');
        }

        // Sorting
        $sortField = $request->input('sort', 'created_at');
        $sortOrder = $request->input('order', 'desc');
        $allowedSorts = ['nama', 'created_at', 'status', 'provinsi', 'nasabah_count', 'transactions_count'];
        
        if (in_array($sortField, $allowedSorts)) {
            $query->orderBy($sortField, $sortOrder === 'asc' ? 'asc' : 'desc');
        } else {
            $query->latest();
        }

        $bankSampahs = $query->paginate(10)->withQueryString();

        // Unique provinces, regencies, districts for filter dropdowns
        $provinsiList = BankSampah::whereNotNull('provinsi')->distinct()->pluck('provinsi');
        $kabupatenList = BankSampah::whereNotNull('kabupaten')->distinct()->pluck('kabupaten');
        $kecamatanList = BankSampah::whereNotNull('kecamatan')->distinct()->pluck('kecamatan');

        $stats = [
            'total' => BankSampah::count(),
            'aktif' => BankSampah::where('status', 'aktif')->count(),
            'libur' => BankSampah::where('status', 'libur')->count(),
            'nonaktif' => BankSampah::where('status', 'nonaktif')->count(),
        ];

        return view('admin.bank-sampah.index', compact(
            'bankSampahs', 'provinsiList', 'kabupatenList', 'kecamatanList', 'stats'
        ));
    }

    /**
     * Show form for creating a new Bank Sampah unit.
     */
    public function create()
    {
        return view('admin.bank-sampah.create');
    }

    /**
     * Store a newly created Bank Sampah unit.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'telepon' => 'nullable|string|max:50',
            'whatsapp' => 'nullable|string|max:50',
            'deskripsi' => 'nullable|string',
            'alamat' => 'required|string',
            'provinsi' => 'nullable|string|max:100',
            'kabupaten' => 'nullable|string|max:100',
            'kecamatan' => 'nullable|string|max:100',
            'desa' => 'nullable|string|max:100',
            'kode_pos' => 'nullable|string|max:20',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'jam_buka' => 'required|string',
            'jam_tutup' => 'required|string',
            'hari_operasional' => 'required|string',
            'status' => 'required|in:aktif,libur,nonaktif',
            'logo' => 'nullable|image|max:2048',
            'foto' => 'nullable|image|max:4096',
        ]);

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('bank-sampah/logos', 'public');
        }

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('bank-sampah/photos', 'public');
        }

        $validated['slug'] = Str::slug($validated['nama']) . '-' . Str::random(5);

        $bankSampah = BankSampah::create($validated);

        return redirect()->route('admin.master_bank_sampah.index')
            ->with('success', "Bank Sampah '{$bankSampah->nama}' berhasil ditambahkan.");
    }

    /**
     * Display detailed Bank Sampah info.
     */
    public function show($id)
    {
        $bankSampah = BankSampah::withCount(['nasabah', 'petugas', 'transactions', 'trashCategories'])
            ->with(['users', 'trashCategories'])
            ->findOrFail($id);

        return view('admin.bank-sampah.show', compact('bankSampah'));
    }

    /**
     * Show form for editing an existing Bank Sampah unit.
     */
    public function edit($id)
    {
        $bankSampah = BankSampah::findOrFail($id);
        return view('admin.bank-sampah.edit', compact('bankSampah'));
    }

    /**
     * Update Bank Sampah unit.
     */
    public function update(Request $request, $id)
    {
        $bankSampah = BankSampah::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'telepon' => 'nullable|string|max:50',
            'whatsapp' => 'nullable|string|max:50',
            'deskripsi' => 'nullable|string',
            'alamat' => 'required|string',
            'provinsi' => 'nullable|string|max:100',
            'kabupaten' => 'nullable|string|max:100',
            'kecamatan' => 'nullable|string|max:100',
            'desa' => 'nullable|string|max:100',
            'kode_pos' => 'nullable|string|max:20',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'jam_buka' => 'required|string',
            'jam_tutup' => 'required|string',
            'hari_operasional' => 'required|string',
            'status' => 'required|in:aktif,libur,nonaktif',
            'logo' => 'nullable|image|max:2048',
            'foto' => 'nullable|image|max:4096',
        ]);

        if ($request->hasFile('logo')) {
            if ($bankSampah->logo && !str_starts_with($bankSampah->logo, 'http')) {
                Storage::disk('public')->delete($bankSampah->logo);
            }
            $validated['logo'] = $request->file('logo')->store('bank-sampah/logos', 'public');
        }

        if ($request->hasFile('foto')) {
            if ($bankSampah->foto && !str_starts_with($bankSampah->foto, 'http')) {
                Storage::disk('public')->delete($bankSampah->foto);
            }
            $validated['foto'] = $request->file('foto')->store('bank-sampah/photos', 'public');
        }

        $bankSampah->update($validated);

        return redirect()->route('admin.master_bank_sampah.index')
            ->with('success', "Data Bank Sampah '{$bankSampah->nama}' berhasil diperbarui.");
    }

    /**
     * Toggle status (aktif/libur/nonaktif).
     */
    public function toggleStatus(Request $request, $id)
    {
        $bankSampah = BankSampah::findOrFail($id);
        $newStatus = $request->input('status');

        if (in_array($newStatus, ['aktif', 'libur', 'nonaktif'])) {
            $bankSampah->status = $newStatus;
            $bankSampah->save();

            return response()->json([
                'success' => true,
                'message' => "Status Bank Sampah diubah menjadi {$newStatus}.",
                'status' => $newStatus,
                'badge_bg' => $bankSampah->status_badge_bg,
                'marker_color' => $bankSampah->marker_color,
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Status tidak valid.'], 400);
    }

    /**
     * Delete Bank Sampah unit.
     */
    public function destroy($id)
    {
        $bankSampah = BankSampah::findOrFail($id);
        $nama = $bankSampah->nama;
        $bankSampah->delete();

        return redirect()->route('admin.master_bank_sampah.index')
            ->with('success', "Bank Sampah '{$nama}' berhasil dihapus.");
    }

    /**
     * Nationwide GIS Distribution Map View ("Peta Sebaran Bank Sampah").
     */
    public function sebaranMap()
    {
        $bankSampahs = BankSampah::withCount(['nasabah', 'petugas', 'transactions'])
            ->withSum('transactions as total_pendapatan', 'total_rp')
            ->get();

        // Calculate GIS Coverage Statistics
        $totalCoverageKm2 = 0;
        foreach ($bankSampahs as $bs) {
            $rKm = ($bs->radius_layanan ?: 2000) / 1000;
            $totalCoverageKm2 += 3.14159 * ($rKm * $rKm);
        }

        $gisStats = [
            'total_bank_sampah' => $bankSampahs->count(),
            'total_coverage_km2' => round($totalCoverageKm2, 1),
            'total_nasabah' => $bankSampahs->sum('nasabah_count'),
            'aktif_count' => $bankSampahs->where('status', 'aktif')->count(),
            'libur_count' => $bankSampahs->where('status', 'libur')->count(),
            'nonaktif_count' => $bankSampahs->where('status', 'nonaktif')->count(),
        ];

        return view('admin.bank-sampah.sebaran-map', compact('bankSampahs', 'gisStats'));
    }

    /**
     * API Endpoint: Get Nearest Bank Sampah units by GPS with radius check
     */
    public function nearestApi(Request $request)
    {
        $userLat = (float) $request->input('lat', -6.2088);
        $userLng = (float) $request->input('lng', 106.8456);

        $bankSampahs = BankSampah::active()
            ->withCount(['nasabah', 'petugas', 'transactions'])
            ->get()
            ->map(function ($bs) use ($userLat, $userLng) {
                $distance = $bs->calculateDistance($userLat, $userLng);
                $bs->distance_km = $distance;
                $bs->est_travel_time_min = ceil($distance * 3); // ~ 20km/h driving
                $bs->est_walk_time_min = ceil($distance * 12); // ~ 5km/h walking
                $bs->is_within_radius = $bs->isWithinServiceRadius($userLat, $userLng);
                $bs->is_open = $bs->isOpenNow();
                $bs->harga_pet_kg = 4700; // Sample PET price
                return $bs;
            })
            ->sortBy('distance_km')
            ->values();

        return response()->json([
            'success' => true,
            'count' => $bankSampahs->count(),
            'user_location' => ['lat' => $userLat, 'lng' => $userLng],
            'data' => $bankSampahs,
        ]);
    }
}
