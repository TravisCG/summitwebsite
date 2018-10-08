function doSearchVenn() {

    var formexp1v = '';
    var formexp1v = parseInt(document.getElementById("formexp1").value) || 1;
    var formexp2v = '';
    var formexp2v = parseInt(document.getElementById("formexp2").value) || 2;
    var formexp3v = '';
    var formexp3v = parseInt(document.getElementById("formexp3").value) || 3;
    var formmotivev = '';
    var formmotivev = parseInt(document.getElementById("formmotive").value) || 1;
    var forminelem = '';
    var forminelem = document.getElementById("textboxmnelem").value || 1000;

    var skillsSelect = document.getElementById("formmotive");
    var motive = skillsSelect.options[skillsSelect.selectedIndex].text;

    //the motif will be in the venn page
    //making the input a bit more idiot proof remember to update this link when it goes to a new place

    window.location = "http://summit.med.unideb.hu/summitdb/venn_diagramm.php?exp1=" + encodeURIComponent(formexp1v) + "&exp2=" + encodeURIComponent(formexp2v) + "&exp3=" + encodeURIComponent(formexp3v) +"&motive=" + motive +"&motifid=" + encodeURIComponent(formmotivev) + "&mnelem=" + encodeURIComponent(forminelem)

    return false; // not entirely necessary, but just in case
};


function doSearchVenn2() {

    var formexp1v2 = '';
    var formexp1v2 = parseInt(document.getElementById("formexp1v2").value) || 1;
    var formexp2v2 = '';
    var formexp2v2 = parseInt(document.getElementById("formexp2v2").value) || 2;
    var formexp3v2 = '';
    var formexp3v2 = parseInt(document.getElementById("formexp3v2").value) || 3;
    var formmotivev2 = '';
    var formmotivev2 = parseInt(document.getElementById("formmotive").value) || 1;
    var skillsSelect2 = document.getElementById("formmotive");
    var motive2 = skillsSelect2.options[skillsSelect2.selectedIndex].text;
    var forminelem = '';
    var forminelem = document.getElementById("textboxmnelem").value || 1000;

    //the motif will be in the venn page
    //making the input a bit more idiot proof remember to update this link when it goes to a new place

    window.location = "http://summit.med.unideb.hu/summitdb/venn_diagramm.php?exp1=" + encodeURIComponent(formexp1v2) + "&exp2=" + encodeURIComponent(formexp2v2) + "&exp3=" + encodeURIComponent(formexp3v2) +"&motive=" + motive2 +"&motifid=" + encodeURIComponent(formmotivev2) + "&mnelem=" + encodeURIComponent(forminelem)

    return false; // not entirely necessary, but just in case
};







function doSearchpreVenn() {

    var formexp1v = '';
    var formexp1v = parseInt(document.getElementById("formexp1").value) || 1;
    var formexp2v = '';
    var formexp2v = parseInt(document.getElementById("formexp2").value) || 2;
    var formexp3v = '';
    var formexp3v = parseInt(document.getElementById("formexp3").value) || 3;
    var formmotivev = '';
    var formmotivev = parseInt(document.getElementById("formmotive").value) || 1;
    var skillsSelect = document.getElementById("formmotive");
    var motive = skillsSelect.options[skillsSelect.selectedIndex].text;
    var forminelem = '';
    var forminelem = document.getElementById("textboxmnelem").value || 1000;

    //the motif will be in the venn page
    //making the input a bit more idiot proof remember to update this link when it goes to a new place

    adressvenn = "http://summit.med.unideb.hu/summitdb/venn_diagramm.php?exp1=" + encodeURIComponent(formexp1v) + "&exp2=" + encodeURIComponent(formexp2v) + "&exp3=" + encodeURIComponent(formexp3v) + "&motive=" + motive + "&motifid=" + encodeURIComponent(formmotivev)  + "&mnelem=" + encodeURIComponent(forminelem)
    window.open(adressvenn, '_blank');
    return false; // not entirely necessary, but just in case

};

