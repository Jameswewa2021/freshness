$(function () {

    /*
    -----------------------------
    Flot Chart
    -----------------------------
    */
    // Flot Char Line 
    var revenueData = [[0, 12.725], [10, 13.564], [20, 19.546], [30, 14.241], [40, 22.776], [50, 17.110], [60, 20.200], [70, 10.545], [80, 14.564], [90, 18.055], [100, 15.122]];
    var expenseData = [[0, 7.750], [10, 3.500], [20, 8.140], [30, 4.123], [40, 9.789], [50, 3.100], [60, 11.300], [70, 5.525], [80, 10.514], [90, 14.522], [100, 12.000]];

    $.plot($('#flotChartLine1'), [
        {
            data: revenueData,
            label: 'revenue',
            color: '#3a52ff'
        },
        {
            data: expenseData,
            label: 'expense',
            color: '#3498DBB'
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
                color: 'rgba(0,0,0,.070)',
                font: {
                    size: 10,
                    color: '#777777'
                }
            },
            xaxis: {
                ticks: [[0, 'Jan'], [20, 'Feb'], [40, 'Mar'], [60, 'Apr'], [80, 'May'], [100, 'Jun']],
                color: 'rgba(0,0,0,.070)',
                font: {
                    size: 10,
                    color: '#777777'
                }
            }
        });

    // Flot Char Bar 
    $.plot('#flotChartBar', [{
        data: [[0, 24], [5, 32], [10, 51], [15, 66], [20, 16], [25, 31], [30, 23], [35, 32], [40, 43]],
        bars: {
            show: true,
            lineWidth: 0,
            barWidth: 3,
            fillColor: '#3a52ff'

        }
    }], 
    {
        grid: {
            borderWidth: 1,
            borderColor: 'rgba(0,0,0,.070)',
            margin:0
        },
        yaxis: {
            tickColor: 'rgba(0,0,0,.070)',
            font: {
	            size: 10,
	            color: '#777777'
            }
        },
        xaxis: {
        	ticks: [[0, '00:00'], [10, '05:00'], [20, '10:00'], [30, '15:00'], [40, '20:00']],
            tickColor: 'rgba(0,0,0,.070)',
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
        borderColor: '#fff',
        borderOpacity: 1,
        borderWidth: 2,
        color: '#dedede',
        enableZoom: false,
        multiSelectRegion: true,
        hoverColor: '#3a52ff',
        hoverOpacity: null,
        normalizeFunction: 'linear',
        scaleColors: ['#b6d6ff', '#005ace'],
        selectedColor: '#3a52ff',
        selectedRegions: ['CN', 'GL', 'BR', 'TR'],
        showTooltip: true,  
    });

});
