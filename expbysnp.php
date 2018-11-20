<?php
  include('config.php');
  include('dbutil.php');
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
  <link rel="stylesheet" type="text/css" href="dbsnp.css">
</head>
<body>
<div class="container_16">
  <a href="http://www.naik.hu/en/"><img src="naik-logo.png" alt="SummitDB"  title="SummitDB" class="logo2"/></a>
  <img src="logo.gif" alt="SummitDB"  title="SummitDB" class="logomid"/>
  <a href="https://www.edu.unideb.hu/"><img src="University_logo.png" alt="SummitDB"  title="SummitDB" class="logo"/></a>
</div>
<div class="foo">
    <ul class="navlink">
        <li><a href="index.php" title="Home" class="active">Home</a></li>
        <li onclick="glossToggle()"><a title="Help" class="active">Glossary</a></li>
    </ul>
</div>

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
