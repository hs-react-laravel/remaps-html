@extends('Frontend.layouts.master')
@section('title')
    Home
@endsection

@section('css')
<style>
  .ratings {
    position: relative;
    vertical-align: middle;
    display: inline-block;
    color: #b1b1b1;
    overflow: hidden;
  }

  .full-stars{
    position: absolute;
    left: 0;
    top: 0;
    white-space: nowrap;
    overflow: hidden;
    color: #fde16d;
  }

  .empty-stars:before,
  .full-stars:before {
    content: "\2605\2605\2605\2605\2605";
    font-size: 14pt;
  }

  .empty-stars:before {
    -webkit-text-stroke: 1px #848484;
  }

  .full-stars:before {
    -webkit-text-stroke: 1px orange;
  }

  /* Webkit-text-stroke is not supported on firefox or IE */
  /* Firefox */
  @-moz-document url-prefix() {
    .full-stars{
      color: #ECBE24;
    }
  }
  /* IE */
</style>

@endsection

@section('content')
<section id="intro" class="section intro">
  <div style="height: 72px"></div>
  <div class="container">
    <div class="row">
      <div class="col-md-1"></div>
      <div class="col-md-10 text-center">
        <h3>Compare Prices</h3>
        <p>Looking for a High Quality Remapping file supplier? Look no further. Whether you need a Stage 1, EGR Delete or even a DPF off, simply browse the selected companies below. The more info button also shows basic information about the capabilities of each company. Once you have chosen, click visit to work with your selected company.</p> 
        <h3>Simple - Smart - Fast</h3>
      </div>
    </div>
  </div>
</section>

<div class="client-table-outer" style="padding-top: 40px">
  <div class="container">
    <div class="client-table">
      <div class="table-responsive">
        <table class="table table-bordered text-center" style="color:white;">
          <tr>
            <th class="text-center">Name</th>
            <th class="text-center">Logo</th>
            <th class="text-center">Tuning Credits</th>
            <th class="text-center">
              Rating
              @php
                $url = "compare-prices?keyword=rating&sort=ASC" ;
              @endphp
            </th>
            <th class="text-center">Visit</th>
          </tr>

          @php
              $i=1;

          @endphp
          @foreach($companies as $val)
            @php
              $childTable = $val['tuning_credit_groups'];
              $j =0;
              $datas =[];
              foreach($childTable as $childs):
                foreach($childs['tuning_credit_tires'] as $pivot){
                  if($childs['set_default_tier'] ==1){

                    $datas[$j] = array(
                      'from_credit'=>$pivot['pivot']['from_credit'],
                      'for_credit'=>$pivot['pivot']['for_credit'],
                      'amount'=>$pivot['amount']
                    );

                    $j++;
                  }
                }
              endforeach;
          $from = $for ='';
          if(!empty($datas)){
              $maxAmount = max(array_column($datas, 'amount'));
              $minAmount = min(array_column($datas, 'amount'));

              foreach($datas as $vals){
                if($vals['amount'] == $minAmount){
                  $from =  min($vals['from_credit'],$vals['for_credit']);
                  $from = $minAmount == 0 ? 0 : $from/$minAmount;
                }
                if($vals['amount'] == $maxAmount){
                  $for =  min($vals['from_credit'],$vals['for_credit']);
                  $for = $maxAmount == 0 ? 0 :$for/$maxAmount;
                }
              }
          }
              /*
                $max1 = max(array_column($datas, 'from_credit'));
                $max = $max2 = max(array_column($datas, 'for_credit'));
                if($max1 >$max2){
                  $max = $max1;
                }

                $min1 = min(array_column($datas, 'from_credit'));
                $min = $min2 = min(array_column($datas, 'for_credit'));
              */
          @endphp
              <?php
                /*if($min1 <= $min2):
                  $min = $min1;
                endif;*/
              ?>
              @php
                $logo = Storage::disk('azure')->url($val['logo']);
                $link =$val['v2_domain_link'];
              @endphp
              <tr>
                <td class="">
                    @php echo $val['name'] @endphp
                </td>
                <td>

                  <div class="clt-lg">
                    <a href="@php echo $link @endphp" target="_blank">
                      <img src="{{ URL::asset("$logo") }}" alt="logo" class="tbl-logo" style="width: 128px">
                    </a>
                  </div>

                </td>
                <td>
                  @php
                    if(!empty($from)){
                      $max = round(max($from,$for));
                      $min = round(min($from,$for));
                      echo 'from  £'.$min.' to  £'.$max;
                    }else{
                      echo '-';
                    }
                  @endphp
                </td>
                <!------<td>2019 - 2020</td>------->
                                  @php
                                      $id = $val['id'];
                                      $name = $val['name'];
                                      $addressLine1 = $val['address_line_1'];
                                      $country = $val['country'];
                                      $state = $val['state'];
                                      $town = $val['town'];

                                      $rating = $val['rating'];
                                      $ratings = $val['rating']*20;
                                      $email = $val['support_email_address'];
                                      $moreinfo = $val['more_info'];
                                  @endphp
                <td>
                  <div class="rating-box">
                    <div class="ratings">
                        <div class="empty-stars"></div>
                        <div class="full-stars" style="width:@php echo $ratings.'%'; @endphp"></div>
                    </div>
                    <!----
                    @for($i=1;$i<=5;$i++)

                      @php
                        if($i <= $rating){
                      @endphp
                          <span class="fa fa-star checked"></span>
                      @php
                        }else{
                      @endphp
                          <span class="fa fa-star"></span>
                      @php
                        }
                      @endphp
                    @endfor
                    ----->
                  </div>
                </td>

                <td>
                  <div class="clt-lg client-table">
                      <center>
                        <a class="more-btn" href="@php echo $link @endphp" target="_blank">
                        Visit
                        </a>
                      </center>
                  </div>
                </td>
              </tr>
          @php $i++; @endphp
          @endforeach
        </table>
      </div>
    </div>
  </div> <!-- End Container -->
</div> <!-- End Client Table Outer -->
@endsection
