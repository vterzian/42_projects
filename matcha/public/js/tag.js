$(document).ready( function () {
    setTagWrap();

    $(document).on("keypress", "#hobby", function (e) {
        var key = (e.keyCode) ? e.keyCode : e.which;
        return key != 13;
    });

    $(".tag_wrap a").click(function() {
        $(this).parent().remove();
        setInputValue();
    });

    $('#hobby').keydown(function (e) {
        var key = (e.keyCode) ? e.keyCode : e.which;
        if (key === 8 && $('#hobby').html().slice(-1) === '>') {
            e.preventDefault();
        }
    });

    $('#hobby').keyup(function (e) {
        var key = (e.keyCode) ? e.keyCode : e.which;
        if (key === 13) {
            setInputValue();
        }
    });

    $(".file-input").change(function(){
        previewUpload(this);
    });

    function setTagWrap ()
    {
        var content = $('#tag').val();
        content = content.split(',');
        $("#tag-ticket-wrap").empty();
        jQuery.each(content, function (index, value) {
            if (value.length !== 0) {
                $('#tag-ticket-wrap').html($('#tag-ticket-wrap').html() + '<span class="tag_wrap" contenteditable="false"><span>' + value.toLowerCase() + '</span><a>x</a></span>');
            }
        });
        $("body").on("click", ".tag_wrap a", function() {
            $(this).parent().remove();
            setInputValue();
        });
    }

    function setInputValue ()
    {
        var content = $('#tag-ticket-wrap').html();
        var newTag = $('#hobby').val();
        content = content.replace(new RegExp('</span><a>x</a></span><span class="tag_wrap" contenteditable="false"><span>', 'g'), ';');
        content = content.replace(new RegExp('<span class="tag_wrap" contenteditable="false"><span>', 'g'), ';');
        content = content.replace(new RegExp('</span><a>x</a></span>', 'g'), ';');
        var cont = content.split(';');
        cont.push(newTag);
        cont = cont.filter(function(v){return (v!=='' || v!=='\r\n' || v!=='\t')});

        jQuery.each(cont, function (index, value) {
            var nbOcc = $.grep(cont, function (elem) {
                return elem.toLowerCase() === value.toLowerCase();
            }).length;
            if (nbOcc > 1) {
                cont[cont.lastIndexOf(value)] = '';
            }
        });

        $('#tag').val('');
        $('#hobby').val('');
        $('#tag-ticket-wrap').html('');
        jQuery.each(cont, function (index, value) {
            if (value.length !== 0) {
                (index === 0) ? $('#tag').val($('#tag').val() + value) : $('#tag').val($('#tag').val() + ',' + value);
                $('#tag-ticket-wrap').html($('#tag-ticket-wrap').html() + '<span class="tag_wrap" contenteditable="false"><span>' + value.toLowerCase() + '</span><a>x</a></span>');
            }
        });
      
        $(".tag_wrap a").click(function() {
            $(this).parent().remove();
            setInputValue();
        });
    }

    function previewUpload (input)
    {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#preview-' + $(input).attr('id')).css('background-image', 'url(' + e.target.result + ')');
                $('#preview-' + $(input).attr('id')).css('color', 'rgba(0,0,0,0)');
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
});