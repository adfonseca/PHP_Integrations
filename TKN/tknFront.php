<!DOCTYPE html>

<html>

<!-- <head>
	<title>Tokenizando cartão</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
</head>

<body>

<form action="tknBack.php" method="POST">
  <script
    src="https://www.mercadopago.com.br/integrations/v1/web-tokenize-checkout.js"
    data-public-key="TEST-38a55736-cbe1-4b72-b2f2-61e4da37a96e"
    data-transaction-amount="100.00">
  </script>
</form>

</body> -->
  
<head>
	<title>Tokenizando cartão</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
</head>

<body>
  <div class="tokenizer-container" />
    
 <script src="https://sdk.mercadopago.com/js/v2"></script>
 <script>
src="https://sdk.mercadopago.com/js/v2"
// Adicione as credenciais do SDK
const mp = new MercadoPago('TEST-38a55736-cbe1-4b72-b2f2-61e4da37a96e', {locale: 'pt-BR'});
// Inicializa o Web Tokenize Checkout
mp.checkout({
  tokenizer: {
    totalAmount: 100,
    backUrl: 'tknBack.php'
  },
 render: {
    container: '.tokenizer-container', // Indica onde o botão de pagamento será exibido
    label: 'Pagar' // Muda o texto do botão de pagamento (opcional)
 }
});
</script>
  
 </body>

</html>
