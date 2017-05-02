$j(document).ready(function () {
    if ($j('#cart-giftbox-form').length) {
        giftboxReady();
    }
});

function giftboxReady() {

    $j('input[name="giftbox"]').change(function (el) {
        updateGiftbox();
    });
}

function updateGiftbox() {
    $j.ajax({
        url: giftboxInCartUrl,
        type: 'post',
        data: $j('#cart-giftbox-form').serialize(true),
        dataType: 'json',
        success: function (json) {
            if(!json.error) {
                if(json.giftbox_form){
                    $j('#cart-giftbox').html(json.giftbox_form);
                }
                if(json.totals){
                    $j('#shopping-cart-totals-table').replaceWith(json.totals);
                }

            }
            else{
                alert(json.error);
            }
            giftboxReady();
        }
    });
}