var chartWrapper = $('.chartjs');
var lineChartEx = $('.line-chart-ex');
if (chartWrapper.length) {
chartWrapper.each(function () {
    $(this).wrap($('<div style="height:' + this.getAttribute('data-height') + 'px"></div>'));
});
}
var primaryColorShade = '#836AF9',
yellowColor = '#ffe800',
successColorShade = '#28dac6',
warningColorShade = '#ffe802',
warningLightColor = '#FDAC34',
infoColorShade = '#299AFF',
greyColor = '#4F5D70',
blueColor = '#2c9aff',
blueLightColor = '#84D0FF',
greyLightColor = '#EDF1F4',
tooltipShadow = 'rgba(0, 0, 0, 0.25)',
lineChartPrimary = '#666ee8',
lineChartDanger = '#ff4961',
labelColor = '#6e6b7b',
grid_line_color = 'rgba(200, 200, 200, 0.2)'; // RGBA color helps in dark layout
if (lineChartEx.length) {
var lineExample = new Chart(lineChartEx, {
    type: 'line',
    plugins: [
    // to add spacing between legends and chart
    {
        beforeInit: function (chart) {
        chart.legend.afterFit = function () {
            this.height += 20;
        };
        }
    }
    ],
    options: {
    responsive: true,
    maintainAspectRatio: false,
    backgroundColor: false,
    hover: {
        mode: 'label'
    },
    tooltips: {
        // Updated default tooltip UI
        shadowOffsetX: 1,
        shadowOffsetY: 1,
        shadowBlur: 8,
        shadowColor: tooltipShadow,
        backgroundColor: window.colors.solid.white,
        titleFontColor: window.colors.solid.black,
        bodyFontColor: window.colors.solid.black
    },
    layout: {
        padding: {
        top: -15,
        bottom: -25,
        left: -15
        }
    },
    scales: {
        xAxes: [
        {
            display: true,
            scaleLabel: {
            display: true
            },
            gridLines: {
            display: true,
            color: grid_line_color,
            zeroLineColor: grid_line_color
            },
            ticks: {
            fontColor: labelColor
            }
        }
        ],
        yAxes: [
        {
            display: true,
            scaleLabel: {
            display: true
            },
            ticks: {
            stepSize: 100,
            min: 0,
            max: 400,
            fontColor: labelColor
            },
            gridLines: {
            display: true,
            color: grid_line_color,
            zeroLineColor: grid_line_color
            }
        }
        ]
    },
    legend: {
        position: 'top',
        align: 'start',
        labels: {
        usePointStyle: true,
        padding: 25,
        boxWidth: 9
        }
    }
    },
    data: {
    labels: [0, 10, 20, 30, 40, 50, 60, 70, 80, 90, 100, 110, 120, 130, 140],
    datasets: [
        {
        data: [80, 150, 180, 270, 210, 160, 160, 202, 265, 210, 270, 255, 290, 360, 375],
        label: 'Torque',
        borderColor: lineChartDanger,
        borderDash: [5],
        lineTension: 0.5,
        pointStyle: 'circle',
        backgroundColor: lineChartDanger,
        fill: false,
        pointRadius: 1,
        pointHoverRadius: 5,
        pointHoverBorderWidth: 5,
        pointBorderColor: 'transparent',
        pointHoverBorderColor: window.colors.solid.white,
        pointHoverBackgroundColor: lineChartDanger,
        pointShadowOffsetX: 1,
        pointShadowOffsetY: 1,
        pointShadowBlur: 5,
        pointShadowColor: tooltipShadow
        },
        {
        data: [80, 125, 105, 130, 215, 195, 140, 160, 230, 300, 220, 170, 210, 200, 280],
        label: 'Power',
        borderColor: lineChartPrimary,
        lineTension: 0.5,
        pointStyle: 'circle',
        backgroundColor: lineChartPrimary,
        fill: false,
        pointRadius: 1,
        pointHoverRadius: 5,
        pointHoverBorderWidth: 5,
        pointBorderColor: 'transparent',
        pointHoverBorderColor: window.colors.solid.white,
        pointHoverBackgroundColor: lineChartPrimary,
        pointShadowOffsetX: 1,
        pointShadowOffsetY: 1,
        pointShadowBlur: 5,
        pointShadowColor: tooltipShadow
        }
    ]
    }
});
}
