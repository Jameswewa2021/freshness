$(function () {
    /*
    -----------------------------
    Flot Chart
    -----------------------------
    */
    var flotData1 = [
        [0, 45.545877871210541],
        [1, 41.47564741005432],
        [2, 45.26554654541321],
        [3, 55.54541231212547],
        [4, 52.54312121548646],
        [5, 54.20000047877499],
        [6, 56.21231874641165],
        [7, 54.45654778991100],
        [8, 53.99677491680908],
        [9, 52.21200254878512],
        [10, 57.53415454454554],
        [11, 61.01324578878788],
        [12, 57.7457726121753],
        [13, 60.1545448787999],
        [14, 63.45284705814520],
        [15, 54.11202276349138],
        [16, 56.72497594269612],
        [17, 60.070341498681124],
        [18, 50.09867716530438],
        [19, 45.48185519192089],
        [20, 47.57861168097493],
        [21, 46.99789250679436],
        [22, 54.582491800119456],
        [23, 50.28407438696142],
        [24, 47.24606628705599],
        [25, 38.614330310543856],
        [26, 42.75313497797672],
        [27, 50.34463925296746],
        [28, 49.217320673443936],
        [29, 51.657281647073304],
        [30, 57.445057217757245],
        [31, 56.063914668561345],
        [32, 54.07494250387825],
        [33, 53.970403392565515],
        [34, 49.723854145068756],
        [35, 57.69064629353968],
        [36, 51.590890118378205],
        [37, 50.52332126105745],
        [38, 59.1037709679581],
        [39, 58.05347017020425],
        [40, 61.350810521199946],
        [41, 57.746188675088575],
        [42, 60.276910973029786],
        [43, 61.00841651851749],
        [44, 57.786733623457636],
        [45, 56.805721677811356],
        [46, 58.90301959619822],
        [47, 63.45091969566289],
        [48, 57.75007922945926],
        [49, 59.405842466185355],
        [50, 51.746633122658444],
        [51, 50.465452111212744],
        [52, 50.3020769891715],
        [53, 51.56370473325533],
        [54, 57.407205992344544],
        [55, 48.49825590435839],
        [56, 52.4975614755482],
        [57, 49.79614749316488],
        [58, 47.46776704767111],
        [59, 42.317880548036456],
        [60, 38.96296121124144],
        [61, 34.73218432559628],
        [62, 31.033700732272116],
        [63, 30.637987000382296],
        [64, 37.89513637594264],
        [65, 32.89701755609185],
        [66, 38.742284578187544],
        [67, 42.20516407297906],
        [68, 43.82094321791933],
        [69, 44.64770271525896],
        [70, 40.15348765453412],
        [71, 39.737654438195236],
        [72, 39.755190738237744],
        [73, 37.96228929938593],
        [74, 30.38197394166947],
        [75, 27.95038772723346],
        [76, 20.08944448751686],
        [77, 23.54611335622507],
        [78, 24.309610481106425],
        [79, 38.276849322378055],
        [80, 23.25409223418214],
        [81, 27.920374921780102],
        [82, 26.143447932376702],
        [83, 21.09444253479626],
        [84, 23.79459089729409],
        [85, 23.46775072519832],
        [86, 25.9908486073969],
        [87, 28.218855925354447],
        [88, 22.9163141686872],
        [89, 17.217667423877607],
        [90, 19.135179958932145],
        [91, 20.08666008920407],
        [92, 22.006269617032526],
        [93, 10.201671310476282],
        [94, 9.475865090236113],
        [95, 28.645754524211824],
        [96, 17.76161040821357],
        [97, 13.995208323029495],
        [98, 8.59338056489445],
        [99, 9.536707176236195],
        [100, 11.01308268888571]
    ];
    var plot = $.plot($('#flotChartLine1'), [
        {
            data: flotData1,
            label: 'Balance',
            color: '#3a52ff'
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
                ticks: [[0, ''], [15, '$3400'], [30, '$4150'], [50, '$4700'], [75, '$5200'], [100, '$5570']],
                min: 0,
                max: 70,
                color: 'rgba(0,0,0,.070)',
                font: {
                    size: 10,
                    color: '#777777'
                }
            },
            xaxis: {
                ticks: [[0, '00:00'], [20, '04:00'], [40, '08:00'], [60, '12:00'], [80, '14:00'], [100, '16:00']],
                color: 'rgba(0,0,0,.070)',
                font: {
                    size: 10,
                    color: '#777777'
                }
            }
        });
    
    /*
    -----------------------------
    ChartJS
    -----------------------------
    */
    // ChartJS 1
    var chartjs1 = $("#chartJsLine1");
    new Chart(chartjs1, {
        type: 'line',
        data: {
            labels: ["2013", "2014", "2015", "2016", "2017"],
            datasets: [{
                label: '# of Votes',
                data: [0, 9, 1, 4, 2, 0],
                backgroundColor: 'rgba(247,147,26,0.2)',
                borderColor: 'rgba(247,147,26,1)',
                borderWidth: 2,
                fill: true,
            }]
        },
        options: {
            maintainAspectRatio: false,
            ticks: {
                beginAtZero: true
            },
            tooltips: {
                enabled: false
            },
            elements: {
                line: {
                    tension: 0
                }
            },
            legend: {
                display: false
            },
            scales: {
                xAxes: [{
                    display: false,
                    gridLines: {
                        display: false
                    }
                }],
                yAxes: [{
                    display: false,
                    gridLines: {
                        display: false
                    }
                }]
            },
            elements: {
                line: {
                    tension: 0
                },
                point: {
                    radius: 0
                }
            }
        }
    });

    // ChartJS 2
    var chartjs2 = $("#chartJsLine2");
    new Chart(chartjs2, {
        type: 'line',
        data: {
            labels: ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"],
            datasets: [{
                label: '# of Votes',
                data: [2, 7, 1, 2, 6, 1, 7],
                backgroundColor: 'rgba(88,191,0,0.2)',
                borderColor: 'rgba(88,191,0,1)',
                borderWidth: 2,
                fill: true,
            }]
        },
        options: {
            maintainAspectRatio: false,
            ticks: {
                beginAtZero: true
            },
            tooltips: {
                enabled: false
            },
            elements: {
                line: {
                    tension: 0
                }
            },
            legend: {
                display: false
            },
            scales: {
                xAxes: [{
                    display: false,
                    gridLines: {
                        display: false
                    }
                }],
                yAxes: [{
                    display: false,
                    gridLines: {
                        display: false
                    }
                }]
            },
            elements: {
                line: {
                    tension: 0
                },
                point: {
                    radius: 0
                }
            }
        }
    });

    // ChartJS 3
    var chartjs3 = $("#chartJsLine3");
    new Chart(chartjs3, {
        type: 'line',
        data: {
            labels: ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"],
            datasets: [{
                label: '# of Votes',
                data: [0, 9, 1, 4, 2, 0, 4],
                backgroundColor: 'rgba(150,79,81,0.2)',
                borderColor: 'rgba(150,79,81,1)',
                borderWidth: 2,
                fill: true,
            }]
        },
        options: {
            maintainAspectRatio: false,
            ticks: {
                beginAtZero: true
            },
            tooltips: {
                enabled: false
            },
            elements: {
                line: {
                    tension: 0
                }
            },
            legend: {
                display: false
            },
            scales: {
                xAxes: [{
                    display: false,
                    gridLines: {
                        display: false
                    }
                }],
                yAxes: [{
                    display: false,
                    gridLines: {
                        display: false
                    }
                }]
            },
            elements: {
                line: {
                    tension: 0
                },
                point: {
                    radius: 0
                }
            }
        }
    });

    // ChartJS 4
    var chartjs4 = $("#chartJsLine4");
    new Chart(chartjs4, {
        type: 'line',
        data: {
            labels: ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"],
            datasets: [{
                label: '# of Votes',
                data: [0.620, 0.750, 0.320, 0.900, 0.677, 0.799, 0.350],
                backgroundColor: 'rgba(0,158,249,0.2)',
                borderColor: 'rgba(0,158,249,1)',
                borderWidth: 2,
                fill: true,
            }]
        },
        options: {
            maintainAspectRatio: false,
            ticks: {
                beginAtZero: true
            },
            tooltips: {
                enabled: false
            },
            elements: {
                line: {
                    tension: 0
                }
            },
            legend: {
                display: false
            },
            scales: {
                xAxes: [{
                    display: false,
                    gridLines: {
                        display: false
                    }
                }],
                yAxes: [{
                    display: false,
                    gridLines: {
                        display: false
                    }
                }]
            },
            elements: {
                line: {
                    tension: 0
                },
                point: {
                    radius: 0
                }
            }
        }
    });

});
