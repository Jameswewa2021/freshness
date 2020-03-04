$(function () {
    /*
    -------------------------------------------------
        ChartJS Line Chart
    -------------------------------------------------
    */
    // Chart Line 1
    var ctx1 = $('#chartJsLine1');
    new Chart(ctx1, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                data: [15, 20, 10, 34, 22, 20],
                borderColor: '#3a52ff',
                borderWidth: 2,
                fill: false
            }]
        },
        options: {
            legend: {
                display: false,
                labels: {
                    display: false
                }
            },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        fontSize: 10,
                        max: 50
                    }
                }],
                xAxes: [{
                    ticks: {
                        beginAtZero: true,
                        fontSize: 12
                    }
                }]
            }
        }
    });

    // Chart Line 2
    var ctx2 = $('#chartJsLine2');
    new Chart(ctx2, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                data: [15, 20, 10, 34, 22, 20],
                borderColor: 'red',
                borderWidth: 2,
                fill: false
            },
            {
                data: [25, 30, 20, 44, 32, 30],
                borderColor: '#3a52ff',
                borderWidth: 2,
                fill: false
            }]
        },
        options: {
            legend: {
                display: false,
                labels: {
                    display: false
                }
            },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        fontSize: 10,
                        max: 50
                    }
                }],
                xAxes: [{
                    ticks: {
                        beginAtZero: true,
                        fontSize: 12
                    }
                }]
            }
        }
    });
    /*
    -------------------------------------------------
        ChartJS Area Chart
    -------------------------------------------------
    */
    // Chart Area 1
    var ctx3 = $('#chartJsArea1');
    new Chart(ctx3, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                data: [15, 34, 21, 10, 22, 20],
                backgroundColor: 'rgba(58,82,255,0.5)',
                fill: true,
                borderWidth: 3,
                borderColor: 'rgba(58,82,255,0.8)'
            }]
        },
        options: {
            legend: {
                display: false,
                labels: {
                    display: false
                }
            },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        fontSize: 10,
                        max: 50
                    }
                }],
                xAxes: [{
                    ticks: {
                        beginAtZero: true,
                        fontSize: 12
                    }
                }]
            }
        }
    });

    // Chart Area 2
    var ctx4 = $('#chartJsArea2');
    new Chart(ctx4, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                data: [15, 34, 21, 10, 22, 20],
                backgroundColor: 'rgba(58,82,255,0.5)',
                borderWidth: 1,
                fill: true
            }, {
                data: [25, 44, 31, 20, 32, 30],
                backgroundColor: 'rgba(58,82,255,0.050)',
                borderWidth: 1,
                fill: true
            }]
        },
        options: {
            legend: {
                display: false,
                labels: {
                    display: false
                }
            },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        fontSize: 10,
                        max: 50
                    }
                }],
                xAxes: [{
                    ticks: {
                        beginAtZero: true,
                        fontSize: 12
                    }
                }]
            }
        }
    });

    /*
    -------------------------------------------------
        ChartJS Bar Chart
    -------------------------------------------------
    */
    // Chart Bar
    var ctx5 = $('#chartJsBar1');
    new Chart(ctx5, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug'],
            datasets: [{
                label: '# of Votes',
                data: [10, 30, 25, 15, 27, 22, 10, 17],
                backgroundColor: 'rgba(58,82,255,0.7)'
            }]
        },
        options: {
            legend: {
                display: false,
                labels: {
                    display: false
                }
            },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        fontSize: 10,
                        max: 50
                    }
                }],
                xAxes: [{
                    ticks: {
                        beginAtZero: true,
                        fontSize: 12
                    }
                }]
            }
        }
    });

    // Chart Bar Horizontal
    var ctx6 = $('#chartJsBar2');
    new Chart(ctx6, {
        type: 'horizontalBar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug'],
            datasets: [{
                label: '# of Votes',
                data: [10, 30, 25, 15, 27, 22, 10, 17],
                backgroundColor: 'rgba(58,82,255,0.7)'
            }]
        },
        options: {
            legend: {
                display: false,
                labels: {
                    display: false
                }
            },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        fontSize: 10,
                        max: 50
                    }
                }],
                xAxes: [{
                    ticks: {
                        beginAtZero: true,
                        fontSize: 12
                    }
                }]
            }
        }
    });

    // Chart Bar Stacked 
    var ctx7 = $('#chartJsBar3');
    new Chart(ctx7, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug'],
            datasets: [{
                data: [10, 30, 25, 15, 27, 22, 10, 17],
                backgroundColor: 'rgba(58,82,255,0.7)',
                fill: true
            }, {
                data: [10, 24, 25, 15, 32, 17, 10, 17],
                backgroundColor: 'rgba(20,158,204,0.5)',
                fill: true
            }]
        },
        options: {
            legend: {
                display: false,
                labels: {
                    display: false
                }
            },
            scales: {
                yAxes: [{
                    stacked: true
                }],
                xAxes: [{
                    stacked: true
                }]
            }
        }
    });

    // Chart Bar Stacked Horizontal 
    var ctx8 = $('#chartJsBar4');
    new Chart(ctx8, {
        type: 'horizontalBar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug'],
            datasets: [{
                data: [10, 30, 25, 15, 27, 22, 10, 17],
                backgroundColor: 'rgba(58,82,255,0.7)',
                fill: true
            }, {
                data: [10, 24, 25, 15, 32, 17, 10, 17],
                backgroundColor: 'rgba(20,158,204,0.5)',
                fill: true
            }]
        },
        options: {
            legend: {
                display: false,
                labels: {
                    display: false
                }
            },
            scales: {
                yAxes: [{
                    stacked: true
                }],
                xAxes: [{
                    stacked: true
                }]
            }
        }
    });

    /*
    -------------------------------------------------
        ChartJS Donut & Pie
    -------------------------------------------------
    */
    // Chart Donut
    var ctx9 = $('#chartJsDonut');
    new Chart(ctx9, {
        type: 'doughnut',
        data: {
            labels: ["red", "cyan", "purple"],
            datasets: [
                {
                    label: "TeamA Score",
                    data: [70, 30, 25],
                    backgroundColor: [
                        "rgba(58,82,255,0.7)",
                        "rgba(20,158,204,0.7)",
                        "rgba(255,124,12,0.7)"
                    ],
                    borderColor: [
                        "#fff",
                        "#fff",
                        "#fff"
                    ],
                    borderWidth: [1, 1, 1]
                }
            ]
        },
        options: {
            responsive: true,
            title: {
                display: true,
                position: "top",
                text: "Pie Chart",
                fontSize: 18,
                fontColor: "#333"
            },
            legend: {
                display: true,
                position: "bottom",
                labels: {
                    fontColor: "#666",
                    fontSize: 12
                }
            }
        }
    });

    // Chart Pie
    var ctx10 = $('#chartJsPie');
    new Chart(ctx10, {
        type: 'pie',
        data: {
            labels: ["red", "blue", "orange"],
            datasets: [
                {
                    label: "TeamA Score",
                    data: [70, 30, 25],
                    backgroundColor: [
                        "rgba(58,82,255,0.7)",
                        "rgba(20,158,204,0.7)",
                        "rgba(255,124,12,0.7)"
                    ],
                    borderColor: [
                        "#fff",
                        "#fff",
                        "#fff"
                    ],
                    borderWidth: [1, 1, 1]
                }
            ]
        },
        options: {
            responsive: true,
            title: {
                display: true,
                position: "top",
                text: "Pie Chart",
                fontSize: 18,
                fontColor: "#333"
            },
            legend: {
                display: true,
                position: "bottom",
                labels: {
                    fontColor: "#666",
                    fontSize: 12
                }
            }
        }
    });

});