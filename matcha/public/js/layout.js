$("#burger-wrap").click(function () {
    if ($("#burger-wrap").hasClass('open-burger')) {
        if ($("#icon-new-message").html() !== '0') {
            $("#icon-new-message").css('opacity', '1');
        }
        $("#burger-wrap").removeClass('open-burger');
        $("#burger1").css({"opacity": "1", "top" : "0px"});
        $("#burger2").css({
            '-webkit-transform': 'rotate(0deg)',
            '-moz-transform': 'rotate(0deg)',
            '-ms-transform': 'rotate(0deg)',
            '-o-transform': 'rotate(0deg)',
            'transform': 'rotate(0deg)'
        });
        $("#burger3").css({
            '-webkit-transform': 'rotate(0deg) translate(0px, 0px)',
            '-moz-transform': 'rotate(0deg) translate(0px, 0px)',
            '-ms-transform': 'rotate(0deg) translate(0px, 0px)',
            '-o-transform': 'rotate(0deg) translate(0px, 0px)',
            'transform': 'rotate(0deg) translate(0px, 0px)'
        });
        $("#side-menu").css('left', '-350px');
    } else {
        $("#burger-wrap").addClass('open-burger');
        $("#burger1").css({"opacity": '0', "top": "17px"});
        $("#burger2").css({
            '-webkit-transform': 'rotate(40deg)',
            '-moz-transform': 'rotate(40deg)',
            '-ms-transform': 'rotate(40deg)',
            '-o-transform': 'rotate(40deg)',
            'transform': 'rotate(40deg)'
        });
        $("#burger3").css({
            '-webkit-transform': 'rotate(-40deg) translate(10px, -15px)',
            '-moz-transform': 'rotate(-40deg) translate(10px, -15px)',
            '-ms-transform': 'rotate(-40deg) translate(10px, -15px)',
            '-o-transform': 'rotate(-40deg) translate(10px, -15px)',
            'transform': 'rotate(-40deg) translate(10px, -15px)'
        });
        $("#side-menu").css('left', '0');
        $("#icon-new-message").css('opacity', '0');
    }
});

function renderNotif () {
    var template;
    $.get("/getNotif", function (data) {
        data = jQuery.parseJSON(data);
        if (data !== '' && data !== 'undefined') {
            $("#notif-ticket-wrap").empty();
            $.each(data, function (k, v) {
                template = $("#notif-template").html();
                template = template.replace(/{ id }/g, v.id);
                template = template.replace(/{ img }/g, v.img);
                template = template.replace(/{ content }/g, v.content);
                template = template.replace(/{ date }/g, v.time);
                template = template.replace(/{ color }/g, (v.read === 0) ? "unread" : "read")
                $("#notif-ticket-wrap").append(template);
            });
            $(".notif-ticket").mouseover( function () {
                $.get('/readNotif', {id: $(this).find(".hidden").html()});
            });
            $(".notif-ticket").mouseout( function () {
                renderNotif();
            });
        }
    });
}

function getNotif ()
{
    renderNotif();
    setInterval(function () {
        renderNotif();
    }, 5000);
}