<?php
include('dbutil.php');

function fillCells($array, $default, $type){
  $uniq = [];
  $options = "";
  foreach($array as $record){
     array_push($uniq, $record[$type]);
  }
  $uniq = array_unique($uniq);

  foreach($uniq as $record){
    if($record != $default){
      $options = $options . "<option>" . $record . "</option>";
    }
    else{
      $options = $options .  '<option selected="selected">' . $record . "</option>";
    }
  }
  return($options);
}

function getExpCellAntiBody($conn, $expName){
  $sql = "SELECT experiment.name, cell_lines.name AS cell_line, antibody.name AS antibody, antibody.antibody_id AS antid, cell_lines.cellline_id AS cellid
          FROM
          experiment
          LEFT JOIN cell_lines ON cell_lines.cellline_id = experiment.cell_lines_cellline_id
          LEFT JOIN antibody ON antibody.antibody_id = experiment.antibody_antibody_id
          WHERE experiment.experiment_id = $expName";
  $res = $conn->query($sql);
  $assoc = fetchAssoc($res);
  return($assoc);
}

function getAllExpCellAnti($conn, $motifid, $minelemnum){
  $sql = "SELECT experiment.name          AS name,
                 antibody.name            AS antibody,
                 cell_lines.name          AS cell_line,
                 cell_lines.cellline_id   AS cellid,
                 experiment.experiment_id AS expid,
                 average_deviation.element_num
          FROM experiment
               LEFT JOIN average_deviation ON average_deviation.experiment_experiment_id = experiment.experiment_id 
               LEFT JOIN antibody ON experiment.antibody_antibody_id = antibody.antibody_id
               LEFT JOIN cell_lines ON experiment.cell_lines_cellline_id = cell_lines.cellline_id
          WHERE average_deviation.consensus_motif_motif_id = $motifid AND
                average_deviation.element_num >= $minelemnum;";

  $res = $conn->query($sql);
  $assoc = fetchAssoc($res);
  return($assoc);
}

