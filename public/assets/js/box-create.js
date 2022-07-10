function calculTotal() {
    rows = $('#boxTable tbody tr');
    let total = 0;
    ;
    $.each(rows, function () {
        total += parseInt($(this).find("td.qty input").val());
    });
    $("#total_qty").html(total);
    return total;
}


(function ($) {
    'use strict';
    var form = $("#form_cast");

    $("#wizard2").steps({
        headerTag: "h3",
        transitionEffect: "slideLeft",
        labels: {
            finish: "Valider",
            next: "Suivant",
            previous: "Précedent",
            loading: "Loading ..."
        },
        onStepChanging: function (event, currentIndex, newIndex) {
            form.validate().settings.ignore = ":disabled,:hidden";
            if (newIndex == 3) {
                var max_total = parseInt($("input[name='gender']:checked").data("max-cast"));
                if(calculTotal()<=0){
                    swal({
                        title: `Erreur`,
                        text: "Ajouter au moin un coulée",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    return form.invalid();
                }
                if (calculTotal() > max_total) {
                    swal({
                        title: `Erreur`,
                        text: "Vous avez atteint la quantité maximum",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
    
                    return form.invalid();
                }
                $('#boxTableInfo tbody').empty();
                rows = $('#boxTable tbody tr');
                let total = 0;
                ;
                $.each(rows, function () {
                    let $tr = "<tr>";
                    $tr += '<td class="wp-15">Jermery PONCELET</td>';
                    $tr += '<td ><h3 class=" text-uppercase" >' + $(this).find("td.cast input").val() + "</h3></td>";
                    $tr += "<td><h3>" + $(this).find("td.qty input").val() + "</h3></td>";
                    $('#boxTableInfo tbody').append($tr);
                });
                $("#totalInfo").html(calculTotal());
                $("#partRefInfo").html(parseInt($("input[name='part_id']:checked").data("ref")));
                $("#boxNumberInfo").html($("#box_number").val());
            }
            return form.valid();
        },
        onFinished: function (event, currentIndex) {
            $("#form_cast").submit();


        },

        bodyTag: "section",
        transitionEffect: "none",
        stepsOrientation: "vertical",
        titleTemplate: '<span class="number">#index#</span>'
    });
    /*  $('#boxTable').on("keyup change",'.iqty', function (e) {
          let val=parseInt($(this).val());
          console.log("val",val);
      });*/

    $(document).ready(function () {
        calculTotal();


        $("#add_cast_btn").on("click", function () {
            var max_total = parseInt($("input[name='part_id']:checked").data("max-cast"));

            var item_key = $('#boxTable tbody tr').length;
            if ((calculTotal() + parseInt($("#i_cast_qty").val()) > max_total)) {
                swal({
                    title: `Erreur`,
                    text: "Vous avez atteint la quantité maximum",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                return;
            }
            var $tr = "<tr>";
            $tr += "<td>Jeremy PONCELET</td>";
            $tr += '<td class="cast"> <input  class="form-control  text-uppercase  w-100 text-left hm-30" type="text" name="casts[' + item_key + '][mark]" value="' + $("#i_cast_ref").val() + '">' + "</td>";
            $tr += '<td class="qty"><input onchange="calculTotal()"  type="number" name="casts[' + item_key + '][quantity]" class="form-control iqty w-60 text-center hm-30" value="' + $("#i_cast_qty").val() + '"></td>';
            $tr += "<td>" + moment().format("D/M/Y")+ "</td>";
            $("#i_cast_ref").val("");
            $("#i_cast_qty").val("");
            $("#btn_submit_cast").css("display", "block");

            $('#boxTable tbody').append($tr);
            calculTotal();

        });

        $("#form_cast").on("submit", function (e) {

            var form = $(this);
            return true;
        });

    });



})(jQuery);