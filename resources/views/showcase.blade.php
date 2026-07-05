<!-- Component Showcase / Demo Page -->
<x-app-layout title="UI Components Showcase">
    <div class="space-y-8">
        <!-- Header -->
        <div class="mb-12">
            <h1 class="text-5xl font-bold text-on-surface mb-2">🎨 SiSampah UI Components</h1>
            <p class="text-xl text-on-surface-variant">Clean, modern, dan production-ready component library</p>
        </div>

        <!-- Buttons Section -->
        <x-card>
            <h2 class="text-3xl font-bold text-on-surface mb-6">🔘 Buttons</h2>
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <div class="space-y-2">
                    <p class="text-sm font-medium text-on-surface-variant mb-2">Primary</p>
                    <x-button variant="primary" size="md">Primary</x-button>
                </div>
                <div class="space-y-2">
                    <p class="text-sm font-medium text-on-surface-variant mb-2">Secondary</p>
                    <x-button variant="secondary" size="md">Secondary</x-button>
                </div>
                <div class="space-y-2">
                    <p class="text-sm font-medium text-on-surface-variant mb-2">Danger</p>
                    <x-button variant="danger" size="md">Danger</x-button>
                </div>
                <div class="space-y-2">
                    <p class="text-sm font-medium text-on-surface-variant mb-2">Ghost</p>
                    <x-button variant="ghost" size="md">Ghost</x-button>
                </div>
                <div class="space-y-2">
                    <p class="text-sm font-medium text-on-surface-variant mb-2">Outline</p>
                    <x-button variant="outline" size="md">Outline</x-button>
                </div>
            </div>

            <div class="mt-8 border-t border-outline-variant pt-8">
                <p class="text-sm font-medium text-on-surface-variant mb-4">Button Sizes</p>
                <div class="flex gap-3 flex-wrap">
                    <x-button size="sm">Small</x-button>
                    <x-button size="md">Medium</x-button>
                    <x-button size="lg">Large</x-button>
                </div>
            </div>

            <div class="mt-8 border-t border-outline-variant pt-8">
                <p class="text-sm font-medium text-on-surface-variant mb-4">Button States</p>
                <div class="flex gap-3 flex-wrap">
                    <x-button :disabled="true">Disabled</x-button>
                    <x-button :loading="true">Loading</x-button>
                </div>
            </div>
        </x-card>

        <!-- Alerts Section -->
        <x-card>
            <h2 class="text-3xl font-bold text-on-surface mb-6">⚠️ Alerts</h2>
            <div class="space-y-4">
                <x-alert type="success" title="Success!" dismissible>
                    Data berhasil disimpan ke dalam sistem
                </x-alert>
                <x-alert type="info" title="Info" dismissible>
                    Silakan lengkapi semua data sebelum melanjutkan
                </x-alert>
                <x-alert type="warning" title="Warning" dismissible>
                    Perhatian! Ada beberapa field yang belum terisi dengan benar
                </x-alert>
                <x-alert type="error" title="Error" dismissible>
                    Terjadi kesalahan saat memproses permintaan Anda
                </x-alert>
            </div>
        </x-card>

        <!-- Cards Section -->
        <x-card>
            <h2 class="text-3xl font-bold text-on-surface mb-6">📦 Cards</h2>
            <div class="grid md:grid-cols-3 gap-4">
                <x-card shadow hover border>
                    <h3 class="font-bold text-on-surface mb-2">Card with Shadow</h3>
                    <p class="text-on-surface-variant text-sm">Card dengan shadow ambient</p>
                </x-card>
                <x-card shadow hover border>
                    <h3 class="font-bold text-on-surface mb-2">Card with Border</h3>
                    <p class="text-on-surface-variant text-sm">Card dengan outline border</p>
                </x-card>
                <x-card shadow hover>
                    <h3 class="font-bold text-on-surface mb-2">Interactive Card</h3>
                    <p class="text-on-surface-variant text-sm">Hover untuk melihat effect</p>
                </x-card>
            </div>
        </x-card>

        <!-- Badges Section -->
        <x-card>
            <h2 class="text-3xl font-bold text-on-surface mb-6">🏷️ Badges</h2>
            <div class="flex flex-wrap gap-3">
                <x-badge status="completed" label="Selesai" />
                <x-badge status="pending" label="Pending" />
                <x-badge status="rejected" label="Ditolak" />
                <x-badge status="active" label="Aktif" />
                <x-badge status="draft" label="Draft" />
            </div>
        </x-card>

        <!-- Progress Bars Section -->
        <x-card>
            <h2 class="text-3xl font-bold text-on-surface mb-6">📊 Progress Bars</h2>
            <div class="space-y-6">
                <div>
                    <p class="text-sm font-medium text-on-surface mb-2">Primary Progress</p>
                    <x-progress :value="65" color="primary" :show-label="true" />
                </div>
                <div>
                    <p class="text-sm font-medium text-on-surface mb-2">Success Progress</p>
                    <x-progress :value="100" color="success" :show-label="true" />
                </div>
                <div>
                    <p class="text-sm font-medium text-on-surface mb-2">Warning Progress</p>
                    <x-progress :value="45" color="warning" :show-label="true" />
                </div>
                <div>
                    <p class="text-sm font-medium text-on-surface mb-2">Error Progress</p>
                    <x-progress :value="20" color="error" :show-label="true" />
                </div>
            </div>
        </x-card>

        <!-- Stat Tiles Section -->
        <x-card>
            <h2 class="text-3xl font-bold text-on-surface mb-6">📈 Stat Tiles</h2>
            <div class="grid md:grid-cols-3 gap-4">
                <x-stat-tile 
                    title="2,450 kg" 
                    subtitle="Sampah Hari Ini"
                    trend="up"
                    trendValue="+12%"
                    badge="Sampah"
                >
                    <x-slot:icon>
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M4.5 3a2.5 2.5 0 00-2.5 2.5v7A2.5 2.5 0 004.5 15h11a2.5 2.5 0 002.5-2.5v-7A2.5 2.5 0 0015.5 3h-11zM5 5h10v8H5V5z" />
                        </svg>
                    </x-slot:icon>
                </x-stat-tile>

                <x-stat-tile 
                    title="127" 
                    subtitle="Nasabah Aktif"
                    trend="up"
                    trendValue="+8"
                    badge="Users"
                >
                    <x-slot:icon>
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM9 13a6 6 0 11-12 0 6 6 0 0112 0z" />
                        </svg>
                    </x-slot:icon>
                </x-stat-tile>

                <x-stat-tile 
                    title="Rp 45.6 M" 
                    subtitle="Nilai Total"
                    trend="up"
                    trendValue="+Rp 2.25 M"
                    badge="Revenue"
                >
                    <x-slot:icon>
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M8.5 10.5A1.5 1.5 0 1010 9a1.5 1.5 0 00-1.5 1.5z" />
                            <path fill-rule="evenodd" d="M0 10a10 10 0 1020 0 10 10 0 01-20 0zm10-8a8 8 0 100 16 8 8 0 000-16z" clip-rule="evenodd" />
                        </svg>
                    </x-slot:icon>
                </x-stat-tile>
            </div>
        </x-card>

        <!-- Form Elements -->
        <x-card>
            <h2 class="text-3xl font-bold text-on-surface mb-6">📝 Form Elements</h2>
            <div class="space-y-4">
                <x-input-field 
                    name="name" 
                    label="Nama Lengkap"
                    placeholder="Masukkan nama Anda"
                    required
                    helpText="Nama harus sesuai dengan identitas resmi"
                />

                <x-select-field 
                    name="category"
                    label="Kategori Sampah"
                    :items="[
                        ['value' => 'plastic', 'label' => '♻️ Plastik'],
                        ['value' => 'paper', 'label' => '📄 Kertas'],
                        ['value' => 'metal', 'label' => '⚙️ Metal'],
                        ['value' => 'glass', 'label' => '🥛 Kaca'],
                    ]"
                    selected="plastic"
                    required
                />

                <div class="flex gap-2 pt-4">
                    <x-button variant="outline">Batal</x-button>
                    <x-button>Simpan</x-button>
                </div>
            </div>
        </x-card>

        <!-- Color Palette -->
        <x-card>
            <h2 class="text-3xl font-bold text-on-surface mb-6">🎨 Color Palette</h2>
            <div class="grid md:grid-cols-5 gap-4">
                <div class="space-y-2">
                    <div class="w-full h-24 bg-primary rounded-lg shadow"></div>
                    <p class="text-xs font-medium text-on-surface">Primary</p>
                    <p class="text-xs text-on-surface-variant">#00694c</p>
                </div>
                <div class="space-y-2">
                    <div class="w-full h-24 bg-forest-emerald rounded-lg shadow"></div>
                    <p class="text-xs font-medium text-on-surface">Forest Emerald</p>
                    <p class="text-xs text-on-surface-variant">#1D9E75</p>
                </div>
                <div class="space-y-2">
                    <div class="w-full h-24 bg-secondary-container rounded-lg shadow"></div>
                    <p class="text-xs font-medium text-on-surface">Secondary</p>
                    <p class="text-xs text-on-surface-variant">#d9e2df</p>
                </div>
                <div class="space-y-2">
                    <div class="w-full h-24 bg-green-500 rounded-lg shadow"></div>
                    <p class="text-xs font-medium text-on-surface">Success</p>
                    <p class="text-xs text-on-surface-variant">#22c55e</p>
                </div>
                <div class="space-y-2">
                    <div class="w-full h-24 bg-error rounded-lg shadow"></div>
                    <p class="text-xs font-medium text-on-surface">Error</p>
                    <p class="text-xs text-on-surface-variant">#ba1a1a</p>
                </div>
            </div>
        </x-card>

        <!-- Typography -->
        <x-card>
            <h2 class="text-3xl font-bold text-on-surface mb-6">✍️ Typography</h2>
            <div class="space-y-6">
                <div>
                    <p class="text-xs text-on-surface-variant font-semibold mb-2">HEADING 1</p>
                    <h1 class="text-5xl font-bold text-on-surface">Display Large - 48px</h1>
                </div>
                <div>
                    <p class="text-xs text-on-surface-variant font-semibold mb-2">HEADING 2</p>
                    <h2 class="text-4xl font-bold text-on-surface">Display Medium - 36px</h2>
                </div>
                <div>
                    <p class="text-xs text-on-surface-variant font-semibold mb-2">HEADING 3</p>
                    <h3 class="text-3xl font-bold text-on-surface">Display Small - 28px</h3>
                </div>
                <div>
                    <p class="text-xs text-on-surface-variant font-semibold mb-2">BODY</p>
                    <p class="text-base text-on-surface">Body text - 16px. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc ut semper purus.</p>
                </div>
                <div>
                    <p class="text-xs text-on-surface-variant font-semibold mb-2">CAPTION</p>
                    <p class="text-xs text-on-surface-variant">Caption text - 12px. Gunakan untuk keterangan tambahan atau metadata.</p>
                </div>
            </div>
        </x-card>

        <!-- Spacing & Layout -->
        <x-card>
            <h2 class="text-3xl font-bold text-on-surface mb-6">📐 Spacing & Layout</h2>
            <div class="space-y-4">
                <div>
                    <p class="text-sm font-medium text-on-surface-variant mb-3">Spacing Units</p>
                    <div class="flex gap-2">
                        @php $sizes = ['xs' => '4px', 'sm' => '8px', 'md' => '16px', 'lg' => '24px', 'xl' => '32px'] @endphp
                        @foreach($sizes as $name => $value)
                            <div class="text-center">
                                <div class="bg-primary/20 border-2 border-primary rounded text-center py-2 px-3 text-xs font-semibold text-on-surface">
                                    {{ $value }}
                                </div>
                                <p class="text-xs text-on-surface-variant mt-1">{{ strtoupper($name) }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="border-t border-outline-variant pt-4">
                    <p class="text-sm font-medium text-on-surface-variant mb-3">Responsive Grid</p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        @for($i = 1; $i <= 8; $i++)
                            <div class="bg-primary/10 border border-primary rounded-lg p-4 text-center">
                                <p class="text-xs font-semibold text-on-surface">Grid {{ $i }}</p>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
        </x-card>

        <!-- Shadow Elevation -->
        <x-card>
            <h2 class="text-3xl font-bold text-on-surface mb-6">🌑 Shadows & Elevation</h2>
            <div class="grid md:grid-cols-4 gap-4">
                <div class="h-24 bg-white rounded-lg shadow-sm flex items-end justify-center">
                    <p class="text-xs text-on-surface-variant pb-2">shadow-sm</p>
                </div>
                <div class="h-24 bg-white rounded-lg shadow flex items-end justify-center">
                    <p class="text-xs text-on-surface-variant pb-2">shadow</p>
                </div>
                <div class="h-24 bg-white rounded-lg shadow-lg flex items-end justify-center">
                    <p class="text-xs text-on-surface-variant pb-2">shadow-lg</p>
                </div>
                <div class="h-24 bg-white rounded-lg shadow-xl flex items-end justify-center">
                    <p class="text-xs text-on-surface-variant pb-2">shadow-xl</p>
                </div>
            </div>
        </x-card>

    </div>
</x-app-layout>
