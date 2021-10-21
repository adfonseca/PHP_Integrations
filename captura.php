 <?php
// SDK de Mercado Pago

ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

require __DIR__ .  '/vendor/autoload.php';

// Agrega credenciales
MercadoPago\SDK::setAccessToken('APP_USR-898927286144250-030413-e88cc9d78541b922a63f1752e9f7693d-532818805');

  $payment_id = $_POST['pagamento'];
  $payment = MercadoPago\Payment::find_by_id($payment_id);
  //$payment->transaction_amount = 5;
  $payment->capture = true;
  $payment->update();

//echo '<pre>';
  
//print_r($payment);

  echo $payment->status; 

?>