<?php 
    class Payment extends Controller {
        public function __construct(){
            $this->shoppingcartModel = $this->model('Shopping');
        }

        public function paymomo(){
            $userId = $_SESSION['user_id'];
            $data = array();
            $productInCart = $this->shoppingcartModel->getProductInCart($userId);
            $address = $_POST["address"];
            $phone = $_POST["phone"];
            $data["productInCart"] = $productInCart;
            $data["address"] = $address;
            $data["phone"] = $phone;
            $this->view('payment/paymomo',$data);
        }

        public function handlepayment(){
            // var_dump($_POST);
            $userId = $_SESSION['user_id'];
            $rs = $this->shoppingcartModel->orderCart($userId);
            echo $rs;
        }
    }
?>