<!DOCTYPE html>

<html>

<head>
	<title>Formulário Pagamento Boleto</title>
</head>

<body>

<form action="apiBolBack.php" method="post" id="pay" name="pay">
    <fieldset>
        <p><label for="transaction_amount">Valor total</label>
        <input type="text" name="transaction_amount" id="transaction_amount" value="20.00"/>

        <p><label for="description">Descrição</label>
        <input type="text" name="description" id="description" value="Produto boleto"/>

        <p><label for="email">E-mail</label>
        <input type="email" name="email"  id="email" value="test_user_70028570@testuser.com"/>

        <p><label for="first_name">Nome</label>
        <input type="text" name="first_name" id="first_name" value="Nome"/>

        <p><label for="last_name">Sobrenome</label>
        <input type="text" name="last_name" id="last_name" value="Sobrenome"/>

        <p><label for="docType">Document type:</label>
         <input id="docType" name="docType" value="CPF"/>        

        <p><label for="docNumber">Document number:</label>
        <input type="text" name="docNumber" id="docNumber" data-checkout="docNumber" value="19119119100"/>

        <p><label for="zip_code">CEP</label>
        <input type="text" name="zip_code" id="zip_code" value="06233200"/>

        <p><label for="street_name">Nome da rua</label>
        <input type="text" name="street_name" id="street_name"  value="Av. das Nções Unidas"/>

        <p><label for="street_number">Nº</label>
        <input type="text" name="street_number" id="street_number" value="3003"/>

        <p><label for="neighborhood">Bairro</label>
        <input type="text" name="neighborhood" id="neighborhood" value="Bonfim"/>

        <p><label for="city">Cidade</label>
        <input type="text" name="city" id="city" value="Osasco"/>

        <p><label for="federal_unit">UF</label>
        <input type="text" name="federal_unit" id="federal_unit" value="SP"/>

        <input type="submit" value="Pay!" />

    </fieldset>
</form>


<!--importação da biblioteca js do Mercado Pago para que os dados do cartão do cliente não cheguem ao servidor da aplicação--> 
<script src="https://secure.mlstatic.com/sdk/javascript/v1/mercadopago.js"></script>

<script type="text/javascript">

window.Mercadopago.setPublishableKey("TEST-38a55736-cbe1-4b72-b2f2-61e4da37a96e");

window.Mercadopago.getIdentificationTypes(); //Obtenha o tipo de documento

</script>
  
    <br/>  
    <br/>
    <h3>
      Cancelar pagamento:
    </h3>

  <div>
    <form action="cancelamento.php" method="post" id="pagamento">
     <label for="pagamento">Pagamento</label>
      <input type="text" id="pagamento" name="pagamento"/>
       <input type="submit" value="Cancelar!" />
    </form>
  </div>

</body>

</html>