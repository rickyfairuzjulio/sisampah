# 🎨 SiSampah UI Component Guide

## Design System Overview

**Color Palette:**
- 🟢 Primary (Hijau): `#00694c` - Tema utama lingkungan
- 🔵 Secondary: `#57605e` - Warna pendukung  
- 🟠 Tertiary: `#795600` - Aksen warna
- ❌ Error: `#ba1a1a` - Peringatan/error
- ⚪ Surface: `#f9f9f7` - Background utama

**Typography:**
- Font: Inter
- Primary Headings: Bold, 2rem - 3rem
- Subheadings: Semibold, 1.125rem - 1.5rem
- Body Text: Regular, 0.875rem - 1rem

---

## Available Components

### 1. **Button**
```blade
<!-- Primary Button -->
<x-button variant="primary" size="md">
    Simpan Data
</x-button>

<!-- Variants: primary, secondary, danger, ghost, outline -->
<!-- Sizes: sm, md, lg -->
<!-- Props: disabled, loading, icon, iconPosition -->
```

### 2. **Card**
```blade
<x-card padding="md" shadow hover>
    <h3>Card Title</h3>
    <p>Card content here</p>
</x-card>

<!-- Props: padding (sm, md, lg), shadow, border, hover -->
```

### 3. **Alert / Toast**
```blade
<x-alert type="success" title="Sukses!" dismissible>
    Data berhasil disimpan
</x-alert>

<!-- Types: success, warning, error, info -->
```

### 4. **Progress Bar**
```blade
<x-progress :value="65" color="primary" :showLabel="true" />

<!-- Colors: primary, success, warning, error -->
```

### 5. **Stat Tile**
```blade
<x-stat-tile 
    title="Rp 2.5M" 
    subtitle="Saldo Anda"
    trend="up"
    trendValue="+25% bulan ini"
>
    <x-slot:icon>
        <!-- SVG Icon -->
    </x-slot:icon>
</x-stat-tile>
```

### 6. **Badge**
```blade
<x-badge status="completed" label="Selesai" />

<!-- Statuses: pending, completed, rejected, active, draft -->
```

### 7. **Input Field**
```blade
<x-input-field 
    name="email" 
    label="Email Address"
    type="email"
    placeholder="your@email.com"
    required
    helpText="Gunakan email yang aktif"
/>
```

### 8. **Select Field**
```blade
<x-select-field 
    name="category"
    label="Kategori Sampah"
    :items="[
        ['value' => 'plastic', 'label' => '♻️ Plastik'],
        ['value' => 'paper', 'label' => '📄 Kertas'],
    ]"
    selected="plastic"
    required
/>
```

### 9. **Sheet / Modal**
```blade
<x-sheet title="Edit Profil" description="Update informasi pribadi Anda">
    <!-- Content here -->
    
    <x-slot:action>
        <x-button variant="ghost">Batal</x-button>
        <x-button>Simpan</x-button>
    </x-slot:action>
</x-sheet>
```

---

## Usage Examples

### Dashboard Card Layout
```blade
<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <x-stat-tile title="100" subtitle="Nasabah" />
    <x-stat-tile title="50 Ton" subtitle="Sampah" />
    <x-stat-tile title="Rp 100M" subtitle="Nilai" />
</div>
```

### Form with Validation
```blade
<x-card>
    <h3 class="font-bold mb-4">Form Pendaftaran</h3>
    
    <x-input-field 
        name="name" 
        label="Nama Lengkap"
        required
        @error('name')
            :error="$message"
        @enderror
    />
    
    <x-select-field 
        name="rt"
        label="Pilih RT"
        :items="$rtOptions"
        required
    />
    
    <div class="flex gap-2 mt-4">
        <x-button variant="ghost">Batal</x-button>
        <x-button>Daftar</x-button>
    </div>
</x-card>
```

### Status Display
```blade
<div class="space-y-2">
    <x-badge status="completed" label="Selesai" />
    <x-badge status="pending" label="Pending" />
    <x-badge status="rejected" label="Ditolak" />
</div>
```

---

## Tailwind CSS Utilities

**Responsive Grid:**
```blade
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
    <!-- Items -->
</div>
```

**Spacing:**
- xs: 4px
- sm: 8px
- md: 16px
- lg: 24px
- xl: 32px

**Border Radius:**
- DEFAULT: 0.5rem
- md: 0.75rem
- lg: 1rem
- xl: 1.5rem

---

## Color Usage Guide

| Usage | Color | Tailwind Class |
|-------|-------|----------------|
| Primary Actions | Hijau | `text-primary`, `bg-primary` |
| Success States | Hijau Cerah | `text-green-600`, `bg-green-50` |
| Warning/Pending | Kuning | `text-yellow-600`, `bg-yellow-50` |
| Errors | Merah | `text-red-600`, `bg-red-50` |
| Secondary Text | Abu-abu | `text-on-surface-variant` |
| Borders | Abu-abu Terang | `border-outline-variant` |

---

## Browser Support

✅ Chrome (Latest)
✅ Firefox (Latest)
✅ Safari (Latest)
✅ Edge (Latest)
✅ Mobile browsers

---

Last Updated: December 2024
