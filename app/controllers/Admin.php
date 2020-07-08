<?php
class Admin extends Controller
{
	public function __construct()
	{
		$this->userModel = $this->model('User');
		$this->orderModel = $this->model('Shopping');
		$this->InfoWebModel = $this->model('InfoWeb');
	}

	public function index()
	{
		$num_of_user_per_page = 5;
		$pageNumber = 1;
		if(isset($_GET['page'])){
			$pageNumber = $_GET['page'];
		}
		$allUsers = $this->userModel->getAllUsers($pageNumber,$num_of_user_per_page);
		$numOfUser = $this->userModel->getNumOfUser();
		$totalPage = ceil($numOfUser / $num_of_user_per_page);

		$data = [
			'users' => $allUsers,
			"totalPage"=>$totalPage
		];
		$this->view("admin/index", $data);
	}

	public function deleteUser($userId)
	{
		if ($this->userModel->deleteUserById($userId)) {
			$message = 'Bạn đã xóa user thành công!';
			flash('del_user', $message);
		} else {
			$message = 'Xóa user không thành công!';
			flash('del_user', $message, 'alert-danger');
		}
		redirect('admin');
	}

	public function changepass($userId)
	{
		$data = [
			'id' => $userId,
			'old_pass_err' => '',
			'new_pass_err' => '',
			'confirm_pass_err' => '',
		];
		if ($_SERVER['REQUEST_METHOD'] != 'POST') {
			$this->view('admin/changepass', $data);
		} else {
			$old_pass = trim($_POST['old-pass']);
			$new_pass = trim($_POST['new-pass']);
			$confirm_pass = trim($_POST['confirm-pass']);

			if ($this->userModel->findUserPasswordById($userId)) {
				$currentUser =  $this->userModel->findUserPasswordById($userId);
				if (empty($old_pass)) {
					$data['old_pass_err'] = "Vui lòng nhập mật khẩu cũ";
				} elseif (!password_verify($old_pass, $currentUser['password'])) {
					$data['old_pass_err'] =  "Sai mật khẩu";
				}
				if (empty($new_pass)) {
					$data['new_pass_err'] = "Vui lòng nhập mật khẩu mới";
				} elseif (strlen($new_pass) < 6) {
					$data['new_pass_err'] = "Mật khẩu phải có ít nhất 6 kí tự";
				}
				if (empty($confirm_pass)) {
					$data['confirm_pass_err'] = "Vui lòng nhập lại mật khẩu";
				} elseif ($confirm_pass != $new_pass) {
					$data['confirm_pass_err'] = "Nhập lại mật khẩu sai";
				}
			}
			if (empty($data['old_pass_err']) && empty($data['new_pass_err']) && empty($data['confirm_pass_err'])) {
				$password = password_hash($new_pass, PASSWORD_DEFAULT);

				// Update User
				if ($this->userModel->changePass($userId, $password)) {
					flash('changepass_success', 'Đổi mật khẩu thành công');
					redirect('users/login');
				} else {
					die('Something went wrong');
				}
			} else {
				//load view with error
				$this->view('admin/changepass', $data);
			}
		}
	}

	public function manageOrders()
	{
		$data = [];
		$orders = $this->orderModel->getAllOrders();
		foreach($orders as $order) {
			$d['id'] = $order['id'];
			$d['address'] = $order['address'];
			$d['status'] = $order['status'];
			$d['nameUser'] = $order['nameUser'];
			$d['email'] = $order['email'];
			$d['product'] = $this->orderModel->getProductsByOrderid($order['id']);
			array_push($data, $d);
		}
		$this->view('admin/manage-orders', $data);		
	}

	public function changeStatus($id) {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$status = $_POST['status'];
			$success = $this->orderModel->updateStatus($id, $status);
			if($success){
				flash('update-status', "Mã đơn hàng $id đã được thay đổi trạng thái");
			} else {
				flash('update-status', "Mã đơn hàng $id thay đổi trạng thái không thành công", "alert-danger");
			}
			redirect("admin/manageOrders");
		} 
	}
	public function editcontact(){
		if($_SERVER['REQUEST_METHOD'] != 'POST'){
			$data = [];
			if($this->InfoWebModel->getContact()){
				$data = $this->InfoWebModel->getContact();
			}
			$this->view('admin/editcontact', $data);
		}else{
			$data = [
				"address"=>$_POST["address"], 
				"phone"=> $_POST["phone"], 
				"email"=> $_POST["email"], 
				"facebook" =>  $_POST["facebook"],
				"instagram" => $_POST["instagram"]
			];
			if($this->InfoWebModel->updateContact($data)){
				flash("update_contact","Cập nhật thông tin liên hệ thành công");
				redirect("admin");
			}else{
				flash("update_contact","Cập nhật thông tin liên hệ thất bại", 'alert-danger');
				redirect("admin");
			}
		}
	}
}
