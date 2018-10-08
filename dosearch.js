function doSearch() {
    var max = '';
    var max = parseInt(document.getElementById("textboxmax").value) || 100;
    var min = '';
    var min = parseInt(document.getElementById("textboxmin").value) || 1;
    var minelem = '';
    var minelem = parseInt(document.getElementById("textboxmnelem").value) || 500;
    var maxelem = '';
    var maxelem = parseInt(document.getElementById("textboxmxelem").value) || 100000;


    var motive = '';
   //var motive = document.getElementById("formmotive").value) || '*';
    var skillsSelect = document.getElementById("formmotive");
    var motive = skillsSelect.options[skillsSelect.selectedIndex].text;

    //making the input a bit more idiot proof remember to update this link when it goes to a new place

    window.location = "http://summit.med.unideb.hu/summitdb/motif_view.php?maxid=" + encodeURIComponent(max) + "&minid=" + encodeURIComponent(min) + "&mnelem=" + encodeURIComponent(minelem) + "&mxelem=" + encodeURIComponent(maxelem) +"&motive=" + encodeURIComponent(motive);

    return false; // not entirely necessary, but just in case
};

function dopreSearch() {
    var max = '';
    var max = parseInt(document.getElementById("textboxmax").value) || 100;
    var min = '';
    var min = parseInt(document.getElementById("textboxmin").value) || 1;
    var minelem = '';
    var minelem = parseInt(document.getElementById("textboxmnelem").value) || 500;
    var maxelem = '';
    var maxelem = parseInt(document.getElementById("textboxmxelem").value) || 100000;


    var motive = '';
   //var motive = document.getElementById("formmotive").value) || '*';
    var skillsSelect = document.getElementById("formmotive");
    var motive = skillsSelect.options[skillsSelect.selectedIndex].text;

    //making the input a bit more idiot proof remember to update this link when it goes to a new place
 var adress= "http://summit.med.unideb.hu/summitdb/motif_view.php?maxid=" + encodeURIComponent(max) + "&minid=" + encodeURIComponent(min) + "&mnelem=" +  encodeURIComponent(minelem) + "&mxelem=" + encodeURIComponent(maxelem) +"&motive=" + encodeURIComponent(motive);
 
    window.open(adress, '_blank');

    return false; // not entirely necessary, but just in case
};



function doSearchShift() {
    var motive = '';
    var skillsSelect = document.getElementById("formmotive");
    var motive = skillsSelect.options[skillsSelect.selectedIndex].text;
    var motifid = '';
    var motifid = parseInt(document.getElementById("formmotive").value);
    var firstexp1 = '';
    var firstexp1 = parseInt(document.getElementById("formexp1").value) || "undefined";
    var secondexp2 = '';
    var secondexp2 = parseInt(document.getElementById("formexp2").value) || "undefined";
    var thirdexp3 = '';
    var thirdexp3 = parseInt(document.getElementById("formexp3").value) || "undefined";
    var limit = '';
    var limit = parseInt(document.getElementById("limit").value) || 25;
    var low_limit = '';
    var low_limit = parseInt(document.getElementById("low_limit").value) || -25;
    var minelem = '';
    var minelem = parseInt(document.getElementById("min_field")[0].value) || 25;

//making the input a bit more idiot proof remember to update this link when it goes to a new place

    window.location = "http://summit.med.unideb.hu/summitdb/paired_shift_view.php?exp1=" + encodeURIComponent(firstexp1) + "&exp2=" + encodeURIComponent(secondexp2) + "&exp3=" + encodeURIComponent(thirdexp3)  + "&motive=" + encodeURIComponent(motive) +  "&motifid=" + encodeURIComponent(motifid) + "&limit=" + encodeURIComponent(limit) + "&low_limit=" + encodeURIComponent(low_limit)  + "&mnelem="  + encodeURIComponent(minelem);
;

    return false; // not entirely necessary, but just in case

};


function doSearchpreShift() {
    var motive = '';
    var skillsSelect = document.getElementById("formmotive");
    var motive = skillsSelect.options[skillsSelect.selectedIndex].text;
    var motifid = '';
    var motifid = parseInt(document.getElementById("formmotive").value);
    var firstexp1 = '';
    var firstexp1 = parseInt(document.getElementById("formexp1").value) || "undefined";
    var secondexp2 = '';
    var secondexp2 = parseInt(document.getElementById("formexp2").value) || "undefined";
    var thirdexp3 = '';
    var thirdexp3 = parseInt(document.getElementById("formexp3").value) || "undefined";
    var limit = '';
    var limit = parseInt(document.getElementById("limit").value) || 25;
    var low_limit = '';
    var low_limit = parseInt(document.getElementById("low_limit").value) || -25;
    var minelem = '';
    var minelem = parseInt(document.getElementById("min_field")[0].value) || 25;
//making the input a bit more idiot proof remember to update this link when it goes to a new place

    var adressshift = "http://summit.med.unideb.hu/summitdb/paired_shift_view.php?exp1=" + encodeURIComponent(firstexp1) + "&exp2=" + encodeURIComponent(secondexp2) + "&exp3=" + encodeURIComponent(thirdexp3)  + "&motive=" + encodeURIComponent(motive) +  "&motifid=" + encodeURIComponent(motifid) + "&limit=" + encodeURIComponent(limit) + "&low_limit=" + encodeURIComponent(low_limit) + "&mnelem="  + encodeURIComponent(minelem);

    window.open(adressshift, '_blank');

    return false; // not entirely necessary, but just in case

};


