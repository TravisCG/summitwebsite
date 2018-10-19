<?php
  include('config.php');

  function sql2array($conn, $sql){
    $res = mysqli_query($conn, $sql);
    while( $r = mysqli_fetch_array($res, MYSQLI_NUM)){
      $array[] = $r;
    }
    return($array);
  }

  function motifsbydbsnp($conn, $dbsnpid){
    $sql = "select * from motif_pos left join dbsnp on (dbsnp.chr = motif_pos.chr and dbsnp.end > motif_pos.start and dbsnp.start < motif_pos.end) where dbsnp.dbsnp_id = '$dbsnpid';";
    $result = sql2array($conn, $sql);
    return($result);
  }

  function motifsbyregion($conn, $chr, $start, $end){
    $sql = "";
    $result = sql2array($conn, $sql);
    return($result);
  }

  function drawMotif($motif, $width, $height, $starth){
    echo('<rect x="0" y="'.$starth.'" width="'.$width.'" height="'.$height.'" style="fill:blue;stroke:red;" />');
  }

  function drawAllMotifs($motifs, $width, $cellheight){
    $height = $cellheight * sizeof($motifs);
    echo('<svg width="' . $width . '" height="' . $height . '">');
    for($i = 0; $i < sizeof($motifs); $i++){
      drawMotif($m[$i], $width, $cellheight, $i * $cellheight);
    }
    echo("</svg>");
  }

  $dbsnpid = $_GET['dbsnp'];
  $chr     = $_GET['chr'];
  $start   = $_GET['start'];
  $end     = $_GET['end'];

  $conn = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  if($dbsnpid != ""){
    $motifs = motifsbydbsnp($conn, $dbsnpid);
  }
  elseif($chr != "" && $start != "" && $end != ""){
    $motifs = motifsbyregion($conn, $chr, $start, $end);
  }

?>
<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="style.css">
  <script type="text/javascript">
    function paramcheck(){
      var dbsnpid = document.getElementById("inpdbsnp").value;
      var chr     = document.getElementById("inpchr").value;
      var start   = document.getElementById("inpstart").value;
      var end     = document.getElementById("inpend").value;

      if(dbsnpid == "" && (chr == "" || start == "" || end == "")){
         alert("Please set something");
         return false;
      }
      document.getElementById("dbform").submit();
      return true;
    }
  </script>
</head>
<body>
<form id="dbform" method="get" onsubmit="event.preventDefault();paramcheck();">
dbSNP id:<input id="inpdbsnp" type="text" name="dbsnp" value="<?php echo $dbsnpid;?>"/><br />
Chromosome:<input id="inpchr" type="text" name="chr" value="<?php echo $chr; ?>"/>
Start position:<input id="inpstart" type="text" name="start" value="<?php echo $start; ?>"/>
End position:<input id="inpend" type="text" name="end" value="<?php echo $end ?>"/><br />
<input type="submit" />
</form>
<div>
<?php
  if(isset($motifs)){
    drawAllMotifs($motifs, 400, 300);
  }
?>
</div>
</body>
</html>
