 <?php

// SDK do Mercado Pago
require __DIR__ . '/config.php';

  $payment_id = $_POST['pagamento'];
  $payment = MercadoPago\Payment::find_by_id($payment_id);

  echo $payment->status; 


echo '<pre>';
  
print_r($payment);

?>