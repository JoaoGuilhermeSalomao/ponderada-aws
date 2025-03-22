<?php include "../inc/dbinfo.inc"; ?>

<html>
<body>
<h1>Sample page</h1>
<?php

/* Connect to PostgreSQL and select the database. */
$constring = "host=" . DB_SERVER . " dbname=" . DB_DATABASE . " user=" . DB_USERNAME . " password=" . DB_PASSWORD ;
$connection = pg_connect($constring);

if (!$connection){
 echo "Failed to connect to PostgreSQL";
 exit;
}

/* Ensure that the EMPLOYEES, UNIDADES, and PRODUCTS tables exist. */
VerifyTables($connection, DB_DATABASE);

/* If input fields are populated, add a row to the EMPLOYEES or UNIDADES table. */
$employee_name = htmlentities($_POST['NAME'] ?? '');
$employee_address = htmlentities($_POST['ADDRESS'] ?? '');
$unidade_id = htmlentities($_POST['ID'] ?? '');
$quantidade_funcionarios = htmlentities($_POST['QUANTIDADE_FUNCIONARIOS'] ?? '');
$endereco_unidade = htmlentities($_POST['ENDERECO_UNIDADE'] ?? '');
$data_fundacao = htmlentities($_POST['DATA_FUNDAÇÃO'] ?? '');
$gerente_unidade = htmlentities($_POST['GERENTE_UNIDADE'] ?? '');

if (strlen($employee_name) || strlen($employee_address)) {
  AddEmployee($connection, $employee_name, $employee_address);
}

if (strlen($unidade_id) || strlen($quantidade_funcionarios) || strlen($endereco_unidade) || strlen($data_fundacao) || strlen($gerente_unidade)) {
  AddUnidade($connection, $unidade_id, $quantidade_funcionarios, $endereco_unidade, $data_fundacao, $gerente_unidade);
}

// Include the product registration and listing pages
include 'register_product.php';
include 'list_products.php';

?>

<!-- Input form for EMPLOYEES -->
<form action="<?PHP echo $_SERVER['SCRIPT_NAME'] ?>" method="POST">
  <table border="0">
    <tr>
      <td>NAME</td>
      <td>ADDRESS</td>
    </tr>
    <tr>
      <td>
        <input type="text" name="NAME" maxlength="45" size="30" />
      </td>
      <td>
        <input type="text" name="ADDRESS" maxlength="90" size="60" />
      </td>
      <td>
        <input type="submit" value="Add Data to EMPLOYEES" />
      </td>
    </tr>
  </table>
</form>

<!-- Input form for UNIDADES -->
<form action="<?PHP echo $_SERVER['SCRIPT_NAME'] ?>" method="POST">
  <table border="0">
    <tr>
      <td>ID</td>
      <td>Quantidade de Funcionários</td>
      <td>Endereço da Unidade</td>
      <td>Data de Fundação</td>
      <td>Gerente da Unidade</td>
    </tr>
    <tr>
      <td>
        <input type="text" name="ID" maxlength="10" size="10" />
      </td>
      <td>
        <input type="number" name="QUANTIDADE_FUNCIONARIOS" min="0" />
      </td>
      <td>
        <input type="text" name="ENDERECO_UNIDADE" maxlength="255" size="30" />
      </td>
      <td>
        <input type="date" name="DATA_FUNDAÇÃO" />
      </td>
      <td>
        <input type="text" name="GERENTE_UNIDADE" maxlength="255" size="30" />
      </td>
      <td>
        <input type="submit" value="Add Data to UNIDADES" />
      </td>
    </tr>
  </table>
</form>

<!-- Display EMPLOYEES table data -->
<table border="1" cellpadding="2" cellspacing="2">
  <tr>
    <td>ID</td>
    <td>NAME</td>
    <td>ADDRESS</td>
  </tr>

<?php
$result = pg_query($connection, "SELECT * FROM EMPLOYEES");

while($query_data = pg_fetch_row($result)) {
  echo "<tr>";
  echo "<td>",$query_data[0], "</td>",
       "<td>",$query_data[1], "</td>",
       "<td>",$query_data[2], "</td>";
  echo "</tr>";
}
?>
</table>

