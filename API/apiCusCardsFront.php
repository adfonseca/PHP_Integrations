<!DOCTYPE html>

<html>

<head>
   <title>Pagamento cartão</title>
</head>

<body>

<!--Formulário para ir aos cartões salvos-->
<form action="apiCusCardsSaveds.php" method="post">
    <fieldset>
        <ul>
            <li>
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="test_user_70028570@testuser.com"/>
            </li>
        </ul>
        <input type="submit" value="Ir para pagamento com cartão cadastrado!" />
    </fieldset>
</form>
  
 <!--Formulário para guardar cartão-->
<form action="apiCusCardsFirst.php" method="post">
    <fieldset>
        <input type="submit" value="Ir para formulário e cadastrar cartão pela primeira vez!" />
    </fieldset>
</form>
  
</body>
</html>

