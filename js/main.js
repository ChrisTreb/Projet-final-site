// CODE EDITOR

var codeCSS = CodeMirror.fromTextArea(document.getElementById("css-editor"), {
    mode: "css",
    lineNumbers: false,
    matchBrackets: true,
    tabSize: 4,
    value: '',
    theme: 'darcula',
    gutters: ['error'],
    autoRefresh: true,
    lineWrapping: true
});

var codePHP = CodeMirror.fromTextArea(document.getElementById("php-editor"), {
    mime: "text/x-php",
    mode: "application/x-httpd-php",
    htmlMode: true,
    matchBrackets: true,
    startOpen: true,
    lineNumbers: false,
    tabSize: 4,
    value: '',
    theme: 'monokai',
    gutters: ['error'],
    autoRefresh: true,
    lineWrapping: true
});

// On rafraichi les éditeurs pour charger le code

function openCm() {
    setTimeout(function() {
        codeCSS.refresh();
        codePHP.refresh();
    }, 500);
}

var codeFrames = document.getElementsByClassName("CodeMirror");
for (i = 0; i < codeFrames.length; i++) {
    codeFrames[i].style.height = "85vh";
}

// Récupérer les codes dans les éditeurs

$(document).ready(function() {
    $("#css-btn").click(function() {
        var css = codeCSS.getValue();
        console.log(css);
    });
});

$(document).ready(function() {
    $("#php-btn").click(function() {
        var php = codePHP.getValue();
        console.log(php);
    });
});


// Fonction pour prévenir le refresh à la submission du formulaire
function submitForm() {
    var frm = document.getElementById('save-form');
    frm.submit(); // Submit the form
    frm.reset(); // Reset all form data
    return false; // Prevent page refresh
}

// On vérifie si la div json-text existe
// Si oui on récupère les données
if (document.body.contains(document.getElementById("json-text"))) {

    let json = document.getElementById("json-text").innerText;
    let content = JSON.parse(json);
    console.log(content[0]);

    let id = document.getElementsByName("content_id");
    id[0].value = content[0].id;

    let type = document.getElementsByName("content_type");
    type[0].value = content[0].content_type;

    let name = document.getElementsByName("content_name");
    name[0].value = content[0].content_name;

    let data = document.getElementsByName("content_data");
    data[0].innerHTML = content[0].content_data;
}

// Fonction des boutons
$(document).ready(function() {

    // Menu 

    function closeMenu() {
        $("#nav-menu > div").animate({
            marginLeft: "-171vw",
        }, 500);
        menuOpen = false;
    }

    var menuOpen = false;

    $("#arrow-menu").click(function() {
        if (menuOpen === false) {
            $("#nav-menu > div").animate({
                margin: 0,
            }, 500);
            menuOpen = true;
        } else {
            closeMenu();
        }
    });

    // Refresh Iframe

    $("#refresh-btn").click(function() {
        $("#site-frame").attr("src", $('#site-frame').attr("src"));
    });

    // Ouverture & fermeture
    $("#file-btn").click(function() {
        $("#file-row").toggle(500);
        var vheight = $(window).height();
        $('html, body').animate({
            scrollTop: (Math.floor($(window).scrollTop() / vheight) + 1) * vheight
        }, 500);
        closeMenu();
    });

    $("#gallery-btn").click(function() {
        $("#gallery-row").toggle(500);
        closeMenu();
    });

    $("#frame-btn").click(function() {
        $("#frame-row").toggle(500);
        closeMenu();
    });

    // Menu de modification

    $("#toggle-css").click(function() {
        $("#css-col").toggle(500);
        closeMenu();
    });

    $("#toggle-php").click(function() {
        $("#php-col").toggle(500);
        closeMenu();
    });


    // Resize

    var frame100 = true;
    var css100 = false;
    var php100 = false;

    $("#btn-resize-frame").click(function() {
        if (frame100) {
            $("#frame-row").removeClass("col-md-12");
            $("#frame-row").removeClass("col-md-3");
            $("#frame-row").addClass("col-md-6");
            frame100 = false;
        } else {
            $("#frame-row").removeClass("col-md-3");
            $("#frame-row").removeClass("col-md-6");
            $("#frame-row").addClass("col-md-12");
            frame100 = true;
        }
    });

    $("#btn-resize-phone").click(function() {
        if (frame100) {
            $("#frame-row").removeClass("col-md-12");
            $("#frame-row").removeClass("col-md-6");
            $("#frame-row").addClass("col-md-3");
            frame100 = false;
        } else {
            $("#frame-row").removeClass("col-md-3");
            $("#frame-row").removeClass("col-md-6");
            $("#frame-row").addClass("col-md-12");
            frame100 = true;
        }
    });

    $("#btn-resize-css").click(function() {
        if (css100 === false) {
            $("#css-col").removeClass("col-md-6");
            $("#css-col").addClass("col-md-12");
            css100 = true;
        } else {
            $("#css-col").removeClass("col-md-12");
            $("#css-col").addClass("col-md-6");
            css100 = false;
        }
    });

    $("#btn-resize-php").click(function() {
        if (php100 === false) {
            $("#php-col").removeClass("col-md-6");
            $("#php-col").addClass("col-md-12");
            php100 = true;
        } else {
            $("#php-col").removeClass("col-md-12");
            $("#php-col").addClass("col-md-6");
            php100 = false;
        }
    });

    // GALLERY

    var $grid = $('.grid').masonry({
        itemSelector: '.grid-item',
        percentPosition: true,
        columnWidth: '.grid-sizer'
    });

    // layout Masonry after each image loads
    $grid.imagesLoaded().progress(function() {
        $grid.masonry();
    });

});