<!-- Display PRODUCTS table data -->
<h2>Lista de Produtos</h2>
<table border="1" cellpadding="2" cellspacing="2">
  <tr>
    <td>ID</td>
    <td>Nome</td>
    <td>Preço</td>
    <td>Quantidade</td>
  </tr>

<?php
$result = pg_query($connection, "SELECT * FROM PRODUCTS");

while($query_data = pg_fetch_row($result)) {
  echo "<tr>";
  echo "<td>",$query_data[0], "</td>",
       "<td>",$query_data[1], "</td>",
       "<td>",$query_data[2], "</td>",
       "<td>",$query_data[3], "</td>";
  echo "</tr>";
}
?>
</table>