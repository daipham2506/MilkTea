<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once ROOT . "/vendor/autoload.php";
class Shopping
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getProductInCart($userId)
    {
        $data = array();
        $getList_sql = "SELECT product.name, product.image, productincart.quantity, size.size, sizeofproduct.price, productincart.idproduct, productincart.idcart
                        FROM productincart 
                        INNER JOIN product 
                        ON productincart.idproduct = product.id
                        INNER JOIN sizeofproduct
                        ON productincart.idsize = sizeofproduct.idsize AND sizeofproduct.idproduct = productincart.idproduct
                        INNER JOIN size
                        ON sizeofproduct.idsize = size.id
                        INNER JOIN cart
                        ON productincart.idcart = cart.id
                        WHERE cart.iduser =" . $userId;


        $result = mysqli_query($this->db->conn, $getList_sql);
        if (mysqli_num_rows($result) > 0) {
            // output data of each row
            $i = 0;
            while ($row = mysqli_fetch_assoc($result)) {
                $data[$i]['name'] = $row['name'];
                $data[$i]['image'] = $row['image'];
                $data[$i]['quantity'] = $row['quantity'];
                $data[$i]['size'] = $row['size'];
                $data[$i]['price'] = $row['price'];
                $data[$i]['idproduct'] = $row['idproduct'];
                $data[$i]['idcart'] = $row['idcart'];
                $i++;
            }
        }
        return $data;
     } 
  
      public function changeQuantityAndSize($userId, $productId, $newQuantity, $newSize) {
          $sql_update = "UPDATE productincart, cart
                         SET productincart.quantity=".$newQuantity.",productincart.idsize=".$newSize." WHERE productincart.idproduct=".$productId." AND productincart.idcart=cart.id AND cart.iduser=".$userId;
          mysqli_query($this->db->conn, $sql_update);

      }

      public function cancelProduct($userId, $productId){
          $sql_delete = "DELETE productincart
                          FROM productincart,cart
                          WHERE productincart.idcart = cart.id AND cart.iduser = ".$userId." AND productincart.idproduct = ".$productId;
          if (mysqli_query($this->db->conn, $sql_delete)){
              flash('cancelProduct','Hủy thành công');
          }
          else{
              flash('cancelProduct','Hủy không thành công','alert-danger');
          }
      }
 


        public function orderCart($userId){
            // Check user have Address or not?
            $sql = "SELECT phone FROM users WHERE id=".$userId;
            $result = mysqli_query($this->db->conn, $sql);

            $phone='';
            if (mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_assoc($result)){
                    $phone = $row['phone'];
                }
            }
            if ($phone == ""){
                flash('ordercart','Vui lòng cập nhật số điện thoại trước khi đặt hàng','alert-danger');
                return;
            }
            //check quantity remain
            $sql = "SELECT checkquantity(".$userId.")";
            $result = mysqli_query($this->db->conn, $sql);
            if (mysqli_num_rows($result) > 0){
                $row = mysqli_fetch_assoc($result);
                $productId = $row['checkquantity('.$userId.')'];
                if ($productId !=0 ){
                    $sql = "SELECT name FROM product WHERE product.id=".$productId;
                    $name = mysqli_query($this->db->conn, $sql);
                    $name = mysqli_fetch_assoc($name)['name'];
                     
                    flash('ordercart','Sản phẩm '.$name.' còn lại không đủ, vui lòng đặt lại số lượng','alert-danger');
                    return;
                }
            }
            // order
            if (isset($_POST['address'])){
                $address = $_POST['address'];
            }
            $sql = "CALL CREATE_ORDER(".$userId.",'".$address."')";
            $result = mysqli_query($this->db->conn, $sql);
            if ($result){
                flash('ordercart','Đặt hàng thành công');
            }
       
    }

    public function getOrder($userId)
    {
        $sql = "SELECT * from orders WHERE iduser=" . $userId;
        $result = mysqli_query($this->db->conn, $sql);
        $list_order = array();
        $i = 0;
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $list_order[$i]['id'] = $row['id'];
                $list_order[$i]['address'] = $row['address'];
                $list_order[$i]['status'] = $row['status'];
                $i++;
            }
        }
        return $list_order;
    }

    public function getProductsByOrderid($orderId)
    {
        $sql = "SELECT product.name, product.image, productinorders.quantity, size.size, sizeofproduct.price, productinorders.idproduct 
        FROM productinorders 
        INNER JOIN product ON productinorders.idproduct = product.id 
        INNER JOIN sizeofproduct ON productinorders.idsize = sizeofproduct.idsize AND sizeofproduct.idproduct = productinorders.idproduct 
        INNER JOIN size ON sizeofproduct.idsize = size.id 
        WHERE productinorders.idorder = " . $orderId;
        $result = mysqli_query($this->db->conn, $sql);
        $list_product = array();
        $i = 0;
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $list_product[$i]['name'] = $row['name'];
                $list_product[$i]['image'] = $row['image'];
                $list_product[$i]['quantity'] = $row['quantity'];
                $list_product[$i]['size'] = $row['size'];
                $list_product[$i]['price'] = $row['price'];
                $list_product[$i]['idproduct'] = $row['idproduct'];
                $i++;
            }
        }
        return $list_product;
    }

    public function getAllOrders()
    {
        $sql = "SELECT orders.id, orders.address, orders.status, orders.phone, orders.created_at, users.id as userId
        FROM orders
        INNER JOIN users ON orders.iduser = users.id;
        ";
        $result = mysqli_query($this->db->conn, $sql);
        $orders = [];
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $order['id'] = $row['id'];
                $order['address'] = $row['address'];
                $order['phone'] = $row['phone'];
                $order['status'] = $row['status'];
                $order['userId'] = $row['userId'];
                $order['created_at'] = $row['created_at'];
                array_push($orders, $order);
            }
        }
        return $orders;
    }

    public function updateStatus($id, $status)
    {
        $sql = "UPDATE orders SET status = $status WHERE id =$id";
        return mysqli_query($this->db->conn, $sql);
    }

    public function totalPrice($products)
    {
        $totalPrice = 0;
        foreach ($products as $product) {
            $totalPrice += $product['quantity'] * $product['price'];
        }
        return $totalPrice;
    }

    public function sendEmail($user, $status, $products, $orderID)
    {
        $mail = new PHPMailer(true); //Argument true in constructor enables exceptions

        $mail->CharSet = "utf-8";

        $mail->SMTPDebug = 2;
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'milktea.dmhn@gmail.com';                 // SMTP username
        $mail->Password = 'Milktea123!';                        // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                    // TCP port to connect to

        //From email address and name
        $mail->setFrom("milktea.dmhn@gmail.com", "MilkTeaX");

        //To address and name
        $mail->addAddress($user->email);

        //Address to which recipient will reply
        $mail->addReplyTo('milktea.dmhn@gmail.com');

        // content
        $mail->isHTML(true);

        $totalPrice = $this->totalPrice($products);
        $name = $user->name;
        $email = $user->email;
        $phone = $user->phone;
        $address = $user->address;

        $subject = "MilkTeaX đã nhận đơn hàng #$orderID";
        $body = "<b>Xin chào $name,</b> <br>
        Cảm ơn bạn đã chọn mua tại MilkTeaX! <br>
        MilkTeaX đã nhận được yêu cầu đặt hàng của bạn và đang xử lý nhé. Bạn sẽ nhận được thông báo tiếp theo khi đơn hàng đã sẵn sàng được giao.";
        if ($status == 3) {
            $subject = "Đơn hàng #$orderID đang được vận chuyển";
            $body = "<b>$name thân mến,</b> <br>
            Đơn hàng của bạn đang được vận chuyển, Vui lòng chuẩn bị tiền mặt để nhận hàng";
        } else if ($status == 4) {
            $subject = "Đơn hàng #$orderID đã được giao thành công";
            $body = "<b>$name ơi,</b> <br>
            MilkTeaX đã giao cho bạn đầy đủ với các sản phẩm được liệt kê bên dưới theo đơn hàng #$orderID của bạn, MilkTeaX hi vọng bạn thưởng thức ngon miệng với các sản phẩm này!";
        }
        $body = $body . "
        <br>
        <br>
        <b>Đơn hàng được giao đến </b>  <br>
        Tên : $name <br>
        Địa chỉ: $address <br>
        Số điện thoại: $phone <br>
        Email : $email <br>
        
        <br>
        <b>Sản phẩm</b> <br>
        ";
        $i = 1;
        foreach ($products as $product) {
            $image = $product['image'];
            $name = $product['name'];
            $size = $product['size'];
            $quantity = $product['quantity'];
            $price = $product['price'];
            $total = $quantity * $price;
            $body = $body . "#$i <br>
            <img src='$image' alt='...' style='width: 60px; height:60px'>  
            <p>$name <p>
            Size : $size &emsp; Giá: $price đ <br>
            Số lượng : $quantity <br>
            Tổng: $total đ <br>
            <br>
            ";
            $i++;
        }
        $body = $body . "<hr> <b>Tổng tiền : $totalPrice đ </b>";

        $mail->Subject = $subject;
        $mail->Body = $body;

        $mail->send();
        // try {
        //     $mail->send();
        //     return [true, 'Tình trạng đơn hàng đã được gửi đến email người dùng'];
        // } catch (Exception $e) {
        //     return [false, $mail->ErrorInfo];
        // }
    }
}
