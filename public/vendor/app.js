/* ADD & UPDATE */
$('#form_edit').on('submit', function(e) {
    e.preventDefault();
    var rType, rUrl;
    if ($('#id').val() == '') {
        rType = 'POST';
        rUrl = '/' + $('#resource').val();
    } else {
        rType = 'PUT';
        rUrl = '/' + $('#resource').val() + '/' + $('#id').val();
    }
    $.ajax({
        type: rType,
        url: rUrl,
        contentType: 'application/json',
        data: JSON.stringify(getFormData($(this).serializeArray())),
        resource: $('#resource').val(),
        returnUrl: $('#returnUrl').val(),
        success: function(msg) {
            window.location.replace('/app/' + this.returnUrl);
        },
        error: function(jqXHR, status, error) {
            jsonValue = jQuery.parseJSON(jqXHR.responseText);
            $('#error_msg').text(jsonValue.error);
        }
    });
});

/* DELETE */
$('.deleteBtn').on('click', function(e) {
    e.preventDefault();
    $.ajax({
        type: "DELETE",
        url: '/' + $(this).data("resource") + '/' + $(this).data("value"),
        returnUrl: $(this).data("path"),
        success: function(msg) {
            window.location.replace('/app/' + this.returnUrl);
        },
        error: function(jqXHR, status, error) {
            jsonValue = jQuery.parseJSON(jqXHR.responseText);
            $('#error_msg').text(jsonValue.error);
        }
    });
});

/* HELPERS */
function getFormData(data) {
    var unindexed_array = data;
    var indexed_array = {};
    $.map(unindexed_array, function(n, i) {
        indexed_array[n['name']] = n['value'];
    });
    return indexed_array;
}