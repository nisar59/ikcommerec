$(function () {
    $(document).on('change', 'select[name=type]', function () {

        var _this = $(this);
        var value = _this.val();

        var selector = $('#url-container');
        var url = APP_URL + '/menu/items/get-item-data/' + value;
        // alert(url);
        $.get(url, {}, function (response) {
            console.log(response);
            selector.html(response);
        });
    });
    $(document).on('change', '#nestable', function () {
        var output = $('#nestable-output').val();
        var menuId = $('#old_id').val();
        var url = BASEPATH + 'menu/item/change-position/' + menuId;
        $.post(url, {data: output, _token: $('#csrf_token').val(), }, function (response) {
            $("#server-side-error-for-list").html(alertHtml(1, response.Message));
            removeAlertHtml("#server-side-error-for-list");
        });
    });




    $(document).on('click', '.delete-menu-item', function (e) {
        e.preventDefault();
        if (!confirmBox()) {
            return false;
        }
        window.location = $(this).attr('href');
    });
});


function alertHtml(type, message) {
    var alertClass = "alert-success";
    if (type == 0) {
        alertClass = " alert-danger";
    }
    var html = '<div class = "alert ' + alertClass + ' fade in" ><button type = "button" class = "close close-sm" data - dismiss = "alert" ><i class = "fa fa-times" > </i></button>';
    html += '<strong >' + message + '</strong>';
    html += '</div>';
    return html;
}

function removeAlertHtml($ele) {
    setTimeout(function () {
        $($ele).html('');
    }, 3000);
}
function arrayToMessage(arrayData) {
    if (typeof arrayData == "string") {
        return arrayData;
    }
    var message = '';
    $.each(arrayData, function (index, value) {
        message += value + '<br>';
    });
    return message;
}


function uiBlocker() {
    $("#loading").show();
}
function uiUnBlocker() {
    $("#loading").hide();
} 