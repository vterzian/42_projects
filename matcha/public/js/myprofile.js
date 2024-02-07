$('.icon').hide();
$('#modalBody form').hide();

$('.pen-hover').mouseover(function () {
    $(this).find('.icon').show();
});

$('.pen-hover').mouseout(function () {
    $(this).find('.icon').hide();
});

$('.icon').click(function () {
    if ($(this).parent().attr('id') === 'img-wrap') {
        $("#modal-title").text("Update image profile");
        $("#img-form").show();
    } else if ($(this).parent().attr('id') === 'info-wrap') {
        $("#modal-title").text("Update informations");
        $("#info-form").show();
    } else if ($(this).parent().attr('id') === 'bio-wrap') {
        $("#modal-title").text("Update biographie");
        $("#bio-form").show();
    } else if ($(this).parent().attr('id') === 'tag-wrap') {
        $("#modal-title").text("Update tags");
        $("#tag-form").show();
    }
    for (var i = 2; i <= 5; i++) {
        if ($(this).parent().attr('id') === "file_" + i + "-wrap") {
            $("#modal-title").text("Update image #" + i);
            $("#file_" + i + "-form").show();
        }
    }
    $("#myModal").modal('show');
});

$('#view-title').click(function () {
   $("#viewmodal").modal('show');
});

$('#like-title').click(function () {
   $("#likemodal").modal('show');
});

$('.dismiss-btn').click(function () {
    $("#modal-title").text();
    $('#modalBody form').hide();
});

for (var i = 2; i <= 5; i++) {
    $("#form_file_" + i + " input").change(function () {
        console.log(i);
        $(this).closest("form").submit();
    });
}