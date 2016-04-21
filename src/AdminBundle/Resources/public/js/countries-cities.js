var originCityValue = '';

$(document).ready(function () {
    if ($('.countries-list').length > 0) {

        brandBranch();

        $(".countries-list").change(function () {
            brandBranch();
        });
    }
});

function brandBranch() {
    id = $('select.countries-list').val();

    if ($('.countries-list').hasClass('edit')) {
        originCityValue = $('select.cities-list').val();
    }
    
    $.ajax({
        type: "POST",
        url: getCitiesPath,
        dataType: "json",
        data: {'countryid': id},
        success: function (msg)
        {
            $('select.cities-list').val('').change();
            $('select.cities-list').empty().change();
            if (msg != 'failed') {
                $.each(msg, function () {
                    $('select.cities-list').append('<option value="' + this.id + '">' + this.name + '</option>');
                });

                if (originCityValue != '') {
                    $("select.cities-list").val(originCityValue).change();
                    originCityValue = '';
                }
                $("select.cities-list").trigger("chosen:updated");
            }
        }
    });



}
