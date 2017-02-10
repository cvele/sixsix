var sortAdminSubfields = function() {
    $('.meal-options-group .field-collection > label').remove();
    $('.meal-options-group .field-meal_option > label').remove();
    $('[for$="_price_tbbc_amount"]').remove();
}

$(document).ready(function(){
    sortAdminSubfields();
    $(document).on( "easyadmin.collection.item-added", sortAdminSubfields);
});
