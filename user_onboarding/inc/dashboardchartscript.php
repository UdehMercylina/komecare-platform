<script>
    var p1 = <?= $percent_requested; ?>;
    var p2 = <?= $percent_approved; ?>;
    var p3 = <?= $percent_submitted; ?>;
    var options = {
        chart: { height: 320, type: "area", stacked: !0, toolbar: { show: !1, autoSelected: "zoom" } },
        colors: ["#a5c2f1", "#2a77f4"],
        dataLabels: { enabled: !1 },
        stroke: { curve: "smooth", width: [1.5, 1.5], dashArray: [0, 4], lineCap: "round" },
        grid: { padding: { left: 0, right: 0 }, strokeDashArray: 3 },
        markers: { size: 0, hover: { size: 0 } },
        series: [
            { name: "Month start", data: <?= $task_open; ?> },
            { name: "Month End", data: <?= $task_close; ?> },
        ],
        xaxis: { type: "month", categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"], axisBorder: { show: !0 }, axisTicks: { show: !0 } },
        fill: { type: "gradient", gradient: { shadeIntensity: 1, opacityFrom: 0.4, opacityTo: 0.3, stops: [0, 90, 100] } },
        tooltip: { x: { format: "dd/MM/yy HH:mm" } },
        legend: { position: "top", horizontalAlign: "right" },
    };
    (chart = new ApexCharts(document.querySelector("#ana_dash_1"), options)).render();

    options = {
        chart: { height: 270, type: "donut" },
        plotOptions: { pie: { donut: { size: "85%" } } },
        dataLabels: { enabled: !1 },
        stroke: { show: !0, width: 2, colors: ["transparent"] },
        series: [p1, p2, p3],
        legend: { show: !0, position: "bottom", horizontalAlign: "center", verticalAlign: "middle", floating: !1, fontSize: "13px", offsetX: 0, offsetY: 0 },
        labels: ["Requested", "Approved", "Submitted"],
        colors: ["#2a76f4", "rgba(42, 118, 244, .5)", "rgba(42, 118, 244, .18)"],
        responsive: [{ breakpoint: 600, options: { plotOptions: { donut: { customScale: 0.2 } }, chart: { height: 240 }, legend: { show: !1 } } }],
        tooltip: {
            y: {
                formatter: function (o) {
                    return o + " %";
                },
            },
        },
    };
    (chart = new ApexCharts(document.querySelector("#ana_device"), options)).render();

</script>