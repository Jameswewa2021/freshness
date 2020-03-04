$(function () {

    /*
    -----------------------------
    Flot Chart
    -----------------------------
    */
    var ticketData = [[0, 55], [10, 35], [20, 50], [30, 25], [40, 80], [50, 23], [60, 50], [70, 18], [80, 60], [90, 45], [100, 60]];

    $.plot($('#flotChartLine1'), [
        {
            data: ticketData,
            label: 'revenue',
            color: '#3a52ff'
        }],
        {
            series: {
                lines: {
                    show: true,
                    lineWidth: 2,
                    fill: true,
                    fillColor: { colors: [{ opacity: 0 }, { opacity: .4 }] }
                },
                shadowSize: 7,
            },
            points: {
                show: false,
            },
            legend: {
                noColumns: 1,
            },
            grid: {
                hoverable: true,
                clickable: true,
                borderWidth: 0,
                labelMargin: 5
            },
            yaxis: {
                ticks: [[0, ''], [25, '5'], [50, '10'], [75, '20'], [100, '30']],
                min: 0,
                max: 100,
                color: 'rgba(0,0,0,.070)',
            },
            xaxis: {
                ticks: [[0, '00:00'], [40, '04:00'], [80, '08:00'], [100, '20:00']],
                color: 'rgba(0,0,0,.070)',
            }
        });
    var piedata = [
        { label: 'Satisfied', data: [[1, 40]], color: '#3a52ff' },
        { label: 'Not Satisfied', data: [[1, 20]], color: '#3498DBB' },
        { label: 'Unstable', data: [[1, 15]], color: '#333' },
    ];

    $.plot('#flotChartPie', piedata, {
        series: {
            pie: {
                show: true,
                radius: 1,
                innerRadius: 0.6,
                label: {
                    show: true,
                    radius: 3.2 / 4,
                    formatter: textFormatter,
                }
            }
        },
        grid: {
            hoverable: false,
            clickable: false
        },
        legend: {
            show: false
        }
    });

    function textFormatter(label, series) {
        return '<div style="font-size:10px; font-weight:700; text-align:center; color:#ffff;">' + Math.round(series.percent) + '%</div>';
    }


});
