// Copyright (C) Julian Nicholls 2010-2015, All rights reserved.
// Licensed for use on one site: reallybigshoe.co.uk

$(function() {
    $(".noblank").attr("title", "This field cannot be blank");

    $("#contact-form").submit(function() {
        var ok = true;

        $(".noblank").each(function() {
            var $this = $(this);

            if(trim($this.val()) === '') {
                $this.css('border', '2px solid red');
                ok = false;
            }
        });

        var $info = $("#contact-holder > p");

        if(ok) {
            $("#contact-send").fadeOut(600);
            $.post("contact.php?a=1", $("#contact-form").serialize(), function(data) {

                // alert( 'data: "' + data + '"' );

                $info.css({ 'fontSize': '200%', 'color': '#1a1' });

                if(data.substr(0, 2) == "OK") {
                    $('#contact-form').fadeOut(600);
                    $info.text("Thank you. We will be in touch soon.");
                }
                else {
                    $info.html("Something has gone wrong with sending messages.<br>Please try again later.")
                         .css('color', '#ff2020');
                    $("#contact-send").show();
                }
            });
        }
        else {
            $info.text('You must fill in the indicated fields.')
                 .css({ 'fontWeight': 'bold', 'color': '#ff2020', 'fontSize': '120%' });
        }

        return  false;  // Submit has been done
    });
});

function trim( str ) {
	return str.replace( /^\s+|\s+$/g, '' );
}
