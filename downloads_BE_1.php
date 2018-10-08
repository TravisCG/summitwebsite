<?php

$servername = "localhost";
$username = "sciguest";
$password = "password";
$dbname = "summitdb";
$exp = $_GET['exp'];
$expName = '\''.$exp.'\'';
// Create connection
$conn = new mysqli($servername, $username, $password);
// Check connection

// $con=mysqli_connect($host,$user,$password);

mysqli_select_db($conn,$dbname); 
//To select the database

session_start(); //To start the session

// $query=mysqli_query($con,your query); 
//made query after establishing connection with database.

//if ($conn->connect_error) {
//    die("Connection failed: " . $conn->connect_error);
//}

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=data.csv');

$output = fopen('php://output', 'w');

fputcsv($output, array('Column 1', 'Column 2', 'Column 3', 'Column 4'));

$sql = "SELECT
experiment.name AS experiment,
motif_pos.chr,
motif_pos.start,
motif_pos.end,
CONCAT_WS('#',peak.findPeaks_score,summit.hight,motif_pos.Homer_score) AS peakscore_summitheight_homerscore
FROM 
motif_pos
LEFT JOIN summit ON motif_pos.motifpos_id = summit.motif_pos_motifpos_id
LEFT JOIN peak ON summit.peak_peak_id = peak.peak_id
LEFT JOIN experiment ON peak.experiment_experiment_id = experiment.experiment_id
WHERE 
   experiment.name LIKE $expName";

$result=mysqli_query($conn,$sql);

//$result = $conn->query($sql);
//$result = mysql_query('$sql');

while ($row = mysqli_fetch_assoc($result)) fputcsv($output, $row);


// if ($result->num_rows > 0) {
    // output data 
//        $jsonData = array();
//      genrating data into thisrow

//while($r = mysqli_fetch_assoc($result)) {
//    fputcsv($output, $result);
//}

// fetch the data
//mysql_connect('localhost', 'username', 'password');
//mysql_select_db('database');
//$rows = mysql_query('SELECT field1,field2,field3 FROM table');

// loop over the rows, outputting them
//while ($row = mysql_fetch_assoc($rows)) fputcsv($output, $row);

//} else {
//    echo "0 results found #sad";
//}

$conn->close();

?>

