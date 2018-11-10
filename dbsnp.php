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
    $end    = $snps[0][2] + 50;
    $sql    = "select * from motif_pos left join consensus_motif on (motif_pos.consensus_motif_motif_id = consensus_motif.motif_id) where motif_pos.chr = '"
               . $snps[0][1] . "' and motif_pos.start > $start and motif_pos.end < $end;";
    $motifs = sql2array($conn, $sql);

    $result           = [];
    $result["motifs"] = $motifs;
    $result["snps"]   = $snps;
    $result["chr"]    = $snps[0][1];
    $result["start"]  = $start;
    $result["end"]    = $end;
    return($result);
  }

  function motifsbyregion($conn, $chr, $start, $end){
    $sql    = "select * from motif_pos left join consensus_motif on (consensus_motif_motif_id = motif_id) where chr = '$chr' and start > $start and end < $end order by start;";
    $motifs = sql2array($conn, $sql);
    $sql    = "select * from dbsnp where chr = '$chr' and start > $start and start < $end";
    $snps   = sql2array($conn, $sql);

    $result           = [];
    $result["motifs"] = $motifs;
    $result["snps"]   = $snps;
    $result["chr"]    = $chr;
    $result["start"]  = $start;
    $result["end"]    = $end;
    return($result);
  }

  function getSVGPos($fpos, $gstart, $gend){
    return( ($fpos - $gstart) / ($gend - $gstart) * 100 );
  }

  function drawSNP($snp, $pos, $halfh, $textstart){
    $third  = $halfh / 3;
    $vstart = $halfh;
    $vend   = $vstart + $third / 2;

    echo('<line x1="' . $pos . '%" y1="' . $vstart . '" x2="' . $pos . '%" y2="' . $vend . '" style="stroke:red;stroke-width=4;" />'."\n");
    echo('<a xlink:href="https://www.ncbi.nlm.nih.gov/snp/'.$snp[0].'" xlink:show="new"><text x="' . $pos . '%" y="' . $textstart . '" style="font:13px sans-serif;">' . $snp[0] . '</text></a>'."\n");
  }

  function drawMotifs($motif, $halfh, $gstart, $gend, $boxh){
    $pos  = getSVGPos($motif[2], $gstart, $gend);
    $w    = ($motif[3] - $motif[2]) / ($gend - $gstart) * 100;
    $texth = 13;
    $textbline = ($boxh - $texth) / 2;
    echo('<rect x="' . $pos . '%" y="' . ($halfh - $boxh) . '" width="' . $w . '%" height="' . $boxh . '" style="fill:pink;stroke:green;"/>'."\n");
    echo('<text x="' . $pos . '%" y="' . ($halfh - $textbline) . '" style="font:' . $texth . 'px sans-serif;">' . $motif[9] . '</text>'."\n");
  }

  function regionView($feats, $height){
    $halfh     = $height / 2;
    $gstart    = $feats["start"];
    $gend      = $feats["end"];
    $motifboxh = 16; // height of motif box
    $boxsep    = 4;  // spacer between motif boxes

    echo('<svg width="100%" height="'.$height.'" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1">'."\n");
    echo('<rect x="0" y="0" width="100%" height="100%" style="fill:lightblue;storoke:red;" />'."\n");
    echo('<line x1="0" y1="50%" x2="100%" y2="50%" style="stroke:black;stroke-width=2" />'."\n");
    
    for($i = 0; $i < sizeof($feats["snps"]); $i++){
      $pos = getSVGPos($feats["snps"][$i][2], $gstart, $gend);
      if(($i > 0) && ($pos - $first < 7)){ #This 7 is based on empirical observations
        $base = $base + 14;
      }
      else {
        $base = $halfh + ($halfh / 6) + 10;
        $first = getSVGPos($feats["snps"][$i][2], $gstart, $gend);
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
      drawMotifs($feats["motifs"][$i], $base, $gstart, $gend, $motifboxh);
    }
    echo("</svg>");
  }

  function drawReference($conn, $feats){
    $min = $feats["start"];
    $max = $feats["end"];
    $chr = $feats["chr"];

    $sql = "select * from reference where chr = '$chr' and start < $max and end > $min order by start;";
    $ref = sql2array($conn, $sql);

    $seq = "";
    for($i = 0; $i < sizeof($ref); $i++){
      $subseqlen = strlen($ref[$i][3]);
      $strstart = $min - $ref[$i][1];
      if($strstart < 0) $strstart = 0;
      $strend = 0 - ($ref[$i][2] - $max);
      if($strend > 0) $strend = $subseqlen;
      $seq = $seq . substr($ref[$i][3], $strstart, $strend);
    }

    for($i = 0; $i < strlen($seq); $i ++){
      $pos = $i / strlen($seq) * 100;
      echo('<text x="'.$pos.'%" y="80%" style="text-anchor:start;font:13px sans-serif;">'.$seq[$i].'</text>'."\n");
    }
  }

  function drawSNPWithSEQ($feats){
    $min   = $feats["start"];
    $max   = $feats["end"] + 1;
    $snpid = $feats["snps"][0][0];
    $pos   = $feats["snps"][0][2];
    $ref   = $feats["snps"][0][3];
    $alt   = $feats["snps"][0][4];

    for($i = 0; $i < strlen($ref); $i++){
      $textpos = ( ($pos + $i) - $min) / ($max - $min) * 100;
      echo('<text x="'.$textpos.'%" y="85%" style="fill:green;font:13px sans-serif">'.$ref[$i].'</text>'."\n");
    }

    for($i = 0; $i < strlen($alt); $i++){
      $textpos = (($pos + $i) - $min) / ($max - $min) * 100;
      echo('<text x="'.$textpos.'%" y="90%" style="fill:red;font:13px sans-serif">'.$alt[$i].'</text>'."\n");
    }

    $textpos = ($pos - $min) / ($max - $min) * 100;
    echo('<a xlink:href="https://www.ncbi.nlm.nih.gov/snp/'.$snpid.'" xlink:show="new"><text x="' . $textpos . '%" y="95%" style="font:13px sans-serif;">' . $snpid . '</text></a>'."\n");

  }

  function drawLogo($matrix, $order, $mstart, $mend, $regstart, $regend){
    $ypos = 75 - $order * 15;
    $width = ($mend - $mstart) / ($regend - $regstart) * 100;
    $xpos  = ($mstart - $regstart) / ($regend - $regstart) * 100;
    echo('<rect x="'.$xpos.'%" y="'.($ypos - 15).'%" width="'.$width.'%" height="15%" style="stroke:green;fill:none;"/>'."\n");
    for($i = 0; $i < sizeof($matrix); $i++){
       $xpos  = ($mstart + $i - $regstart) / ($regend - $regstart) * 100;
       echo('<text x="'.$xpos.'%" y="'.$ypos.'%">N</text>'."\n");
    }
  }

  function drawMotifLogos($conn, $feats){
    $regstart = $feats["start"];
    $regend   = $feats["end"] + 1;
    for($i = 0; $i < sizeof($feats["motifs"]); $i++){
      $sql    = "select position,probA,probC,probG,probT from pfm left join consensus_motif on (motif_id = consensus_motif_motif_id) where jaspar_code = '".$feats["motifs"][$i][10]."' order by position;";
      $matrix = sql2array($conn, $sql);
      $mstart = $feats["motifs"][$i][2];
      $mend   = $feats["motifs"][$i][3];
      drawLogo($matrix, $i, $mstart, $mend, $regstart, $regend);
    }
  }

  function motifView($conn, $feats, $height){
    echo('<svg width="100%" height="'.$height.'" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1">'."\n");
    echo('<rect x="0" y="0" width="100%" height="100%" style="fill:lightblue;storoke:red;" />');
    drawReference($conn, $feats);
    drawSNPWithSEQ($feats);
    drawMotifLogos($conn, $feats);
    echo('</svg>');
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
  <link rel="stylesheet" type="text/css" href="dbsnp.css">
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
    var features = <?php echo json_encode($motifs); ?>;
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
    regionView($motifs, 300);
    motifView($conn, $motifs, 300);
  }
?>
</div>
</body>
</html>
