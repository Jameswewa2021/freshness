<?php 
session_start();

require "init.php";


$basicInfo = $coin->GetBasicProfile();
$username = $basicInfo['result']['public_name'];

echo $username;



$amount = $_POST['amount'];
echo $amount."<br>";
$email = $_SESSION['em'];
echo $email;


switch ($amount) {
    case '50':
        $plan="1";
        break;
    case '100':
        $plan="2";
        break; 
    case '200':
        $plan="3";
        break; 
    case '500':
        $plan="4";
        break;
    case '1000':
        $plan="5";
        break;
    case '5000':
        $plan="6";
        break;
    case '10000':
        $plan="7";
        break;
    case '15000':
        $plan="8";
        break;
    case '25000':
        $plan="9";
        break;                                  
    default:
        # code...
        break;
}

echo "<br>".$plan;




$scurrency = "USD";
$rcurrency = "BTC";

$request = [
    'amount' => $amount,
    'currency1' => $scurrency,
    'currency2' => $rcurrency,
    'buyer_email' => $email,
    'item' => "Buying packages",
    'address' => "",
    'ipn_url' => "https://www.blueforexlimited.com/core/webhook.php"
];

$result = $coin->CreateTransaction($request);
// var_dump($result);
if ($result['error'] == "ok") {
    $payment = new Payment;
    $payment->email = $email;
    $payment->plans= $plan;
    $payment->entered_amount = $amount;
    $payment->amount = $result['result']['amount'];
    $payment->from_currency = $scurrency;
    $payment->to_currency = $rcurrency;
    $payment->status = "initialized";
    $payment->gateway_id = $result['result']['txn_id'];
    $payment->gateway_url = $result['result']['status_url'];
    $payment->save();
} else {
    print 'Error: ' . $result['error'] . "\n";
    die();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Accept Cryptocurrency</title>
<link rel="stylesheet" type="text/css" href="bulma.css">
    <style>
        canvas {
            background-image: url("/images/bg.jpeg");
            background-repeat: no-repeat;
            background-size: 100% 100%;
            position: fixed;
            display: block;
            top: 0;
            left: 0;
            z-index: 0;
        }
    </style>
    <script>
        particlesJS.load("particles-js", "json/particles.json", function() {
            console.log("particles loaded");
        });
    </script>
</head>
<body>
<div align="center" style="width:100%;">
    <div style="margin:auto;display: inline-block;" class="box">
                 <div class="panel-heading">
                    <h1 class="title is-1">Pay with cryptocurrency</h1>
                    <p style="font-style: italic;">to <b><?php echo $username; ?></b></p>
                </div>
                <hr>
                <form>
                    <label for="amount">Amount (<?php echo $rcurrency; ?>)</label>
                    <h1><?php echo $result['result']['amount'] ?> <?php echo $rcurrency ?></h1>
                    <hr>
                    <a href="<?php echo $result['result']['status_url'] ?>" class="button is-info is-fullwidth">Pay Now</a>
                </form>       
    </div>    
</div>

    


   
</body>
</html>