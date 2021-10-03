<?php
// include '../lib/session.php';
$filepath = realpath(dirname(__FILE__));

include_once($filepath . '/../lib/database.php');
include_once($filepath . '/../helpers/format.php');
// include_once ("$_SERVER[DOCUMENT_ROOT]/website_mvc/lib/database.php");
// include_once ("$_SERVER[DOCUMENT_ROOT]/website_mvc/helpers/format.php");

class cart
{
    private $db;
    private $fm;

    public function __construct()
    {
        $this->db = new Database();
        $this->fm = new Format();
    }
    public function add_to_cart($quantity, $id)
    {
        $quantity = $this->fm->validation($quantity);
        $quantity = mysqli_real_escape_string($this->db->link, $quantity);
        $id = mysqli_real_escape_string($this->db->link, $id);
        $sId = session_id();

        $query = "Select *from tbl_product where productId='$id'";
        $result= $this->db->select($query)->fetch_assoc();
        $image=$result["image"];
        $price=$result["price"];
        $productName=$result["productName"];
        // echo session_id();
       
        $checkcart = "Select *from tbl_cart where sId='$sId' and productId='$id'";//câu truy vấn
        $check_cart=$this->db->select($checkcart);// thực hiện lệnh
        
        // if(mysqli_num_rows($check_cart)>0){
            if($check_cart){
           
            $alert="Product already added";
            return $alert;
        }
        else{
        $query_insert = "Insert into tbl_cart(productId,quantity,sId,image,price,productName)
        values('$id','$quantity','$sId','$image','$price','$productName')";
        // values('$id','$quantity','$sId','$result['image']','$result['price']','$result['productName']')";
        $insert_cart = $this->db->insert($query_insert);
        if ($insert_cart) {
            header('Location:cart.php');
           
        } else {
            header('Location:404.php');
           
        }
    }
    }
    public function get_product_cart(){
        // hiển thị sản phẩm theo session của người dùng đã thêm
        $sId = session_id();
        $query ="select *from tbl_cart where sId='$sId'";
        
        $result= $this->db->select($query);
        return $result;
    }
    public function update_quantity_cart($quantity,$cartId){
        $quantity = mysqli_real_escape_string($this->db->link, $quantity);
        $cartId = mysqli_real_escape_string($this->db->link, $cartId);

        $query = "UPDATE tbl_cart SET 
            quantity ='$quantity'
           
             where cartId ='$cartId'";
         $result= $this->db->update($query);
         if($result){
            header('Location:cart.php');
         }
         else{
            $msg="<span class='error'>Product quantity update not successfully</span>";
            return $msg;
         }
    }
    public function del_product_cart($cartId){
        $cartId = mysqli_real_escape_string($this->db->link, $cartId);
        $query = "delete from tbl_cart where cartId='$cartId'";
        
        $result= $this->db->delete($query);
        if($result){
            header('Location:cart.php');
           
         }
         else{
            $msg="<span class='error'>Product Deleted not successfully</span>";
            return $msg;
         }
    }
    public function check_cart(){
        $sId = session_id();
        $query ="select *from tbl_cart where sId='$sId'";
        
        $result= $this->db->select($query);
        return $result;
    }
    public function check_order($customer_id){
        $sId = session_id();
        $query ="select *from tbl_order where customer_id='$customer_id'";
        
        $result= $this->db->select($query);
        return $result;

    }
    public function del_all_data_cart(){
        $sId = session_id();
        $query ="delete from tbl_cart where sId='$sId'";
        
        $result= $this->db->delete($query);
        return $result;
    }
    public function del_compare_($customer_id){
        $sId = session_id();
        $query ="delete from tbl_compare where customer_id='$customer_id'";
        
        $result= $this->db->delete($query);
        return $result;


    }
    public function insertOrder($customer_id){
        $sId =session_id();
        $query ="select * from tbl_cart where sId='$sId'";
        
        $get_product= $this->db->select($query);
        if($get_product){
            while($result =$get_product->fetch_assoc()){
                $productId=$result['productId'];
                $productName=$result['productName'];
                $quantity=$result['quantity'];
                $price=$result['price']*$quantity;
                $image=$result['image'];
                $customer_id=$customer_id;
                $query_order = "Insert into tbl_order(productId,productName,quantity,price,image,customer_id)
                values('$productId','$productName','$quantity','$price','$image','$customer_id')";
                
                $insert_order = $this->db->insert($query_order);
               

            }
        }

    }
    public function getAmoutPrice($customer_id){
        
        $query ="select price from tbl_order where customer_id='$customer_id' ";
        $get_price= $this->db->select($query);
        return $get_price;

    }
    public function get_cart_ordered($customer_id){
        
        $query ="select *from tbl_order where customer_id='$customer_id' ";
        $get_cart_ordered= $this->db->select($query);
        return $get_cart_ordered;
    }
    public function get_inbox_cart(){
        $query ="select *from tbl_order order by date_order ";
        $get_inbox_cart= $this->db->select($query);
        return $get_inbox_cart;
    }
    public function shifted($id,$time,$price){
        $id = mysqli_real_escape_string($this->db->link, $id);
        $time = mysqli_real_escape_string($this->db->link, $time);
        $price = mysqli_real_escape_string($this->db->link, $price);

        $query = "UPDATE tbl_order SET 
            status ='1'
           
             where id ='$id' and date_order ='$time' and price ='$price'";
         $result= $this->db->update($query);
         if($result){
            $msg="<span class='error'>Update order  successfully</span>";
            return $msg;
         }
         else{
            $msg="<span class='error'>Update order not  successfully</span>";
            return $msg;
         }
    }
    public function del_shifted($id,$time,$price){
        $id = mysqli_real_escape_string($this->db->link, $id);
        $time = mysqli_real_escape_string($this->db->link, $time);
        $price = mysqli_real_escape_string($this->db->link, $price);

        $query = "DELETE from tbl_order 
           
             where id ='$id' and date_order ='$time' and price ='$price'";
         $result= $this->db->delete($query);
         if($result){
            $msg="<span class='error'>Delete order  successfully</span>";
            return $msg;
         }
         else{
            $msg="<span class='error'>Delete order not  successfully</span>";
            return $msg;
         }
    }
    public function shifted_confirm($id,$time,$price){
        $id = mysqli_real_escape_string($this->db->link, $id);
        $time = mysqli_real_escape_string($this->db->link, $time);
        $price = mysqli_real_escape_string($this->db->link, $price);

        $query = "Update tbl_order set status='2'
           
             where customer_id ='$id' and date_order ='$time' and price ='$price'";
         $result= $this->db->update($query);
         return $result;
    }
   
}
?>
