<?php
// SDK de Mercado Pago
require __DIR__ . '/../config.php';

// Cria um objeto preferencia
$preference = new MercadoPago\Preference();

// Cria um item na preferencia
$item = new MercadoPago\Item();
$item->title = 'Prod1';
$item->quantity = 1;
$item->unit_price = 15.00;

$item2 = new MercadoPago\Item();
$item2->title = 'Prod2';
$item2->quantity = 1;
$item2->unit_price = 10.00;

$preference->items = array($item,$item2);

$payer = new MercadoPago\Payer();
  $payer->name = "Nome";
  $payer->surname = "Sobrenome";
//   $payer->email = "test_user_27183576@testuser.com";
  $payer->email = "";
  $payer->date_created = "2018-06-02T12:58:41.425-04:00";
  $payer->phone = array(
    "area_code" => "11",
    "number" => "4444-4444"
  );
    
  $payer->identification = array(
    "type" => "CPF",
    "number" => "19119119100"
  );
    
  $payer->address = array(
    "street_name" => "Street",
    "street_number" => 123,
    "zip_code" => "06233200"
  );

$preference->payer = $payer;

$preference->notification_url = 'https://IXexamplesPHP-dx979308.codeanyapp.com/notificationwooks.php';

$preference->back_urls = array(
	"success" => "https://www.mercadopago.com.br/developers/pt/guides/online-payments/checkout-pro/introduction",
	"failure" => "https://www.mercadopago.com.br/developers/pt/guides/online-payments/checkout-pro/introduction",
	"pending" => "https://www.mercadopago.com.br/developers/pt/guides/online-payments/checkout-pro/introduction"
);

$preference->auto_return = "approved";

$preference->save();
?>

<!DOCTYPE html>

<html>
  <head>
    <title>Pagar</title>
  </head>
  <body>
<!--     <a href="<?php echo $preference->init_point; ?>">Pagar com Mercado Pago</a> -->
		<a href="<?php echo $preference->init_point; ?>">
      Clique aqui para <strong style="font-weight:bold">Pagar</strong>
   </a>
  </body>
	<script>
		data-header-color="#678f12" 
		data-elements-color="#ff650e"
	</script>
</html>