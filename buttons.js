//this part helps rewrite the graph when you push one of the buttons
function updateelem_num() {
    d3.select("svg").remove();
    DrawAllShizStand_dev("element_num", "average", "Element number", nameOfX);
    unshadow();
    document.getElementById("y2").style.boxShadow = "4px 6px 8px #555555";
    document.getElementById("y2").style.color = "#111111";
    document.getElementById("y2").style.backgroundColor = "#DDDDDD";
};

function updatestand_dev() {
    d3.select("svg").remove();
    DrawAllShizStand_dev("std_dev", "average", "Standard deviation of positions", nameOfX);
    unshadow();
    document.getElementById("y1").style.boxShadow = "4px 6px 8px #555555";
    document.getElementById("y1").style.color = "#111111";
    document.getElementById("y1").style.backgroundColor = "#DDDDDD";
};

function update_avg_std() {
    d3.select("svg").remove();
    DrawAllShizStand_dev("avgstd_dev", "avg_avg", "Average standard deviation of positions", nameOfX);
    unshadow();
    document.getElementById("y3").style.boxShadow = "4px 6px 8px #555555";
    document.getElementById("y3").style.color = "#111111";
    document.getElementById("y3").style.backgroundColor = "#DDDDDD";
};

function update_avg_elem() {
    d3.select("svg").remove();
    DrawAllShizStand_dev("avg_elem", "avg_avg", "Average element number", nameOfX);
    unshadow();
    document.getElementById("y4").style.boxShadow = "4px 6px 8px #555555";
    document.getElementById("y4").style.color = "#111111";
    document.getElementById("y4").style.backgroundColor = "#DDDDDD";
};

function update_alphabet() {
    d3.selectAll("#chart2 svg").remove();
    DrawAllShizCubes("sorteddata", "new", "motive");
};

function update_nonalphabet() {
    d3.selectAll("#chart2 svg", "new").remove();
    DrawAllShizCubes("data", "new", "motive");
};

function update_alphabet_cell() {
    d3.selectAll("#chart2 svg").remove();
    DrawAllShizCubes("sorteddata", "new", "cell");
};

function update_nonalphabet_cell() {
    d3.selectAll("#chart2 svg", "new").remove();
    DrawAllShizCubes("data", "new", "cell");
};

//some lazy jquery to fde out some of the legends

$(document).ready(function(){
    $("#nodotz").click(function(){
        $(".dot").fadeOut("slow");
    });
});

$(document).ready(function(){
    $("#yesdotz").click(function(){
        $(".dot").fadeIn("slow");
    });
});

// this will give the selected button a nice shadow

function unshadow(){
    document.getElementById("y1").style.boxShadow = "1px 2px 3px #555555";
    document.getElementById("y2").style.boxShadow = "1px 2px 3px #555555";
    document.getElementById("y3").style.boxShadow = "1px 2px 3px #555555";
    document.getElementById("y4").style.boxShadow = "1px 2px 3px #555555";
    document.getElementById("y1").style.color = "#DDDDDD";
    document.getElementById("y2").style.color = "#DDDDDD";
    document.getElementById("y3").style.color = "#DDDDDD";
    document.getElementById("y4").style.color = "#DDDDDD";
    document.getElementById("y1").style.backgroundColor = "#777777";
    document.getElementById("y2").style.backgroundColor = "#777777";
    document.getElementById("y3").style.backgroundColor = "#777777";
    document.getElementById("y4").style.backgroundColor = "#777777";
};

