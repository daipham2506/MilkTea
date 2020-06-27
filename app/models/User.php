<?php
class User
{
  private $db;

  public function __construct()
  {
    $this->db = new Database;
  }

  // Regsiter user
  public function register($data)
  {
    $this->db->query('INSERT INTO users (name, email, password) VALUES(:name, :email, :password)');
    // Bind values
    $this->db->bind(':name', $data['name']);
    $this->db->bind(':email', $data['email']);
    $this->db->bind(':password', $data['password']);

    // Execute
    if ($this->db->execute()) {
      return true;
    } else {
      return false;
    }
  }

  // Login User
  public function login($email, $password)
  {
    $this->db->query('SELECT * FROM users WHERE email = :email');
    $this->db->bind(':email', $email);

    $row = $this->db->single();

    $hashed_password = $row->password;
    if (password_verify($password, $hashed_password)) {
      return $row;
    } else {
      return false;
    }
  }

  // Find user by email
  public function findUserByEmail($email)
  {
    $this->db->query('SELECT * FROM users WHERE email = :email');
    // Bind value
    $this->db->bind(':email', $email);

    $row = $this->db->single();

    // Check row
    if ($this->db->rowCount() > 0) {
      return true;
    } else {
      return false;
    }
  }
  public function findUserById($userId)
  {
    $this->db->query('SELECT * FROM users WHERE id = :userId');
    $this->db->bind(':userId', $userId);
    $row = $this->db->single();
    if ($this->db->rowCount() > 0) {
      return $row;
    } else {
      return false;
    }
  }
  public function findOtherUserByEmail($userId, $email)
  {
    $sql = "SELECT * FROM users WHERE (email = '$email') AND (id != $userId)";
    $result = mysqli_query($this->db->conn, $sql);
    if (mysqli_num_rows($result) > 0) {
      return true;
    } else {
      return false;
    }
  }
  public function update($data, $userId)
  {
    $sql = "UPDATE `users`
      SET `name` = '" . $data["name"] . "',
      `email` = '" . $data["email"] . "',
      `birthday` = '" . $data["birthday"] . "',
      `address` = '" . $data["address"] . "',
      `gender` = '" . $data["gender"] . "',
      `avatar` = '" . $data["avatar"] . "'
      WHERE `id` = $userId";
    if (mysqli_query($this->db->conn, $sql)) {
      return true;
    } else {
      echo ("Error description: " . $this->db->conn->error);
      return false;
    }
  }
  public function findUserPasswordById($userId)
  {
    $sql = "SELECT `id`, `password` FROM `users` WHERE `id` = $userId";
    $result = mysqli_query($this->db->conn, $sql);
    if ($result) {
      $row = $result->fetch_assoc();
      return $row;
    } else {
      echo ("Error description: " . $this->db->conn->error);
      return false;
    }
  }
  public function changePass($userId, $password)
  {
    $sql = "UPDATE `users` SET `password` = '".$password."' WHERE `id` = $userId;";
    if (mysqli_query($this->db->conn, $sql)) {
      return true;
    } else {
      echo ("Error description: " . $this->db->conn->error);
      return false;
    }
  }
}
