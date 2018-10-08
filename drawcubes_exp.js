function DrawAllShizCubes(howtosort,isitnew){

// setup x 
var xValue = function(d) { return d.motive_name;}, // data -> value
    xScale = d3.scale.linear().range([0, 1]), // value -> display

    xAxis = d3.svg.axis().scale(xScale).orient("center");

// setup y
var yValue = function(d) { return d.std_dev; },
    yScale = d3.scale.linear().range([1, 0]), // value -> display
    yAxis = d3.svg.axis().scale(yScale).orient("left");

// setup fill color
// a kockak itt vannak elnevezve
  var cValue = function(d) { return d.exp_name;},
    color = d3.scale.category20();

if (howtosort == "data") {
var sorteddata = data.sort(function(x, y){
   return d3.ascending(x.exp_ID, y.exp_ID);
});
} else {
var sorteddata = data.sort(function(x, y){
   return d3.ascending(x.antiagent, y.antiagent);
});
}

// add the graph canvas to the body of the webpage
  var svg = d3.select("#chart2").append("svg")
    .attr("width", 250 )
    .attr("height", 10000 )
  .append("g");

//load data
  // x-axis
  svg.append("g")
      .attr("class", "axisRed")

  // y-axis
  svg.append("g")
      .attr("class", "axisRed")

  // draw dots
  svg.selectAll(".dot")
    .data(sorteddata)
    .enter().append("circle")
      .style("fill", function(d) { return color(cValue(d));}) 

// draw legend
  var legend = svg.selectAll(".legend")
      .data(color.domain())
    .enter().append("g")
      .attr("class", function(d) { return d + "leg legend " + isitnew;})
      .attr("transform", function(d, i) { return "translate( 0," + i * 20 + ")"; });
//add links
  legend.append("a")
      .attr("xlink:href", function(d, x) { return "http://genomics.dote.hu/summitdb/motive_view.php?maxid=66&minid=1&mnelem=100&mxelem=12345&motive=" + data[x].antiagent;} ) 
      .append("rect")
      .attr("x", width - 1160)
      .attr("width", 48)
      .attr("height", 18)
      .style("fill", "transparent");

  //add cube
  legend.append("g")
        .append("rect")
        .attr("x", width - 1102)
      .attr("width", 18)
      .attr("height", 18)
        .style("fill", color);

// draw legend text
  legend.append("text")
      .attr("x", width - 1118)
      .attr("y", 9)
      .attr("dy", ".35em")
      .style("text-anchor", "end")
      .text(function(d) { return d;})
      .style("pointer-events", "none");
;


};

