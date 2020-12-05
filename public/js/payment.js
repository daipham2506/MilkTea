$(document).ready(function() {
    console.log("Run here");

    const payWithMomoBtn = $('#pay-with-momo');

    const paymentAPI = ' https://payment-server-momo.herokuapp.com/init-payment';

    const urlRoot = payWithMomoBtn.attr("urlRoot");
    const userId = payWithMomoBtn.attr("userId");
    const address = payWithMomoBtn.attr("address");
    const phone = payWithMomoBtn.attr("phone");

    payWithMomoBtn.on('click', function(){     

        const orderId = payWithMomoBtn.attr('orderId');
        const typePayment = $('#type-payment').val();

        const dataPayment = {
            orderId: orderId,
            orderInfo: "Order payment",
            amount: "160000",
            extraData: ""
        }

        const phoneAndAddress = {
            address: address,
            phone: phone
        }

        if(typePayment === "momo"){
            $.post(`${urlRoot}payment/handlepayment`, phoneAndAddress)
            .done(function(data){
                if(data === "1") { // Success
                    $.post(paymentAPI,dataPayment)
                    .done(function(data){
                        console.log(data);
                        const {payUrl} = data.data;
                        window.open(payUrl);
                        window.location.replace(`${urlRoot}shoppings/shoppingcart/${userId}`);
                    })
                    .fail(function(err){
                        console.log(err);
                    });
                }
                else{
                    window.location.replace(`${urlRoot}shoppings/shoppingcart/${userId}`);
                }
            });
        }
        else{
            $.post(`${urlRoot}payment/handlepayment`, phoneAndAddress)
            .done(function(data){
                window.location.replace(`${urlRoot}shoppings/shoppingcart/${userId}`);
            });
        }
    })
        
})