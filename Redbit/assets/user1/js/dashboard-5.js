$(function () {

    /*
    -----------------------------
    Flot Chart
    -----------------------------
    */
    // flot chart line
    var fitnessData1 = [[0, 70], [10, 60], [20, 70], [30, 50], [40, 85], [50, 50], [60, 65], [70, 35], [80, 65], [90, 55], [100, 65]];
    var fitnessData2 = [[0, 35], [10, 55], [20, 40], [30, 17], [40, 72], [50, 25], [60, 40], [70, 20], [80, 40], [90, 35], [100, 50]];

    $.plot($('#flotChartLine1'), [
        {
            data: fitnessData1,
            label: 'Exercise',
            color: '#cbcbcb'
        },{
            data: fitnessData2,
            label: 'Exercise',
            color: '#3a52ff'
        }],
        {
        series: {
            lines: {
                show: true,
                lineWidth: 3,
                fill: true,
                fillColor: { colors: [{ opacity: 0 }, { opacity: .1 }] }
            },
            shadowSize: 0,
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
            ticks: [[0, ''], [25, '1K'], [50, '2K'], [75, '3K'], [100, '4K']],
            min: 0,
            max: 100,
            color: 'rgba(0,0,0,.060)',
        },
        xaxis: {
            show:true,
            ticks: [[0, '00:00'], [40, '04:00'], [80, '08:00'], [100, '20:00']],
            color: 'rgba(0,0,0,.060)',
        }
    });

    // flot chart bar 1
    $.plot('#flotChartBar1', [{
        data: [[0, 25], [10, 50], [20,85], [30,45], [40,60], [50,55], [60,44], [70,35]],
        bars: {
            show: true,
            lineWidth: 0,
            barWidth: 4,
            fillColor: {
                colors:['rgba(4,221,221,.8)', 'rgba(70,189,189,.1)'] 
            }

        }
    }], 
    {
        grid: {
            borderWidth: 1,
            borderColor: 'transparent',
            margin:0
        },
        yaxis: {

            ticks: [[0, '0'], [20, '1'], [40, '2'], [60, '3'], [80, '4']],
            tickColor: 'transparent',
            max: 70,
        },
        xaxis: {
            show:false,
            ticks: [[10, 'Mon'], [20, 'Tue'], [30, 'Wed'], [40, 'Thu'], [50, 'Fri'], [60, 'Sat'], [, [70, 'Sun']]],
            tickColor: 'transparent',
        }
    });


    // flot chart bar 2
    $.plot('#flotChartBar2', [{
        data: [[0, 25], [10, 50], [20,85], [30,45], [40,60], [50,55], [60,44], [70,35]],
        bars: {
            show: true,
            lineWidth: 0,
            barWidth: 4,
            fillColor: {
                colors:['rgba(251,119,156,1)', 'rgba(251,119,156,.3)'] 
            }

        }
    }], 
    {
        grid: {
            borderWidth: 1,
            borderColor: 'transparent',
            margin:0
        },
        yaxis: {
            show: false,
            ticks: [[0, '0'], [20, '1'], [40, '2'], [60, '3'], [80, '4']],
            tickColor: 'transparent',
            max: 70,
        },
        xaxis: {
            show:false,
            ticks: [[10, 'Mon'], [20, 'Tue'], [30, 'Wed'], [40, 'Thu'], [50, 'Fri'], [60, 'Sat'], [, [70, 'Sun']]],
            tickColor: 'transparent',
        }
    });
    /*
    -----------------------------
    Circle Progress
    -----------------------------
    */
    // circle progress 1
    $('.circleProgress1').circleProgress({
        size:110,
        startAngle: -Math.PI / 4 * 3,
        value: 0.75,
        thickness: 9,
        fill: {gradient: [['#3a52ff', 1], ['#b13aff', .1]], gradientAngle: Math.PI /  4 * 3},
         lineCap: '',
    }).on('circle-animation-progress', function(event, progress, stepValue) {
         $(this).find('.value').html(Math.round(100 * stepValue) + '<i class="fw-400">%</i>');
    });

    // circle progress 2
    $('.circleProgress2').circleProgress({
        size:110,
        startAngle: -Math.PI / 4 * 3,
        value: 0.43,
        thickness: 9,
        fill: {gradient: [['#3498DBB', 1], ['#AD0233', .1]], gradientAngle: Math.PI /  4 * 3},
         lineCap: '',
    }).on('circle-animation-progress', function(event, progress, stepValue) {
         $(this).find('.value').html(Math.round(100 * stepValue) + '<i class="fw-400">%</i>');
    });

    // circle progress 3
    $('.circleProgress3').circleProgress({
        size:110,
        startAngle: -Math.PI / 4 * 3,
        value: 0.62,
        thickness: 9,
        fill: {gradient: [['#48ba16', 1], ['#66ED0C', .1]], gradientAngle: Math.PI /  4 * 3},
         lineCap: '',
    }).on('circle-animation-progress', function(event, progress, stepValue) {
        $(this).find('.value').html(Math.round(100 * stepValue) + '<i class="fw-400">%</i>');
    });

    // circle progress 4
    $('.circleProgress4').circleProgress({
        size:110,
        startAngle: -Math.PI / 4 * 3,
        value: 0.34,
        thickness: 9,
        fill: {gradient: [['#ffc107', 1], ['#C49505', .1]], gradientAngle: Math.PI /  4 * 3},
         lineCap: '',
    }).on('circle-animation-progress', function(event, progress, stepValue) {
         $(this).find('.value').html(Math.round(100 * stepValue) + '<i class="fw-400">%</i>');
    });
});
