<?php

include("config.php");

$motifid = $_GET["motifid"];
$minelemnum = $_GET["minelemnum"];

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT experiment.name AS expname,
               antibody.name   AS antiname,
               cell_lines.name AS cellname,
               average_deviation.element_num
        FROM experiment
             LEFT JOIN average_deviation ON average_deviation.experiment_experiment_id = experiment.experiment_id 
             LEFT JOIN antibody ON experiment.antibody_antibody_id = antibody.antibody_id
             LEFT JOIN cell_lines ON experiment.cell_lines_cellline_id = cell_lines.cellline_id
        WHERE average_deviation.consensus_motif_motif_id = $motifid AND
              average_deviation.element_num >= $minelemnum;";

$res = $conn->query($sql);
while( $r = mysqli_fetch_assoc($res) ){
  $array[] = $r;
}

header("Content-Type: application/json");
echo json_encode($array);
?>
