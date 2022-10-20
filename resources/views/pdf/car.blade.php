<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Car</title>
</head>
@php
    $logofile = str_replace(" ", "-", strtolower($car->brand));
    $logofile = asset('images/carlogo/'.$logofile.'.jpg');
@endphp
<body>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-bottom: 2px solid black">
        <tr>
            <td align="top">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                    <td style="font-family:Arial, Helvetica, sans-serif; font-size:15px; height:22px; color:#575757; "><strong>{{ $company->name }}</strong></td>
                    </tr>
                    <tr>
                    <td style="font-family:Arial, Helvetica, sans-serif; font-size:13px; height:22px; color:#575757; ">{{ $company->address_line_1 }}</td>
                    </tr>
                    @if($company->address_line_2 != null)
                    <tr>
                    <td style="font-family:Arial, Helvetica, sans-serif; font-size:13px; height:22px; color:#575757; ">{{ $company->address_line_2 }}</td>
                    </tr>
                    @endif
                    @if($company->country != null)
                    <tr>
                    <td style="font-family:Arial, Helvetica, sans-serif; font-size:13px; height:22px; color:#575757; ">{{ $company->country }}</td>
                    </tr>
                    @endif
                    <tr>
                    <td style="font-family:Arial, Helvetica, sans-serif; font-size:13px; height:22px; color:#575757; "><a href="mailto:{{ $company->support_email_address }}">{{ $company->support_email_address }}</a></td>
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
            <td align="right">
                <p>Date: {{ \Carbon\Carbon::now()->format('d M Y h:i A') }}</p>
                <p>Vehicle reg: 12345</p>
            </td>
        </tr>
    </table>
</body>
</html>
