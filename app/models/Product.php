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
    $sql = "SELECT sizeofproduct.idproduct, sizeofproduct.price,sizeofproduct.quantity, size.size 
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
    echo $sql;
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