<!-- Display UNIDADES table data -->
<table border="1" cellpadding="2" cellspacing="2">
  <tr>
    <td>ID</td>
    <td>Quantidade de Funcionários</td>
    <td>Endereço da Unidade</td>
    <td>Data de Fundação</td>
    <td>Gerente da Unidade</td>
  </tr>

<?php
$result = pg_query($connection, "SELECT * FROM UNIDADES");

while($query_data = pg_fetch_row($result)) {
  echo "<tr>";
  echo "<td>",$query_data[0], "</td>",
       "<td>",$query_data[1], "</td>",
       "<td>",$query_data[2], "</td>",
       "<td>",$query_data[3], "</td>",
       "<td>",$query_data[4], "</td>";
  echo "</tr>";
}
?>
</table>

<!-- Clean up. -->
<?php
  pg_free_result($result);
  pg_close($connection);

/* Add an employee to the table. */
function AddEmployee($connection, $name, $address) {
   $n = pg_escape_string($name);
   $a = pg_escape_string($address);
   $query = "INSERT INTO EMPLOYEES (NAME, ADDRESS) VALUES ('$n', '$a');";

   if(!pg_query($connection, $query)) echo("<p>Error adding employee data.</p>"); 
}

/* Add a unidade to the table. */
function AddUnidade($connection, $id, $quantidade_funcionarios, $endereco_unidade, $data_fundacao, $gerente_unidade) {
   $id = pg_escape_string($id);
   $quantidade_funcionarios = pg_escape_string($quantidade_funcionarios);
   $endereco_unidade = pg_escape_string($endereco_unidade);
   $data_fundacao = pg_escape_string($data_fundacao);
   $gerente_unidade = pg_escape_string($gerente_unidade);
   $query = "INSERT INTO UNIDADES (ID, QUANTIDADE_FUNCIONARIOS, ENDERECO_UNIDADE, DATA_FUNDAÇÃO, GERENTE_UNIDADE) VALUES ('$id', '$quantidade_funcionarios', '$endereco_unidade', '$data_fundacao', '$gerente_unidade');";

   if(!pg_query($connection, $query)) echo("<p>Error adding unidade data.</p>"); 
}

/* Check whether the tables exist and, if not, create them. */
function VerifyTables($connection, $dbName) {
  if(!TableExists("EMPLOYEES", $connection, $dbName))
  {
     $query = "CREATE TABLE EMPLOYEES (
         ID serial PRIMARY KEY,
         NAME VARCHAR(45),
         ADDRESS VARCHAR(90)
       )";

     if(!pg_query($connection, $query)) echo("<p>Error creating EMPLOYEES table.</p>"); 
  }
  
  if(!TableExists("UNIDADES", $connection, $dbName))
  {
     $query = "CREATE TABLE UNIDADES (
         ID VARCHAR(10) PRIMARY KEY,
         QUANTIDADE_FUNCIONARIOS INTEGER,
         ENDERECO_UNIDADE VARCHAR(255),
         DATA_FUNDAÇÃO DATE,
         GERENTE_UNIDADE VARCHAR(255)
       )";

     if(!pg_query($connection, $query)) echo("<p>Error creating UNIDADES table.</p>"); 
  }
  
  if(!TableExists("PRODUCTS", $connection, $dbName))
  {
     $query = "CREATE TABLE PRODUCTS (
         ID SERIAL PRIMARY KEY,
         NAME VARCHAR(255),
         PRICE DECIMAL(10, 2),
         QUANTITY INTEGER
       )";

     if(!pg_query($connection, $query)) echo("<p>Error creating PRODUCTS table.</p>"); 
  }
}

/* Check for the existence of a table. */
function TableExists($tableName, $connection, $dbName) {
  $t = strtolower(pg_escape_string($tableName)); //table name is case sensitive
  $d = pg_escape_string($dbName); //schema is 'public' instead of 'sample' db name so not using that

  $query = "SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_NAME = '$t';";
  $checktable = pg_query($connection, $query);

  if (pg_num_rows($checktable) >0) return true;
  return false;
}
?>
</body>
</html>
