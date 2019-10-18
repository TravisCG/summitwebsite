function doSearch(wname) {
    var max = parseInt(document.getElementById("textboxmax").value) || 100;
    var min = parseInt(document.getElementById("textboxmin").value);
    var minelem = parseInt(document.getElementById("textboxmnelem").value) || 500;
    var maxelem = parseInt(document.getElementById("textboxmxelem").value) || 100000;

    var skillsSelect = document.getElementById("formmotive");
    var motive = skillsSelect.options[skillsSelect.selectedIndex].text;

    //making the input a bit more idiot proof remember to update this link when it goes to a new place

    var address = "http://summit.med.unideb.hu/summitdb/motif_view.php?maxid=" + encodeURIComponent(max) + "&minid=" + encodeURIComponent(min) + "&mnelem=" + encodeURIComponent(minelem) + "&mxelem=" + encodeURIComponent(maxelem) +"&motive=" + encodeURIComponent(motive);

    window.open(address, wname);

    return false; // not entirely necessary, but just in case
};

function doSearchShift(wname, suffix) {
    var skillsSelect = document.getElementById("formmotive");
    var motive = skillsSelect.options[skillsSelect.selectedIndex].text;
    var motifid = parseInt(document.getElementById("formmotive").value);
    var firstexp1 = parseInt(document.getElementById("formexp1" + suffix).value) || "undefined";
    var secondexp2 = parseInt(document.getElementById("formexp2" + suffix).value) || "undefined";
    var thirdexp3 = parseInt(document.getElementById("formexp3" + suffix).value) || "undefined";
    var limit = parseInt(document.getElementById("limit").value) || 40;
    var low_limit = parseInt(document.getElementById("low_limit").value) || -40;
    var minelem = parseInt(document.getElementById("min_field")[0].value) || 25;

    //making the input a bit more idiot proof remember to update this link when it goes to a new place
    var address = "http://summit.med.unideb.hu/summitdb/paired_shift_view.php?exp1=" + encodeURIComponent(firstexp1) + "&exp2=" + encodeURIComponent(secondexp2) + "&exp3=" + encodeURIComponent(thirdexp3)  + "&motive=" + encodeURIComponent(motive) +  "&motifid=" + encodeURIComponent(motifid) + "&limit=" + encodeURIComponent(limit) + "&low_limit=" + encodeURIComponent(low_limit)  + "&mnelem="  + encodeURIComponent(minelem);
;

    window.open(address, wname);
    return false; // not entirely necessary, but just in case

};

