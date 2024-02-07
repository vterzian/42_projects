function searchResult () {
    $.get("/searchFilter", {
        minAge: $("#minAge").val(),
        maxAge: $("#maxAge").val(),
        minScore: $("#minScore").val(),
        maxScore: $("#maxScore").val(),
        location: $("#location").val(),
        tags: $("#tags").val(),
        orderBy: $("#sortBy").val().toLowerCase().replace(/ /g,"_")
    }, function (data) {
        $("#match-container").empty();
        var template;
        var orient;
        $.each(JSON.parse(data), function (k, v) {
            template = $('#ticket-template').html().toString();
            if ((v.orientation === 1 && v.gender === 1) || (v.orientation === 2 && v.gender === 2) ) {
                orient = "female.png";
                template = template.replace(/{ col-md }/g, "");
            } else if ((v.orientation === 2 && v.gender === 1) || (v.orientation === 1 && v.gender === 2)) {
                orient = "male.png";
                template = template.replace(/{ col-md }/g, "");
            } else {
                orient = "bi.png";
                template = template.replace(/{ col-md }/g, "large");
            }
            template = template.replace(/{ file_1 }/g, v.file_1);
            template = template.replace(/{ username }/g, v.username);
            template = template.replace(/{ age }/g, v.age);
            template = template.replace(/{ from }/g, v.country + " " + v.state + "<br />" + v.city + " " + v.zip);
            template = template.replace(/{ gender }/g, (v.gender === 1) ? "male.png" : "female.png");
            template = template.replace(/{ orient }/g, orient);
            template = template.replace(/{ col-md }/g, "large");
            $('#match-container').append(template);
        });
    });
}

$('#sortBy').change(function () {
    searchResult();
});

$('.searchInput').change(function () {
    searchResult();
});
$('#location').keyup(function (e) {
    searchResult();
});