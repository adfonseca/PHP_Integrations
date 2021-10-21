<?php  
// SDK do Mercado Pago
require __DIR__ . '/../config.php';

//Filtro do e-mail inserido no front para buscar os cartões do customer

$filter = array(
    "email" => ($_POST["email"])
);

$customer_filter = MercadoPago\Customer::search($filter);

foreach ($customer_filter as $customer) {
    foreach ($customer->cards as $cards) {
        $idCustomer = $cards->customer_id;
        $card = $cards->last_four_digits;
    };   
 };
?>

<!DOCTYPE html>

<html>

<head>
   <title>Pagamento cartão armazenado</title>
</head>

<body>

<!--Formulário de dados do cartão armazenado no customer-->
<form action="apiCusCardsPagarSaveds.php" method="post" id="pay" name="pay" >
    <fieldset>
        <ul>
          <li>
              <label>Payment Method:</label>
              <select id="cardId" name="cardId" data-checkout='cardId'>
                    <?php foreach ($customer_filter as $customer) {
                             foreach ($customer->cards as $cards) { ?>
                        <option value="<?php echo ($cards->id); ?>" first_six_digits="<?php echo ($cards->first_six_digits); ?>" security_code_length="<?php echo ($card->security_code); ?>">
                                <?php echo ($cards->payment_method->name); ?> Started in: <?php echo ($cards->first_six_digits); ?>  Ended in: <?php echo ($cards->last_four_digits); ?>
                        </option>
                    <?php } }?>
              </select>
            </li>
            <li id="cvv">
                <label for="cvv">Security code:</label>
                <input type="text" id="cvv" data-checkout="securityCode" value="123"/>
            </li>
            <li>
                <label for="amount">Valor:</label>
                <input type="text" name="amount"  id="amount" value="20"/>
            </li>
            </ul>
        <input type="hidden" name="id" value="<?php echo ($cards->customer_id); ?>"/>
        <input type="hidden" name="paymentMethodId" value="<?php echo ($cards->payment_method->id); ?>"/>
        <input type="submit" value="Pay!" />
    </fieldset>
</form>
  
<!--importação da biblioteca js do Mercado Pago para que os dados do cartão do cliente não cheguem ao servidor da aplicação--> 
<script src="https://secure.mlstatic.com/sdk/javascript/v1/mercadopago.js"></script>

<script type="text/javascript">

window.Mercadopago.setPublishableKey("TEST-38a55736-cbe1-4b72-b2f2-61e4da37a96e");

function addEvent(to, type, fn){ //Adicionei a função que estava faltando
        if(document.addEventListener){
            to.addEventListener(type, fn, false);
        } else if(document.attachEvent){
            to.attachEvent('on'+type, fn);
        } else {
            to['on'+type] = fn;
        }  
    };

//Capture os dados

doSubmit = false;
addEvent(document.querySelector('#pay'), 'submit', doPay);
function doPay(event){
    event.preventDefault();
    if(!doSubmit){
        var $form = document.querySelector('#pay');

        window.Mercadopago.createToken($form, sdkResponseHandler); // The function "sdkResponseHandler" is defined below

        return false;
    }
};

function sdkResponseHandler(status, response) {
    if (status != 200 && status != 201) {
        alert("verify filled data");
    }else{
        var form = document.querySelector('#pay');
        var card = document.createElement('input');
        card.setAttribute('name', 'token');
        card.setAttribute('type', 'text');
        card.setAttribute('value', response.id);
        form.appendChild(card);
        doSubmit=true;
        form.submit();
    }
};
    
</script>

</body>
</html>
