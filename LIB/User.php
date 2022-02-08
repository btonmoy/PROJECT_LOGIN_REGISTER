<?php
	include_once 'Session.php';
	include 'Database.php' ;

class User{
	
	private $db;
    public function __construct(){
    	
       $this->db = new database();
       }

	public function userRegistration($data){
        
        $name = $data['name'];
        $username = $data['username'];
        $email = $data['email'];
        $Password = $data['Password'];

        $chk_email= $this->emailCheck($email);

       if ($name == "" OR $username == "" OR $email == "" OR $Password == "") {
        
           $msg = "<div class='alert alert-danger'><strong>Error ! </strong>Field must not be Empty</div>";
            return $msg;
       } 
       if (strlen($username)<3) {
       	$msg ="<div class='alert alert-danger'><strong>Error ! </strong>Username is too short</div>";
       	   return $msg;
       }elseif (preg_match('/[^a-z0-9]+/i', $username)) {
       	$msg ="<div class='alert alert-danger'><strong>Error ! </strong>Username must only contain alphanumerical, dashes and underscores!</div>";
	}
	if (filter_var($email,FILTER_VALIDATE_EMAIL)=== false) {
		
		$msg = "<div class='alert alert-danger'><strong>Error ! </strong>The email address is not valid!</div>";
		return $msg;
	}
	if ($chk_email == true) {
       $msg = "<div class='alert alert-danger'><strong>Error ! </strong>The email address already Exist!</div>";
		return $msg;
  }

   $Password = md5($data['Password']);
  $sql = "INSERT INTO tbl_user (name,username,email,password) VALUES (:name,:username,:email,:Password)";
      $query=$this->db->pdo->prepare($sql);
       $query->bindValue(':name',$name);
       $query->bindValue(':username',$username);
       $query->bindValue(':email',$email);
       $query->bindValue(':Password',$Password);
       $result=$query->execute();

       if ($result) {
             $msg = "<div class='alert alert-success'><strong>Sucess ! </strong>Thank you, You have been register!</div>";
              return $msg;
       }else{
           
           $msg = "<div class='alert alert-danger'><strong>Sucess ! </strong>Sorry there has been problem inserting your details!</div>";
              return $msg;
       }


}
  public function emailCheck($email){

       $sql ="SELECT email FROM tbl_user WHERE email = :email";
       $query=$this->db->pdo->prepare($sql);
       $query->bindValue(':email', $email);
       $query->execute();
       if ($query->rowCount() > 0) {

            return true;
        }else{
        	return false;
        }
  }

   public function getLoginUser($email,$Password){
      
       $sql ="SELECT * FROM tbl_user WHERE email = :email AND   Password= :Password LIMIT 1";
       $query=$this->db->pdo->prepare($sql);
       $query->bindValue(':email', $email);
       $query->bindValue(':Password', $Password);
       $query->execute(); 
       $result=$query->fetch(PDO::FETCH_OBJ);
       return $result;
   }

  public function userLogin($data){

        $email = $data['email'];
        $Password = md5($data['Password']);

        $chk_email= $this->emailCheck($email);

       if ($email == "" OR $Password == "") {
        
           $msg = "<div class='alert alert-danger'><strong>Error ! </strong>Field must not be Empty</div>";
            return $msg;
       } 
      
      if (filter_var($email,FILTER_VALIDATE_EMAIL)=== false) {
     
      $msg = "<div class='alert alert-danger'><strong>Error ! </strong>The email address is not valid!</div>";
      return $msg;
  }
      if ($chk_email == false) {
       $msg = "<div class='alert alert-danger'><strong>Error ! </strong>The email address Not Exist!</div>";
      return $msg;

   }
     $result = $this->getLoginUser($email, $Password);
     if ($result) {
         Session::init();
         Session::set("login",true);
         Session::set ("id", $result->id);
         Session::set ("name", $result->name);
         Session::set ("username", $result->username);
         Session::set ("loginmsg", "<div class='alert alert-success'><strong>Sucess ! </strong>you are LoggedIn!</div>");
         header("Location:index.php");
     }else{
      $msg = "<div class='alert alert-danger'><strong>Error ! </strong>Data not found!</div>";
      return $msg; 
     }
  }

  public function getUserData(){
   
     $sql ="SELECT * FROM tbl_user ORDER BY id DESC";
       $query=$this->db->pdo->prepare($sql);
       $query->execute();
       $result=$query->fetchAll();
       return $result;
  }  

  public function getUserById($id){
   
     $sql ="SELECT * FROM tbl_user WHERE id = :id LIMIT 1";
        $query=$this->db->pdo->prepare($sql);
       $query->bindValue(':id', $id);
       $query->execute(); 
       $result=$query->fetch(PDO::FETCH_OBJ);
       return $result;
  }

  public function updateuserData($id , $data){

        $name = $data['name'];
        $username = $data['username'];
        $email = $data['email'];

       if ($name == "" OR $username == "" OR $email == "") {
        
           $msg = "<div class='alert alert-danger'><strong>Error ! </strong>Field must not be Empty</div>";
            return $msg;
       } 

  $sql = " UPDATE tbl_user set
             name = :name,
             username = :username,
             email = :email
             WHERE id = :id ";
      $query=$this->db->pdo->prepare($sql);
       $query->bindValue(':name',$name);
       $query->bindValue(':username',$username);
       $query->bindValue(':email',$email);
       $query->bindValue(':id',$id);
       $result=$query->execute();

       if ($result) {
             $msg = "<div class='alert alert-success'><strong>Sucess ! </strong>Userdata updated Sucessfully!</div>";
              return $msg;
       }else{
           
           $msg = "<div class='alert alert-danger'><strong>Sucess ! </strong>Userdata Not Updated!</div>";
              return $msg;
       }
   }
   private function checkPassword($old_pass , $id){
     $Password = md5($old_pass);
     $sql ="SELECT * FROM tbl_user WHERE id = :id  AND Password= :Password";
       $query=$this->db->pdo->prepare($sql);
       $query->bindValue(':id', $id);
       $query->bindValue(':Password', $Password);
       $query->execute();
       if ($query->rowCount() > 0) {
            return true;
        }else{
          return false;
        }
   }
 public function updatePassword($id , $data){

           $old_pass = $data['old_pass'];
           $new_pass = $data['Password'];
           $chk_pass = $this->checkPassword($old_pass ,$id); 

           if ($old_pass == "" OR $new_pass == "" ) {
              
                $msg = "<div class='alert alert-danger'><strong>Error ! </strong>Field Must Not be Empty</div>";
                return $msg;
           }
        
            if ($chk_pass == false) {
              $msg = "<div class='alert alert-danger'><strong>Error ! </strong>Old password not exist </div>";
                return $msg;
            }

            if (strlen($new_pass)<6) {
              $msg = "<div class='alert alert-danger'><strong>Error ! </strong> Password is too short.</div>";
              return $msg;
            }

            $Password = md5($new_pass);
            $sql = "UPDATE tbl_user set
             Password = :Password
             WHERE id = :id ";
        $query=$this->db->pdo->prepare($sql);

       $query->bindValue(':Password', $Password);
       $query->bindValue(':id',$id);
       $result=$query->execute(); 
       if ($result) {
             $msg = "<div class='alert alert-success'><strong>Sucess ! </strong> Password updated Sucessfully!</div>";
              return $msg;
       }else{
           
           $msg = "<div class='alert alert-danger'><strong>Sucess ! </strong>Password Not Updated!</div>";
              return $msg;
       }
    }

  }
?>