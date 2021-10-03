<?php
// include '../lib/session.php';
$filepath = realpath(dirname(__FILE__));
include_once ($filepath.'/../lib/database.php');
include_once ($filepath.'/../helpers/format.php');
// include_once ("$_SERVER[DOCUMENT_ROOT]/website_mvc/lib/database.php");
// include_once ("$_SERVER[DOCUMENT_ROOT]/website_mvc/helpers/format.php");
class product
{
    private $db;
    private $fm;

    public function __construct()
    {
        $this->db = new Database();
        $this->fm = new Format();
    }
    public function insert_product($data, $files)
    {
        // $productName = $this->fm->validation($productName);

        $productName = mysqli_real_escape_string($this->db->link, $data['productName']);
        $brand = mysqli_real_escape_string($this->db->link,  $data['brand']);
        $category = mysqli_real_escape_string($this->db->link,  $data['category']);
        $product_desc = mysqli_real_escape_string($this->db->link,  $data['product_desc']);
        $price = mysqli_real_escape_string($this->db->link,  $data['price']);
        $type = mysqli_real_escape_string($this->db->link,  $data['type']);
        //kiểm tra hình ảnh và lấy hình ảnh cho vào folder uploads

        $permited = array('jpg', 'jpeg', 'png', 'gif');
        $file_name = $_FILES['image']['name'];
        $file_size = $_FILES['image']['size'];
        $file_temp = $_FILES['image']['tmp_name'];

        $div = explode('.', $file_name);
        $file_ext = strtolower(end($div));
        $unique_image = substr(md5(time()), 0, 10) . '.' . $file_ext;
        $uploaded_image = "uploads/" . $unique_image;

        if ($productName == "" || $category == "" || $brand == "" || $product_desc == "" || $price == "" || $type == "" || $file_name == "") {
            $alert = "<span class='error'> Field must be not empty</span>";
            return $alert;
        } else {
            move_uploaded_file($file_temp, $uploaded_image);
            $query = "Insert into tbl_product(productName,catId,brandId,product_desc,type,price,image)
                 values('$productName','$category','$brand','$product_desc','$type','$price','$unique_image')";
            $result = $this->db->insert($query);
            if ($result) {
                $alert = "<span class='success'>Insert Product successfully</span>";
                return $alert;
            } else {
                $alert = "<span class='error'>Insert Product not successfully</span>";
                return $alert;
            }
        }
    }
    public function insert_slider($data, $files){
        
        $sliderName = mysqli_real_escape_string($this->db->link, $data['sliderName']);
        $type = mysqli_real_escape_string($this->db->link,  $data['type']);
        
       //kiểm tra hình ảnh và lấy hình ảnh cho vào folder uploads

       $permited = array('jpg', 'jpeg', 'png', 'gif');
       $file_name = $_FILES['image']['name'];
       $file_size = $_FILES['image']['size'];
       $file_temp = $_FILES['image']['tmp_name'];

       $div = explode('.', $file_name);
       $file_ext = strtolower(end($div)); //lay duoi jpg,..
      // $file_current = strtolower(end($div));
       $unique_image = substr(md5(time()), 0, 10) . '.' . $file_ext;
       $uploaded_image = "uploads/" . $unique_image;


       if ($sliderName == "" || $type == "" ) {
           $alert = "<span class='error'> Field must be not empty</span>";
           return $alert;
       } else  {
           if(!empty($file_name)){
               //neey nguoi dung chon anh
           if($file_size >1024000){
              
               $alert = "<span class='error'>Image Size should be less than 1MB!</span>";
               return $alert;
           }
           elseif (in_array($file_ext, $permited) === false){
              // echo "<span class='error'> You can upload only:-".implode(',',$permited)."</span>";
               $alert = "<span class='error'> You can upload only:-".implode(',',$permited)."</span>";
               return $alert; 

           }
           move_uploaded_file($file_temp, $uploaded_image);
           $query = "Insert into tbl_slider(sliderName,type,slider_image)
           values('$sliderName','$type','$unique_image')";
      $result = $this->db->insert($query);
      if ($result) {
          $alert = "<span class='success'>Slider Added successfully</span>";
          return $alert;
      } else {
          $alert = "<span class='error'>Slider Added not successfully</span>";
          return $alert;
      }
                

       }
       
    }

    }
    public function show_product()
    {
        $query = "select p.*,c.catName,b.brandName
         from tbl_product as p , tbl_category as c,tbl_brand as b 
         where p.catId = c.catId
          and p.brandId = b.brandId
          order by p.productId desc";

        // $query = "select tbl_product.*,tbl_category.catName,tbl_brand.brandName
        // from tbl_product INNER JOIN tbl_category ON tbl_product.catId = tbl_category.catId
        // INNER JOIN tbl_brand ON tbl_product.brandId = tbl_brand.brandId
        //  order by productId desc";
        // $query = "select * from tbl_product order by productId desc";
        $result = $this->db->select($query);
        return $result;
    }
    public function show_slider()
    {
        $query ="Select * from tbl_slider where type='1' order by sliderId desc";
        $result = $this->db->select($query);
        
        
        return $result;
    }
    public function update_product($data,$file,$id)
    {

       
        $productName = mysqli_real_escape_string($this->db->link, $data['productName']);
        $brand = mysqli_real_escape_string($this->db->link,  $data['brand']);
        $category = mysqli_real_escape_string($this->db->link,  $data['category']);
        $product_desc = mysqli_real_escape_string($this->db->link,  $data['product_desc']);
        $price = mysqli_real_escape_string($this->db->link,  $data['price']);
        $type = mysqli_real_escape_string($this->db->link,  $data['type']);
        //kiểm tra hình ảnh và lấy hình ảnh cho vào folder uploads

        $permited = array('jpg', 'jpeg', 'png', 'gif');
        $file_name = $_FILES['image']['name'];
        $file_size = $_FILES['image']['size'];
        $file_temp = $_FILES['image']['tmp_name'];

        $div = explode('.', $file_name);
        $file_ext = strtolower(end($div)); //lay duoi jpg,..
       // $file_current = strtolower(end($div));
        $unique_image = substr(md5(time()), 0, 10) . '.' . $file_ext;
        $uploaded_image = "uploads/" . $unique_image;


        if ($productName == "" || $category == "" || $brand == "" || $product_desc == "" || $price == "" || $type == "" ) {
            $alert = "<span class='error'> Field must be not empty</span>";
            return $alert;
        } else  {
            if(!empty($file_name)){
                //neey nguoi dung chon anh
            if($file_size >1024000){
               
                $alert = "<span class='error'>Image Size should be less than 1MB!</span>";
                return $alert;
            }
            elseif (in_array($file_ext, $permited) === false){
               // echo "<span class='error'> You can upload only:-".implode(',',$permited)."</span>";
                $alert = "<span class='error'> You can upload only:-".implode(',',$permited)."</span>";
                return $alert; 

            }
            move_uploaded_file($file_temp, $uploaded_image);
            $query = "UPDATE tbl_product SET 
            productName ='$productName',
            brandId ='$brand',
            catId ='$category',
            type ='$type',
            price ='$price',
            image ='$unique_image',
            
            product_desc ='$product_desc'
             where productId ='$id'";         

        }
        
        else{
           
            // neu khong chon anh
            $query = "UPDATE tbl_product SET 
            productName ='$productName',
            brandId ='$brand',
            catId ='$category',
            type ='$type',
            price ='$price',
           
            product_desc ='$product_desc'
             where productId ='$id'";


        }
            $result = $this->db->update($query);
            if ($result) {
                $alert = "<span class='success'>Product Update successfully</span>";
                return $alert;
            } else {
                $alert = "<span class='error'>Product not successfully</span>";
                return $alert;
            }
        
        }
    }
    public function del_product($id)
    {
        $query = "DELETE FROM `tbl_product` WHERE productId='$id'";
        $result = $this->db->delete($query);
        if ($result) {
            $alert = "<span class='success'>Delete Product successfully</span>";
            return $alert;
        } else {
            $alert = "<span class='error'>Delete Product not successfully</span>";
            return $alert;
        }
    }
    public function del_wlist($proid,$customer_id){
        $query = "DELETE FROM tbl_wishlist WHERE productId='$proid' and customer_id='$customer_id'";
        $result = $this->db->delete($query);
        return $result;
    }
    public function getproductbyId($id)
    {
        $query = "select * from tbl_product where productId='$id'";
        $result = $this->db->select($query);
        return $result;
    }
    //ENd Backend
    public function getproduct_feathered(){
        $query = "select * from tbl_product where type='0'";
        $result = $this->db->select($query);
        return $result;
    }
    public function getproduct_new(){
        $query = "select * from tbl_product order by productId  desc LIMIT 4";
        $result = $this->db->select($query);
        return $result;
    }
    public function get_details($id){
       
          $query = "select tbl_product.*,tbl_category.catName,tbl_brand.brandName
        from tbl_product INNER JOIN tbl_category ON tbl_product.catId = tbl_category.catId
        INNER JOIN tbl_brand ON tbl_product.brandId = tbl_brand.brandId
         where tbl_product.productId = '$id'";
        
        $result = $this->db->select($query);
        return $result;
    }
    public function getLastestDell(){
        $query = "select * from tbl_product where brandId ='1' order by productId desc limit 1";
        $result = $this->db->select($query);
        return $result;
    }
    public function getLastestOppo(){
        $query = "select * from tbl_product where brandId ='6' order by productId desc limit 1";
        $result = $this->db->select($query);
        return $result;
    }
    public function getLastestHuawei(){
        $query = "select * from tbl_product where brandId ='7' order by productId desc limit 1";
        $result = $this->db->select($query);
        return $result;
    }
    public function getLastestSamsung(){
        $query = "select * from tbl_product where brandId ='3' order by productId desc limit 1";
        $result = $this->db->select($query);
        return $result;
    }
    public function get_compare($customer_id){
        $query = "select * from tbl_compare where customer_id ='$customer_id' order by id desc ";
        $result = $this->db->select($query);
        return $result;
    }
    public function get_wishlist($customer_id){
        $query = "select * from tbl_wishlist where customer_id ='$customer_id' order by id desc ";
        $result = $this->db->select($query);
        return $result;
    }
    public function insertCompare($productid,$customer_id){
        
        $productid = mysqli_real_escape_string($this->db->link, $productid);
        $customer_id = mysqli_real_escape_string($this->db->link, $customer_id);
       
        // echo session_id();
       
        $query_check_compare = "Select *from tbl_compare where productid='$productid' and customer_id='$customer_id'";//câu truy vấn
        $check_compare=$this->db->select($query_check_compare);// thực hiện lệnh
        
        // if(mysqli_num_rows($check_cart)>0){
            if($check_compare){
           
            $alert="<span class='error'>Product Added to Compare</span>";
            return $alert;
        }
        else{
            
        $query = "Select *from tbl_product where productId='$productid'";
        $result= $this->db->select($query)->fetch_assoc();
        $productName=$result["productName"];
        $price=$result["price"];
        $image=$result["image"];
        $query_insert = "Insert into tbl_compare(productId,customer_id,productName,price,image)
        values('$productid','$customer_id','$productName','$price','$image')";
        
        $insert_compare = $this->db->insert($query_insert);
        if ($insert_compare) {
            $alert = "<span class='success'>Added compare successfully</span>";
            return $alert;
        } else {
            $alert = "<span class='error'>Added compare not successfully</span>";
            return $alert;
        }}
    
    }
    public function insertWishlist($productid, $customer_id){
        $productid = mysqli_real_escape_string($this->db->link, $productid);
        $customer_id = mysqli_real_escape_string($this->db->link, $customer_id);
       
        $query_wlist = "Select *from tbl_wishlist where productid='$productid' and customer_id='$customer_id'";//câu truy vấn
        $check_wlist=$this->db->select($query_wlist);// thực hiện lệnh

        if($check_wlist){
           
            $alert="<span class='error'>Product Added to Wishlist</span>";
            return $alert;
        }
        else{

        $query = "Select *from tbl_product where productId='$productid'";
        $result= $this->db->select($query)->fetch_assoc();
        $productName=$result["productName"];
        $price=$result["price"];
        $image=$result["image"];
        // echo session_id();
       
        
        
        // if(mysqli_num_rows($check_cart)>0){
          
        $query_insert = "Insert into tbl_wishlist(productId,customer_id,productName,price,image)
        values('$productid','$customer_id','$productName','$price','$image')";
        
        $insert_compare = $this->db->insert($query_insert);
        if ($insert_compare) {
            $alert = "<span class='success'>Added wishlist successfully</span>";
            return $alert;
        } else {
            $alert = "<span class='error'>Added wishlist not successfully</span>";
            return $alert;
        }}

    }
    
    
    
}

    
