<?php

function show_header(){
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
    <li><button id="homebut" onclick="dochange('introduction.html')">Home</button></li>
    <li><button>Search views</button>
    <ul class="subnav">
      <li><button id="motifbut"  onclick="dochange('motif_preview.php')">Motif view</button></li>
      <li><button id="pairbut"  onclick="dochange('paired_shift_preview.php?exp1=16&exp2=19&exp3=4&motive=CTCF&motifid=32&limit=25&low_limit=-25&formminelem=1000')">Pairshift view</button></li>
      <li><button id="vennbut"  onclick="dochange('venn_preview.php?exp1=16&exp2=19&exp3=4&motive=CTCF&motifid=32&mnelem=1000')">Venn diagramm view</button></li>
      <li><button id="exbut"  onclick="dochange('experiment_preview.php')">Experiment view</button></li>
      <li><button id="snpbut" onclick="dochange('dbsnp.php')">dbSNP view</li>
      <a style="padding:0px;" href="http://summit.med.unideb.hu/jbrowse" target="_blank"><li><button id="jbrbut">Genome view</button></li></a>
    </ul></li>
    <li><button id="docbut" onclick="dochange('Documentation.html')" >Documentation</button></li>
    <li><button id="helbut" onclick="dochange('Help.html')">Help</button></li>
    <li><button id="tutbut" onclick="dochange('tutorial.html')">Tutorial</button></li>
    <li><button id="globut" onclick="dochange('glossary.html')">Glossary</button></li>
  </ul>
</div>
TEMPHEAD;

}

?>
