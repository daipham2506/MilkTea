<?php
class Admin extends Controller
{
  public function __construct()
  {
    $this->userModel = $this->model('User');
  }

  public function index() {
    $allUsers = $this->userModel->getAllUsers();

    $data = [
      'users' => $allUsers
    ];
    $this->view("admin/index", $data);
  }

    public function deleteUser($userId) {
        if($this->userModel->deleteUserById($userId)) {
            $message = 'Bạn đã xóa user thành công!';
            flash('del_user', $message);
        } else {
            $message = 'Xóa user không thành công!';
            flash('del_user', $message, 'alert-danger');
        }
        redirect('admin');
    }
}
