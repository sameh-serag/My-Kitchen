var originZoneValue = '';
$(document).ready(function () {

    if ($('.myCityClass').length > 0) {

        cityZone();

        $(".myCityClass").change(function () {
            cityZone();
        });
    }
});
function cityZone() {
    id = $('select.myCityClass').val();

    if ($('.myCityClass').hasClass('edit')) {
        originZoneValue = $('select.myZoneClass').val();
    }

    $.ajax({
        type: "POST",
        url: getZonePath,
        dataType: "json",
        data: {'cityId': id},
        success: function (msg)
        {
            $('select.myZoneClass').empty();

            if (msg != 'failed') {
                $.each(msg, function () {
                    $('select.myZoneClass').append('<option value="' + this.id + '">' + this.name + '</option>');
                });

                if (originZoneValue != '') {
                    $("select.myZoneClass").val(originZoneValue).change();
                    originZoneValue = '';
                } else {
                    $("select.myZoneClass").val(msg[0].id).change();
                }

            } else {
                alert("this City han't any Zones");
            }
            $("select.myZoneClass").trigger("chosen:updated");
        }
    });
}
