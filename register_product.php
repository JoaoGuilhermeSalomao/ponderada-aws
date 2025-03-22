<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_name = htmlentities($_POST['NAME'] ?? '');
    $product_price = htmlentities($_POST['PRICE'] ?? '');
    $product_quantity = htmlentities($_POST['QUANTITY'] ?? '');

    if (strlen($product_name) && strlen($product_price) && strlen($product_quantity)) {
        AddProduct($connection, $product_name, $product_price, $product_quantity);
    }
}
?>

<!-- Input form for PRODUCTS -->
<form action="<?PHP echo $_SERVER['SCRIPT_NAME'] ?>" method="POST">
  <table border="0">
    <tr>
      <td>Nome do Produto</td>
      <td>Preço</td>
      <td>Quantidade</td>
    </tr>
    <tr>
      <td>
        <input type="text" name="NAME" maxlength="255" size="30" required />
      </td>
      <td>
        <input type="number" name="PRICE" step="0.01" min="0" required />
      </td>
      <td>
        <input type="number" name="QUANTITY" min="0" required />
      </td>
      <td>
        <input type="submit" value="Adicionar Produto" />
      </td>
    </tr>
  </table>
</form>

<?php
function AddProduct($connection, $name, $price, $quantity) {
   $n = pg_escape_string($name);
   $p = pg_escape_string($price);
   $q = pg_escape_string($quantity);
   $query = "INSERT INTO PRODUCTS (NAME, PRICE, QUANTITY) VALUES ('$n', $p, $q);";

   if(!pg_query($connection, $query)) echo("<p>Error adding product data.</p>"); 
}
?>
