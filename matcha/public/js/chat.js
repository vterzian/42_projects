var user;
var lastMessage = [];
var totalUnread;

clickChatTicket();

$(".chat-ticket").click(function () {
    $("#chatModal").modal('show');
    user = $(this).find('.ticket-username').html();
    $("#chatModal .modal-title").html(user);
    getMessage(user);
    $("#chat-input").click();
});

$("#chat-input").keyup( function (e) {
    if (e.keyCode === 13 && $(this).val() !== '') {
        $.get("/addMessage", {to : $("#chat-modal-title").html(), content: $("#chat-input").val()}, function (data) {
            data = jQuery.parseJSON(data);
            $("#chat-input").val('');
            getMessage(user);
        });
    }
});

$("#chat-input").click( function (e) {
    var user = $("#chatModal .modal-title").html();
    $.get("/readAll", {user: user});
    $(".chat-ticket").each(function (index) {
        if ($(this).find(".ticket-username").html() === user) {
            $(this).find(".new-message").css("opacity", "0");
        }
    });
    $("#conv").scrollTop($("#conv").prop("scrollHeight"));
});

function clickChatTicket () {
    $(".chat-ticket").click(function () {
        $("#chatModal").modal('show');
        user = $(this).find('.ticket-username').html();
        $("#chatModal .modal-title").html(user);
        getMessage(user);
        $("#chat-input").click();
    });
}

function getMessage (user) {
    $.get("/getMessages", {user: user}, function (data) {
        $("#conv").empty();
        $("#conv").html(data);
        $("#conv").scrollTop($("#conv").prop("scrollHeight"));
    });
}

function getConnected () {
    var template;
    $.get("/stillConnected", function (data) {
        $('.chat-ticket-wrap').empty();
//        data = JSON.parse(data);
        $.each(data, function (k, v) {
            var img = (v.connected === 1) ? "connected.png" : "disconnected.png";
            template = $('#chat-ticket-template').html().toString();
            template = template.replace(/{ file_1 }/g, v.file_1);
            template = template.replace(/{ username }/g, v.username);
            template = template.replace(/{ img }/g, img);
            if (v.nbrMess > 0) {
                template = template.replace(/{ nbrMess }/g, v.nbrMess);
                template = template.replace(/{ show }/g , "show");
            } else {
                template = template.replace(/{ nbrMess }/g, '0');
                template = template.replace(/{ show }/g , "hide");
            }
            $('.chat-ticket-wrap').append(template);
        });
        clickChatTicket();
    });
}

function stillConnect () {
    getConnected();
    clickChatTicket ();
    setInterval(function () {
        getConnected();
        clickChatTicket ();
    }, 5000);
}

function getNewMessage () {
    $.get("/newMessages", function (data) {
        totalUnread = 0;
        $(".chat-ticket").each(function (index) {
            if (data[index] === 0) {
                // $(this).find(".new-message").css("opacity", "0");
            } else {
                // $(this).find(".new-message").css("opacity", "1");
                if ($(this).find(".ticket-username").html() === $("#chat-modal-title").html()) {
                    $("#conv").scrollTop($("#conv").prop("scrollHeight"));
                }
                totalUnread += data[index];
            }
            lastMessage[index] = data[index];
            $(this).find(".new-message").html(data[index]);
        });
        $.get("/countNotif", function (data) {
            totalUnread += parseInt(data);
            $("#notif-count").html(data);
            $("#notif-count").css('opacity', (parseInt(data) === 0) ? '0' : '1');
            $("#icon-new-message").html(totalUnread);
            if (totalUnread > 0 && $("#burger-wrap").not('open-burger')) {
                $("#icon-new-message").css("opacity", ($("#burger-wrap").hasClass('open-burger')) ? "0" : "1");
            } else if (totalUnread === 0) {
                $("#icon-new-message").css("opacity", "0");
            }
        });
    }, "json");
}

function newMessage () {
    $.get("/newMessages", function (data) {
        totalUnread = 0;
        $(".chat-ticket").each(function (index) {
            if (data[index] !== 0) {
                if ($(this).find(".ticket-username").html() === $("#chat-modal-title").html()) {
                    $("#conv").scrollTop($("#conv").prop("scrollHeight"));
                }
                totalUnread += data[index];
            }
            lastMessage[index] = data[index];
            $(this).find(".new-message").html(data[index]);
        });
        $.get("/countNotif", function (data) {
            totalUnread += parseInt(data);
            $("#notif-count").html(data);
            $("#notif-count").css('opacity', (parseInt(data) === 0) ? '0' : '1');
            $("#icon-new-message").html(totalUnread);
            if (totalUnread > 0 && $("#burger-wrap").not('open-burger')) {
                $("#icon-new-message").css("opacity", ($("#burger-wrap").hasClass('open-burger')) ? "0" : "1");
            } else if (totalUnread === 0) {
                $("#icon-new-message").css("opacity", "0");
            }
        });
    }, "json");
    setInterval(function () {
        $.get("/newMessages", function (data) {
            totalUnread = 0;
            $(".chat-ticket").each(function (index) {
                if (data[index] !== 0) {
                    if ($(this).find(".ticket-username").html() === $("#chat-modal-title").html()
                        && (lastMessage[index] < data[index] || lastMessage[index] === undefined)) {
                        getMessage(user);
                    }
                    if ((lastMessage[index] < data[index] || lastMessage[index] === undefined)) {
                        $("#notif-sound")[0].play();
                    }
                    totalUnread += data[index];
                }
                lastMessage[index] = data[index];
                $(this).find(".new-message").html(data[index]);
            });
            $.get("/countNotif", function (data) {
                totalUnread += parseInt(data);
                $("#notif-count").html(data);
                $("#notif-count").css('opacity', (parseInt(data) === 0) ? '0' : '1');
                $("#icon-new-message").html(totalUnread);
                if (totalUnread > 0) {
                    $("#icon-new-message").css("opacity", ($("#burger-wrap").hasClass('open-burger')) ? "0" : "1");
                } else if (totalUnread === 0) {
                    $("#icon-new-message").css("opacity", "0");
                }
            });
        }, "json");
    }, 3000);
}
