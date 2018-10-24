    //makes the three jump to experiment view buttons work
    function jumptoexp(expelement) {
        var expID = parseInt(document.getElementById(expelement).value) || "undefined";
        var adresshift = "http://summit.med.unideb.hu/summitdb/experiment_view.php?exp=" + encodeURIComponent(expID);
        window.open(adresshift, '_blank');
    }

    // Fill the antibody selects by the specified cell type
    function fillSelect(afid, selector, data, defaultvalue, selectid, fillid) {
        var options = "";
        var resultnames = [];

        for(var i = 0; i < data.length; i++){
            if(data[i][selectid] == selector){
                var found = false;
                for(var j = 0; j < resultnames.length; j++){
                    if(resultnames[j] == data[i][fillid]){
                        found = true;
                        break;
                    }
                }
                if(!found){
                    if(data[i][fillid] == defaultvalue){
                        options = options + '<option selected="selected">' + data[i][fillid] + '</option>';
                    }
                    else{
                        options = options + '<option>' + data[i][fillid] + '</options>';
                    }
                    resultnames.push(data[i][fillid]);
                }
            }
        }

        $(afid).empty();
        $(afid).prepend(options);
    }

    // Fill the experiment selects by the specified antibody and cell type
    function fillExpByAntiCell(exid, anti, cell, data, defaultvalue){
       var options = "";
       var expnames = [];

       for(var i = 0; i < data.length; i++){
           if(data[i].cellname == cell && data[i].antiname == anti){
               var found = false;
               for(var j = 0; j < expnames.length; j++){
                   if(expnames[j] == data[i].expname){
                       found = true;
                       break;
                   }
               }
               if(!found){
                   if(data[i].expname == defaultvalue){
                       options = options + '<option selected="selected" value="' + data[i].expid + '">' + data[i].expname + '</option>';
                   }
                   else{
                       options = options + '<option value="' + data[i].expid + '">' + data[i].expname + '</option>';
                   }
                   expnames.push(data[i].expname);
               }
           }
       }

       $(exid).empty();
       $(exid).prepend(options);
    }

