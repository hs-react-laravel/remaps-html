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
            <h4 class="card-title">
              <img src="{{ $logofile }}" style="width: 100px; height: 100px; margin:20px; padding:0" />
              {{ $car->title }}
            </h4>
            @if ($car->tuned_bhp_2)
            <div class="card-body">
              <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                  <a
                    class="nav-link active"
                    id="home-tab"
                    data-bs-toggle="tab"
                    href="#stage1"
                    aria-controls="home"
                    role="tab"
                    aria-selected="true"
                    onClick="onStage(1)"
                    >Stage 1</a>
                </li>
                <li class="nav-item">
                  <a
                    class="nav-link"
                    id="profile-tab"
                    data-bs-toggle="tab"
                    href="#stage2"
                    aria-controls="profile"
                    role="tab"
                    aria-selected="false"
                    onClick="onStage(2)"
                    >Stage 2</a>
                </li>
              </ul>

              <div class="tab-content">
                <div class="tab-pane active" id="stage1" aria-labelledby="stage1-tab" role="tabpanel">
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
                      <div class="param-item bg-dark" id="cell_tuned_bhp">{{ $car->tuned_bhp }}</div>
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
                      <div class="param-item bg-dark" id="cell_tuned_torque">{{ $car->tuned_torque }}</div>
                    </div>
                    <div class="col-3 param-wrapper">
                      <div class="param-item bg-black" id="cell_diff_torque">{{ intval($car->tuned_torque) - intval($car->std_torque) }} Nm</div>
                    </div>
                  </div>
                </div>
                <div class="tab-pane" id="stage2" aria-labelledby="stage2-tab" role="tabpanel">
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
                      <div class="param-item bg-dark" id="cell_tuned_bhp_2">{{ $car->tuned_bhp_2 }}</div>
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
                      <div class="param-item bg-dark" id="cell_tuned_torque_2">{{ $car->tuned_torque_2 }}</div>
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
                  <div class="param-item bg-dark" id="cell_tuned_bhp">{{ $car->tuned_bhp }}</div>
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
                  <div class="param-item bg-dark" id="cell_tuned_torque">{{ $car->tuned_torque }}</div>
                </div>
                <div class="col-3 param-wrapper">
                  <div class="param-item bg-black" id="cell_diff_torque">{{ intval($car->tuned_torque) - intval($car->std_torque) }} Nm</div>
                </div>
              </div>
            @endif
          </div>
          <div class="col-md-12 col-xl-6">
            <canvas class="line-chart-ex chartjs" data-height="350"></canvas>
            <p style="text-align: end; padding-right: 50px">Graph for illustration only</p>
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
          @if(isset($make))
            <div class="card col-md-6 col-lg-3">
              <a class="btn btn-dark" href="{{ Auth::guard('customer')->check() ? route('cars.category') : route('admin.cars.category') }}">Overview</a>
            </div>
          @endif
          @if(isset($model))
            <div class="card col-md-6 col-lg-3">
              <a class="btn btn-dark" href="{{ (Auth::guard('customer')->check() ? route('cars.category') : route('admin.cars.category')).'?make='.$make }}">
                Back to {{ $make }}
              </a>
            </div>
          @endif
          @if(isset($generation))
            <div class="card col-md-6 col-lg-3">
              <a class="btn btn-dark" href="{{ (Auth::guard('customer')->check() ? route('cars.category') : route('admin.cars.category')).'?make='.$make.'&model='.$model }}">
                Back to {{ $model }}
              </a>
            </div>
          @endif
          @if(isset($engine))
            <div class="card col-md-6 col-lg-3">
              <a class="btn btn-dark" href="{{ (Auth::guard('customer')->check() ? route('cars.category') : route('admin.cars.category')).'?make='.$make.'&model='.$model.'&generation='.$generation }}">
                Back to {{ $generation }}
              </a>
            </div>
          @endif
        </div>
        @if(isset($engine))
        <div class="row">
          <div class="card col-md-6 col-lg-3">
            <a class="btn btn-primary" onclick="onPrint()">Print</a>
          </div>
          <div class="card col-md-6 col-lg-3">
            <a class="btn btn-primary" onclick="onModifyParam()">Modify Params</a>
          </div>
        </div>
        @endif
      </div>
    </div>
  </div>
</div>
@if (isset($car))
<form id="form_print" action="{{ route('cars.print') }}" method="POST">
    @csrf
    <input type="hidden" name="company_id" id="company_id" value="{{ $company->id }}">
    <input type="hidden" name="user_id" id="user_id" value="{{ $user->id }}">
    <input type="hidden" name="car_id" id="car_id" value="{{ $car->id }}" />
    <input type="hidden" name="stage" id="stage" />
    <input type="hidden" name="blob" id="blob" />
    <input type="hidden" name="vehicle_reg" id="vehicle_reg">
    <input type="hidden" name="std_bhp" id="std_bhp" value="{{ intval($car->std_bhp) }}">
    <input type="hidden" name="std_torque" id="std_torque" value="{{ intval($car->std_torque) }}">
    <input type="hidden" name="tuned_bhp" id="tuned_bhp" value="{{ intval($car->tuned_bhp) }}">
    <input type="hidden" name="tuned_torque" id="tuned_torque" value="{{ intval($car->tuned_torque) }}">
    <input type="hidden" name="tuned_bhp_2" id="tuned_bhp_2" value="{{ intval($car->tuned_bhp_2) }}">
    <input type="hidden" name="tuned_torque_2" id="tuned_torque_2" value="{{ intval($car->tuned_torque_2) }}">
