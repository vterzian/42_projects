$(".click-img").click(function() {
    $('#imagepreview').attr('src', $(this).attr('src'));
    $("#imagemodal").modal('show');
});

function actionButton () {
    var user = $("#username").html();
    user = user.toLowerCase();

    $("#like").click(function () {
        if ($(this).find("img").attr("src") === '/img/star2.png') {
            $.get("/profile/" + user + "/like", function () {
                $("#like").find("span").html("Unlike it!");
                $("#like").find("img").attr("src", "/img/star.png");
            });
        } else {
            $.get("/profile/" + user + "/unlike", function () {
                $("#like").find("span").html("Like it!");
                $("#like").find("img").attr("src", "/img/star2.png");
            });
        }
    });

    $("#fake").click(function () {
        if ($(this).find("img").attr("src") === '/img/fake2.png') {
            $.get("/profile/" + user + "/fake", function () {
                $("#fake").find("span").html("Unfake !");
                $("#fake").find("img").attr("src", "/img/fake.png");
            });
        } else {
            $.get("/profile/" + user + "/unfake", function () {
                $("#fake").find("span").html("Fake !");
                $("#fake").find("img").attr("src", "/img/fake2.png");
            });
        }
    });

    $("#block").click(function () {
        if ($(this).find("img").attr("src") === '/img/block2.png') {
            $.get("/profile/" + user + "/block", function () {
                $("#block").find("span").html("Unblock !");
                $("#block").find("img").attr("src", "/img/block.png");
            });
        } else {
            $.get("/profile/" + user + "/unblock", function () {
                $("#block").find("span").html("Block !");
                $("#block").find("img").attr("src", "/img/block2.png");
            });
        }
    });
}



