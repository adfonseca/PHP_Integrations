<?php  

ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

// SDK do Mercado Pago
require __DIR__ . '/../config.php';


$date_of_expiration = date('Y-m-d\TH:i:s.vP', strtotime('+2 days'));


 $payment = new MercadoPago\Payment();
 $payment->date_of_expiration =  $date_of_expiration;
 $payment->transaction_amount = ($_POST["transaction_amount"]);
 $payment->description = "Title of what you are paying for";
 $payment->payment_method_id = "bolbradesco";
 $payment->payer = array(
     "email" => ($_POST["email"]),
     "first_name" => ($_POST["first_name"]),
     "last_name" => ($_POST["last_name"]),
     "identification" => array( 
         "type" => ($_POST["docType"]),
         "number" => ($_POST["docNumber"])
      ),
     "address"=>  array(
         "zip_code" => ($_POST["zip_code"]),
         "street_name" => ($_POST["street_name"]),
         "street_number" => ($_POST["street_number"]),
         "neighborhood" => ($_POST["neighborhood"]),
         "city" => ($_POST["city"]),
         "federal_unit" => ($_POST["federal_unit"])
      )
   );

$payment->save();

// Print the payment status
//echo $payment->status; 

echo $payment->transaction_details->external_resource_url;

?>