function redcircle(x) {

  var selection3 = document.querySelector('.red3') !== null;
  if (selection3) {
    document.querySelector(".red3").style.stroke = "grey";
    document.querySelector(".red3").style.strokeWidth= "1";
    document.querySelector(".red3").classList.remove('red3');
  }

  var selection2 = document.querySelector('.red2') !== null;
  if (selection2) {
    document.querySelector(".red2").classList.add('red3');
    document.querySelector(".red2").classList.remove('red2');
  }

  var selection1 = document.querySelector('.red1') !== null;
  if (selection1) {
    document.querySelector(".red1").classList.add('red2');
    document.querySelector(".red1").classList.remove('red1');
  }

  document.querySelector(x).classList.add('red1');
  document.querySelector(".red1").style.stroke = "black";
  document.querySelector(".red1").style.strokeWidth= "4";
}




function DrawAllShizStand_dev(argy, argx, namey, namex){
var width2 = $('#motifchart1').width();

d3.select(window).on('resize', resize); 

function resize() {
    // update width
    width = parseInt(d3.select('#motifchart1').style('width'), 10);
}



// setup x
var xValue = function(d) { return d[argx];}, // data -> value
    xScale = d3.scale.linear().range([0, width2 - 55]), // value -> display
    xMap = function(d) { return xScale(xValue(d));}, // data -> display
    xAxis = d3.svg.axis().scale(xScale).orient("center");

// setup y
var yValue = function(d) { return d[argy]; }, // data -> value (this is acsi magics if stand_dev is NA retun 0)
    yScale = d3.scale.linear().range([600, 0]), // value -> display
    yMap = function(d) { return yScale(yValue(d));}, // data -> display
    yAxis = d3.svg.axis().scale(yScale).orient("left");

// setup fill color
// a kockak nem itt vannak elnevezve
  var cValue = function(d) { return d.antibody;},
    color = d3.scale.category20();
 //   .attr("transform", "translate(100px , 0 )");

// add the graph canvas to the body of the webpage
  var svg = d3.select("#motifchart1").append("svg")
//    .attr("width", width + margin.left + margin.right + legendtitle)
    .attr("width", "95%")
    .attr("height", "99%")
  .append("g")
    .attr("transform", "translate(" + margin.left + "," + margin.top + ")");
// add the tooltip area to the webpage
  var tooltip = d3.select("#motifchart1").append("div")
    .attr("class", "tooltip")
    .style("opacity", 0);

// load data


  // don't want dots overlapping axis, so add in buffer to data domain
  xScale.domain([d3.min(data, xValue)-1, d3.max(data, xValue)+1]);
  yScale.domain([d3.min(data, yValue)-6, d3.max(data, yValue)+1]);
  //yScale.domain([-80, +80]);
  // x-axis
  svg.append("g")
      .attr("class", "x axis")
      .attr("transform", "translate(0, 600 )")
      .call(xAxis)
    .append("text")
      .attr("class", "label")
      .attr("x", width)
      .attr("y", -6)
      .style("text-anchor", "end")
      .text(namex); // y-axis
  svg.append("g")
      .attr("class", "y axis")
      .call(yAxis)
    .append("text")
      .attr("class", "label")
      .attr("transform", "rotate(-90)")
      .attr("y", 6)
      .attr("dy", ".71em")
      .style("text-anchor", "end")
      .text(namey);





  // draw dots

 var dots =  svg.selectAll(".dot")
.data(data)
.enter()
.append("path")
.attr("class", function(d) { return "dot " + d.antibody + " " + d.cell_line;})
.attr("id", function(d) { return "dot_" + d.exp_ID;})
.attr("data-target", function(d) { return d.antibody + " " + d.cell_line;})
.attr("data-cell_line", function(d) { return d.cell_line;})
.attr("transform", function(d) { return "translate(" + xScale(d[argx]) + "," + yScale(d[argy]) + ")"; })
.attr("d", d3.svg.symbol().type( function(d) {
	if(d.factor_type == "Cofactor"){
            return "triangle-down";
	}
                else {
            return "circle";
        }}))
  .style("fill", function(d) { return d.colour_hex;})
//  .on("click",  window.open("https://www.w3schools.com"))
  .style("opacity", function(d) {
        if(d.factor_type == "Cofactor"){
            return 0.5;
}
                else {
            return 0.7;
                        }
    }
)
  .attr("r",3.5)




.on("mouseover", function(d) {

if(argx == "average"){


tooltip.transition()
               .duration(200)
               .style("opacity",  0.9);
 tooltip.html("<br/> (experiment name:" + d.exp_name 
		+ "<br/> cell line: " + d.cell_line 
                + "<br/> antibody: " + d.antibody 
		+ "<br/> average position: " + d.average 
		+ "<br/> element number: " + d.element_num 
		+ "<br/> standard deviation: " + d.std_dev 
		+ ")")
               .style("left", (d3.event.pageX + 5) + "px")
               .style("top", (d3.event.pageY - 28) + "px")
               //.style("transition: opacity 


}

else {

tooltip.transition()
               .duration(200)
               .style("opacity",  0.9);
 tooltip.html("<br/> cell line: " + d.cell_line
                + "<br/> antibody: " + d.antibody
                + "<br/> average position: " + d.average
                + "<br/> element number: " + d.element_num
                + "<br/> standard deviation: " + d.std_dev
                + ")")
               .style("left", (d3.event.pageX + 5) + "px")
               .style("top", (d3.event.pageY - 28) + "px")

}

      })

      .on("mouseout", function(d) {
          tooltip.transition()
               .duration(500)
               .style("opacity", 0);})

.on("click", function(d) {choosethree( d.cell_line + ", " + d.antibody + ", " + d.element_num, d.average_deviation_id,  d.exp_ID, d.avg_name);
//redcircle function goes under
redcircle( "#dot_" + d.exp_ID);
//alert('"' + "#dot_" + d.exp_ID + '"');

;
})
;


};

