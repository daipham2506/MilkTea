<?php
    class Shopping{
        private $db;

        public function __construct(){
            $this->db = new Database;
        }

        public function getShoppingCart($userId){
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
            
            if ($result || mysqli_num_rows($result) > 0) {
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
            else {
                echo "0 result";
            } 
            return $data;

        } 
        public function changeQuantity($userId, $productId, $newQuantity) {
            $sql_update = "UPDATE productincart, cart
                           SET productincart.quantity=".$newQuantity." WHERE productincart.idproduct=".$productId." AND productincart.idcart=cart.id AND cart.iduser=".$userId;
            if(mysqli_query($this->db->conn, $sql_update)){
                flash('changeQuantity','Đổi số lượng thành công');
            }     
            else{
                flash('changeQuantity','Đổi không thành công');
            }       
        }

        public function cancelProduct($userId, $productId){
            $sql_delete = "DELETE productincart
                            FROM productincart,cart
                            WHERE productincart.idcart = cart.id AND cart.iduser = ".$userId." AND productincart.idproduct = ".$productId;
            if (mysqli_query($this->db->conn, $sql_delete)){
                flash('cancelProduct','Hủy thành công');
            }
            else{
                flash('cancelProduct','Hủy không thành công');
            }
        }

        public function orderCart($userId){
            // Check user have Address or not?
            $sql = "SELECT address FROM users WHERE id=".$userId;
            $result = mysqli_query($this->db->conn, $sql);

            $address='';
            if (mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_assoc($result)){
                    $address = $row['address'];
                }
            }
            if ($address == ""){
                flash('ordercart','Vui lòng cập nhật địa chỉ trước khi đặt hàng');
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
                     
                    flash('ordercart','Sản phẩm '.$name.' còn lại không đủ, vui lòng đặt lại số lượng');
                    return;
                }
            }
            // order

            $sql = "CALL CREATE_ORDER(".$userId.")";
            $result = mysqli_query($this->db->conn, $sql);
            if ($result){
                flash('ordercart','Đặt hàng thành công');
            }
           
        }
    }
?>