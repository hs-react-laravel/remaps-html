<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Invoice</title>
</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
      <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td valign="top">
            @if($company->logo)
              <img src="{{ Storage::disk('azure')->url($company->logo) }}" alt="" style="width:280px" />
            @endif
          </td>
          <td align="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
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
            </table></td>
            <td valign="top">
              <table width="80%" border="0" align="right" cellpadding="0" cellspacing="0">
                @if($company->vat_number != null)
                  <tr>
                    <td style="font-family:Arial, Helvetica, sans-serif; font-size:15px; height:22px; color:#575757; text-align: right; "><strong>VAT</strong></td>
                    </tr>
                    <tr>
                      <td style="font-family:Arial, Helvetica, sans-serif; font-size:13px; height:22px; color:#575757; text-align: right; ">{{ $company->vat_number }}</td>
                    </tr>
                @endif
              </table>
            </td>
          </tr>
        <tr>
          <td valign="top">&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          </tr>
        <tr>
          <td valign="top">&nbsp;</td>
          <td>&nbsp;</td>

      <td style="color:#cccccc; font-size:50px; font-family:Arial, Helvetica, sans-serif; text-align:right">Invoice</td>

          </tr>
        <tr>
          <td valign="top">&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          </tr>
        <tr>
          <td valign="top">&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          </tr>
        <tr>
          <td valign="top">&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          </tr>
        <tr>
          <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td style="font-size:16px; font-family:Arial, Helvetica, sans-serif;"><strong>CUSTOMER</strong></td>
              </tr>
            <tr>
              <td height="5"></td>
              </tr>
            <tr>
                <td style="font-size:15px; font-family:Arial, Helvetica, sans-serif; height:22px">
                  {{ $me->business_name }}
                </td>
            </tr>
            <tr>
              <td style="font-size:15px; font-family:Arial, Helvetica, sans-serif; height:22px">
                  {{ $me->address_line_1 }}
              </td>
            </tr>
            <tr>
              <td style="font-size:15px; font-family:Arial, Helvetica, sans-serif; height:22px">
                  {{ $me->town }}
              </td>
            </tr>
            <tr>
              <td style="font-size:15px; font-family:Arial, Helvetica, sans-serif; height:22px">
                  {{ $me->county }}
              </td>
            </tr>

            @if($myCompany->vat_number != null)
            <tr>
              <td style="font-size:15px; font-family:Arial, Helvetica, sans-serif;height:22px">
                VAT: {{ $myCompany->vat_number }}
              </td>
            </tr>
            @endif
            <tr>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
            </tr>
            </table></td>
          <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td style="font-size:16px; font-family:Arial, Helvetica, sans-serif;"><strong>PAYMENT DATE</strong></td>
              </tr>
            <tr>
              <td height="5"></td>
              </tr>
            <tr>
                <td style="font-size:17px; font-family:Arial, Helvetica, sans-serif; height:22px">
                    {{ $subscription_payment->created_at }}
                </td>
              </tr>
            <tr>
              <td style="font-size:15px; font-family:Arial, Helvetica, sans-serif; height:22px">&nbsp;</td>
              </tr>
            <tr>
              <td style="font-size:16px; font-family:Arial, Helvetica, sans-serif;">&nbsp;</td>
              </tr>
            <tr>
              <td height="5"></td>
              </tr>
            <tr>
              <td style="font-size:17px; font-family:Arial, Helvetica, sans-serif; height:22px">
                  &nbsp;
              </td>
            </tr>
            <tr>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
            </tr>
            </table></td>
          <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td align="right" style="font-size:16px; font-family:Arial, Helvetica, sans-serif;"><strong>INVOICE DATE</strong></td>
              </tr>
            <tr>
              <td height="5" align="right"></td>
              </tr>
            <tr>
              <td align="right" style="font-size:17px; font-family:Arial, Helvetica, sans-serif; height:22px">{{ $subscription_payment->created_at }}</td>
              </tr>
            <tr>
              <td align="right" style="font-size:15px; font-family:Arial, Helvetica, sans-serif; height:22px">&nbsp;</td>
              </tr>
            <tr>
              <td align="right" style="font-size:16px; font-family:Arial, Helvetica, sans-serif;"><strong>PAY TXN NUMBER</strong></td>
              </tr>
            <tr>
              <td height="5" align="right"></td>
              </tr>
            <tr>
              <td align="right" style="font-size:17px; font-family:Arial, Helvetica, sans-serif; height:22px">{{ $subscription_payment->pay_txn_id }} </td>
              </tr>
            <tr>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
            </tr>

            </table></td>
          </tr>
      </table></td>
      </tr>
    <tr>
      <td>&nbsp;</td>
      </tr>
   <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="26%" style="font-size:17px; font-family:Arial, Helvetica, sans-serif; height:25px; background:#e4e4e4; padding:10px"><strong>Last Payment Date</strong></td>
        <td width="26%" align="left" style="font-size:17px; font-family:Arial, Helvetica, sans-serif; height:25px; background:#e4e4e4; padding:10px"><strong>Next Payment Date</strong></td>
        <td width="31%" align="left" style="font-size:17px; font-family:Arial, Helvetica, sans-serif; height:25px; background:#e4e4e4; padding:10px"><strong>Last Payment Amount</strong></td>
        <td width="17%" align="right" style="font-size:17px; font-family:Arial, Helvetica, sans-serif; height:25px; background:#e4e4e4; padding:10px"><strong>Payment Failed Count</strong></td>
      </tr>
      <tr>
        <td style="font-size:17px; font-family:Arial, Helvetica, sans-serif; height:25px;padding:10px; border-bottom:solid 2px #aaaaaa">{{ $subscription_payment->last_payment_date }}</td>
        <td align="left" style="font-size:17px; font-family:Arial, Helvetica, sans-serif; height:25px;padding:10px; border-bottom:solid 2px #aaaaaa">{{ $subscription_payment->next_billing_date }}</td>
        <td align="left" style="font-size:17px; font-family:Arial, Helvetica, sans-serif; height:25px; padding:10px; border-bottom:solid 2px #aaaaaa"> {{ $subscription_payment->last_payment_amount}}</td>
        <td align="right" style="font-size:17px; font-family:Arial, Helvetica, sans-serif; height:25px; padding:10px; border-bottom:solid 2px #aaaaaa">{{ $subscription_payment->failed_payment_count }}</td>
      </tr>
    </table></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td style="font-size:16px; font-family:Arial, Helvetica, sans-serif; height:22px">
        <strong>{{ $paymentReasonMsg }}</strong>
        <br>
        <strong>{{ $paymentAmount }} GBP</strong>
      </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
  </table>

</body>
</html>
