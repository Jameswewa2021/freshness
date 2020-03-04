$(function() {
    /*
    -----------------------------
    Flot Chart
    -----------------------------
    */
    // Flot Chart 1
    var flotChart1Data1 = [
        [0, 70],
        [10, 60],
        [20, 70],
        [30, 50],
        [40, 85],
        [50, 50],
        [60, 65],
        [70, 35],
        [80, 65],
        [90, 55],
        [100, 65]
    ];
    var flotChart1Data2 = [
        [0, 35],
        [10, 55],
        [20, 40],
        [30, 17],
        [40, 72],
        [50, 25],
        [60, 40],
        [70, 20],
        [80, 40],
        [90, 35],
        [100, 50]
    ];
    $.plot($('#flotChartLine1'), [{
        data: flotChart1Data1,
        label: 'Exercise',
        color: '#cbcbcb'
    }, {
        data: flotChart1Data2,
        label: 'Exercise',
        color: '#3a52ff'
    }], {
        series: {
            lines: {
                show: true,
                lineWidth: 3,
                fill: true,
                fillColor: {
                    colors: [{
                        opacity: 0
                    }, {
                        opacity: .1
                    }]
                }
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
            ticks: [
                [0, ''],
                [25, '1K'],
                [50, '2K'],
                [75, '3K'],
                [100, '4K']
            ],
            min: 0,
            max: 100,
            color: 'rgba(0,0,0,.060)',
        },
        xaxis: {
            show: true,
            ticks: [
                [0, '00:00'],
                [40, '04:00'],
                [80, '08:00'],
                [100, '20:00']
            ],
            color: 'rgba(0,0,0,.060)',
        }
    });



    // Flot Chart 2
    var flotChart2Data = [
        [0, 55],
        [10, 35],
        [20, 50],
        [30, 25],
        [40, 80],
        [50, 23],
        [60, 50],
        [70, 18],
        [80, 60],
        [90, 45],
        [100, 60]
    ];
    $.plot($('#flotChartLine2'), [{
        data: flotChart2Data,
        label: 'revenue',
        color: '#3a52ff'
    }], {
        series: {
            lines: {
                show: true,
                lineWidth: 2,
                fill: true,
                fillColor: {
                    colors: [{
                        opacity: 0
                    }, {
                        opacity: .4
                    }]
                }
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
            ticks: [
                [0, ''],
                [25, '5'],
                [50, '10'],
                [75, '20'],
                [100, '30']
            ],
            min: 0,
            max: 100,
            color: 'rgba(0,0,0,.060)',
        },
        xaxis: {
            ticks: [
                [0, '00:00'],
                [40, '04:00'],
                [80, '08:00'],
                [100, '20:00']
            ],
            color: 'rgba(0,0,0,.060)',
        }
    });

    // Flot Char Bar 
    $.plot('#flotChartBar1', [{
        data: [
            [0, 24],
            [5, 32],
            [10, 51],
            [15, 66],
            [20, 16],
            [25, 31],
            [30, 23],
            [35, 32],
            [40, 43]
        ],
        bars: {
            show: true,
            lineWidth: 0,
            barWidth: 3,
            fillColor: '#3a52ff'

        }
    }], {
        grid: {
            borderWidth: 1,
            borderColor: 'rgba(0,0,0,.060)',
            margin: 0
        },
        yaxis: {
            tickColor: 'rgba(0,0,0,.060)',
            font: {
                size: 10,
                color: '#777777'
            }
        },
        xaxis: {
            ticks: [
                [0, '00:00'],
                [10, '05:00'],
                [20, '10:00'],
                [30, '15:00'],
                [40, '20:00']
            ],
            tickColor: 'rgba(0,0,0,.060)',
            font: {
                size: 10,
                color: '#777777'
            }
        }
    });


    /*
    -----------------------------
    jQuery Vector Map
    -----------------------------
    */
    jQuery('#vmap').vectorMap({
        map: 'world_en',
        backgroundColor: 'transparent',
        borderColor: '#3a52ff',
        borderOpacity: 1,
        borderWidth: 2,
        color: 'rgba(255,255,255,.7)',
        enableZoom: false,
        multiSelectRegion: true,
        hoverColor: '#fff',
        hoverOpacity: null,
        normalizeFunction: 'linear',
        scaleColors: ['#b6d6ff', '#005ace'],
        selectedColor: '#fff',
        selectedRegions: ['CN', 'GL', 'BR', 'TR'],
        showTooltip: true,
    });

    

});