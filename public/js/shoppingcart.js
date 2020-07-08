function ConfirmDialog()  {
    var result = confirm("Xác nhận bỏ sản phẩm khỏi giỏ hàng ?");
    if(result)  {
        return true;
    } else {
        return false;
    }
}

function changePrice(productId){
    var sizeId = document.getElementById("size-"+productId).value;
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("price-"+productId).innerHTML = this.responseText;
            changeTotalPrice();
        }
    }
    xmlhttp.open("GET", "http://localhost/milktea/shoppings/getpriceProduct/"+sizeId+"/" + productId, true);
    xmlhttp.send();
    
}

function changeTotalPrice(){
    var price = document.getElementsByClassName("price-detail");
    var quantity = document.getElementsByClassName("quantity");
    var total_price = 0;
    for (i=0; i<price.length; i++){
        var price_str = price[i].innerHTML;
        var price_row = parseInt(price_str.slice(0, price_str.length-1));
        total_price += quantity[i].value*price_row;
    }
    document.getElementById("total-price").innerHTML = "Tổng giá tiền: "+ total_price + "đ";
}  