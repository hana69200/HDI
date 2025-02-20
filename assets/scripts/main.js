function visibilite(thingId) {
    var targetElement;
    targetElement = document.getElementById(thingId);
    if (targetElement.style.display == "none") {
        targetElement.style.display = "";
    } else {
        targetElement.style.display = "none";
    }
}


var openFile = function (event) {
    $('.rfp').hide();
    var input = event.target;

    var reader = new FileReader();
    reader.onload = function () {
        var dataURL = reader.result;
        var output = document.getElementById('avatarPreview');
        output.src = dataURL;
    };
    reader.readAsDataURL(input.files[0]);
};



function sendTrash(id) {
    if(document.getElementById("noUser") == null){
        $("#tid").val(id);
        $("#avatarpp").hide();
        $("#avatarPreview").hide();
        $("#pp").append('<i id="noUser" class="fa fa-user-circle-o rfp"></i>');
    }
    else{
        return;
    }     
}


function formatJSONCit(){
    let dataCit = [];
    $("#publi_container_tt").html('<p id="pLoadCit" class="publi m-5 rounded-lg p-3">Loading data from api.archives-ouvertes.fr ...<p>');
    $.getJSON('https://api.archives-ouvertes.fr/search/?q=collCode_s:LTDS&fl=*&rows=100000&sort=producedDate_tdate+desc', function (data) {
            (data.response.docs).forEach(element => {
                dataCit.push({ citation: element["citationFull_s"], id: element["halId_s"], abstract: element["abstract_s"]});
            });
            console.log(dataCit);
            updateTtPub(dataCit);
    });
    
}

function updateTtPub(data = null) {
    
    if (data==null) {
        formatJSONCit();
        return;
    }

    let container = $('#pagination');
    container.pagination({
        dataSource: data,
        pageSize: 10,
        className: "paginationjs-big",
        callback: function (data, pagination) {
            var dataHtml = '';
            
            $.each(data, function (index, item) {
                dataHtml += '<div id="' + item.id + '" class="publi m-4 rounded-lg p-3" onclick="selectPub(this)">' + item.citation + '<div class="mt-5" onclick="displayAb(this)"><a>Voir plus</a><p class="ab_content hidden">' + item.abstract +'</p></div></div>';
            });
            $("#publi_container_tt").html(dataHtml);
        }
    })
};

function updateLastPub() {
    var dt = new Date();
    var oldDate = (dt.getFullYear() - 1) + '-' + (dt.getMonth() + 1) + '-' + dt.getDate();
    var newDate = dt.getFullYear() + '-' + (dt.getMonth() + 1) + '-' + dt.getDate();

    $.getJSON('https://api.archives-ouvertes.fr/search/?q=collCode_s:LTDS%20AND%20docType_s:*%20AND%20NOT%20popularLevel_s:1%20AND%20(producedDate_tdate:[' + oldDate + 'T00:00:00Z%20TO%20' + newDate + 'T00:00:00Z]%20OR%20publicationDate_tdate:[' + oldDate + 'T00:00:00Z%20TO%20' + newDate + 'T00:00:00Z])%20AND%20submittedDate_tdate:[' + oldDate + 'T00:00:00Z%20TO%20' + newDate + 'T00:00:00Z]&rows=10&fl=*&sort=submittedDate_tdate%20desc&wt=json', function (data) {
        (data.response.docs).forEach(element => {
            $("#publi_container").append('<div id="' + element['halId_s'] + '" class="publi m-4 rounded-lg p-3" onclick="selectPub(this)">' + element["citationFull_s"] + '.' + '<div class="mt-5" onclick="displayAb(this)"><a>Voir plus</a><p class="ab_content hidden">' + element["abstract_s"] +'</p></div></div>');
            //console.log(element["abstract_s"]);
        });

    });
}

function selectPub(el){
    $(el).toggleClass("publiSelected"); 
    if (!$("#publi_container_tt").find("button")){
        $("#publi_container_tt").append('<button type="submit"><i class="fa fa-download"></i></button>');
    }
}

function displayAb(el){
    if($(el).find(".ab_content").html() != "undefined"){
        $(el).find(".ab_content").toggleClass("hidden");
    }
    else{
        $(el).find(".ab_content").html("Aucun extrait disponible");
        $(el).find(".ab_content").toggleClass("hidden");
    }
}

function findSelectedPub(){
    console.log($("#publi_container").find(".publiSelected"));
}

function filterHandler(el){
    var container = $("#inputContainer");
    let bTest = container.find(".inner-select").length != 0 || container.find("input").length != 0;
    if (el.value == "Equipe"){
        let eqp = ["Choisissez l'equipe","DySCo","GCD","MMP","TPCDI"];
        if (bTest) {
            container.append('<select name="equipe" class="custom-select inner-select">')
            eqp.forEach(element => {

                container.find(".inner-select").append('<option value="' + element + '">' + element + '</option>');
            });
            container.append('</select>');
        }
        else{
            container.append('<select name="equipe" class="custom-select inner-select">')
            eqp.forEach(element => {

                container.find(".inner-select").append('<option value="' + element + '">' + element + '</option>');
            });
            container.append('</select>')
            return;
        }
    }
    else if (el.value == "Groupe"){
        let grp = ["Choisissez le groupe","VIAME","DISI","DNLCS","ID","GCM","OID","MNP","MMV","ComPETe","SFV","TFM"];
        if(bTest) {
            container.find(".inner-select").remove();
            container.append('<select name="groupe" class="custom-select inner-select">')
            grp.forEach(element => {
                
                container.find(".inner-select").append('<option value="' + element + '">' + element +'</option>');
            });
            container.append('</select>');
            
        }
        else{
            container.append('<select name="groupe" class="custom-select inner-select">')
            grp.forEach(element => {

                container.find(".inner-select").append('<option value="' + element + '">' + element + '</option>');
            });
            container.append('</select>')
            return;
        }
    }
    else if (el.value == "Auteurs"){
        if(bTest) {
            container.find(".inner-select").remove();
            container.append('<input type="text" name="auteur" aria-label="Choix Auteur" class="form-control inner-select" placeholder="Entrer le ou les noms d\'Auteurs">')
        }
        else{
            container.append('<input type="text" name="auteur" aria-label="Choix Auteur" class="form-control inner-select" placeholder="Entrer le ou les noms d\'Auteurs">')
            return;
        }
    }else{
        container.find(".inner-select").remove();  
    }
}

function dateTime(){
    $('#datepicker1').datepicker();
    $('#datepicker1').datepicker("option", "dateFormat", "dd/mm/yy");
    $('#datepicker2').datepicker();
    $('#datepicker2').datepicker("option", "dateFormat", "dd/mm/yy");
}

function updateMinDate(){
    let date = $('#datepicker1').datepicker("getDate");
    $('#datepicker2').datepicker("option", "minDate", new Date(date.getFullYear(),date.getMonth(),date.getDate()));
}

$(document).ready(function () {
    dateTime();
    updateLastPub();
    updateTtPub();
    
});


