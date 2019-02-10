(function($){
    $(document).ready(function() {

        var header = 165; // taille du header minifié

        /******
         * Infobulles sur les lemmes
         */
        $('#results').tooltip({
            selector: "[data-toggle=tooltip]",
            container: "body",
            html: "true",
            placement: "bottom"
        });

        /******
         * Reset textarea
         */
        $(".form-lemme input[type='reset']").click(function(event) {
            event.preventDefault();
            $("#traitement_texte").empty();
        });


        /******
         * Soumission du formulaire via Ajax pour /ajax/collatinus-web.php
         */
        $(".form-lemme button[type='submit']").click(function(event) {
            event.preventDefault();

            // Type d'operation
            var opera = $(this).parent().siblings("input[name='opera']").val();
            // Valeur du token
            var token = $(this).parent().siblings("input[name='token']").val();
            // Definition variables et parametres POST en fonction de l'operation
            switch (opera) {
                case "consult":
                    var lemme = $("#recherche_lemme").val();
                    var dico = $("#dicos option:selected").val();
                    $("#dicos").change(function() {
                        var dico = $(this).val();
                    });
                    var dataString = 'lemme=' + lemme + '&opera=' + opera + '&dicos=' + dico + '&token=' + token;
                    break;

                case "flexion":
                    var lemme = $("#flexion_lemme").val();
                    var dataString = 'lemme=' + lemme + '&opera=' + opera + '&token=' + token;
                    break;

                case "traite_txt":
                    var action = $(this).val();
                    var texte = $("#traitement_texte").val();
                    var langue = $("#langue option:selected").val();
                    $("#langue").change(function() {
                        var langue = $(this).val();
                    });
                    var dataString = 'texte=' + texte + '&langue=' + langue + '&opera=' + opera + '&action=' + action + '&token=' + token;
                    break;
            }

            if (lemme || texte) {
                $.ajax({
                    type: "POST",
                    url: "/ajax/collatinus-web/collatinus-web.php",
                    data: dataString,
                    dataType: "html",
                    cache: false,
                })
                .done(function(data) {
                    $("#results").html(data);

                    /*
                     * ScrollToTop top button
                     */
                    var divResults = $("#results");

                    /*var imgDico = $("#results img");
                    var imgDicoWidth = imgDico.width();*/

                    // Calculate best horizontal position
                    var divResultsOffsetTop = divResults.offset().top;
                    var divResultsOffsetTop = divResultsOffsetTop + 20;
                    var divResultsWidth = divResults.width();
                    var divResultsHeight = divResults.height();
                    var windowWidth = $(window).width();
                    var positionRight = (windowWidth - divResultsWidth) / 2 - 60;

                    // $(window).scroll(function() {
                    //     if ($(this).scrollTop() > divResultsOffsetTop) {
                    //         $("#scrollToTop").css("right", positionRight).fadeIn();
                    //     } else {
                    //         $("#scrollToTop").fadeOut();
                    //     }
                    // });

                    // Click event to go to top of #results
                    // $("#scrollToTop a").click(function() {
                    //     $("html, body").stop(true).animate({
                    //         scrollTop: $("#results").offset().top
                    //     }, 800);
                    //     return false;
                    // });

                    $("html, body").stop(true).animate({
                        scrollTop: $("#results").offset().top - header
                    }, 600);

                    afterHtmlAppendCallback();

                })
                .fail(function() {
                    $("#results").html("<p class='text-danger'><strong>Une erreur s'est produite<strong></p>");
                });

            } else {
                $("#modal-error").modal()
            }

        });

        function afterHtmlAppendCallback() {

            $(".pager a, .liste-liens a[data-value]").click(function(event) {
                event.preventDefault();

                var r = $(this).attr("data-value");

                var dataString = 'r=' + r;

                $.ajax({
                        type: "POST",
                        url: "/ajax/collatinus-web/collatinus-web.php",
                        data: dataString,
                        dataType: "html",
                        cache: false,
                    })
                    .done(function(data) {
                        $("#results").html(data);

                        afterHtmlAppendCallback();

                    })
                    .fail(function() {
                        $("#results").html("<p class='text-danger'><strong>Une erreur s'est produite<strong></p>");
                    });
            });

            // on vire les href sur les liens inutiles du du_Cange
            $(".text a.form").removeAttr("href");

            // Scroll anime vers ancres
            $('a[href^=#]:not([href=#])').click(function() {
                //if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
                var target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                if (target.length) {
                    $('html,body').stop(true).animate({
                        scrollTop: target.offset().top - header
                    }, 1000);
                    return false;
                }
                //}
            });
        }
    });
}(jQuery))
