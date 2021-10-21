 <?php
// SDK de Mercado Pago
require __DIR__ . '/../config.php';

    // Crea un objeto de preferencia
$preference = new MercadoPago\Preference();

$item = new MercadoPago\Item();
$item->title = "Teste Cow MKT";
$item->quantity = 1;
$item->currency_id = "BRL";
$item->unit_price = 17;

$payer = new MercadoPago\Payer();
$payer->email = "test_user_70028570@testuser.com";

$preference->items = array($item);
$preference->payer = $payer;
$preference->marketplace_fee = 2.50;
$preference->notification_url = "https://IXexamplesPHP-dx979308.codeanyapp.com/notificationwooks.php";


$preference->save();

?>

<!DOCTYPE html>

<html>

  <head>
    <title>Pagar</title>
  </head>


<body>

 <form action="." method="POST">
  <script
   src="https://www.mercadopago.com.br/integrations/v1/web-payment-checkout.js"
   data-preference-id="<?php echo $preference->id; ?>">
  </script>
 </form>

</body>

</html>