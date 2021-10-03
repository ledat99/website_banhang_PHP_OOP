<?php

$filepath = realpath(dirname(__FILE__));

include_once($filepath . '/../lib/database.php');
include_once($filepath . '/../helpers/format.php');


class customer
{
    private $db;
    private $fm;

    public function __construct()
    {
        $this->db = new Database();
        $this->fm = new Format();
    }
    public function insert_customers($data)
    {
        $name = mysqli_real_escape_string($this->db->link, $data['name']);
        $city = mysqli_real_escape_string($this->db->link, $data['city']);
        $zipcode = mysqli_real_escape_string($this->db->link, $data['zipcode']);
        $email = mysqli_real_escape_string($this->db->link, $data['email']);
        $address = mysqli_real_escape_string($this->db->link, $data['address']);
        $country = mysqli_real_escape_string($this->db->link, $data['country']);
        $phone = mysqli_real_escape_string($this->db->link, $data['phone']);
        $password = mysqli_real_escape_string($this->db->link, md5($data['password']));

        if ($name == "" || $city == "" || $zipcode == "" || $email == "" || $address == "" || $country == "" || $phone == "" || $password == "") {
            $alert = "<span class='error'> Field must be not empty</span>";
            return $alert;
        } else {
            $check_email = "select * from tbl_customer where email='$email' limit 1";
            $result_check = $this->db->select($check_email);
            if ($result_check) {
                $alert = "<span class='error'> Email already existed  ! Please Enter Another Email</span>";
                return $alert;
            } else {
                
                $query = "Insert into tbl_customer(name,city,zipcode,email,address,country,phone,password)
                 values('$name','$city','$zipcode','$email','$address','$country','$phone','$password')";
                $result = $this->db->insert($query);
                if ($result) {
                    $alert = "<span class='success'>Customer created successfully</span>";
                    return $alert;
                } else {
                    $alert = "<span class='error'>Customer created not successfully</span>";
                    return $alert;
                }
            }
        }
    }
    public function login_customers($data){
        $email = mysqli_real_escape_string($this->db->link, $data['email']);
        $password = mysqli_real_escape_string($this->db->link, md5($data['password']));
        
        if ($email == "" || $password == "") {
            
            $alert = "<span class='error'> Email and password must be not empty</span>";
            return $alert;
        } else {
            $check_login = "select * from tbl_customer where email='$email' and password='$password' ";
            $result_check = $this->db->select($check_login);
            if ($result_check!= false) {//neu khong sai
                $value =$result_check->fetch_assoc();
                Session::set('customer_login',true);//người dùng đăng nhập thành công
                Session::set('customer_id',$value['id']);
                Session::set('customer_name',$value['name']);
                header('Location:order.php');
            } else {
                $alert = "<span class='error'> Email or password doesn't match</span>";
                return $alert;
                
            }
        }

    }
    public function show_customers($id){
        $query = "select * from tbl_customer where id='$id'";
        $result = $this->db->select($query);
        return $result;

    }
    public function update_customers($data,$id){
        $name = mysqli_real_escape_string($this->db->link, $data['name']);
        
        $zipcode = mysqli_real_escape_string($this->db->link, $data['zipcode']);
        $email = mysqli_real_escape_string($this->db->link, $data['email']);
        $address = mysqli_real_escape_string($this->db->link, $data['address']);
        
        $phone = mysqli_real_escape_string($this->db->link, $data['phone']);
       

        if ($name == "" ||  $zipcode == "" || $email == "" || $address == ""  || $phone == "" ) {
            $alert = "<span class='error'> Field must be not empty</span>";
            return $alert;
        } else {
           
                
                $query = "Update tbl_customer set name='$name',zipcode='$zipcode',email='$email',address='$address',phone='$phone'
                 where id='$id' ";
                $result = $this->db->insert($query);
                if ($result) {
                    $alert = "<span class='success'>Customer updated successfully</span>";
                    return $alert;
                } else {
                    $alert = "<span class='error'>Customer updated not successfully</span>";
                    return $alert;
                }
            
        }

    }
}
