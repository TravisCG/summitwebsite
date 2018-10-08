function doSearch() {
    var max = '';
    var max = parseInt(document.getElementById("textboxmax").value) || 100;
    var min = '';
    var min = parseInt(document.getElementById("textboxmin").value) || 12;
    var minelem = '';
    var minelem = parseInt(document.getElementById("textboxmnelem").value) || 500;
    var maxelem = '';
    var maxelem = parseInt(document.getElementById("textboxmxelem").value) || 100000;


    var motive = '';
   //var motive = document.getElementById("formmotive").value) || '*';
    var skillsSelect = document.getElementById("formmotive");
    var motive = skillsSelect.options[skillsSelect.selectedIndex].text;

    //making the input a bit more idiot proof remember to update this link when it goes to a new place

    window.location = "http://summit.med.unideb.hu/summitdb/motive_view.php?maxid=" + encodeURIComponent(max) + "&minid=" + encodeURIComponent(min) + "&mnelem=" + encodeURIComponent(minelem) + "&mxelem=" + enco$

    return false; // not entirely necessary, but just in case
};
 

