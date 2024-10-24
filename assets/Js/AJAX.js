$('#plain').change(function () {
    var plain_id = $(this).val();
    $.ajax({
        url: 'get-stands.php',
        type: 'GET',
        data: { plain_id: plain_id },
        success: function (data) {
            $('#stand').html(data);
        }
    });
});
