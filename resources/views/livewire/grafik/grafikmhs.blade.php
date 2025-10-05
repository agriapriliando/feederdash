<div class="grid grid-cols-12 gap-4 md:gap-6">
    <div class="col-span-12">
        <!-- ====== Chart Three Start -->
        <div class="space-y-5 sm:space-y-6">
            <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                <div id="chartprodi"></div>
            </div>
        </div>
        <!-- ====== Chart Three End -->
    </div>
</div>
@push('chartjs')
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/drilldown.js"></script>
    <!-- optional -->
    <script src="https://code.highcharts.com/modules/offline-exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/themes/adaptive.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const chartData = @json($chartData);
            // Ambil tanggal hari ini
            let today = new Date();
            let options = {
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            };
            let formattedDate = today.toLocaleDateString('id-ID', options);

            Highcharts.chart('chartprodi', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Jumlah Mahasiswa Berdasarkan Prodi'
                },
                subtitle: {
                    text: 'Data ini mencakup seluruh Status Mahasiswa (Aktif, Lulus, dsb) (per ' + formattedDate + ')'
                },
                accessibility: {
                    announceNewData: {
                        enabled: true
                    }
                },
                xAxis: {
                    type: 'category',
                    title: {
                        text: 'Prodi'
                    }
                },
                yAxis: {
                    title: {
                        text: 'Jumlah Mahasiswa'
                    }

                },
                legend: {
                    enabled: false
                },
                plotOptions: {
                    series: {
                        borderWidth: 0,
                        dataLabels: {
                            enabled: true,
                            format: '{point.y:.f} Orang'
                        }
                    }
                },

                tooltip: {
                    headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                    pointFormat: '<span style="color:{point.color}">{point.name}</span>: ' +
                        '<b>{point.y:.f} Orang'
                },

                series: chartData.series,
                drilldown: chartData.drilldown, // kirim data drilldown dari Livewire ke JS
                exporting: {
                    chartOptions: {
                        chart: {
                            style: {
                                fontFamily: 'monospace'
                            }
                        }
                    }
                }
            });


        });
    </script>
@endpush
