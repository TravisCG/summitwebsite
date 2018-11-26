<?php

function show_full_navigation(){
  echo <<<TEMPHEAD
<div class="container_16">
<!--topdiv -->
<a href="https://www.edu.unideb.hu/"><img src="University_logo.png" alt="SummitDB"  title="SummitDB" class="logo"/></a>
  <img src="logo.gif" alt="SummitDB"  title="SummitDB" class="logomid"/>
  <a href="http://www.naik.hu/en/"><img src="naik-logo.png" alt="SummitDB"  title="SummitDB" class="logo2"/>
  </a>
</div>                                               

<div class="foo"> 
  <ul class="navlink">
    <li><button id="homebut" class="navbutton" onclick="dochange('index.php')">Home</button></li>
    <li><button class="navbutton" >Search views</button>
    <ul class="subnav">
      <li><button id="motifbut" class="navbutton"  onclick="dochange('motif_preview.php')">Motif view</button></li>
      <li><button id="pairbut"  class="navbutton" onclick="dochange('paired_shift_view.php?exp1=16&exp2=19&exp3=4&motive=CTCF&motifid=32&limit=25&low_limit=-25&mnelem=1000')">Pairshift view</button></li>
      <li><button id="vennbut" class="navbutton" onclick="dochange('venn_diagramm.php?exp1=16&exp2=19&exp3=4&motive=CTCF&motifid=32&mnelem=1000')">Venn diagramm view</button></li>
      <li><button id="exbut" class="navbutton" onclick="dochange('experiment_preview.php')">Experiment view</button></li>
      <li><button id="snpbut" class="navbutton" onclick="dochange('dbsnp.php')">dbSNP view</button></li>
      <a style="padding:0px;" href="http://summit.med.unideb.hu/jbrowse" target="_blank"><li><button id="jbrbut">Genome view</button></li></a>
    </ul></li>
    <li><button id="docbut" class="navbutton" onclick="dochange('Documentation.html')" >Documentation</button></li>
    <li><button id="helbut" class="navbutton" onclick="dochange('Help.html')">Help</button></li>
    <li><button id="tutbut" class="navbutton" onclick="dochange('tutorial.html')">Tutorial</button></li>
    <li><button id="globut" class="navbutton" onclick="dochange('glossary.html')">Glossary</button></li>
  </ul>
</div>
TEMPHEAD;

}

function show_small_navigation($title){
  echo <<<SMALLNAV
<div class="container_16">
  <a href="http://www.naik.hu/en/"><img src="naik-logo.png" alt="SummitDB"  title="SummitDB" class="logo2"/></a>
  <img src="logo.gif" alt="SummitDB"  title="SummitDB" class="logomid"/>
  <a href="https://www.edu.unideb.hu/"><img src="University_logo.png" alt="SummitDB"  title="SummitDB" class="logo"/></a>
</div>
<div class="foo">
    <ul class="navlink">
        <li><a href="index.php" title="Home" class="active">Home</a></li>
        <li onclick="glossToggle()"><a title="$title" class="active">Glossary</a></li>
    </ul>
</div>
SMALLNAV;
}

?>
