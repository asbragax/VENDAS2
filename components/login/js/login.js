$(document).ready(function() {
    "use strict";
    $("#submit").click(function() {

        var username = $("#myusername").val(),
            password = $("#mypassword").val();

        if ((username === "") || (password === "")) {
            $("#message").html("<div class=\"alert alert-danger alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>Digite um login e uma senha por favor</div>");
        } else {
            // console.log("myusername=" + username + "&mypassword=" + password);
            $.ajax({
                type: "POST",
                url: "action/checklogin.php",
                data: "myusername=" + username + "&mypassword=" + password,
                dataType: 'JSON',
                success: function(html) {
                    // console.log(1);
                    // console.log(html.response + ' ' + html.username);
                    if (html.response === 'true') {
                        location.reload();
                        return html.username;
                    } else {
                        $("#message").html(html.response);
                    }
                },
                error: function(textStatus, errorThrown) {
                    console.log(textStatus);
                    // console.log(1);
                    console.log(errorThrown);
                },
                beforeSend: function() {
                    $("#message").html("<p class='text-center'><img src='images/ajax-loader.gif'></p>");
                }
            });
        }
        return false;
    });
});