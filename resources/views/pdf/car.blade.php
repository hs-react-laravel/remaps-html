<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Car</title>
</head>
@php
    $logofile = str_replace(" ", "-", strtolower($car->brand));
    $logofile = asset('images/carlogo/'.$logofile.'.jpg');

    $graphfile = asset('storage/uploads/graph/'.$car->id.'-'.$stage.'.png');
@endphp
<body>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-bottom: 2px solid black">
        <tr>
            <td align="top">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                    <td style="font-family:Arial, Helvetica, sans-serif; font-size:15px; height:18px; color:#575757; "><strong>{{ $user->is_admin ? $company->name : $user->business_name }}</strong></td>
                    </tr>
                    <tr>
                    <td style="font-family:Arial, Helvetica, sans-serif; font-size:13px; height:18px; color:#575757; ">{{ $user->is_admin ? $company->address_line_1 : $user->address_line_1 }}</td>
                    </tr>
                    @if($company->address_line_2 != null)
                    <tr>
                    <td style="font-family:Arial, Helvetica, sans-serif; font-size:13px; height:18px; color:#575757; ">{{ $user->is_admin ? $company->address_line_2 : $company->address_line_1 }}</td>
                    </tr>
                    @endif
                    @if($company->country != null)
                    <tr>
                    <td style="font-family:Arial, Helvetica, sans-serif; font-size:13px; height:18px; color:#575757; ">{{ $user->is_admin ? $company->country : $user->county }}</td>
                    </tr>
                    @endif
                    <tr>
                    <td style="font-family:Arial, Helvetica, sans-serif; font-size:13px; height:18px; color:#575757; ">
                        <a href="mailto:{{ $user->is_admin ? $company->support_email_address : $user->email }}">
                            {{ $user->is_admin ? $company->support_email_address : $user->email }}
                        </a>
                    </td>
                    </tr>
                    <tr><td style="height: 10px"></td></tr>
                </table>
            </td>
            <td valign="top" style="text-align: right">
                @if($user->logo)
                    <img src="{{ asset('storage/uploads/logo/'.$user->logo) }}" alt="" style="width:280px" />
                @else
                    <img src="{{ asset('storage/uploads/logo/'.$company->logo) }}" alt="" style="width:280px" />
                @endif
            </td>
        </tr>
    </table>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td style="width: 100px">
                <img src="{{ $logofile }}" alt="" style="width:100px" />
            </td>
            <td align="left" style="font-family:Arial, Helvetica, sans-serif; font-size:16px; height:22px; color:#575757;">
                {{ $car->brand }} {{ $car->model }} {{ $car->year }} {{ $car->engine_type }}
            </td>
            <td align="right" style="font-family:Arial, Helvetica, sans-serif; font-size:16px; color:#575757;">
                <p>Date: {{ \Carbon\Carbon::now()->format('d M Y h:i A') }}</p>
                <p>Vehicle reg: {{ $vehicle }}</p>
            </td>
        </tr>
    </table>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr><td><img src="{{ $graphfile }}" alt="" style="height: 350px; width: 650px; margin-left: 30px" /></td></tr>
        <tr style="font-family:Arial, Helvetica, sans-serif; font-size:16px; color:#575757;">
            <td align="right">
                Graph for illustration only
            </td>
        </tr>
    </table>
    @if ($car->tuned_bhp_2)
    <table style="width: 170px" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td style="width: 85px; height: 30px; color:#575757; @if($stage == 1) border-bottom: 3px solid #575757 @endif">
                <div style="width: 85px; height: 38px; text-align:center; line-height: 30px">Stage 1</div>
            </td>
            <td style="width: 85px; height: 30px; color:#575757; @if($stage == 2) border-bottom: 3px solid #575757 @endif">
                <div style="width: 85px; height: 38px; text-align:center; line-height: 30px">Stage 2</div>
            </td>
        </tr>
    </table>
    @endif
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <p style="font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#575757;">
                @if($stage == 1)
                Estimated {{ round((intval($tuned_bhp) - intval($std_bhp)) / intval($std_bhp) * 100) }}% more power and
                {{ round((intval($tuned_torque) - intval($std_torque)) / intval($std_torque) * 100) }}% more torque
                @elseif ($stage == 2)
                Estimated {{ round((intval($tuned_bhp_2) - intval($std_bhp)) / intval($std_bhp) * 100) }}% more power and
                {{ round((intval($tuned_torque_2) - intval($std_torque)) / intval($std_torque) * 100) }}% more torque.
                @endif
            </p>
        </tr>
    </table>
    <table style="width: 720px; font-family:Arial, Helvetica, sans-serif;" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td>
                <div style="background: #ff9f431f; height: 35px; margin: 3px; color: #ff9f43; text-align: center; line-height: 30px; font-size: 14px">
                    Parameter
                </div>
            </td>
            <td>
                <div style="background: #00cfe81f; height: 35px; margin: 3px; color: #00cfe8; text-align: center; line-height: 30px; font-size: 14px; text-transform: uppercase">
                    Standard
                </div>
            </td>
            <td>
                <div style="background: #00cfe81f; height: 35px; margin: 3px; color: #00cfe8; text-align: center; line-height: 30px; font-size: 14px; text-transform: uppercase">
                    Chiptuning
                </div>
            </td>
            <td>
                <div style="background: #00cfe81f; height: 35px; margin: 3px; color: #00cfe8; text-align: center; line-height: 30px; font-size: 14px; text-transform: uppercase">
                    Difference
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div style="background: #7367f01f; height: 35px; margin: 3px; color: #7367f0; text-align: center; line-height: 30px; font-size: 14px; text-transform: uppercase">
                    BHP
                </div>
            </td>
            <td>
                <div style="background: #82868b; height: 35px; margin: 3px; color: #fff; text-align: center; line-height: 30px; font-size: 14px">
                    {{ $std_bhp }} hp
                </div>
            </td>
            <td>
                <div style="background: #4b4b4b; height: 35px; margin: 3px; color: #fff; text-align: center; line-height: 30px; font-size: 14px">
                    {{ $stage == 1 ? $tuned_bhp : $tuned_bhp_2 }} hp
                </div>
            </td>
            <td>
                <div style="background: #000; height: 35px; margin: 3px; color: #fff; text-align: center; line-height: 30px; font-size: 14px">
                    {{ intval($stage == 1 ? $tuned_bhp : $tuned_bhp_2) - intval($std_bhp) }} hp
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div style="background: #ea54551f; height: 35px; margin: 3px; color: #ea5455; text-align: center; line-height: 30px; font-size: 14px; text-transform: uppercase">
                    Torque
                </div>
            </td>
            <td>
                <div style="background: #82868b; height: 35px; margin: 3px; color: #fff; text-align: center; line-height: 30px; font-size: 14px">
                    {{ $std_torque }} Nm
                </div>
            </td>
            <td>
                <div style="background: #4b4b4b; height: 35px; margin: 3px; color: #fff; text-align: center; line-height: 30px; font-size: 14px">
                    {{ $stage == 1 ? $tuned_torque : $tuned_torque_2 }} Nm
                </div>
            </td>
            <td>
                <div style="background: #000; height: 35px; margin: 3px; color: #fff; text-align: center; line-height: 30px; font-size: 14px">
                    {{ intval($stage == 1 ? $tuned_torque : $tuned_torque_2) - intval($car->std_torque) }} Nm
                </div>
            </td>
        </tr>
    </table>
    @if ($stage == 2)
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr style="font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#575757;">
            <b>Stage 2 may require hardware upgrades to achieve these figures, Contact your tuner for information.</b>
        </tr>
    </table>
    @endif
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td>
            <p style="font-family:Arial, Helvetica, sans-serif; font-size:15px; color:#575757;">
                The development of each {{ $car->title }} tuning file is the result of perfection and dedication by {{ $user->is_admin ? $company->name : $user->business_name }} programmers.
                The organization only uses the latest technologies and has many years experience in ECU remapping software.
                Many (chiptuning) organizations around the globe download their tuning files for {{ $car->title }} at {{ $user->is_admin ? $company->name : $user->business_name }} for the best possible result.
                All {{ $car->title }} tuning files deliver the best possible performance and results within the safety margins.
            </p>
            <ul style="font-family:Arial, Helvetica, sans-serif; font-size:15px; color:#575757;">
                <li>100% custom made tuning file guarantee</li>
                <li>Tested and developed via a 4x4 Dynometer</li>
                <li>Best possible performance and results, within the safety margins</li>
                <li>Reduced fuel consumption</li>
            </ul>
            </td>
        </tr>
    </table>
</body>
</html>
