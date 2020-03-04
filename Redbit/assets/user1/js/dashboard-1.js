$(function () {


    /*
    -----------------------------
    ChartJS
    -----------------------------
    */
   // ChartJS Line Chart 1
    var chartjs1 = $('#chartLine1');
    new Chart(chartjs1, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                data: [20,30,15,30,20,44,20,30,20,30,20,30],
                backgroundColor: 'rgba(58,82,255,0.2)',
                fill: true,
                borderWidth: 3,
                borderColor: 'rgba(58,82,255,1)'
            },{
                data: [30,45,30,45,30,57,30,42,30,52,30,45],
                backgroundColor: 'rgba(67,75,127,0.1)',
                fill: true,
                borderWidth: 3,
                borderColor: 'rgba(67,75,127,0.8)'
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
                    display: false,
                    ticks: {
                        beginAtZero: true,
                        fontSize: 10,
                        max: 60
                    }
                }],
                xAxes: [{
                    display:false,
                    layout: {
                        padding: 0
                    },
                    ticks: {
                        beginAtZero: true,
                        fontSize: 12,
                    },
                    gridLines: {
                        display: false
                    }
                }]
            },
            legend: {
                display: false
            },
            tooltips: {
                enabled: false
            },
            elements: {
                line: {
                    tension: .11
                },
                point: {
                    radius: 0
                }
            }

        }
    });

   // ChartJS Line Chart 2
    var chartjs2 = $('#chartDonut1');
    new Chart(chartjs2, {
        type: 'doughnut',
        data: {
            labels: ["Georgia", "Turkey", "England", "Italy"],
            datasets: [
                {
                    label: "",
                    data: [1300, 1050, 977, 567],
                    backgroundColor: [
                        "#1DCF3B",
                        "#DB3847",
                        "#3AA4F5",
                        "#F3BB00"
                    ],
                    borderColor: [
                        "#fff",
                        "#fff",
                        "#fff",
                        "#fff"
                    ],
                    borderWidth: 0,
                    hoverBorderColor: 'transparent'
                }
            ]
        },
        options: {
            cutoutPercentage: 80,
            responsive: true,
            maintainAspectRatio: false,
            title: {
                display: false,
                fontSize: 18,
                fontColor: "#333"
            },
            legend: {
                display: false,
                position: "bottom",
                labels: {
                    fontColor: "#666",
                    fontSize: 12
                }
            },
        }
    });

   // ChartJS Line Chart 3
    var chartjs3 = $("#chartLine2").get(0).getContext("2d");
    new Chart(chartjs3, {
        type: 'line',
        data: {
            labels: ["2013", "2014", "2015", "2016", "2017"],
            datasets: [{
                label: '# of Votes',
                data: [0, 9, 1, 4, 2, 0],
                backgroundColor: 'rgba(58,82,255,0.2)',
                borderColor: 'rgba(58,82,255,1)',
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

    // ChartJS Line Chart 4
    var chartjs4 = $("#chartLine3").get(0).getContext("2d");
    new Chart(chartjs4, {
        type: 'line',
        data: {
            labels: ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"],
            datasets: [{
                label: '# of Votes',
                data: [9761, 1763, 8764, 6612, 4214, 7243, 3333],
                backgroundColor: 'rgba(67,75,127,0.1)',
                borderColor: 'rgba(67,75,127,1)',
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
