@extends('layouts/contentLayoutMaster')

@section('title', 'Browse Specs')

@section('content')
<style>
  .param-wrapper {
    padding: 2.5px;
  }
  .param-header {
    padding: 10px 20px;
    font-weight: bold;
    text-align: center;
  }
  .param-item {
    padding: 10px 20px;
    font-weight: bold;
    min-height: 50px;
    display: flex;
    justify-content: center;
    align-items: center;
  }
</style>
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-md-12 col-xl-6">
            <h4 class="card-title"><img src="{{ $logofile }}" style="width: 100px; height: 100px; margin:20px; padding:0" />{{ $car->title }}</h4>
            <p>Estimated {{ round((intval($car->tuned_bhp) - intval($car->std_bhp)) / intval($car->std_bhp) * 100) }}% more power and
                {{ round((intval($car->tuned_torque) - intval($car->std_torque)) / intval($car->std_torque) * 100) }}% more torque</p>
            <div class="row" style="color: white; justify-content: center; font-size: 10px;">
              <div class="col-3 param-wrapper"><div class="param-header bg-light-warning">Parameter</div></div>
              <div class="col-3 param-wrapper">
                <div class="param-header bg-light-info">STANDARD</div>
              </div>
              <div class="col-3 param-wrapper">
                <div class="param-header bg-light-info">CHIPTUNING</div>
              </div>
              <div class="col-3 param-wrapper">
                <div class="param-header bg-light-info">DIFFERENCE</div>
              </div>
              <div class="col-3 param-wrapper">
                <div class="param-item bg-light-primary">BHP</div>
              </div>
              <div class="col-3 param-wrapper">
                <div class="param-item bg-secondary">{{ $car->std_bhp }}</div>
              </div>
              <div class="col-3 param-wrapper">
                <div class="param-item bg-dark">{{ $car->tuned_bhp }}</div>
              </div>
              <div class="col-3 param-wrapper">
                <div class="param-item bg-black">{{ intval($car->tuned_bhp) - intval($car->std_bhp) }} hp</div>
              </div>
              <div class="col-3 param-wrapper">
                <div class="param-item bg-light-danger">TORQUE</div>
              </div>
              <div class="col-3 param-wrapper">
                <div class="param-item bg-secondary">{{ $car->std_torque }}</div>
              </div>
              <div class="col-3 param-wrapper">
                <div class="param-item bg-dark">{{ $car->tuned_torque }}</div>
              </div>
              <div class="col-3 param-wrapper">
                <div class="param-item bg-black">{{ intval($car->tuned_torque) - intval($car->std_torque) }} Nm</div>
              </div>
            </div>
          </div>
          <div class="col-md-12 col-xl-6">
            <canvas class="line-chart-ex chartjs" data-height="350"></canvas>
          </div>
        </div>

        <div class="row mb-2 mt-2 col-md-12 col-xl-8">
          <p>
            The development of each {{ $car->title }} tuning file is the result of perfection and dedication by {{ $company->name }} programmers.
            The organization only uses the latest technologies and has many years experience in ECU remapping software.
            Many (chiptuning) organizations around the globe download their tuning files for {{ $car->title }} at {{ $company->name }} for the best possible result.
            All {{ $car->title }} tuning files deliver the best possible performance and results within the safety margins.
          </p>
          <ul class="ms-2">
            <li>100% custom made tuning file guarantee</li>
            <li>Tested and developed via a 4x4 Dynometer</li>
            <li>Best possible performance and results, within the safety margins</li>
            <li>Reduced fuel consumption</li>
          </ul>
        </div>
        <div class="row">
          @if(!empty($_GET['make']))
            <div class="card col-md-6 col-lg-3">
              <a class="btn btn-dark" href="{{ url('/cars/category') }}">Overview</a>
            </div>
          @endif
          @if(!empty($_GET['model']))
            <div class="card col-md-6 col-lg-3">
              <a class="btn btn-dark" href="{{ url('/cars/category'.'?make='.$_GET['make']) }}">
                Back to {{ $_GET['make'] }}
              </a>
            </div>
          @endif
          @if(!empty($_GET['generation']))
            <div class="card col-md-6 col-lg-3">
              <a class="btn btn-dark" href="{{ url('/cars/category'.'?make='.$_GET['make'].'&model='.$_GET['model']) }}">
                Back to {{ $_GET['model'] }}
              </a>
            </div>
          @endif
          @if(!empty($_GET['engine']))
            <div class="card col-md-6 col-lg-3">
              <a class="btn btn-dark" href="{{ url('/cars/category'.'?make='.$_GET['make'].'&model='.$_GET['model'].'&generation='.$_GET['generation']) }}">
                Back to {{ $_GET['generation'] }}
              </a>
            </div>
          @endif
        </div>

      </div>
    </div>
  </div>
