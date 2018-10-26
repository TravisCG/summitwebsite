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
    $sql    = "select * from motif_pos where dbsnp_id = '$dbsnpid';";
    //$snps   = sql2array($conn, $sql);
    $start  = $snps[2] - 50; //SNPs just one nucleotide long, we need a bigger picture.
    $end    = $snps[3] + 50;
    $sql    = "select * from motif_pos left join consensus_motif on (motif_pos.consensus_motif_motif_id = consensus_motif.motif_id) where motif_pos.chr = '"
               . $snps[1] . "' and motif_pos.start > $start and motif_pos.end < $end;"; //TODO what about partial overlap?
    $motifs = sql2array($conn, $sql);

    $result           = [];
    $result["motifs"] = $motifs;
    $result["snps"]   = $snps;
    $result["start"]  = $start;
    $result["end"]    = $end;
    return($result);
  }

  function motifsbyregion($conn, $chr, $start, $end){
    $sql    = "select * from motif_pos left join consensus_motif on (consensus_motif_motif_id = motif_id) where chr = '$chr' and start > $start and end < $end order by start;";
    $motifs = sql2array($conn, $sql);
    $sql    = "select * from dbsnp where chr = '$chr' and start > $start and end < $end";
    //$snps   = sql2array($conn, $sql);

    $result           = [];
    $result["motifs"] = $motifs;
    $result["snps"]   = $snps;
    $result["start"]  = $start;
    $result["end"]    = $end;
    return($result);
  }

  function drawSNP($snp, $width, $halfh, $gstart, $gend){
    $third  = $halfh / 3;
    $vstart = $halfh + $third;
    $vend   = $vstart + $third / 2;
    $pos    = ($snp[2] - $gstart) / ($gend - $gstart) * $width;

    //TODO If there are too many SNPs, the labels will collide
    echo('<line x1="' . $pos . '" y1="' . $vstart . '" x2="' . $pos . '" y2="' . $vend . '" style="stroke:red;stroke-width=4;" />');
    echo('<text x="' . $pos . '" y="' . ($vend + 10) . '" text-anchor="middle" style="font:13px sans-serif;">' . $snp[0] . '</text>');
  }

  function drawMotifs($motif, $width, $halfh, $gstart, $gend, $boxh){
    $pos  = ($motif[2] - $gstart) / ($gend - $gstart) * $width;
    $w    = ($motif[3] - $motif[2]) / ($gend - $gstart) * $width;
    $texth = 13;
    $textbline = ($boxh - $texth) / 2;
    echo('<rect x="' . $pos . '" y="' . ($halfh - $boxh) . '" width="' . $w . '" height="' . $boxh . '" style="fill:pink;stroke:green;"/>');
    echo('<text x="' . $pos . '" y="' . ($halfh - $textbline) . '" style="font:' . $texth . 'px sans-serif;">' . $motif[9] . '</text>');
  }

  function drawAllMotifs($feats, $width, $height){
    $halfh     = $height / 2;
    $gstart    = $feats["start"];
    $gend      = $feats["end"];
    $motifboxh = 16; // height of motif box
    $boxsep    = 4;  // spacer between motif boxes

    echo('<svg width="' . $width . '" height="' . $height . '">');
    echo('<rect x="0" y="0" width="'.$width.'" height="'.$height.'" style="fill:lightblue;storoke:red;" />');
    echo('<line x1="0" y1="'.$halfh.'" x2="'.$width.'" y2="'.$halfh.'" style="stroke:black;stroke-width=2" />');
    
    for($i = 0; $i < sizeof($feats["snps"]); $i++){
      drawSNP($feats["snps"][$i], $width, $halfh, $gstart, $gend);
    }

    $base = $halfh;
    for($i = 0; $i < sizeof($feats["motifs"]); $i++){
      if(($i > 0) && ($feats["motifs"][$i][2] < $feats["motifs"][$i-1][3])){
        $base = $base - $motifboxh - $boxsep;
      }
      else{
        $base = $halfh;
      }
      drawMotifs($feats["motifs"][$i], $width, $base, $gstart, $gend, $motifboxh);
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
    drawAllMotifs($motifs, 700, 300);
  }
?>
</div>
</body>
</html>
