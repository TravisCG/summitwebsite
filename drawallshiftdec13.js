//function DrawAllShizStand_dev(argy, argx){
//var datafirst = [{"distance":-49,"count":97},{"distance":-48,"count":105},{"distance":-47,"count":89},{"distance":-46,"count":89},{"distance":-45,"count":88},{"distance":-44,"count":99},{"distance":-43,"count":97},{"distance":-42,"count":96},{"distance":-41,"count":105},{"distance":-40,"count":87},{"distance":-39,"count":78},{"distance":-38,"count":106},{"distance":-37,"count":87},{"distance":-36,"count":85},{"distance":-35,"count":116},{"distance":-34,"count":106},{"distance":-33,"count":102},{"distance":-32,"count":116},{"distance":-31,"count":95},{"distance":-30,"count":89},{"distance":-29,"count":103},{"distance":-28,"count":87},{"distance":-27,"count":104},{"distance":-26,"count":126},{"distance":-25,"count":101},{"distance":-24,"count":104},{"distance":-23,"count":117},{"distance":-22,"count":113},{"distance":-21,"count":110},{"distance":-20,"count":99},{"distance":-19,"count":72},{"distance":-18,"count":100},{"distance":-17,"count":97},{"distance":-16,"count":94},{"distance":-15,"count":101},{"distance":-14,"count":104},{"distance":-13,"count":117},{"distance":-12,"count":108},{"distance":-11,"count":98},{"distance":-10,"count":89},{"distance":-9,"count":99},{"distance":-8,"count":100},{"distance":-7,"count":112},{"distance":-6,"count":129},{"distance":-5,"count":123},{"distance":-4,"count":117},{"distance":-3,"count":119},{"distance":-2,"count":114},{"distance":-1,"count":123},{"distance":0,"count":124},{"distance":1,"count":112},{"distance":2,"count":102},{"distance":3,"count":118},{"distance":4,"count":88},{"distance":5,"count":107},{"distance":6,"count":109},{"distance":7,"count":110},{"distance":8,"count":105},{"distance":9,"count":131},{"distance":10,"count":100},{"distance":11,"count":91},{"distance":12,"count":95},{"distance":13,"count":110},{"distance":14,"count":108},{"distance":15,"count":88},{"distance":16,"count":107},{"distance":17,"count":93},{"distance":18,"count":94},{"distance":19,"count":123},{"distance":20,"count":95},{"distance":21,"count":112},{"distance":22,"count":109},{"distance":23,"count":119},{"distance":24,"count":132},{"distance":25,"count":118},{"distance":26,"count":109},{"distance":27,"count":106},{"distance":28,"count":121},{"distance":29,"count":122},{"distance":30,"count":112},{"distance":31,"count":133},{"distance":32,"count":103},{"distance":33,"count":102},{"distance":34,"count":104},{"distance":35,"count":108},{"distance":36,"count":96},{"distance":37,"count":89},{"distance":38,"count":87},{"distance":39,"count":79},{"distance":40,"count":83},{"distance":41,"count":83},{"distance":42,"count":101},{"distance":43,"count":99},{"distance":44,"count":112},{"distance":45,"count":83},{"distance":46,"count":102},{"distance":47,"count":113},{"distance":48,"count":98},{"distance":49,"count":112}] ;
//var datasecond = [34, 16, 82, 16, 15, 45, 11, 20, 23, 19, 8, 15, 2, 3, 66, 2, 76, 5, 20, 1, 30, 50, 9, 80, 5, 7, 34];

var datafirst = data2;
var datasecond = data;

var maxValue = d3.max([  // Find the max value of a list of 2 elements
    d3.max(dataJSON3.set1, function(d) { return d.n2; }), // Find the max value in `set1`
    d3.max(dataJSON3.set2, function(d) { return d.n2; })  // Find the max value in `set2`
]);


var width2 = $('#chart').width();
var w = 1439,
    h = 480;

var x = d3.scale.linear()
    .domain([0, 1])
    .range([0, w]);
var y = d3.scale.linear()
    .domain([0, 100])
    .rangeRound([h, 0]);

var chartlength2 = 2;
var chartlength = Math.max(datafirst.length, datasecond.length);

var chart = d3.select("#chart").append("svg")
    .attr("class", "chart")
    .attr("width", width2)
//* datafirst.length -1)
    .attr("height", h + 200);

var line = d3.svg.line()
    .x(function(d,i) { return x(i) / chartlength; })
    .y(function(d) { return y(d.count)+150; })

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
        // Transform the points into a basis line
        pathDesc = d3.svg.line().interpolate("basis")(points)
        // Remove the extra "M"
        return pathDesc.slice(1, pathDesc.length);
    }
}

var _movingSum;
var movingAverageLine = d3.svg.line()
    .x(function(d,i) { return x(i)/ chartlength; })
    .y(function(d,i) { return y(d.count)+150; })
    .interpolate(movingAvg(5));

chart.append('svg:path')
 .attr('class', 'avg')
 .style("stroke", "#bb0000")
 .style("stroke-width", "5")
 .style("fill", "none")
 .attr("d", movingAverageLine(datafirst));

chart.append("svg:path")
 .style("stroke", "#ff0000")
 .style("stroke-width", "5")
 .style("fill", "none")
 .attr("d", line(datafirst));

chart.append('svg:path')
 .attr('class', 'avg')
 .style("stroke", "#cccc00")
 .style("stroke-width", "5")
 .style("fill", "none")
 .attr("d", movingAverageLine(datasecond));

chart.append("svg:path")
 .style("stroke", "#aaaa00")
 .style("stroke-width", "5")
 .style("fill", "none")
 .attr("d", line(datasecond));


//};