</div>
@endsection

@section('vendor-script')
  <!-- vendor files -->
  <script src="{{ asset(mix('vendors/js/charts/chart.min.js')) }}"></script>
@endsection
@section('page-script')
  <script>
    var yAxisMaxLeft = ({{ intval($car->tuned_bhp) }} / 100) + 1;
    var yAxisMaxRight = ({{ intval($car->tuned_torque) }} / 100) + 1;
    var bhpdata = [0, 22.85, 40, 52.85, 67.14, 77.14, 87.14, 97.14, 97.85, 100, 100, 80, 0, 0].map((v) => Math.round(v / 100 * {{ intval($car->tuned_bhp) }}) );
    var tordata = [0, 58.18, 87.27, 98.78, 100, 95.75, 92.27, 90.30, 87.27, 84.24, 78.78, 60, 0, 0].map((v) => Math.round(v / 100 * {{ intval($car->tuned_torque) }}));

    var chartWrapper = $('.chartjs');
    var lineChartEx = $('.line-chart-ex');
    if (chartWrapper.length) {
      chartWrapper.each(function () {
        $(this).wrap($('<div style="height:' + this.getAttribute('data-height') + 'px"></div>'));
      });
    }
    var primaryColorShade = '#836AF9', yellowColor = '#ffe800',
    successColorShade = '#28dac6', warningColorShade = '#ffe802',
    warningLightColor = '#FDAC34', infoColorShade = '#299AFF',
    greyColor = '#4F5D70', blueColor = '#2c9aff',
    blueLightColor = '#84D0FF', greyLightColor = '#EDF1F4',
    tooltipShadow = 'rgba(0, 0, 0, 0.25)', lineChartPrimary = '#666ee8',
    lineChartDanger = '#ff4961', labelColor = '#6e6b7b',
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
                id: 'y-left',
                display: true,
                position: 'left',
                scaleLabel: {
                    display: true
                },
                ticks: {
                    stepSize: yAxisMaxLeft * 100 / 5,
                    min: 0,
                    max: yAxisMaxLeft * 100,
                    fontColor: labelColor
                },
                gridLines: {
                    display: true,
                    color: grid_line_color,
                    zeroLineColor: grid_line_color
                }
              },
              {
                id: 'y-right',
                display: true,
                position: 'right',
                scaleLabel: {
                    display: true
                },
                ticks: {
                    stepSize: yAxisMaxRight * 100 / 5,
                    min: 0,
                    max: yAxisMaxRight * 100,
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
    labels: [0, 500, 1000, 1500, 2000, 2500, 3000, 3500, 4000, 4500, 5000, 5500, 6000, 6500],
    datasets: [
        {
            data: tordata,
            label: 'Torque',
            borderColor: lineChartDanger,
            // borderDash: [5],
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
            pointShadowColor: tooltipShadow,
            yAxisID: 'y-right'
        },
        {
            data: bhpdata,
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
            pointShadowColor: tooltipShadow,
            yAxisID: 'y-left'
        }
    ]
    }
});
}

  </script>
@endsection
