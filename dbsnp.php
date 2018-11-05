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
    $sql    = "select * from dbsnp where dbsnp_id = '$dbsnpid';";
    $snps   = sql2array($conn, $sql);
    $start  = $snps[0][2] - 50; //SNPs just one nucleotide long, we need a bigger picture.
    $end    = $snps[0][3] + 50;
    $sql    = "select * from motif_pos left join consensus_motif on (motif_pos.consensus_motif_motif_id = consensus_motif.motif_id) where motif_pos.chr = '"
               . $snps[0][1] . "' and motif_pos.start > $start and motif_pos.end < $end;";
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
    $snps   = sql2array($conn, $sql);

    $result           = [];
    $result["motifs"] = $motifs;
    $result["snps"]   = $snps;
    $result["start"]  = $start;
    $result["end"]    = $end;
    return($result);
  }

  function getSVGPos($fpos, $gstart, $gend, $width){
    return( ($fpos - $gstart) / ($gend - $gstart) * $width );
  }

  function drawSNP($snp, $pos, $halfh, $textstart){
    $third  = $halfh / 3;
    $vstart = $halfh;
    $vend   = $vstart + $third / 2;

    echo('<line x1="' . $pos . '" y1="' . $vstart . '" x2="' . $pos . '" y2="' . $vend . '" style="stroke:red;stroke-width=4;" />');
    echo('<text x="' . $pos . '" y="' . $textstart . '" style="font:13px sans-serif;">' . $snp[0] . '</text>');
  }

  function drawMotifs($motif, $width, $halfh, $gstart, $gend, $boxh){
    $pos  = getSVGPos($motif[2], $gstart, $gend, $width);
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
      $pos = getSVGPos($feats["snps"][$i][2], $gstart, $gend, $width);
      if(($i > 0) && ($pos - $first < 80)){ #This 80 is based on empirical observations
        $base = $base + 14;
      }
      else {
        $base = $halfh + ($halfh / 6) + 10;
        $first = getSVGPos($feats["snps"][$i][3], $gstart, $gend, $width);
      }
      drawSNP($feats["snps"][$i], $pos, $halfh, $base);
    }

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
  elseif($chr != "" && $start != "" && $end != "" && $end - $start < 1000){
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
      if(end - start > 1000){
         alert("Interval too large (>1000)");
         return false;
      }
      document.getElementById("dbform").submit();
      return true;
    }
  </script>
</head>
<body>
<p>This view helps you to see variations and overlapping regulatory motifs.</p>
<p>Please specify the dbSNP ID or a genomic region. If both set, only dbSNP will be used. If dbSNP ID is set the final image will be created using 50bp  flanking region. If you would like to see a larger landscape, you can set the
genomic region manually.</p>
<p>Caution: The genomic region cannot be larger than 1000bp!</p>
<form id="dbform" method="get" onsubmit="event.preventDefault();paramcheck();">
<p>dbSNP id:<input id="inpdbsnp" type="text" name="dbsnp" value="<?php echo $dbsnpid;?>"/></p>
<p>or</p>
<p>Chromosome:<input id="inpchr" type="text" name="chr" value="<?php echo $chr; ?>" size="3" maxlength="2"/>
Start position:<input id="inpstart" type="text" name="start" value="<?php echo $start; ?>" size="5"/>
End position:<input id="inpend" type="text" name="end" value="<?php echo $end ?>" size="5"/></p>
<input type="submit" value="Send" />
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
