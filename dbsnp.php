<?php
  include('config.php');
  define("SVGW", 1200); // SVG viewport X limit
  define("SVGH", 300);  // SVG viewport Y limit
  define("NUCW", 45);   // Nucleotide width in logo
  define("NUCH", 100);  // Nucleotide height in logo

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
    $params = "chr=".$motif[1]."&start=".($motif[2]-5)."&end=".($motif[3]+5)."&mv=1";
    echo('<a xlink:href="http://summit.med.unideb.hu/summitdb/dbsnp.php?'.$params.'"><rect x="' . $pos . '%" y="' . ($halfh - $boxh) . '" width="' . $w . '%" height="' . $boxh . '" style="fill:pink;stroke:green;"/></a>'."\n");
    echo('<a xlink:href="http://summit.med.unideb.hu/summitdb/motif_view.php?maxid=10000&minid=1&mnelem=100&mxelem=120000&motive='.$motif[9].'" xlink:show="new"><text x="' . $pos . '%" y="' . ($halfh - $textbline) . '" style="font:' . $texth . 'px sans-serif;">' . $motif[9] . '</text></a>'."\n");
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
    for($s = 0; $s < sizeof($feats["snps"]); $s++){
      $snpid = $feats["snps"][$s][0];
      $pos   = $feats["snps"][$s][2];
      $ref   = $feats["snps"][$s][3];
      $alt   = $feats["snps"][$s][4];

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
  }

  function drawNuc($x, $y, $height, $width, $array, $style){
    echo('<path class="'.$style.'" d="M ' . ($x + $array[0]) . ' ');
    for($i = 1; $i < sizeof($array); $i++){
      if($i % 2 == 0){
        echo('L ');
        echo( ($x + $array[$i] / NUCW * $width) . ' ');
      }
      else{
        echo( ($y + $array[$i] / 100 * $height) . ' ');
      }
    }
    echo('Z" />');
  }

  function drawA($x, $y, $height, $width){
    $A = [0.0,99.9087254236147,0.046875,99.81745084722931,19.527344000000028,0.0,25.445313000000056,0.0,45.01953200000003,100.0,38.14453200000003,100.0,33.23828200000003,73.9016663101245,11.738282000000027,73.9016663101245,6.9257820000000265,99.9087254236147,0.0,99.9087254236147,13.804688000000056,63.10088868949046,31.265625,63.00961411310511,22.558594000000028,16.33807907440221,22.460938000000056,16.24680449801686,22.367188000000056,16.526712783532965,13.757813000000056,63.00961411310511,13.804688000000056,63.10088868949046];
    drawNuc($x, $y, $height, $width, $A, "nucA");
  }

  function drawT($x, $y, $height, $width){
    $T = [0.0,0.0,45.019531,0.0,45.019531,10.703475583327753,26.257813,10.799779060000542,26.257813,100.0,18.707031,100.0,18.707031,10.891498110341733,18.597656999999998,10.703475583327753,0.0,10.703475583327753];
    drawNuc($x, $y, $height, $width, $T, "nucT");
  }

  function drawG($x, $y, $height, $width){
    $G = [0.0,42.830733450059164,0.05468800000005558,42.73896445216878,0.05468800000005558,40.91289955904085,0.2734380000000556,36.80325570141609,0.8242190000000278,31.14152336672688,1.5390630000000556,26.483927357925836,2.3046880000000556,22.830467334537634,2.800781000000029,20.912633783994654,3.625,18.17287098526126,4.335938000000056,16.164598673960246,6.148438000000056,12.054954816335481,8.457031000000029,8.219287715249527,9.71875,6.575429899819355,11.144531000000029,5.0220111856225484,13.175781000000029,3.2877149499096774,14.109375,2.647993800843011,16.964844000000028,1.1863440845365927,20.203125,0.2739764160634733,23.773438000000056,0.0,25.421875,
         0.09043910123336694,27.671875,0.4561838342365596,30.746094000000028,1.4603201601247322,32.50390700000003,2.3740177252548715,33.875,3.2877149499096774,35.304688000000056,4.474059034446269,37.05859400000003,6.301453824231215,38.70703100000003,8.493263790837666,40.023438000000056,10.685073757444117,41.34375,13.424836215702182,42.44140700000003,16.34680609213333,43.375,19.542752384627956,44.19921900000003,23.378419826189244,44.69140700000003,26.57436611868387,45.01953100000003,29.77164230783551,37.390625,29.77164230783551,36.94921900000003,26.57436611868387,36.45703100000003,24.109909632670963,35.632813000000056,21.09617109882476,34.80859400000003,18.90436113221831,33.984375,17.168734999848418,32.44921900000003,14.794717615068881,31.128907000000027,13.333067558287128,29.484375,12.054954816335481,27.890625,11.23302624909573,26.078125,10.685073757444117,24.980469000000028,10.501536102138678,22.070313000000056,10.501536102138678,19.4375,11.141257591680677,17.898438000000056,11.871417501505375,16.80078100000003,12.60290764846243,15.261719000000028,
         13.972788707353795,14.328125,15.068693690657021,13.78125,15.798853600481719,12.132813000000056,18.630384716154836,11.035157000000027,21.186609859582795,10.433594000000028,22.922235991952686,9.664063000000056,25.66199845021075,9.113281000000029,28.127784832880675,8.511719000000028,31.779914619136523,8.179688000000056,34.51967707739459,7.742188000000056,40.73069214086777,7.6875,57.16926689041616,7.851563000000056,60.63918925849892,8.179688000000056,64.38308804264516,8.621094000000028,67.67080299255484,9.277344000000028,71.14072536063759,9.9375,73.79004905813763,11.089844000000028,77.35174008363545,12.078125,79.72575780889032,12.847657000000027,81.27784628595477,14.328125,83.74363266862468,14.933594000000028,84.56556123586444,16.36328100000003,86.20941905129462,17.84375,87.48886134942795,19.65625,88.58476633273116,21.027344000000028,89.13271882438278,23.222657000000027,89.58890265861935,26.023438000000056,89.58890265861935,29.320313000000056,89.04095016696775,31.40625,88.3107899166677,32.83203100000003,87.57930011018598,33.765625,86.94090885777634,34.91796900000003,85.93544263523114,35.742188000000056,85.02307496675803,36.51171900000003,84.01760908468816,37.445313000000056,82.46552026714838,37.445313000000056,60.63918925849892,23.882813000000056,60.54742060108387,23.882813000000056,50.31986057453332,44.96484400000003,50.22809191711828,45.01953100000003,85.93544263523114,43.867188000000056,88.40122901790107,42.44140700000003,90.77657629933763,41.06640700000003,92.60264119246554,39.640625,94.15473001000534,37.609375,95.89035614237523,35.960938000000056,96.98626112567844,33.4375,98.2643738676301,31.128907000000027,99.08630243486985,28.714844000000028,99.63425492652146,26.574219000000028,99.9082310021096,24.046875,100.0,21.796875,99.81779258182691,19.382813000000056,99.26983974969997,17.460938000000056,98.53834994321824,15.703125,97.62598261522045,13.945313000000056,96.43830863402682,11.75,94.52047508348387,10.320313000000056,92.96838626594408,8.839844000000028,91.0505527154011,7.355469000000028,88.76697375090426,6.039063000000056,86.30118770870968,5.1601570000000265,84.38335381769136,4.28125,82.19154385108489,3.3476570000000265,79.45178139282683,2.4726570000000265,76.34627420156559,1.8125,73.51607298254949,1.207031000000029,70.3187964529225,0.769531000000029,67.3050579190763,0.328125,63.196744298583894,0.109375,59.90902934867422,0.0,57.0774982330011];
    drawNuc($x, $y, $height, $width, $G, "nucG");
  }

  function drawC($x, $y, $height, $width){
    $C = [0.0,43.51028283231891,0.05468800000005558,43.41300923933707,0.05468800000005558,41.231239000111465,0.21875,37.75708859563453,0.6054690000000278,33.3657602360153,0.9882820000000265,30.350193472811355,1.9765630000000556,24.958312841949954,3.347656000000029,19.747083677702513,4.777344000000028,15.717065366374449,5.820313000000056,13.340744383653341,6.753906000000029,11.520291307782951,8.894532000000027,8.129518776937726,10.265625,6.392443574699053,11.75,4.836023396606163,13.5625,3.29349893786339,14.878906000000029,2.376320982721107,17.84375,0.9171779551420807,20.039063000000056,0.26403645530942904,21.742188000000056,0.0,25.421875,0.0,27.617188000000056,0.36131360582319133,29.207032000000027,0.8199008046283183,30.964844000000028,1.55642017809289,32.44921900000003,2.376320982721107,35.02734400000003,4.377432640269109,
          37.335938000000056,6.948307924017942,38.37890600000003,8.40745095159717,40.023438000000056,11.242359133123506,41.289063000000056,13.979990164135977,42.164063000000056,16.356311146857287,43.15234400000003,19.747083677702513,44.03125,23.86047986266229,44.69140600000003,28.515844677590845,45.01953200000003,32.44858228087302,37.335938000000056,32.44858228087302,36.94921900000003,28.793773294718463,36.51171900000003,25.958868670723955,35.6875,22.206782534055538,34.86328200000003,19.552529376674784,33.710938000000056,16.912175496176175,32.66796900000003,15.175100293937502,31.238282000000027,13.438021534167003,29.976563000000056,12.340188554879342,28.66015600000003,11.520291307782951,27.398438000000056,10.964426958464061,24.980469000000028,10.422458328495086,22.179688000000056,10.422458328495086,21.136719000000028,10.603113352640667,18.996094000000028,11.325737006755224,17.84375,11.96498278723806,16.195313000000056,13.25736651002142,15.042969000000028,14.438577362941004,13.671875,16.272929715693337,12.738282000000027,
          17.81545417443631,11.585938000000056,20.205670876507536,10.761719000000028,22.304059684569403,9.828125,25.319622890241316,9.277344000000028,27.598666722448762,8.785156000000029,30.169538448665566,8.34375,33.18510521186951,8.015625,36.381323441687215,7.796875,39.75820025318252,7.6875,43.05169563351389,7.6875,57.22623654114556,7.796875,60.51973192147692,8.070313000000056,64.35519593177726,8.785156000000029,69.92773514431626,9.828125,74.77765426027254,11.035156000000029,78.61311827057288,12.1875,81.35074930158535,12.847656000000029,82.6292373050188,13.726563000000056,84.10227960947977,15.097656000000029,85.92273268535016,17.074219000000028,87.75708503810249,18.226563000000056,88.47970869221705,19.984375,89.21623162321355,21.796875,89.57754167150492,24.210938000000056,89.57754167150492,26.355469000000028,89.21623162321355,27.78125,88.7576408668765,29.261719000000028,88.03501721276193,31.296875,86.47859703466905,32.55859400000003,85.00555828774012,33.65625,83.28237880485155,34.48046900000003,81.54530360261288,35.02734400000003,80.0722612981519,35.851563000000056,77.23735311662557,36.51171900000003,74.1384084797897,37.00390600000003,70.92829097309027,37.335938000000056,67.82934989378643,45.01953200000003,67.82934989378643,44.69140600000003,71.48415532240917,44.19921900000003,75.04168715805005,43.703125,77.6959403154306,42.93359400000003,80.89216210278033,42.054688000000056,83.72707028430666,40.79296900000003,86.93718423347427,39.75,89.03557304153594,38.37890600000003,91.31461687374338,37.11328200000003,93.05169207598206,35.742188000000056,94.60811225407495,33.710938000000056,96.44246816435911,32.39453200000003,97.35964256196937,30.964844000000028,98.17954336659778,29.261719000000028,98.90216702071234,27.121094000000028,99.54140924366295,24.81640600000003,99.91661856883626,22.675782000000027,100.0,20.371094000000028,99.8193414183224,18.667969000000028,99.45803137003124,16.417969000000028,98.6381305654028,13.617188000000056,96.98443323679605,11.585938000000056,95.24735803455758,9.992188000000056,93.51028283231912,8.621094000000028,91.68982619891669,7.0820320000000265,89.21623162321355,5.105469000000028,85.2001090312356,3.8984380000000556,82.08726867504981,3.074219000000028,79.53029266818294,2.140625,75.95886511319213,1.4804690000000278,72.76264688337443,0.7148440000000278,67.64869486964065,0.16406300000005558,61.15897770195976,0.0,56.128403561857695];
    drawNuc($x, $y, $height, $width, $C, "nucC");
  }

  function drawLogo($matrix, $order, $mstart, $mend, $regstart, $regend){
    // you have 15% height for every motif
    $ypos = 75 - $order * 15 - 15;
    $width = ($mend - $mstart) / ($regend - $regstart) * 100;
    $xpos  = ($mstart - $regstart) / ($regend - $regstart) * 100;
    //echo('<rect x="'.$xpos.'%" y="' . $ypos .'%" width="'.$width.'%" height="15%" style="stroke:green;fill:none;"/>'."\n");
    $ypos = $ypos * SVGH / 100;
    $nucw = $width / sizeof($matrix) / 100 * SVGW;
    for($i = 0; $i < sizeof($matrix); $i++){
       arsort($matrix[$i]);
       $xpos  = ($mstart + $i - $regstart) / ($regend - $regstart) * 100;
       $xpos  = $xpos * SVGW / 100;
       $baseline = 0;
       foreach($matrix[$i] as $nuc => $perc){
         $height = SVGH * 0.15 * $perc;
         if($nuc == 0){
           drawA($xpos, $ypos + $baseline, $height, $nucw);
         }
         elseif($nuc == 1){
           drawC($xpos, $ypos + $baseline, $height, $nucw);
         }
         elseif($nuc == 2){ 
           drawG($xpos, $ypos + $baseline, $height, $nucw);
         }
         else{
           drawT($xpos, $ypos + $baseline, $height, $nucw);
         }
         $baseline = $baseline + $height;
       }
    }
  }

  function drawMotifLogos($conn, $feats){
    $regstart = $feats["start"];
    $regend   = $feats["end"] + 1;
    for($i = 0; $i < sizeof($feats["motifs"]); $i++){
      if($feats["motifs"][$i][4] == "-"){
        $sql = "select probT,probG,probC,probA from pfm left join consensus_motif on (motif_id = consensus_motif_motif_id) where jaspar_code = '".$feats["motifs"][$i][10]."' order by position desc;";
      }
      else {
        $sql = "select probA,probC,probG,probT from pfm left join consensus_motif on (motif_id = consensus_motif_motif_id) where jaspar_code = '".$feats["motifs"][$i][10]."' order by position asc;";
      }
      $matrix = sql2array($conn, $sql);
      $mstart = $feats["motifs"][$i][2];
      $mend   = $feats["motifs"][$i][3];
      echo('<a xlink:href="http://summit.med.unideb.hu/summitdb/motif_view.php?maxid=10000&minid=1&mnelem=100&mxelem=120000&motive='.$feats["motifs"][$i][9].'" xlink:show="new">');
      drawLogo($matrix, $i, $mstart, $mend, $regstart, $regend);
      echo('</a>');
    }
  }

  function motifView($conn, $feats, $height){
    echo('<svg width="100%" height="'.$height.'" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" viewBox="0 0 '.SVGW.' '.SVGH.'" preserveAspectRatio="none">'."\n");
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
  $moview  = $_GET['mv']; // force to show MotifView instead of region view

  $conn = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  if($dbsnpid != ""){
    $motifs = motifsbydbsnp($conn, $dbsnpid);
    $overlap = false;
    for($i = 0; $i < sizeof($motifs["motifs"]); $i++){
      for($j = 0; $j < sizeof($motifs["snps"]); $j++){
        if($motifs["motifs"][$i][2] < $motifs["snps"][$j][2] && $motifs["motifs"][$i][3] > $motifs["snps"][$j][2]){
          $overlap = true;
          break;
        }
      }
      if($overlap == true) break;
    }
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
    if( ($dbsnpid == "" || $overlap == false) && $moview != 1){
      regionView($motifs, SVGH);
    } else {
      motifView($conn, $motifs, SVGH);
    }
  }
?>
</div>
</body>
</html>
