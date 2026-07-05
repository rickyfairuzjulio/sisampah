<x-card class="border border-outline-variant p-0 overflow-hidden relative" x-data="priceChart()">
    <div class="p-4 border-b border-outline-variant bg-surface-container-low flex justify-between items-center">
        <h3 class="font-bold text-on-surface">Grafik Pergerakan Harga</h3>
        <div class="flex gap-2">
            <button @click="updateRange('7d')" :class="range === '7d' ? 'bg-primary text-white' : 'bg-surface-container hover:bg-surface-container-high text-on-surface-variant'" class="px-2 py-1 text-xs font-semibold rounded transition-colors">7 Hari</button>
            <button @click="updateRange('30d')" :class="range === '30d' ? 'bg-primary text-white' : 'bg-surface-container hover:bg-surface-container-high text-on-surface-variant'" class="px-2 py-1 text-xs font-semibold rounded transition-colors">30 Hari</button>
        </div>
    </div>
    
    <div class="p-4 relative">
        <div class="w-full h-64 relative z-10">
            <canvas id="priceHistoryChart"></canvas>
        </div>
        
        <!-- Loading Overlay -->
        <div x-show="loading" class="absolute inset-0 bg-surface/50 backdrop-blur-sm z-20 flex items-center justify-center">
            <svg class="animate-spin h-8 w-8 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
        </div>
    </div>
</x-card>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    function priceChart() {
        return {
            range: '30d',
            loading: true,
            chart: null,
            categoryId: {{ $category->id }},
            
            init() {
                this.fetchDataAndRender();
            },
            
            updateRange(newRange) {
                this.range = newRange;
                this.fetchDataAndRender();
            },
            
            async fetchDataAndRender() {
                this.loading = true;
                try {
                    // Fetch real data from API
                    const response = await fetch(`/api/v1/price-history?category_id=${this.categoryId}&per_page=${this.range === '30d' ? 30 : 7}`);
                    const json = await response.json();
                    
                    if (json.status === 'success') {
                        // Reverse because API returns desc, we want asc for chart (left to right = past to present)
                        const data = json.data.data.reverse();
                        
                        const labels = data.map(item => {
                            const date = new Date(item.created_at);
                            return date.toLocaleDateString('id-ID', { day: 'numeric', month: 'short' });
                        });
                        
                        const prices = data.map(item => item.harga_baru);
                        
                        this.renderChart(labels, prices);
                    }
                } catch (error) {
                    console.error("Failed to load chart data:", error);
                } finally {
                    this.loading = false;
                }
            },
            
            renderChart(labels, data) {
                const ctx = document.getElementById('priceHistoryChart').getContext('2d');
                
                if (this.chart) {
                    this.chart.destroy();
                }

                // Create gradient
                const gradient = ctx.createLinearGradient(0, 0, 0, 300);
                gradient.addColorStop(0, 'rgba(16, 185, 129, 0.4)'); // primary color with opacity
                gradient.addColorStop(1, 'rgba(16, 185, 129, 0.0)');

                this.chart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Harga per Kg (Rp)',
                            data: data,
                            borderColor: '#10b981', // primary color
                            backgroundColor: gradient,
                            borderWidth: 3,
                            pointBackgroundColor: '#fff',
                            pointBorderColor: '#10b981',
                            pointBorderWidth: 2,
                            pointRadius: 4,
                            pointHoverRadius: 6,
                            fill: true,
                            tension: 0.4 // Smooth curves
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: {
                            intersect: false,
                            mode: 'index',
                        },
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                backgroundColor: 'rgba(17, 24, 39, 0.9)',
                                titleFont: { size: 13, family: "'Inter', sans-serif" },
                                bodyFont: { size: 14, family: "'Inter', sans-serif", weight: 'bold' },
                                padding: 12,
                                cornerRadius: 8,
                                displayColors: false,
                                callbacks: {
                                    label: function(context) {
                                        let label = context.dataset.label || '';
                                        if (label) {
                                            label += ': ';
                                        }
                                        if (context.parsed.y !== null) {
                                            label += new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(context.parsed.y);
                                        }
                                        return label;
                                    }
                                }
                            }
                        },
                        scales: {
                            x: {
                                grid: {
                                    display: false,
                                    drawBorder: false
                                },
                                ticks: {
                                    font: { family: "'Inter', sans-serif", size: 11 },
                                    color: '#6b7280'
                                }
                            },
                            y: {
                                border: { display: false },
                                grid: {
                                    color: '#f3f4f6',
                                    drawBorder: false
                                },
                                ticks: {
                                    font: { family: "'Inter', sans-serif", size: 11 },
                                    color: '#6b7280',
                                    callback: function(value) {
                                        return 'Rp ' + (value / 1000) + 'k';
                                    }
                                },
                                beginAtZero: false,
                            }
                        }
                    }
                });
            }
        }
    }
</script>
@endpush
