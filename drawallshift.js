
var datafirst = data;
var datasecond = data2;
var datathird = data3;


var maxValue = d3.max([  // Find the max value of a list of 3 elements
    d3.max(data, function(d) { return d.count; }), // Find the max value in `set1`
    d3.max(data2, function(d) { return d.count; }),  // Find the max value in `set2`
    d3.max(data3, function(d) { return d.count; })  // Find the max value in `set3`
]);


var width2 = "95%";
//$('#chart').width();
var w = $('#chart').width() *0.65;
//1400,
    h = $('#chart').height() *0.85;
//480;

var x = d3.scale.linear()
    .domain([0, 1])
    .range([0, w]);
var y = d3.scale.linear()
    .domain([0, 100])
    .rangeRound([h, 0]);

var chartlength2 = 2;
var chartlength = Math.max(datafirst.length, datasecond.length, datathird.length);

var chart = d3.select("#chart").append("svg")
    .attr("class", "chart")
    .attr("width", width2)
// datafirst.length -1)
    .attr("height", h + 200);

var line = d3.svg.line()
    .x(function(d,i) { return x((d.distance+50) / (chartlength*1.2))-15; })
    .y(function(d) { return y(d.count/maxValue*100)+50; })

movingAvg = function(n) {
    return function (points) {
        points = points.map(function(each, index, array) {
            var to = index + n - 1;
            var subSeq, sum;
            if (to < points.length) {
                subSeq = array.slice(index, to + 1);
                sum = subSeq.reduce(function(a,b) { return [a[0] + b[0], a[1] + b[1]]; });
                return sum.map(function(each) { return each / n; });
            }
            return undefined;
        });

 points = points.filter(function(each) { return typeof each !== 'undefined' });
        // Transform the points into a base line
        pathDesc = d3.svg.line().interpolate("basis")(points)
        // Remove the extra "M"
        return pathDesc.slice(1, pathDesc.length);
    }
}

var _movingSum;
var movingAverageLine = d3.svg.line()
    .x(function(d,i) { return x(d.distance+10)/(chartlength*0.9)+650; })
    .y(function(d,i) { return y(d.count/maxValue*90)+10; })
    .interpolate(movingAvg(5));




chart.append('svg:path')
 .attr('class', 'avg')
 .style("stroke", "#bb0000")
 .style("stroke-width", "5")
 .style("fill", "none")
 .attr("d", movingAverageLine(datafirst));

/* chart.append("svg:path")
 .style("stroke", "#ff0000")
 .style("stroke-width", "5")
 .style("fill", "none")
 .attr("d", line(datafirst));
*/

chart.append('svg:path')
 .attr('class', 'avg')
 .style("stroke", "#0000cc")
 .style("stroke-width", "5")
 .style("fill", "none")
 .attr("d", movingAverageLine(datasecond));

/* chart.append("svg:path")
 .style("stroke", "#0000aa")
 .style("stroke-width", "5")
 .style("fill", "none")
 .attr("d", line(datasecond));
*/

chart.append('svg:path')
 .attr('class', 'avg')
 .style("stroke", "#00cc00")
 .style("stroke-width", "5")
 .style("fill", "none")
 .attr("d", movingAverageLine(datathird));

/* chart.append("svg:path")
 .style("stroke", "#00aa00")
 .style("stroke-width", "5")
 .style("fill", "none")
 .attr("d", line(datathird));
*/
// setting up the x and the y axis
chart.append("line")
    .attr("x1", 50)
    .attr("y1", function(d,i) { return y(0/maxValue*90)-2; })
    .attr("x2", function(d) { return x(37)/(chartlength*0.9)+870; })
    .attr("y2", function(d,i) { return y(0/maxValue*90)-2; })
    .attr("stroke-width", 2)
    .attr("stroke", "black");

chart.append("line")
    .attr("x1", 70)
    .attr("y1", function(d,i) { return y(0/maxValue*90)+15; })
    .attr("x2", 70)
    .attr("y",function(d,i) { return y(1000/maxValue*90)+3; })
    .attr("stroke-width", 2)
    .attr("stroke", "black");


// the numbers to the chart are added here
chart.append("text")
    .attr("class", "label")
    .attr("x",870)
    .attr("y",function(d,i) { return y(0/maxValue*90)+25; })
    .text("0");
    
chart.append("text")
    .attr("class", "label")
    .attr("x",function(d) { return x(5)/(chartlength*0.9)+870; })
    .attr("y",function(d,i) { return y(0/maxValue*90)+25; })
    .text("+5");

chart.append("text")
    .attr("class", "label")
    .attr("x",function(d) { return x(-5)/(chartlength*0.9)+870; })
    .attr("y",function(d,i) { return y(0/maxValue*90)+25; })
    .text("-5");