</form>
@endif
@endsection

@section('vendor-script')
  <!-- vendor files -->
  <script src="{{ asset(mix('vendors/js/charts/chart.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
@endsection
@section('page-script')
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
            backgroundColor: window.colors.solid.white,
            titleFontColor: window.colors.solid.black,
            bodyFontColor: window.colors.solid.black
          },
          scales: {
            xAxes: [
              {
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
              }
            ],
            yAxes: [
              {
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
              }
            ]
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
          datasets: [
            {
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
              pointHoverBorderColor: window.colors.solid.white,
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
              pointHoverBorderColor: window.colors.solid.white,
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
    async function onPrint() {
      const { value } = await Swal.fire({
        title: 'Enter your vehicle reg',
        input: 'text'
      })
      let base64Img = chartStage.toBase64Image();
      $('#stage').val(currentStage)
      $('#blob').val(base64Img)
      $('#vehicle_reg').val(value)
      $('#form_print').submit()
    }
    async function onModifyParam() {
      var stdBhp = $('#std_bhp').val();
      var stdTorque = $('#std_torque').val();
      var tunedBhp = $('#tuned_bhp').val();
      var tunedTorque = $('#tuned_torque').val();
      var tunedBhp2 = $('#tuned_bhp_2').val();
      var tunedTorque2 = $('#tuned_torque_2').val();
      var placeholder1 = currentStage == 1 ? tunedBhp : tunedBhp2
      var placeholder2 = currentStage == 1 ? tunedTorque: tunedTorque2
      const { value: formValues } = await Swal.fire({
        title: 'Modify Parameters',
        html:
          `<div style="display: flex; align-items: center">
            <label for="swal-input1" style="margin-top: 20px; width: 120px">Tuned BHP</label>
            <input id="swal-input1" type="number" class="swal2-input" value="${placeholder1}">
          </div>
          <div style="display: flex; align-items: center">
            <label for="swal-input2" style="margin-top: 20px; width: 120px">Tuned Torque</label>
            <input id="swal-input2" type="number" class="swal2-input" value="${placeholder2}">
          </div>`,
        focusConfirm: false,
        preConfirm: () => {
          return [
            document.getElementById('swal-input1').value,
            document.getElementById('swal-input2').value
          ]
        }
      })
      let bhpdata_tuned, tordata_tuned
      if (currentStage == 1) {
        $('#tuned_bhp').val(formValues[0])
        $('#tuned_torque').val(formValues[1])
        $('#cell_tuned_bhp').html(`${formValues[0]} hp`)
        $('#cell_diff_bhp').html(`${formValues[0] - stdBhp} hp`)
        $('#cell_tuned_torque').html(`${formValues[1]} Nm`)
        $('#cell_diff_torque').html(`${formValues[1] - stdTorque} Nm`)
        bhpdata_tuned = [0, 22.85, 40, 52.85, 67.14, 77.14, 87.14, 97.14, 97.85, 100, 100, 80, 0, 0].map((v) => Math.round(v / 100 * formValues[0]) );
        tordata_tuned = [0, 58.18, 87.27, 98.78, 100, 95.75, 92.27, 90.30, 87.27, 84.24, 78.78, 60, 0, 0].map((v) => Math.round(v / 100 * formValues[1]));
      } else if (currentStage == 2) {
        $('#tuned_bhp_2').val(formValues[0]),
        $('#tuned_torque_2').val(formValues[1])
        $('#cell_tuned_bhp_2').html(`${formValues[0]} hp`)
        $('#cell_diff_bhp_2').html(`${formValues[0] - stdBhp} hp`)
        $('#cell_tuned_torque_2').html(`${formValues[1]} Nm`)
        $('#cell_diff_torque_2').html(`${formValues[1] - stdTorque} Nm`)
        bhpdata_tuned = [0, 22.85, 40, 52.85, 67.14, 77.14, 87.14, 97.14, 97.85, 100, 100, 80, 0, 0].map((v) => Math.round(v / 100 * formValues[0]) );
        tordata_tuned = [0, 58.18, 87.27, 98.78, 100, 95.75, 92.27, 90.30, 87.27, 84.24, 78.78, 60, 0, 0].map((v) => Math.round(v / 100 * formValues[1]));
      }
      chartStage.data.datasets[2].data = tordata_tuned;
      chartStage.data.datasets[3].data = bhpdata_tuned;
      chartStage.update();
    }
    prepareChart();
</script>
@endsection
