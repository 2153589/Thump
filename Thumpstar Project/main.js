//Displays detailed information about the product.
function modal(){
    let modal_box = $('.product_modal');
    let close = $('.close');
    
    modal_box.show();

    close.click( function(){
       modal_box.removeAttr('.style').hide();
    });

}