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
}
