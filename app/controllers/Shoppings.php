<?php
    class Shoppings extends Controller{
        public function __construct(){
            $this->shoppingcartModel = $this->model('Shopping');
        }

        public function shoppingcart($userId){
            if ($_SERVER['REQUEST_METHOD'] == 'POST'){
                if (isset($_POST['Quantity'])){
                    print_r('OK');
                }
            }
            $data = $this->shoppingcartModel->getShoppingCart($userId);
            $this->view('shopping/shoppingcart',$data);
            
        }

        public function updatecart($userId){
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

        public function ordercart($userId){
            if (isset($_POST['ordercart'])){
                $this->shoppingcartModel->orderCart($userId);
            }
            redirect("shoppings/shoppingcart/".$userId);
        }
    }

?>