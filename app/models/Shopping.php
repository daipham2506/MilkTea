<?php
    class Shopping{
        private $db;

        public function __construct(){
            $this->db = new Database;
        }

        public function getProductInCart($userId){
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
                            WHERE cart.iduser =".$userId;

                          
            $result = mysqli_query($this->db->conn, $getList_sql);
            
            if (mysqli_num_rows($result) > 0) {
                // output data of each row
                $i = 0;
                while($row = mysqli_fetch_assoc($result)) {
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

        public function getOrder($userId){
            $sql = "SELECT * from orders WHERE iduser=".$userId;
            $result = mysqli_query($this->db->conn, $sql);
            $list_order = array();
            $i = 0;
            if (mysqli_num_rows($result) >0 ){
                while ($row = mysqli_fetch_assoc($result)){
                    $list_order[$i]['id'] = $row['id'];
                    $list_order[$i]['address'] = $row['address'];
                    $list_order[$i]['status'] = $row['status'];
                    $i++;
                }
            }
            return $list_order;
        }

        public function getProductsByOrderid($orderId){
            $sql = "SELECT product.name, product.image, productinorders.quantity, size.size, sizeofproduct.price, productinorders.idproduct 
            FROM productinorders 
            INNER JOIN product ON productinorders.idproduct = product.id 
            INNER JOIN sizeofproduct ON productinorders.idsize = sizeofproduct.idsize AND sizeofproduct.idproduct = productinorders.idproduct 
            INNER JOIN size ON sizeofproduct.idsize = size.id 
            WHERE productinorders.idorder = ".$orderId;
            $result = mysqli_query($this->db->conn, $sql);
            $list_product = array();
            $i = 0;
            if (mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_assoc($result)){
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
    }
?>