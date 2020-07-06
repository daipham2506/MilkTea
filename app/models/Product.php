<?php
class Product
{
  private $db;

  public function __construct()
  {
    $this->db = new Database;
  }
  public function getAllCategory()
  {
    $sql = "SELECT * FROM `category`";
    $result = $this->db->connection->query($sql);
    if ($result) {
      return $result;
    } else {
      echo ("Error description: " . $this->db->connection->error);
      return false;
    }
  }
  public function getCategoryById($categoryId)
  {
    $sql = "SELECT * FROM `category` WHERE id = $categoryId";
    $result = $this->db->connection->query($sql);
    if ($result) {
      return $result;
    } else {
      echo ("Error description: " . $this->db->connection->error);
      return false;
    }
  }
  public function getPriceByProductId($productId){
    $sql = "SELECT sizeofproduct.idproduct, sizeofproduct.price,sizeofproduct.quantity, size.size, size.id
    FROM `sizeofproduct` INNER JOIN `size` ON sizeofproduct.idsize = size.id WHERE sizeofproduct.idproduct = $productId";
    $result = $this->db->connection->query($sql);
    if ($result) {
      return $result;
    } else {
      echo ("Error description: " . $this->db->connection->error);
      return false;
    }
  }
  public function getProductByCategory($categoryId)
  {
    $sql = "SELECT product.id AS `id_product`, product.idcategory, product.name AS `name_product`,
     product.image, product.description, category.name AS `name_category` 
     FROM `product` INNER JOIN `category` ON product.idcategory = category.id 
     WHERE category.id = $categoryId";
    $result = $this->db->connection->query($sql);

    if ($result) {
      $final_result = []; // list product with price
      while($row = $result->fetch_assoc()){
        $product_price =  $this->getPriceByProductId($row["id_product"]);
        array_push($final_result,[
          "id_product"=> $row["id_product"],
          "image"=>$row["image"], 
          "name_product"=> $row["name_product"],
          "idcategory" => $row["idcategory"],
          "description"=> $row["description"],
          "name_category"=> $row["name_category"],
          "price_list"=>$product_price // need to fetch
        ]);
      }
      return $final_result;
    } else {
      echo ("Error description: " . $this->db->connection->error);
      return false;
    }
  }
  public function getProductById($productId){
    $sql = "SELECT * FROM `product` WHERE `id` = $productId";
    $result = $this->db->connection->query($sql);
    $product_price = $this->getPriceByProductId($productId);
    $final_result = [];
    if ($result) {
      $row_product = $result->fetch_assoc();
      $final_result = [
        "id"=>$row_product["id"],
        "idcategory"=>$row_product["idcategory"],
        "name"=>$row_product["name"],
        "image"=>$row_product["image"],
        "description"=>$row_product["description"],
        "price_list"=>$product_price
      ];
      return $final_result;
    } else {
      echo ("Error description: " . $this->db->connection->error);
      return false;
    }
  }
  public function getAllReviewByProductId($productId){
    $sql = "SELECT review.*, users.name, users.avatar FROM `review` INNER JOIN `users` 
    ON review.iduser = users.id WHERE `idproduct` = $productId ORDER BY createdAt DESC";
    $review = [];
    $result = $this->db->connection->query($sql);
    if($result){
        $review = $result;
    }else{
      echo ("Error description: " . $this->db->connection->error);
      return false;
    }
    return $review;
  }
  public function getAverageStarByProductId($productId){
    $sql = "SELECT * FROM (SELECT `idproduct`,AVG(numberstar) 'avgstar' 
    FROM `review` GROUP BY `idproduct`) AS `avgStar` WHERE avgStar.idproduct = $productId;";
    $result = $this->db->connection->query($sql);
    $avgStar = 0;
    if($result){
      if($result->num_rows > 0){
        $row = $result->fetch_assoc();
        //cal start round to 0.5
        $star = round($row["avgstar"],2);
        $floor_star = floor($star);
        if($star - $floor_star >= 0.75){
          $avgStar = $floor_star + 1;
        }elseif($star - $floor_star >= 0.25){
          $avgStar = round(($floor_star + 0.5),1);
        }else{
          $avgStar = $floor_star;
        }
      }
    }else{
      echo ("Error description: " . $this->db->connection->error);
      return false; 
    }
    return $avgStar;
  }
  public function addReview($data){
    $productId = $data["productId"];
    $userId = $data["userId"];
    $content = $data["content"];
    $rating_value = $data["rating_value"];
    $sql = "INSERT INTO `review`(`content`, `createdAt`, `numberstar`, `iduser`, `idproduct`) VALUES ('". $content."',NOW(),$rating_value,$userId,$productId);";
    // echo $sql;
    if($this->db->connection->query($sql)){
      return true;
    }else{
      echo ("Error description: " . $this->db->connection->error);
      return false;
    }
  }

  public function getListProductByNameKey($name_key)
  {
    $name_key = strtolower(stripVN($name_key));
    $name_key_arr = explode(" ",$name_key);
    // var_dump($name_key_arr);
    
    // $query = "SELECT * FROM product where instr(product.name,'$name_key')";
    $query = "SELECT * FROM product";
    $rs = $this->db->connection->query($query);
    $listProduct = [];
    if($rs){
        while($row = $rs->fetch_assoc()){
            $name = strtolower(stripVN($row["name"]));
            $count = 0;
            for($i = 0; $i < count($name_key_arr); $i++){
              $index = strpos($name,$name_key_arr[$i]);
              if(is_integer($index)){
                $count++;
              }
            }
            
            if($count == count($name_key_arr)){
              array_push($listProduct,$row);
            }
            
        }   
        return $listProduct;
    }
    else{
        echo $this->db->connection->error;
        return $listProduct;
    }
  }

  public function getSizePriceQualityByProductId($productId){
    $sql = "SELECT sizeofproduct.price,sizeofproduct.quantity, size.size,size.id FROM sizeofproduct INNER JOIN size 
    ON sizeofproduct.idsize = size.id  WHERE idproduct = $productId ORDER BY size.id";
    $result = $this->db->connection->query($sql);
    if($result){
      return $result;
    }else{
      echo ("Error description: " . $this->db->connection->error);
      return false;
    }
  }
  public function getAllProduct(){
    $sql = "SELECT product.name AS 'product_name',product.id, product.image, product.description , category.name AS 'category_name' 
    FROM `product` INNER JOIN `category` ON product.idcategory = category.id ORDER BY product.id";
    $result = $this->db->connection->query($sql);
    $product_arr = [];
    if($result){
      while($product_row = $result->fetch_assoc()){
        $id = $product_row["id"];
        $name = $product_row["product_name"];
        $image = $product_row["image"];
        $description = $product_row["description"];
        $category = $product_row["category_name"];
        $size_price_quality_list = $this->getSizePriceQualityByProductId($id);
        $product= [
          "id_product" => $id,
          "name_product"=> $name,
          "image" => $image,
          "description"=>$description,
          "name_category"=>$category,
          "size_price_quality"=>$size_price_quality_list
        ];
        array_push($product_arr, $product);
      }
      return $product_arr;
    }else{
      echo ("Error description: " . $this->db->connection->error);
      return false;
    }
  }
  public function getLastProductId(){
    $sql = "SELECT MAX(id) AS `last_id` FROM `product`";
    $result = $this->db->connection->query($sql);
    if($result){
      $row = $result->fetch_assoc();
      return $row["last_id"];
    }else{
      echo ("Error description: " . $this->db->connection->error);
      return false;
    }
  }
  public function addSizeOfProduct($productId,$idsize, $price, $quantity){
    $sql = "INSERT INTO sizeofproduct(`idproduct`, `idsize`, `price`, `quantity`) VALUES($productId,$idsize, $price, $quantity );";
    if($this->db->connection->query($sql)){
      return true;
    }else{
      echo ("Error description: " . $this->db->connection->error);
      return false;
    }
  }
  public function addProduct($data){
    $idcategory = $data["category"];
    $name = $data["name"];
    $image = $data["image"];
    $description = $data["description"];
    $sql = "INSERT INTO product(`idcategory`, `name`,`image`, `description` ) VALUES ('$idcategory', '$name', '$image','$description')";
    if($this->db->connection->query($sql)){
      $product_id = $this->getLastProductId();
      $size_price_quantity_list = $data["price_list"];
      for($i = 0; $i < count($size_price_quantity_list); $i++ ){
        $size_price_quantity = $size_price_quantity_list[$i];
        $idsize =  $size_price_quantity["idsize"];
        $price = $size_price_quantity["price"];
        $quantity =$size_price_quantity["quality"]; //^_^ quality is quantity
        if(!$this->addSizeOfProduct($product_id, $idsize, $price,$quantity)){
          return false;
        }
      }
      return true;
    }else{
      echo ("Error description: " . $this->db->connection->error);
      return false;
    }
  }
  public function getProductToEditById($productId){
    $sql = "SELECT product.name AS 'product_name',product.id, product.image, product.description ,category.id AS 'category_id', category.name AS 'category_name' 
    FROM `product` INNER JOIN `category` ON product.idcategory = category.id WHERE product.id = $productId";
    $result = $this->db->connection->query($sql);
    $product = [];
    if($result){
        $product_row = $result->fetch_assoc();
        $id = $product_row["id"];
        $name = $product_row["product_name"];
        $image = $product_row["image"];
        $description = $product_row["description"];
        $category = $product_row["category_id"];
        $size_price_quality_list = [];
        $res = $this->getSizePriceQualityByProductId($id);
        while($row = $res-> fetch_assoc()){
          array_push($size_price_quality_list, ["idsize" => $row["id"], "quality" => $row["quantity"],"price" => $row["price"]]);
        }
        
        $product= [
          "id_product" => $id,
          "name_product"=> $name,
          "image" => $image,
          "description"=>$description,
          "id_category"=>$category,
          "size_price_quality"=>$size_price_quality_list
        ];
      return $product;
    }else{
      echo ("Error description: " . $this->db->connection->error);
      return false;
    }
  }
  public function updateSizeOfProduct($product_id, $idsize, $price,$quantity){
    // $sql = "INSERT INTO sizeofproduct(`idproduct`, `idsize`, `price`, `quantity`) VALUES($product_id,$idsize, $price, $quantity );";
    $sql = "UPDATE `sizeofproduct` SET `price`= $price, `quantity` = $quantity WHERE `idproduct` = $product_id AND `idsize` = $idsize;";
    // echo $sql. "<br>";
    if($this->db->connection->query($sql)){
      return true;
    }else{
      echo ("Error description: " . $this->db->connection->error);
      return false;
    }
  }
  public function getSizeOfProductByProductId($productId){
    $sql = "SELECT * FROM `sizeofproduct` WHERE `idproduct` = $productId ORDER BY `idsize`";
    $result = $this->db->connection->query($sql);
    $final_result = [];
    if($result){
      while($row = $result -> fetch_assoc()){
        array_push($final_result, ["idsize" => $row["idsize"], "price"=> $row["price"], "quantity"=>$row["quantity"] ]);
      }
      return $final_result;
    }else{
      echo ("Error description: " . $this->db->connection->error);
      return false;
    }
  }
  public function deleteSizeOfProductByPdIdAndSizeId($productId, $idsize){
    $sql = "DELETE FROM `sizeofproduct` WHERE `idproduct` = $productId AND `idsize` = $idsize";
    if($this->db->connection->query($sql)){
      return true;
    }else{
      echo ("Error description: " . $this->db->connection->error);
      return false;
    }
  }
  public function updateProduct($data){
    $productId = $data["productId"];
    $idcategory = $data["category"];
    $name = $data["name"];
    $image = $data["image"];
    $description = $data["description"];
    // $sql = "INSERT INTO product(`idcategory`, `name`,`image`, `description` ) VALUES ('$idcategory', '$name', '$image','$description')";
    $sql = "UPDATE `product` SET `idcategory` = $idcategory, `name` = '$name',`image` = '$image', `description` = '$description'  WHERE `id` = $productId ";
    if($this->db->connection->query($sql)){
      $product_id = $data["productId"];
      $size_price_quantity_list = $data["price_list"];
      $size_price_quantity_old = $this->getSizeOfProductByProductId($product_id);
      // print_r( $size_price_quantity_list). "<br>";
      // xóa hết bảng sizeofproduct cũ và cập nhật bảng mới
      for($j = 0; $j < count($size_price_quantity_old); $j++){
        $idsize =  $size_price_quantity_old[$j]["idsize"];
        // $price = $size_price_quantity_old[$j]["price"];
        // $quantity =$size_price_quantity_old[$j]["quantity"];
        if(!$this->deleteSizeOfProductByPdIdAndSizeId($product_id, $idsize)){
          return false;
        }
      }
      for($i = 0; $i < count($size_price_quantity_list); $i++ ){
        $size_price_quantity = $size_price_quantity_list[$i];
        $idsize =  $size_price_quantity["idsize"];
        $price = $size_price_quantity["price"];
        $quantity =$size_price_quantity["quality"]; //^_^ quality is quantity
        if(!$this->addSizeOfProduct($product_id, $idsize, $price,$quantity)){
            return false;
        }
      }
      return true;
    }else{
      echo ("Error description: " . $this->db->connection->error);
      return false;
    }
  }

  public function addtocart($productId, $sizeId, $quantity, $userId){
    $sql = "INSERT INTO productincart VALUE(".$userId.",".$productId.",".$quantity.",".$sizeId.")";
    if (mysqli_query($this->db->conn, $sql)){
      flash('addtocart','Thêm vào giỏ hàng thành công');
    }
    else{
      flash('addtocart','Thêm vào giỏ hàng không thành công');
    }
  }
}

function stripVN($str) {
  $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', $str);
  $str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $str);
  $str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $str);
  $str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $str);
  $str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $str);
  $str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $str);
  $str = preg_replace("/(đ)/", 'd', $str);

  $str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", 'A', $str);
  $str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $str);
  $str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $str);
  $str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'O', $str);
  $str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $str);
  $str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $str);
  $str = preg_replace("/(Đ)/", 'D', $str);
  return $str;

}
