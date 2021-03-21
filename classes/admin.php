<?php
$filepath=realpath(dirname(__FILE__));
include($filepath.'/../lib/Database.php');
include($filepath.'/../lib/Session.php');
include($filepath.'/../helpers/Format.php');


class admin{

    private $db;
    private $fm;

    public function __construct()
    {
        $this->db=new Database();
        $this->fm=new Format();
    }

    public function getAdminData($data){
        $username=$this->fm->validation($data['username']);
        $password=$this->fm->validation($data['password']);
        $username=mysqli_real_escape_string($this->db->link,$username);
        $password=mysqli_real_escape_string($this->db->link,$password);

        $query="select * from admin where email='$username' AND password='$password'";
        $result=$this->db->select($query);
        if($result != FALSE){
            $value=$result->fetch_assoc();
            Session::init();
            Session::set('adminLogin','true');
            Session::set('adminEmail',$value['email']);
            Session::set('adminLogin',$value['password']);

            header('location:index.php');
        }else{
            $msg="<span class='error'>Username or password not matched</span>";
            return $msg;
        }
    }

}


?>