<div class="card-body">
    <div class="d-flex align-items-center">
        <div class="subheader">Tardiness Rate</div>
        <div class="ms-auto lh-1">
            <span class="text-muted">Lastest last 15 days</span>
            
        </div>
    </div>
    <div class="d-flex align-items-baseline">
        <div class="h1 mb-3 me-2"><?= $tardiness['total_tardy_employees']?></div>
        <div class="me-auto">
            <span class="text-green d-inline-flex align-items-center lh-1">
                Employee
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="icon ms-1 icon-2">
                    <path d="M3 17l6 -6l4 4l8 -8"></path>
                    <path d="M14 7l7 0l0 7"></path>
                </svg>
            </span>
        </div>
    </div>
    <div id="chart-tardiness" class="chart-sm">
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        window.ApexCharts &&
            new ApexCharts(document.getElementById("chart-tardiness"), {
                chart: {
                    type: "bar",
                    fontFamily: "inherit",
                    height: 100,
                    sparkline: {
                        enabled: true,
                    },
                    animations: {
                        enabled: false,
                    },
                },
                plotOptions: {
                    bar: {
                        columnWidth: "50%",
                    },
                },
                dataLabels: {
                    enabled: false,
                },
                fill: {
                    opacity: 1,
                },
                series: [
                    {
                        name: "Employee(s)",
                        data: <?= json_encode(array_values($tardiness['rates'])); ?>,
                    },
                ],
                tooltip: {
                    theme: "dark",
                    y: {
                        formatter: function (value) {
                            return value + '%';
                        }
                    }
                },
                grid: {
                    strokeDashArray: 4,
                },
                xaxis: {
                    labels: {
                        padding: 0,
                    },
                    tooltip: {
                        enabled: false,
                    },
                    axisBorder: {
                        show: false,
                    },
                    type: "datetime",
                },
                yaxis: {
                    labels: {
                        padding: 4,
                    },
                },
                labels: <?= json_encode(array_keys($tardiness['rates'])); ?>,
                colors: [tabler.getColor("primary")],
                legend: {
                    show: false,
                },
            }).render();
    });
</script>