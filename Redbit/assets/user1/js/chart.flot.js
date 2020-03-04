$(function () {
    /*
    -------------------------------------------------
        Flot Line Charts
    -------------------------------------------------
    */
    $.plot($('#flotLine1'), [
        {
            data: [[0, 70], [10, 60], [20, 70], [30, 50], [40, 85], [50, 50], [60, 65], [70, 35], [80, 65], [90, 55], [100, 65]],
            label: 'Data',
            color: '#cbcbcb'
        }],
        {
            series: {
                lines: {
                    show: true,
                    lineWidth: 3,
                    fill: false,
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
                show: true,
                ticks: [[0, '00:00'], [40, '04:00'], [80, '08:00'], [100, '20:00']],
                color: 'rgba(0,0,0,.060)',
            }
        });

    $.plot($('#flotLine2'), [
        {
            data: [[0, 70], [10, 60], [20, 70], [30, 50], [40, 85], [50, 50], [60, 65], [70, 35], [80, 65], [90, 55], [100, 65]],
            label: 'Data 1',
            color: '#cbcbcb'
        }, {
            data: [[0, 35], [10, 55], [20, 40], [30, 17], [40, 72], [50, 25], [60, 40], [70, 20], [80, 40], [90, 35], [100, 50]],
            label: 'Data 2',
            color: '#3a52ff'
        }],
        {
            series: {
                lines: {
                    show: true,
                    lineWidth: 3,
                    fill: false,
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
                show: true,
                ticks: [[0, '00:00'], [40, '04:00'], [80, '08:00'], [100, '20:00']],
                color: 'rgba(0,0,0,.060)',
            }
        });

    /*
    -------------------------------------------------
        Flot Area Charts
    -------------------------------------------------
    */
    $.plot($('#flotArea1'), [
        {
            data: [[0, 12.725], [10, 13.564], [20, 19.546], [30, 14.241], [40, 22.776], [50, 17.110], [60, 20.200], [70, 10.545], [80, 14.564], [90, 18.055], [100, 15.122]],
            label: 'Data 1',
            color: '#3a52ff'
        },
        {
            data: [[0, 7.750], [10, 3.500], [20, 8.140], [30, 4.123], [40, 9.789], [50, 3.100], [60, 11.300], [70, 5.525], [80, 10.514], [90, 14.522], [100, 12.000]],
            label: 'Data 2',
            color: '#3498DB'
        }],
        {
            series: {
                lines: {
                    show: true,
                    lineWidth: 2,
                    fill: true,
                    fillColor: { colors: [{ opacity: 0 }, { opacity: .7 }] }
                },
                shadowSize: 1
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
                ticks: [[0, ''], [5, '$50,000'], [10, '$100,000'], [15, '$150,000'], [20, '$200,000'], [25, '$250,000']],
                min: 0,
                max: 25,
                color: 'rgba(0,0,0,.060)',
                font: {
                    size: 10,
                    color: '#777777'
                }
            },
            xaxis: {
                ticks: [[0, 'Jan'], [20, 'Feb'], [40, 'Mar'], [60, 'Apr'], [80, 'May'], [100, 'Jun']],
                color: 'rgba(0,0,0,.060)',
                font: {
                    size: 10,
                    color: '#777777'
                }
            }
        });

    var ticketData = [[0, 55], [10, 35], [20, 50], [30, 25], [40, 80], [50, 23], [60, 50], [70, 18], [80, 60], [90, 45], [100, 60]];
    $.plot($('#flotArea2'), [
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
                color: 'rgba(0,0,0,.060)',
            },
            xaxis: {
                ticks: [[0, '00:00'], [40, '04:00'], [80, '08:00'], [100, '20:00']],
                color: 'rgba(0,0,0,.060)',
            }
        });

    /*
    -------------------------------------------------
        Flot Bar Charts
    -------------------------------------------------
    */
    // Flot Bar Chart
    $.plot('#flotBar1', [{
        data: [[0, 25], [10, 50], [20, 85], [30, 45], [40, 60], [50, 55], [60, 44], [70, 35]],
        bars: {
            show: true,
            lineWidth: 0,
            barWidth: 4,
            fillColor: {
                colors: ['rgba(4,221,221,.8)', 'rgba(70,189,189,.1)']
            }

        }
    }],
        {
            grid: {
                borderWidth: 1,
                borderColor: 'rgba(0,0,0,.060)',
                margin: 0
            },
            yaxis: {
                ticks: [[0, '0'], [20, '1'], [40, '2'], [60, '3'], [80, '4']],
                tickColor: 'rgba(0,0,0,.060)',
                max: 70,
            },
            xaxis: {
                show: false,
                ticks: [[10, 'Mon'], [20, 'Tue'], [30, 'Wed'], [40, 'Thu'], [50, 'Fri'], [60, 'Sat'], [, [70, 'Sun']]],
                tickColor: 'rgba(0,0,0,.060)',
            }
        });


    // Flot Bar Chart
    $.plot('#flotBar2', [{
        data: [[0, 10], [2, 15], [4, 25], [6, 20], [8, 15], [10, 22], [12, 10], [14, 15]],
        bars: {
            show: true,
            lineWidth: 0,
            fillColor: '#3a52ff',
            barWidth: .7
        }
    }, {
        data: [[1, 14], [3, 22], [5, 35], [7, 20], [9, 15], [11, 25], [13, 12], [15, 10]],
        bars: {
            show: true,
            lineWidth: 0,
            fillColor: '#3498DBB ',
            barWidth: .7
        }
    }],
        {
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
                ticks: [[0, '00:00'], [5, '05:00'], [10, '10:00'], [15, '15:00'], [20, '20:00']],
                tickColor: 'rgba(0,0,0,.060)',
                font: {
                    size: 10,
                    color: '#777777'
                }
            }
        });

    /*
    -------------------------------------------------
        Flot Pie & Donut 
    -------------------------------------------------
    */    
    // Flot Pie Chart
    var piedata = [
        { label: 'Data 1', data: [[1, 40]], color: '#3a52ff' },
        { label: 'Data 2', data: [[1, 20]], color: '#3498DBB' },
        { label: 'Data 3', data: [[1, 15]], color: '#333' },
    ];
    $.plot('#flotDonut', piedata, {
        series: {
            pie: {
                show: true,
                radius: .9,
                innerRadius: 0.6,
                label: {
                    show: true,
                    radius: 3 / 4,
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

    // Flot Donut Chart
    var piedata = [
        { label: 'Data 1', data: [[1, 40]], color: '#3a52ff' },
        { label: 'Data 2', data: [[1, 20]], color: '#3498DBB' },
        { label: 'Data 3', data: [[1, 15]], color: '#333' },
    ];
    $.plot('#flotPie', piedata, {
        series: {
            pie: {
                show: true,
                radius: .9,
                label: {
                    show: true,
                    radius: 2 / 4,
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