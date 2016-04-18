var originBranchValue = '';

$(document).ready(function () {
    if ($('.myBrandClass').length > 0) {

        brandBranch();

        $(".myBrandClass").change(function () {
            brandBranch();
        });
    }
});

function brandBranch() {
    id = $('select.myBrandClass').val();

    if ($('.myBrandClass').hasClass('edit')) {
        originBranchValue = $('select.myBranchClass').val();
    }
    
    $.ajax({
        type: "POST",
        url: getBranchPath,
        dataType: "json",
        data: {'brandId': id},
        success: function (msg)
        {
            $('select.myBranchClass').val('').change();
            $('select.myBranchClass').empty().change();
            if (msg != 'failed') {
                $.each(msg, function () {
                    $('select.myBranchClass').append('<option value="' + this.id + '">' + this.name + '</option>');
                });

                if (originBranchValue != '') {
                    $("select.myBranchClass").val(originBranchValue).change();
                    originBranchValue = '';
                }
                $("select.myBranchClass").trigger("chosen:updated");
            }
        }
    });



}
