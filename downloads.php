<?php

$servername = "localhost";
$username = "sciguest";
$password = "password";
$dbname = "summitdb";
$firstexp = $_GET['firstexp'];
$firstexpName = '\''.$firstexp.'\'';
$secondexp = $_GET['secondexp'];
$secondexpName = '\''.$secondexp.'\'';
$thirdexp = $_GET['thirdexp'];
$thirdexpName = '\''.$thirdexp.'\'';

$motive = $_GET['motive'];
$motiveName = '\''.$motive.'\'';






// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

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
LEFT JOIN consensus_motif ON motif_pos.consensus_motif_motif_id = consensus_motif.motif_id
WHERE 
   experiment.name LIKE $firstexpName || $secondexpName || $thirdexpName
&& consensus_motif.name = $motiveName
";

$result = $conn->query($sql);


if ($result->num_rows > 0) {
    // output data 
        $jsonData = array();
//      genrating data into thisrow

while($r = mysqli_fetch_assoc($result)) {
    $jsonData[] = $r;
}

} else {
    echo "0 results found #sad";
}

$conn->close();


$column = array_column($jsonData, 'exp_name');
echo $motiveName

?>

<head>
<meta charset="utf-8">
<title>NAIK Genome Database</title>
<link href="favicon.png" rel="icon"  type="image/png" />
<meta name="Description" content="A database containing genomic data that was analysed and meta analysed by the Bioinformatics Research Group of the NAIK MBK.">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="jsonhandler.js"></script>
<style>
a {
	text-decoration:none;
	color:#2F769F;
  }
button {
    background-color: #777777; /* Grey */
    border: none;
    color: white;
    padding: 3px 12px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16;
    border-radius: 4px;
    width: 11em;
}

button:hover {
    background-color: #666666; /* Grey */
}

</style>
</head>




<body>
<div id="link" position="static" style="width:100% ;text-align:center;height: 4em; background-color: white;">
<button><p> download exp. data</p></button>
</div>
<script>
// really basic example, writes the table to a downloadable file

function download_csv(csv, filename) {
    var csvFile;
    var downloadLink;

    // CSV FILE
    csvFile = new Blob([csv], {type: "text/csv"});

    // Download link
    downloadLink = document.createElement("a");

    // File name
    downloadLink.download = filename;

    // We have to create a link to the file
    downloadLink.href = window.URL.createObjectURL(csvFile);

    // Make sure that the link is not displayed
    downloadLink.style.display = "none";

    // Add the link to your DOM
    document.body.appendChild(downloadLink);

    // Lanzamos
    downloadLink.click();
}

function export_table_to_csv(html, filename) {
	var csv = [];
	var rows = document.querySelectorAll("table tr");
	
    for (var i = 0; i < rows.length; i++) {
		var row = [], cols = rows[i].querySelectorAll("td, th");
		
        for (var j = 0; j < cols.length; j++) 
            row.push(cols[j].innerText);
        
		csv.push(row.join("\t"));		
	}

    // Download CSV
    download_csv(csv.join("\n"), filename);
}

document.querySelector("button").addEventListener("click", function () {
    var html = document.querySelector("table").outerHTML;
	export_table_to_csv(html, "<?php echo($exp);?>.bed");
});

var jsonData = <?php echo json_encode($jsonData);?>;

//lets put the json into a table

$(function() {
            $.getJSON('jsonData', function(data) {
                var tr;
                for (var i = 0; i < data.length; i++) {
                    tr = $('<tr/>');
                    tr.append("<td>" + data[i][0] + "</td>");
                    tr.append("<td>" + data[i][1] + "</td>");
                    $('table').append(tr);
                }
            });
        });


$("body").append("<table id='testTable'style=\"display:none\"></table>")
//style=\"display:none\"
// Spawn a new JSONTable object on the newly created table
var jsonTable = new JSONTable($("#testTable"))

// Create HTML table (data)structure from JSON data
jsonTable.fromJSON(jsonData)  
</script>
<script src="jsonhandler.js"></script>

</body>
