<?php
  include('config.php');

  $dbsnpid = $_GET['dbsnp'];
  $chr     = $_GET['chr'];
  $start   = $_GET['start'];
  $end     = $_GET['end'];

  $conn = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

?>
<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<form method="get" >
dbSNP id:<input type="text" name="dbsnp" value="<?php echo $dbsnpid;?>"/><br />
Chromosome:<input type="text" name="chr" value="<?php echo $chr; ?>"/> Start position:<input type="text" name="start" value="<?php echo $start; ?>"/> End position:<input type="text" name="end" value="<?php echo $end ?>"/><br />
<input type="submit" />
</form>
</body>
</html>
