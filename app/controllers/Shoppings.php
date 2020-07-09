<?php
class Shoppings extends Controller{
    public function __construct(){
        $this->shoppingcartModel = $this->model('Shopping');
    }

    public function shoppingcart($userId){
        $data = $this->shoppingcartModel->getProductInCart($userId);
        $this->view('shopping/shoppingcart',$data);
        
    }
    public function cancelcart($userId){
        $productId = $_GET['productid'];
        $this->shoppingcartModel->cancelProduct($userId, $productId);
        redirect("shoppings/shoppingcart/".$userId);
    }

    public function updatecart($userId, $product){
        $productId = $_GET['productid'];
        $newQuantity = $_POST['quantity'];
        if (isset($_POST['changeQuantity'])){
            $this->shoppingcartModel->changeQuantity($userId, $productId, $newQuantity);
        }
        if (isset($_POST['cancel'])){
            $this->shoppingcartModel->cancelProduct($userId, $productId);
        }
        redirect("shoppings/shoppingcart/".$userId);
    }


        // public function updatecart($userId, $product){
        //     $productId = $_GET['productid'];
        //     $newQuantity = $_POST['quantity'];
        //     if (isset($_POST['changeQuantity'])){
        //         $this->shoppingcartModel->changeQuantity($userId, $productId, $newQuantity);
        //     }
        //     if (isset($_POST['cancel'])){
        //         $this->shoppingcartModel->cancelProduct($userId, $productId);
        //     }
        //     redirect("shoppings/shoppingcart/".$userId);
        // }

    public function ordercart($userId){
        $list_product = $this->shoppingcartModel->getProductInCart($userId);
            
        for ($i = 0; $i < count($list_product); $i++){
            $quantity = $_POST["quantity-".$list_product[$i]['idproduct']];
            $size = $_POST["size-".$list_product[$i]['idproduct']];
            $this->shoppingcartModel->changeQuantityAndSize($userId, $list_product[$i]['idproduct'], $quantity,$size);
        }
        if (isset($_POST['ordercart'])){
            $this->shoppingcartModel->orderCart($userId);
        }
        redirect("shoppings/shoppingcart/".$userId);
    }

    public function orderpage($userId){
        $data = array();
        $list_order= $this->shoppingcartModel->getOrder($userId);
        for ($i = 0; $i < count($list_order); $i++){
            $data[$i]['id'] = $list_order[$i]['id'];
            $data[$i]['status'] = $list_order[$i]['status'];
            $data[$i]['address'] = $list_order[$i]['address'];
            $data[$i]['product'] = $this->shoppingcartModel->getProductsByOrderid($data[$i]['id']);
        }
       
        $this->view('shopping/order',$data);
   }
  
   public function getPriceProduct($sizeId, $productId){
        require_once APPROOT."/models/Product.php";
        $productModel = new Product;
        $price = $productModel->getPriceBySizeAndId($sizeId,$productId);
        echo $price."đ"; 
    }
}

?>