function expJS($allExperiment, $jsonData1, $jsonData2, $jsonData3){
  $a = false;
  $b = false;
  $c = false;

  foreach($allExperiment as $ex){
    if($ex["name"] === $jsonData1[0]["name"]){
      $a = true;
    }
    if($ex["name"] === $jsonData2[0]["name"]){
      $b = true;
    }
    if($ex["name"] === $jsonData3[0]["name"]){
      $c = true;
    }
  }

  if($jsonData1 === NULL || $a == false){
    $jsonData1 = [$allExperiment[0]];
  }
  if($jsonData2 === NULL || $b == false){
    $jsonData2 = [$allExperiment[0]];
  }
  if($jsonData3 === NULL || $c == false){
    $jsonData3 = [$allExperiment[0]];
  }
  echo "
        var allExperiment = " . json_encode($allExperiment) . ";
        var data1start = " . json_encode($jsonData1) . ";
        var data2start = " . json_encode($jsonData2) . ";
        var data3start = " . json_encode($jsonData3) . ";

        $('#cellformexp1').prepend('" . fillCells($allExperiment, $jsonData1[0]["cell_line"], "cell_line") . "');
        $('#cellformexp2').prepend('" . fillCells($allExperiment, $jsonData2[0]["cell_line"], "cell_line") . "');
        $('#cellformexp3').prepend('" . fillCells($allExperiment, $jsonData3[0]["cell_line"], "cell_line") . "');

        fillSelect('#antiformexp1', data1start[0].cell_line, allExperiment, data1start[0].antibody, 'cell_line', \"antibody\");
        fillSelect('#antiformexp2', data2start[0].cell_line, allExperiment, data2start[0].antibody, 'cell_line', \"antibody\");
        fillSelect('#antiformexp3', data3start[0].cell_line, allExperiment, data3start[0].antibody, 'cell_line', \"antibody\");

        fillExpByAntiCell('#formexp1', data1start[0].antibody, data1start[0].cell_line, allExperiment, data1start[0].name);
        fillExpByAntiCell('#formexp2', data2start[0].antibody, data2start[0].cell_line, allExperiment, data2start[0].name);
        fillExpByAntiCell('#formexp3', data3start[0].antibody, data3start[0].cell_line, allExperiment, data3start[0].name);

        $('#cellformexp1').change(function(){
            fillSelect('#antiformexp1', $('#cellformexp1').val(), allExperiment, \"\", \"cell_line\", \"antibody\");
            fillExpByAntiCell('#formexp1', $('#antiformexp1').val(), $('#cellformexp1').val(), allExperiment);
        });

        $('#cellformexp2').change(function(){
            fillSelect('#antiformexp2', $('#cellformexp2').val(), allExperiment, \"\", \"cell_line\", \"antibody\");
            fillExpByAntiCell('#formexp2', $('#antiformexp2').val(), $('#cellformexp2').val(), allExperiment);
        });

        $('#cellformexp3').change(function(){
            fillSelect('#antiformexp3', $('#cellformexp3').val(), allExperiment, \"\", \"cell_line\", \"antibody\");
            fillExpByAntiCell('#formexp3', $('#antiformexp3').val(), $('#cellformexp3').val(), allExperiment);
        });

        $('#antiformexp1').change(function(){
            fillExpByAntiCell('#formexp1', $('#antiformexp1').val(), $('#cellformexp1').val(), allExperiment);
        });

        $('#antiformexp2').change(function(){
            fillExpByAntiCell('#formexp2', $('#antiformexp2').val(), $('#cellformexp2').val(), allExperiment);
        });

        $('#antiformexp3').change(function(){
            fillExpByAntiCell('#formexp3', $('#antiformexp3').val(), $('#cellformexp3').val(), allExperiment);
        });

        $('#antiformexp1v2').prepend('" . fillCells($allExperiment, $jsonData1[0]["antibody"], "antibody") . "');
        $('#antiformexp2v2').prepend('" . fillCells($allExperiment, $jsonData2[0]["antibody"], "antibody") . "');
        $('#antiformexp3v2').prepend('" . fillCells($allExperiment, $jsonData3[0]["antibody"], "antibody") . "');

        fillSelect('#cellformexp1v2', data1start[0].antibody, allExperiment, data1start[0].cell_line, 'antibody', 'cell_line');
        fillSelect('#cellformexp2v2', data2start[0].antibody, allExperiment, data2start[0].cell_line, 'antibody', 'cell_line');
        fillSelect('#cellformexp3v2', data3start[0].antibody, allExperiment, data3start[0].cell_line, 'antibody', 'cell_line');
 
        fillExpByAntiCell('#formexp1v2', data1start[0].antibody, data1start[0].cell_line, allExperiment, data1start[0].name);
        fillExpByAntiCell('#formexp2v2', data2start[0].antibody, data2start[0].cell_line, allExperiment, data2start[0].name);
        fillExpByAntiCell('#formexp3v2', data3start[0].antibody, data3start[0].cell_line, allExperiment, data3start[0].name);

        $('#antiformexp1v2').change(function(){
            fillSelect('#cellformexp1v2', $('#antiformexp1v2').val(), allExperiment, '', 'antibody', 'cell_line');
            fillExpByAntiCell('#formexp1v2', $('#antiformexp1v2').val(), $('#cellformexp1v2').val(), allExperiment);
        });

        $('#antiformexp2v2').change(function(){
            fillSelect('#cellformexp2v2', $('#antiformexp2v2').val(), allExperiment, '', 'antibody', 'cell_line');
            fillExpByAntiCell('#formexp2v2', $('#antiformexp2v2').val(), $('#cellformexp2v2').val(), allExperiment);
        });

        $('#antiformexp3v2').change(function(){
            fillSelect('#cellformexp3v2', $('#antiformexp3v2').val(), allExperiment, '', 'antibody', 'cell_line');
            fillExpByAntiCell('#formexp3v2', $('#antiformexp3v2').val(), $('#cellformexp3v2').val(), allExperiment);
        });

        $('#cellformexp1v2').change(function(){
            fillExpByAntiCell('#formexp1v2', $('#antiformexp1v2').val(), $('#cellformexp1v2').val(), allExperiment);
        });

        $('#cellformexp2v2').change(function(){
            fillExpByAntiCell('#formexp2v2', $('#antiformexp2v2').val(), $('#cellformexp2v2').val(), allExperiment);
        });

        $('#cellformexp3v2').change(function(){
            fillExpByAntiCell('#formexp3v2', $('#antiformexp3v2').val(), $('#cellformexp3v2').val(), allExperiment);
        });
  ";
}

function expBoxes(){
  echo "
    <div class=\"wrapper\">

      <select id=\"cellformexp1\" class=\"one exp1\" type=\"text\" value=\"\" placeholder=\"Type to filter\">
      </select>

      <select id=\"antiformexp1\" type=\"text\" class=\"two exp1\" value=\"\" placeholder=\"Type to filter\">
      </select>

      <select id=\"formexp1\" type=\"text\" value=\"\" class=\"three exp1\" placeholder=\"Type to filter\">
      </select>

      <button class=\"threeAH\" onclick=\"jumptoexp('formexp1')\"> experiment view </button>
      <br>

      <select id=\"cellformexp2\" type=\"text\" class=\"four exp2\" value=\"\" placeholder=\"Type to filter\">
      </select>

      <select id=\"antiformexp2\" type=\"text\" class=\"five exp2\" value=\"\" placeholder=\"Type to filter\">
      </select>

      <select id=\"formexp2\" type=\"text\" class=\"six exp2\" value=\"\"  placeholder=\"Type to filter\">
      </select>
      <button class=\"sixAH\" onclick=\"jumptoexp('formexp2')\"> experiment view </button>
      <br>

      <select id=\"cellformexp3\" type=\"text\" value=\"\" class=\"seven exp3\" placeholder=\"Type to filter\">
      </select>

      <select id=\"antiformexp3\" type=\"text\" value=\"\" class=\"eight exp3\" placeholder=\"Type to filter\">
      </select>

      <select id=\"formexp3\" type=\"text\" value=\"\" class=\"nine exp3\" placeholder=\"Type to filter\">
      </select>
      <button class=\"nineAH\" onclick=\"jumptoexp('formexp3')\"> experiment view </button>

      <br>
    </div>
";
}

function expBoxesCell(){
  echo <<<OUT
   <div class="wrapper">

      <select id="cellformexp1v2" class="two exp1" type="text" value="" placeholder="Type to filter">
      </select>

      <select id="antiformexp1v2" type="text" class="one exp1" value="" placeholder="Type to filter">
      </select>

      <select id="formexp1v2" type="text" value="" class="three exp1" placeholder="Type to filter">
      </select>
      <button class="threeAH" onclick="jumptoexp('formexp1v2')"> experiment view </button>
      <br>

      <select id="cellformexp2v2" type="text" class="five exp2" value="" placeholder="Type to filter">
      </select>

      <select id="antiformexp2v2" type="text" class="four exp2" value="" placeholder="Type to filter">
      </select>

      <select id="formexp2v2" type="text" class="six exp2" value=""  placeholder="Type to filter">
      </select>
      <button class="sixAH" onclick="jumptoexp('formexp2v2')"> experiment view </button>
      <br>

      <select id="cellformexp3v2" type="text" value="" class="eight exp3" placeholder="Type to filter">
      </select>

      <select id="antiformexp3v2" type="text" value="" class="seven exp3" placeholder="Type to filter">
      </select>

      <select id="formexp3v2" type="text" value="" class="nine exp3" placeholder="Type to filter">
      </select>
      <button class="nineAH" onclick="jumptoexp('formexp3v2')"> experiment view </button>

   </div>

OUT;
}

function getMotifPos($conn, $motifName, $expName){
  $sql = "SELECT motifpos_id FROM venn_view WHERE motif_id = $motifName AND experiment_id = $expName";
  $res = $conn->query($sql);
  $assoc = fetchAssoc($res);
  return($assoc);
}

?>
