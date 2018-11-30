<?php
  include('config.php');
  include('dbutil.php');
  include('templates/header.php');
  $snpid = $_GET['dbsnp'];

  $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }

  $sql = "select * from dbsnp where dbsnp_id = '" . $snpid . "';";
  $res = sql2array($conn, $sql);
  $chr = $res[0][1];
  $pos = $res[0][2];

  $sql = "select experiment_id, name from peak left join experiment on (experiment_id = experiment_experiment_id) where chromosome = '".$chr."' and start < ".$pos." and end > ".$pos.";";
  $res = sql2array($conn, $sql);

  $conn->close();
?>
<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="style.css">
  <link rel="stylesheet" type="text/css" href="master.css">
  <link rel="stylesheet" type="text/css" href="dbsnp.css">
  <script>
    function dochange(target) { window.open(target,"_self");};
  </script>
</head>
<body>
<?php show_full_navigation(); ?>
<p>List of experiments which overlap with the following SNP: <?php echo($snpid);?></p>
<div id="explist">
<?php

  foreach($res as $record){
    echo('<p>');
    echo('<a href="http://summit.med.unideb.hu/summitdb/experiment_view.php?exp='.$record[0].'">'.$record[1].'</a>');
    echo("</p>\n");
  }
?>
</div>
</body>
</html>