chart.append("text")
    .attr("class", "label")
    .attr("x",function(d) { return x(10)/(chartlength*0.9)+870; })
    .attr("y",function(d,i) { return y(0/maxValue*90)+25; })
    .text("+10");

chart.append("text")
    .attr("class", "label")
    .attr("x",function(d) { return x(-10)/(chartlength*0.9)+870; })
    .attr("y",function(d,i) { return y(0/maxValue*90)+25; })
    .text("-10");

chart.append("text")
    .attr("class", "label")
    .attr("x",function(d) { return x(15)/(chartlength*0.9)+870; })
    .attr("y",function(d,i) { return y(0/maxValue*90)+25; })
    .text("+15");

chart.append("text")
    .attr("class", "label")
    .attr("x",function(d) { return x(-15)/(chartlength*0.9)+870; })
    .attr("y",function(d,i) { return y(0/maxValue*90)+25; })
    .text("-15");

chart.append("text")
    .attr("class", "label")
    .attr("x",function(d) { return x(20)/(chartlength*0.9)+870; })
    .attr("y",function(d,i) { return y(0/maxValue*90)+25; })
    .text("+20");

chart.append("text")
    .attr("class", "label")
    .attr("x",function(d) { return x(-20)/(chartlength*0.9)+870; })
    .attr("y",function(d,i) { return y(0/maxValue*90)+25; })
    .text("-20");


chart.append("text")
    .attr("class", "label")
    .attr("x",function(d) { return x(25)/(chartlength*0.9)+870; })
    .attr("y",function(d,i) { return y(0/maxValue*90)+25; })
    .text("+25");

chart.append("text")
    .attr("class", "label")
    .attr("x",function(d) { return x(-25)/(chartlength*0.9)+870; })
    .attr("y",function(d,i) { return y(0/maxValue*90)+25; })
    .text("-25");

chart.append("text")
    .attr("class", "label")
    .attr("x",function(d) { return x(30)/(chartlength*0.9)+870; })
    .attr("y",function(d,i) { return y(0/maxValue*90)+25; })
    .text("+30");

chart.append("text")
    .attr("class", "label")
    .attr("x",function(d) { return x(-30)/(chartlength*0.9)+870; })
    .attr("y",function(d,i) { return y(0/maxValue*90)+25; })
    .text("-30");

chart.append("text")
    .attr("class", "label")
    .attr("x",function(d) { return x(35)/(chartlength*0.9)+870; })
    .attr("y",function(d,i) { return y(0/maxValue*90)+25; })
    .text("+35");

chart.append("text")
    .attr("class", "label")
    .attr("x", 14)
    .attr("y",function(d,i) { return y(0/maxValue*90)+10; })
    .text("0");

chart.append("text")
    .attr("class", "label")
    .attr("x", 14)
    .attr("y",function(d,i) { return y(5/maxValue*90)+10; })
    .text("5")
    .style("opacity",function(d){
            if (maxValue < 100) {return "1.0"}
            else 	{ return "0.0" }
        ;});

chart.append("text")
    .attr("class", "label")
    .attr("x", 14)
    .attr("y",function(d,i) { return y(10/maxValue*90)+10; })
    .text("10")
    .style("opacity",function(d){
            if (maxValue < 100) {return "1.0"}
            else        { return "0.0" }
        ;});

chart.append("text")
    .attr("class", "label")
    .attr("x", 14)
    .attr("y",function(d,i) { return y(15/maxValue*90)+10; })
    .text("15")
    .style("opacity",function(d){
            if (maxValue < 100) {return "1.0"}
            else        { return "0.0" }
        ;});

chart.append("text")
    .attr("class", "label")
    .attr("x", 14)
    .attr("y",function(d,i) { return y(20/maxValue*90)+10; })
    .text("20")
    .style("opacity",function(d){
            if (maxValue < 100) {return "1.0"}
            else        { return "0.0" }
        ;});

chart.append("text")
    .attr("class", "label")
    .attr("x", 14)
    .attr("y",function(d,i) { return y(50/maxValue*90)+10; })
    .text("50");

chart.append("text")
    .attr("class", "label")
    .attr("x", 14)
    .attr("y",function(d,i) { return y(100/maxValue*90)+10; })
    .text("100");

chart.append("text")
    .attr("class", "label")
    .attr("x", 14)
    .attr("y",function(d,i) { return y(200/maxValue*90)+10; })
    .text("200");

chart.append("text")
    .attr("class", "label")
    .attr("x", 14)
    .attr("y",function(d,i) { return y(500/maxValue*90)+10; })
    .text("500");

chart.append("text")
    .attr("class", "label")
    .attr("x", 14)
    .attr("y",function(d,i) { return y(1000/maxValue*90)+10; })
    .text("1000");
