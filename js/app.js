// Fonction XHR async
var xmlhttp = new XMLHttpRequest();

function get_data_types(str) {

    if (str == "" || str == "Sélectionner le type de contenu") {
        document.getElementById("content_types").innerHTML = "";
        return;
    } else {
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("content_types").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "php-includes/db_get_data.php?&type=" + str, true);
        xmlhttp.send();
    }
}

function httpGet() {
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            return xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET", "index.php", true);
    xmlhttp.setRequestHeader('Content-Type', 'text/plain');
    xmlhttp.send();
}