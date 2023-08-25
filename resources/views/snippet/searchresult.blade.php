<!doctype html>
<html data-bs-theme="light">
    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
        <script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
    </head>
    <style>
        .btn-custom {
            border-color: #{{ $color }} !important;
            background: #{{ $color }} !important;
            color: #{{ $btextcolor }} !important;
        }
        .btn-custom:hover {
            background: #{{ $color }}80 !important;
        }
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
        .bg-light-warning {
            background: rgba(255,159,67,.12)!important;
            color: #ff9f43!important;
        }
        .bg-light-info {
            background: rgba(0,207,232,.12)!important;
            color: #00cfe8!important;
        }
        .bg-light-primary {
            background: rgba(115,103,240,.12)!important;
            color: #7367f0!important;
        }
        .bg-light-danger {
            background: rgba(234,84,85,.12)!important;
            color: #ea5455!important;
        }
    </style>
    <body data-bs-theme="{{ $theme }}" style="@if($background) background: #{{ $background }}; @endif padding: {{ $py }}px {{ $px }}px">
        <div class="container-fluid py-2">
            <div class="row">
                <div class="col-12">
                      <div class="row">
                        <div class="col-md-12 col-xl-6">
                          <h4 class="card-title">
                            <img src="{{ $logofile }}" style="width: 100px; height: 100px; margin:20px; padding:0" />
                            <span style="color: #{{ $color }}">{{ $car->title }}</span>
                          </h4>
                          @if ($car->tuned_bhp_2)
                          <div class="card-body">
                            <ul class="nav nav-tabs" role="tablist">
                              <li class="nav-item">
                                <button
                                  class="nav-link active"
                                  id="home-tab"
                                  data-bs-toggle="tab"
                                  data-bs-target="#stage1"
                                  role="tab"
                                  aria-selected="true"
                                  onclick="onStage(1)"
                                  >Stage 1</button>
                              </li>
                              <li class="nav-item">
                                <button
                                  class="nav-link"
                                  id="profile-tab"
                                  data-bs-toggle="tab"
                                  data-bs-target="#stage2"
                                  role="tab"
                                  aria-selected="false"
                                  onclick="onStage(2)"
                                  >Stage 2</button>
                              </li>
                            </ul>

                            <div class="tab-content">
                              <div class="tab-pane fade show active" id="stage1" aria-labelledby="stage1-tab" role="tabpanel">
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
                                    <div class="param-item" style="background: #303030" id="cell_tuned_bhp">{{ $car->tuned_bhp }}</div>
                                  </div>
                                  <div class="col-3 param-wrapper">
                                    <div class="param-item bg-black" id="cell_diff_bhp">{{ intval($car->tuned_bhp) - intval($car->std_bhp) }} hp</div>
                                  </div>
                                  <div class="col-3 param-wrapper">
                                    <div class="param-item bg-light-danger">TORQUE</div>
                                  </div>
                                  <div class="col-3 param-wrapper">
                                    <div class="param-item bg-secondary">{{ $car->std_torque }}</div>
                                  </div>
                                  <div class="col-3 param-wrapper">
                                    <div class="param-item" style="background: #303030" id="cell_tuned_torque">{{ $car->tuned_torque }}</div>
                                  </div>
                                  <div class="col-3 param-wrapper">
                                    <div class="param-item bg-black" id="cell_diff_torque">{{ intval($car->tuned_torque) - intval($car->std_torque) }} Nm</div>
                                  </div>
                                </div>
                              </div>
                              <div class="tab-pane fade" id="stage2" aria-labelledby="stage2-tab" role="tabpanel">
                                <p>Estimated {{ round((intval($car->tuned_bhp_2) - intval($car->std_bhp)) / intval($car->std_bhp) * 100) }}% more power and
                                  {{ round((intval($car->tuned_torque_2) - intval($car->std_torque)) / intval($car->std_torque) * 100) }}% more torque.
                                </p>
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
                                    <div class="param-item" style="background: #303030" id="cell_tuned_bhp_2">{{ $car->tuned_bhp_2 }}</div>
                                  </div>
                                  <div class="col-3 param-wrapper">
                                    <div class="param-item bg-black" id="cell_diff_bhp_2">{{ intval($car->tuned_bhp_2) - intval($car->std_bhp) }} hp</div>
                                  </div>
                                  <div class="col-3 param-wrapper">
                                    <div class="param-item bg-light-danger">TORQUE</div>
                                  </div>
                                  <div class="col-3 param-wrapper">
                                    <div class="param-item bg-secondary">{{ $car->std_torque }}</div>
                                  </div>
                                  <div class="col-3 param-wrapper">
                                    <div class="param-item" style="background: #303030" id="cell_tuned_torque_2">{{ $car->tuned_torque_2 }}</div>
                                  </div>
                                  <div class="col-3 param-wrapper">
                                    <div class="param-item bg-black" id="cell_diff_torque_2">{{ intval($car->tuned_torque_2) - intval($car->std_torque) }} Nm</div>
                                  </div>
                                </div>
                                <b>Stage 2 may require hardware upgrades to achieve these figures, Contact your tuner for information.</b>
                              </div>
                            </div>
                          </div>
                          @else
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
                                <div class="param-item" style="background: #303030" id="cell_tuned_bhp">{{ $car->tuned_bhp }}</div>
                              </div>
                              <div class="col-3 param-wrapper">
                                <div class="param-item bg-black" id="cell_diff_bhp">{{ intval($car->tuned_bhp) - intval($car->std_bhp) }} hp</div>
                              </div>
                              <div class="col-3 param-wrapper">
                                <div class="param-item bg-light-danger">TORQUE</div>
                              </div>
                              <div class="col-3 param-wrapper">
                                <div class="param-item bg-secondary">{{ $car->std_torque }}</div>
                              </div>
                              <div class="col-3 param-wrapper">
                                <div class="param-item" style="background: #303030" id="cell_tuned_torque">{{ $car->tuned_torque }}</div>
                              </div>
                              <div class="col-3 param-wrapper">
                                <div class="param-item bg-black" id="cell_diff_torque">{{ intval($car->tuned_torque) - intval($car->std_torque) }} Nm</div>
                              </div>
                            </div>
                          @endif
                        </div>
                        <div class="col-md-12 col-xl-6 pt-2">
                          <canvas class="line-chart-ex chartjs" data-height="350"></canvas>
                          <p style="text-align: end; padding-right: 50px">Graph for illustration only</p>
                        </div>
                      </div>

                        <div class="row mb-2 mt-2 col-md-12 col-xl-8 ms-1">
                            {!! $body !!}
                        </div>
                </div>
              </div>
              <a class="btn btn-dark btn-custom" href="{{ route('api.snippet.show', ['id' => $id, 'theme' => $theme, 'color' => $color, 'btextcolor' => $btextcolor, 'background' => $background, 'px' => $px, 'py' => $py, 'dm' => $dm]) }}">Back to Makes</a>
              <a class="btn btn-dark btn-custom" href="{{ route('api.snippet.search', ['id' => $id,'brand' => $car->brand, 'theme' => $theme, 'color' => $color, 'btextcolor' => $btextcolor, 'background' => $background, 'px' => $px, 'py' => $py, 'dm' => $dm]) }}">Back to {{ $car->brand }}</a>
		</div>
        <input type="hidden" name="std_bhp" id="std_bhp" value="{{ intval($car->std_bhp) }}">
        <input type="hidden" name="std_torque" id="std_torque" value="{{ intval($car->std_torque) }}">
        <input type="hidden" name="tuned_bhp" id="tuned_bhp" value="{{ intval($car->tuned_bhp) }}">
        <input type="hidden" name="tuned_torque" id="tuned_torque" value="{{ intval($car->tuned_torque) }}">
        <input type="hidden" name="tuned_bhp_2" id="tuned_bhp_2" value="{{ intval($car->tuned_bhp_2) }}">
        <input type="hidden" name="tuned_torque_2" id="tuned_torque_2" value="{{ intval($car->tuned_torque_2) }}">
    </body>
    <script src="{{ asset('customjs/iframeResizer.contentWindow.min.js') }}"></script>
    <script src="{{ asset(mix('vendors/js/charts/chart.min.js')) }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <script>
        let chartStage;
        let currentStage = 1;
        let bhpdata, tordata;
        let yAxisMaxLeft, yAxisMaxRight;
        function prepareChart() {
            var stdBhp = $('#std_bhp').val();
            var stdTorque = $('#std_torque').val();
            var tunedBhp = $('#tuned_bhp').val();
            var tunedTorque = $('#tuned_torque').val();
            var tunedBhp2 = $('#tuned_bhp_2').val();
            var tunedTorque2 = $('#tuned_torque_2').val();
            bhpdata = [0, 22.85, 40, 52.85, 67.14, 77.14, 87.14, 97.14, 97.85, 100, 100, 80, 0, 0].map((v) => Math.round(v / 100 * stdBhp) );
            tordata = [0, 58.18, 87.27, 98.78, 100, 95.75, 92.27, 90.30, 87.27, 84.24, 78.78, 60, 0, 0].map((v) => Math.round(v / 100 * stdTorque));
            yAxisMaxLeft = Math.round(tunedBhp / 100) + 1;
            yAxisMaxRight = Math.round(tunedTorque / 100) + 1;

            var chartWrapper = $('.chartjs');
            var lineChartEx = $('.line-chart-ex');
            if (chartWrapper.length) {
                chartWrapper.each(function () {
                $(this).wrap($('<div style="height:' + this.getAttribute('data-height') + 'px"></div>'));
                });
            }

            if (lineChartEx.length) {
                chartStage = makeChart(lineChartEx, tunedBhp, tunedTorque)
            }
        }
        function makeChart(target, bhp, torque) {
            var bhpdata_tuned = [0, 22.85, 40, 52.85, 67.14, 77.14, 87.14, 97.14, 97.85, 100, 100, 80, 0, 0].map((v) => Math.round(v / 100 * bhp) );
            var tordata_tuned = [0, 58.18, 87.27, 98.78, 100, 95.75, 92.27, 90.30, 87.27, 84.24, 78.78, 60, 0, 0].map((v) => Math.round(v / 100 * torque));

            var primaryColorShade = '#836AF9', yellowColor = '#ffe800',
            successColorShade = '#28dac6', warningColorShade = '#ffe802',
            warningLightColor = '#FDAC34', infoColorShade = '#299AFF',
            greyColor = '#4F5D70', blueColor = '#2c9aff',
            blueLightColor = '#84D0FF', greyLightColor = '#EDF1F4',
            tooltipShadow = 'rgba(0, 0, 0, 0.25)', lineChartPrimary = '#666ee8',
            lineChartDanger = '#ff4961', labelColor = '#6e6b7b',
            grid_line_color = 'rgba(200, 200, 200, 0.2)';
            let chartObj = new Chart(target, {
                type: 'line',
                plugins: [{
                    beforeInit: function (chart) {
                            chart.legend.afterFit = function () {
                            this.height += 20;
                        };
                    }
                }],
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
                    backgroundColor: 'white',
                    titleFontColor: 'black',
                    bodyFontColor: 'black'
                },
                scales: {
                    xAxes: [{
                        display: true,
                        scaleLabel: {
                        display: true,
                            labelString: 'RPM'
                        },
                        gridLines: {
                        display: true,
                            color: grid_line_color,
                            zeroLineColor: grid_line_color
                        },
                        ticks: {
                        display: false
                        }
                    }],
                    yAxes: [{
                        id: 'y-left',
                        display: true,
                        position: 'left',
                        scaleLabel: {
                            display: true,
                            labelString: 'Power(hp)'
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
                            display: true,
                            labelString: 'Torque(Nm)'
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
                    }]
                },
                legend: {
                    position: 'top',
                    align: 'start',
                    labels: {
                        // usePointStyle: true,
                        padding: 25,
                        boxWidth: 2
                    }
                }
                },
                data: {
                labels: [0, 500, 1000, 1500, 2000, 2500, 3000, 3500, 4000, 4500, 5000, 5500, 6000, 6500],
                datasets: [{
                        data: tordata,
                        label: 'OEM Torque',
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
                        pointHoverBorderColor: 'white',
                        pointHoverBackgroundColor: lineChartDanger,
                        pointShadowOffsetX: 1,
                        pointShadowOffsetY: 1,
                        pointShadowBlur: 5,
                        pointShadowColor: tooltipShadow,
                        yAxisID: 'y-right'
                    },
                    {
                        data: bhpdata,
                        label: 'OEM Power',
                        borderColor: lineChartPrimary,
                        lineTension: 0.5,
                        pointStyle: 'circle',
                        backgroundColor: lineChartPrimary,
                        fill: false,
                        pointRadius: 1,
                        pointHoverRadius: 5,
                        pointHoverBorderWidth: 5,
                        pointBorderColor: 'transparent',
                        pointHoverBorderColor: 'white',
                        pointHoverBackgroundColor: lineChartPrimary,
                        pointShadowOffsetX: 1,
                        pointShadowOffsetY: 1,
                        pointShadowBlur: 5,
                        pointShadowColor: tooltipShadow,
                        yAxisID: 'y-left'
                    },
                    {
                        data: tordata_tuned,
                        label: 'Tuned Torque',
                        borderColor: lineChartDanger,
                        borderDash: [2],
                        lineTension: 0.5,
                        pointStyle: 'circle',
                        backgroundColor: lineChartDanger,
                        fill: false,
                        pointRadius: 1,
                        pointHoverRadius: 5,
                        pointHoverBorderWidth: 5,
                        pointBorderColor: 'transparent',
                        pointHoverBorderColor: 'white',
                        pointHoverBackgroundColor: lineChartDanger,
                        pointShadowOffsetX: 1,
                        pointShadowOffsetY: 1,
                        pointShadowBlur: 5,
                        pointShadowColor: tooltipShadow,
                        yAxisID: 'y-right'
                    },
                    {
                        data: bhpdata_tuned,
                        label: 'Tuned Power',
                        borderColor: lineChartPrimary,
                        borderDash: [2],
                        lineTension: 0.5,
                        pointStyle: 'circle',
                        backgroundColor: lineChartPrimary,
                        fill: false,
                        pointRadius: 1,
                        pointHoverRadius: 5,
                        pointHoverBorderWidth: 5,
                        pointBorderColor: 'transparent',
                        pointHoverBorderColor: 'white',
                        pointHoverBackgroundColor: lineChartPrimary,
                        pointShadowOffsetX: 1,
                        pointShadowOffsetY: 1,
                        pointShadowBlur: 5,
                        pointShadowColor: tooltipShadow,
                        yAxisID: 'y-left'
                    }]
                }
            });
            return chartObj
        }
        function onStage(stage) {
            var tunedBhp = $('#tuned_bhp').val();
            var tunedTorque = $('#tuned_torque').val();
            var tunedBhp2 = $('#tuned_bhp_2').val();
            var tunedTorque2 = $('#tuned_torque_2').val();
            var bhpdata_tuned, tordata_tuned;
            if (stage == 1) {
                bhpdata_tuned = [0, 22.85, 40, 52.85, 67.14, 77.14, 87.14, 97.14, 97.85, 100, 100, 80, 0, 0].map((v) => Math.round(v / 100 * tunedBhp) );
                tordata_tuned = [0, 58.18, 87.27, 98.78, 100, 95.75, 92.27, 90.30, 87.27, 84.24, 78.78, 60, 0, 0].map((v) => Math.round(v / 100 * tunedTorque));
            } else if (stage == 2) {
                bhpdata_tuned = [0, 22.85, 40, 52.85, 67.14, 77.14, 87.14, 97.14, 97.85, 100, 100, 80, 0, 0].map((v) => Math.round(v / 100 * tunedBhp2) );
                tordata_tuned = [0, 58.18, 87.27, 98.78, 100, 95.75, 92.27, 90.30, 87.27, 84.24, 78.78, 60, 0, 0].map((v) => Math.round(v / 100 * tunedTorque2));
            }
            chartStage.data.datasets[2].data = tordata_tuned;
            chartStage.data.datasets[3].data = bhpdata_tuned;
            chartStage.update();
            currentStage = stage
        }
        prepareChart();
    </script>
</html>
