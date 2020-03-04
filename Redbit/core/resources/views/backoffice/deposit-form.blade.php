<!doctype html>
<html>
    <head>
        <title>{{ $page_title }}</title>
    </head>
    <body  oncontextmenu="return false">
        @if($fund->payment_type == 1)
            <form action="https://secure.paypal.com/uk/cgi-bin/webscr" method="post" name="paypal" id="payform">
                <input type="hidden" name="cmd" value="_xclick" />
                <input type="hidden" name="business" value="{{ $fund->payment->val1 }}" />
                <input type="hidden" name="cbt" value="{{ $basic->title }}" />
                <input type="hidden" name="currency_code" value="USD" />
                <input type="hidden" name="quantity" value="1" />
                <input type="hidden" name="item_name" value="Add Fund to {{ $basic->title }}" />

                <!-- Custom value you want to send and process back in the IPN -->
                <input type="hidden" name="custom" value="{{ $fund->custom }}" />

                <input name="amount" type="hidden" value="{{ $fund->usd  }}">
                <input type="hidden" name="return" value="{{ route('deposit-fund') }}"/>
                <input type="hidden" name="cancel_return" value="{{ route('deposit-fund') }}" />
                <!-- Where to send the PayPal IPN to. -->
                <input type="hidden" name="notify_url" value="{{ route('paypal-ipn') }}" />
            </form>
        @elseif($fund->payment_type == 2)
            <form action="https://perfectmoney.is/api/step1.asp" method="POST" id="payform">
                <input type="hidden" name="PAYEE_ACCOUNT" value="{{ $fund->payment->val1 }}">
                <input type="hidden" name="PAYEE_NAME" value="{{ $basic->title }}">
                <input type='hidden' name='PAYMENT_ID' value='{{ $fund->custom }}'>
                <input type="hidden" name="PAYMENT_AMOUNT"  value="{{ round(($fund->usd),2)  }}">
                <input type="hidden" name="PAYMENT_UNITS" value="USD">
                <input type="hidden" name="STATUS_URL" value="{{ route('perfect-ipn') }}">
                <input type="hidden" name="PAYMENT_URL" value="{{ route('deposit-fund') }}">
                <input type="hidden" name="PAYMENT_URL_METHOD" value="GET">
                <input type="hidden" name="NOPAYMENT_URL" value="{{ route('deposit-fund') }}">
                <input type="hidden" name="NOPAYMENT_URL_METHOD" value="GET">
                <input type="hidden" name="SUGGESTED_MEMO" value="{{ $basic->title }}">
                <input type="hidden" name="BAGGAGE_FIELDS" value="IDENT"><br>
            </form>
        @elseif($fund->payment_type == 3)
            <form action="{{ route('btc-preview') }}" method="POST" id="payform">
                {{ csrf_field() }}
                <input type="hidden" name="amount" value="{{ round(($fund->usd),3)  }}">
                <input type="hidden" name="fund_id" value="{{ $fund->id }}">
                <input type="hidden" name="custom" value="{{ $fund->custom }}">
            </form>
        @elseif($fund->payment_type == 4)
            <form action="{{ route('stripe-preview') }}" method="POST" id="payform">
                {{ csrf_field() }}
                <input type="hidden" name="amount" value="{{ round(($fund->usd),2)  }}">
                <input type="hidden" name="fund_id" value="{{ $fund->id }}">
                <input type="hidden" name="custom" value="{{ $fund->custom }}">
                <input type="hidden" name="url" value="{{ route('deposit-fund') }}">
            </form>
        @elseif($fund->payment_type == 5)
            <form action="{{ route('coin.pay.preview') }}" method="POST" id="payform">
                {{ csrf_field() }}
                <input type="hidden" name="amount" value="{{ round(($fund->usd),2)  }}">
                <input type="hidden" name="fund_id" value="{{ $fund->id }}">
            </form>
        @elseif($fund->payment_type == 6)
            <form action="https://www.moneybookers.com/app/payment.pl" method="post" id="payform">
                <input name="pay_to_email" value="{{ $fund->payment->val1 }}" type="hidden">
                <input name="transaction_id" value="{{ $fund->custom }}" type="hidden">
                <input name="return_url" value="{{ route('deposit-fund') }}" type="hidden">
                <input name="return_url_text" value="Return {{ $basic->title }}" type="hidden">
                <input name="cancel_url" value="{{ route('deposit-fund') }}" type="hidden">
                <input name="status_url" value="{{ route('skrill-ipn') }}" type="hidden">
                <input name="language" value="EN" type="hidden">
                <input name="amount" value="{{ $fund->usd  }}" type="hidden">
                <input name="currency" value="USD" type="hidden">
                <input name="detail1_description" value="{{ $basic->title }}" type="hidden">
                <input name="detail1_text" value="Add Fund To {{ $basic->title }}" type="hidden">
                <input name="logo_url" value="{{ asset('assets/images/logo/logo.png') }}" type="hidden">
            </form>
        @endif

        <script type="text/javascript">
            function disableRightClick() {
                if (event.button == 2) {
                    alert('For Security Reason Right Click is Disabled')
                }
            }
            document.onmousedown = disableRightClick;
            document.getElementById("payform").submit();
        </script>
    </body>
</html>