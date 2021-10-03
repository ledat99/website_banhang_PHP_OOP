<?php
// include '../lib/session.php';
$filepath = realpath(dirname(__FILE__));
include_once ($filepath.'/../lib/database.php');
include_once ($filepath.'/../helpers/format.php');
// include_once ("$_SERVER[DOCUMENT_ROOT]/website_mvc/lib/database.php");
// include_once ("$_SERVER[DOCUMENT_ROOT]/website_mvc/helpers/format.php");
class category
{
    private $db;
    private $fm;

    public function __construct()
    {
        $this->db = new Database();
        $this->fm = new Format();
    }
    public function insert_category($catName)
    {
        $catName = $this->fm->validation($catName);
        $catName = mysqli_real_escape_string($this->db->link, $catName);
        $result = $this->check_catename($catName);
        $result1 = $result->fetch_assoc();


        if (empty($catName)) {
            $alert = "<span class='error'> Category must be not empty</span>";
            return $alert;
        } else {

            if ($result1['count'] > 0) {
                $alert = "<span class='error'>Đã tồn tại cartName</span>";
                return $alert;
            } else {
                $query = "Insert into tbl_category(catName) values('$catName')";
                $result = $this->db->insert($query);
                if ($result) {
                    $alert = "<span class='success'>Insert Category successfully</span>";
                    return $alert;
                } else {
                    $alert = "<span class='error'>Insert Category not successfully</span>";
                    return $alert;
                }
            }
        }
    }
    public function show_category()
    {
        $query = "select * from tbl_category order by catId desc";
        $result = $this->db->select($query);
        return $result;
    }
    public function update_category($catName, $id)
    {

        $catName = $this->fm->validation($catName);
        $catName = mysqli_real_escape_string($this->db->link, $catName);
        $id = mysqli_real_escape_string($this->db->link, $id);
        $result = $this->check_catename($catName);
        $result1 = $result->fetch_assoc();

        if (empty($catName)) {
            $alert = "<span class='error'> Category must be not empty</span>";
            return $alert;
        } else {
            if ($result1['count'] > 0) {
                $alert = "<span class='error'>Đã tồn tại cartName</span>";
                return $alert;
            } else {
                $query = "UPDATE tbl_category SET catName ='$catName' where catId ='$id'";
                $result = $this->db->update($query);
                if ($result) {
                    $alert = "<span class='success'>Insert Category Update successfully</span>";
                    return $alert;
                } else {
                    $alert = "<span class='error'>Insert Category not successfully</span>";
                    return $alert;
                }
            }
        }
    }
    public function getcatbyId($id)
    {
        $query = "select * from tbl_category where catid='$id'";
        $result = $this->db->select($query);
        return $result;
    }
    public function del_category($id)
    {
        $query = "delete  from tbl_category where catid='$id'";
        $result = $this->db->delete($query);
        if ($result) {
            $alert = "<span class='success'>Delete Category successfully</span>";
            return $alert;
        } else {
            $alert = "<span class='error'>Delete Category not successfully</span>";
            return $alert;
        }
    }
    public function check_catename($catName)
    {
        $catName = $this->fm->validation($catName);
        $catName = mysqli_real_escape_string($this->db->link, $catName);
        $query = "SELECT count(*)  AS count FROM `tbl_category` WHERE catName='$catName'";
        $result = $this->db->select($query);
        return $result;
    }
    public function show_category_frontend()
    {
        $query = "select * from tbl_category order by catId desc";
        $result = $this->db->select($query);
        return $result;
    }
    public function get_product_by_cat($id){
        $query = "select * from tbl_product where catId='$id' order by catId desc limit 8";
        $result = $this->db->select($query);
        return $result;
    }
    public function get_name_by_cat($id){
        $query = "select   tbl_product.*,tbl_category.catName,tbl_category.catId from tbl_product,tbl_category
        where tbl_product.catId=tbl_category.catId and tbl_product.catId='$id' limit 1";
        $result = $this->db->select($query);
        return $result;

    }
}
    
