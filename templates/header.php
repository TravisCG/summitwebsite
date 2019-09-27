<?php

function show_full_navigation(){
  echo <<<TEMPHEAD
<div class="container_16">
<!--topdiv -->
<a href="https://www.edu.unideb.hu/"><img src="images/University_logo.png" alt="SummitDB"  title="SummitDB" class="logo"/></a>
<a href="http://summit.med.unideb.hu/summitdb/"><img src="images/logo.gif" alt="SummitDB"  title="SummitDB" class="logomid"/></a>
<a href="http://www.naik.hu/en/"><img src="images/naik-logo.png" alt="SummitDB"  title="SummitDB" class="logo2"/></a>
</div>                                               

<div class="foo"> 
  <ul class="navlink">
    <li><button id="homebut" class="navbutton" onclick="dochange('index.php')">Home</button></li>
    <li><button class="navbutton" >Search views</button>
    <ul class="subnav">
      <li><button id="motifbut" class="navbutton"  onclick="dochange('motif_preview.php')">MotifView</button></li>
      <li><button id="pairbut"  class="navbutton" onclick="dochange('paired_shift_view.php?exp1=16&exp2=19&exp3=4&motive=CTCF&motifid=32&limit=30&low_limit=-30&mnelem=1000')">PairShiftView</button></li>
      <li><button id="vennbut" class="navbutton" onclick="dochange('venn_diagramm.php?exp1=16&exp2=19&exp3=4&motive=CTCF&motifid=32&mnelem=1000')">VennView</button></li>
      <li><button id="exbut" class="navbutton" onclick="dochange('experiment_preview.php')">ExperimentView</button></li>
      <li><button id="snpbut" class="navbutton" onclick="dochange('dbsnp.php')">dbSNPView</button></li>
      <a style="padding:0px;" href="http://summit.med.unideb.hu/jbrowse" target="_blank"><li><button id="jbrbut">GenomeView</button></li></a>
    </ul></li>
    <li><button id="docbut" class="navbutton" onclick="dochange('Documentation.php')" >Documentation</button></li>
    <li><button id="helbut" class="navbutton" onclick="dochange('Help.php')">Help</button></li>
    <li><button id="tutbut" class="navbutton" onclick="dochange('tutorial.php')">Tutorial</button></li>
    <li><button id="globut" class="navbutton" onclick="dochange('glossary.php')">Glossary</button></li>
  </ul>
</div>
TEMPHEAD;

}
?>
