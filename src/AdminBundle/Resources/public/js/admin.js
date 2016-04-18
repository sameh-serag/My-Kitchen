function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            if ($(input).parent().find('img.imageThumb').length > 0) {
                $(input).parent().find('img.imageThumb').attr('src', e.target.result);
                if ($(input).parent().find('a.removeImage').length > 0) {
                    $(input).parent().find('a.removeImage').remove();
                }
            } else {
                $(input).parent().append('<img class="imageThumb" width="60" height="60" src="' + e.target.result + '"/>');
            }
        };
        reader.readAsDataURL(input.files[0]);
    }
}
function removeImage(anchor) {
    $.ajax({
        url: $(anchor).parent().find('input').attr('data-image-remove-url'),
        success: function () {
            $(anchor).parent().find('img').remove();
            $(anchor).remove();
        }
    });
}

$(document).ready(function () {
    $('.datepicker').datepicker({
        showButtonPanel: true,
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd',
        constrainInput: true
    });
});