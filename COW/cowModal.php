<?php
// SDK de Mercado Pago
require __DIR__ . '/../config_prod.php';

// Cria um objeto preferencia
$preference = new MercadoPago\Preference();

// Cria um item na preferencia
$item = new MercadoPago\Item();
$item->title = 'Prod1';
$item->quantity = 1;
$item->unit_price = 15.00;

$preference->items = array($item);
// $preference->purpose = "wallet_purchase"; wallet_button

// $payer = new MercadoPago\Payer();
//  $payer->email = "test_user_22515001@testuser.com";
//   $payer->name = "Nome";
//   $payer->surname = "Sobrenome";
//   $payer->date_created = "2018-06-02T12:58:41.425-04:00";
//   $payer->phone = array(
//     "area_code" => "11",
//     "number" => "4444-4444"
//   );
    
//   $payer->identification = array(
//     "type" => "CPF",
//     "number" => "19119119100"
//   );
    
//   $payer->address = array(
//     "street_name" => "Street",
//     "street_number" => 123,
//     "zip_code" => "06233200"
//   );

// $preference->payer = $payer;
$preference->external_reference = 'Pedido 1';

$preference->notification_url = "https://IXexamplesPHP-dx979308.codeanyapp.com/notificationwooks.php";

$preference->back_urls = array(
	"success" => "https://www.mercadopago.com.br/developers/pt/guides/online-payments/checkout-pro/introduction",
	"failure" => "https://www.mercadopago.com.br/developers/pt/guides/online-payments/checkout-pro/introduction",
	"pending" => "https://www.mercadopago.com.br/developers/pt/guides/online-payments/checkout-pro/introduction"
);

// $preference->auto_return = "approved";

$shipments = new MercadoPago\Shipments();

$shipments->mode = "not_specified"; 
$shipments->cost = 10; 

$preference->shipments = $shipments;

$preference->payment_methods = array(
//   "excluded_payment_methods" => array(
//     array("id" => "debelo")
//   ),
  "excluded_payment_types" => array(
    array("id" => "debit_card")
  ),
	"installments" => 5,
);

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