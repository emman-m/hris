<div class="d-flex align-items-center">
    <div class="subheader">Turnover Rate</div>
    <div class="ms-auto lh-1">
        <span class="text-muted">Monthly Report</span>
    </div>
</div>
<div class="d-flex align-items-baseline">
    <div class="h1 mb-3 me-2"><?= $turnover['total_employees'] ?></div>
    <div class="me-auto">
        <span class="text-green d-inline-flex align-items-center lh-1">
            Employees
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="icon ms-1 icon-2">
                <path d="M3 17l6 -6l4 4l8 -8"></path>
                <path d="M14 7l7 0l0 7"></path>
            </svg>
        </span>
    </div>
</div>
<div id="chart-turnover" class="chart-lg">
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const departmentRates = <?= json_encode($turnover['department_rates'] ?? []) ?>;
        const series = [];
        const colors = [
            tabler.getColor("primary"),
            tabler.getColor("success"),
            tabler.getColor("warning"),
            tabler.getColor("danger"),
            tabler.getColor("info"),
            tabler.getColor("secondary")
        ];

        // If we have department rates, create series for each department
        if (Object.keys(departmentRates).length > 0) {
            Object.entries(departmentRates).forEach(([dept, data], index) => {
                // Convert sparse data to full month data with zeros
                const fullMonthData = {};
                Object.keys(<?= json_encode($turnover['rates']) ?>).forEach(date => {
                    fullMonthData[date] = data.rates[date] || 0;
                });

                series.push({
                    name: dept,
                    data: Object.values(fullMonthData),
                    color: colors[index % colors.length]
                });
            });
        } else {
            // Fallback to single series if no department data
            series.push({
                name: "Employee(s)",
                data: <?= json_encode(array_values($turnover['rates'])); ?>,
                color: colors[0]
            });
        }

        window.ApexCharts &&
            new ApexCharts(document.getElementById("chart-turnover"), {
                chart: {
                    type: "bar",
                    fontFamily: "inherit",
                    height: 400,
                    animations: {
                        enabled: false,
                    },
                    stacked: true,
                    toolbar: {
                        show: true,
                        tools: {
                            download: true,
                            selection: true,
                            zoom: true,
                            zoomin: true,
                            zoomout: true,
                            pan: true,
                            reset: true
                        }
                    }
                },
                plotOptions: {
                    bar: {
                        columnWidth: "50%",
                        borderRadius: 4,
                        dataLabels: {
                            position: 'top'
                        }
                    },
                },
                dataLabels: {
                    enabled: true,
                    formatter: function (val) {
                        return val > 0 ? val : '';
                    },
                    offsetY: -20,
                    style: {
                        fontSize: '12px',
                        colors: ["#304758"]
                    }
                },
                fill: {
                    opacity: 1,
                },
                series: series,
                tooltip: {
                    theme: "dark",
                    y: {
                        formatter: function (value) {
                            return value + ' employee(s)';
                        }
                    },
                    x: {
                        format: 'dd MMM yyyy'
                    }
                },
                grid: {
                    strokeDashArray: 4,
                    borderColor: '#f1f1f1',
                    xaxis: {
                        lines: {
                            show: true
                        }
                    }
                },
                xaxis: {
                    labels: {
                        padding: 0,
                        format: 'dd MMM',
                        rotate: -45,
                        rotateAlways: true
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
                    forceNiceScale: true,
                    min: 0,
                    tickAmount: 5
                },
                labels: <?= json_encode(array_keys($turnover['rates'])); ?>,
                legend: {
                    show: true,
                    position: 'top',
                    horizontalAlign: 'right',
                    offsetY: -10
                },
                noData: {
                    text: 'No turnover data available',
                    align: 'center',
                    verticalAlign: 'middle',
                    style: {
                        fontSize: '14px'
                    }
                }
            }).render();
    });
</script> 