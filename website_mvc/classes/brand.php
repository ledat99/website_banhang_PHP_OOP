<?php
// include '../lib/session.php';
$filepath = realpath(dirname(__FILE__));
include_once ($filepath.'/../lib/database.php');
include_once ($filepath.'/../helpers/format.php');


class brand
{
    private $db;
    private $fm;

    public function __construct()
    {
        $this->db = new Database();
        $this->fm = new Format();
    }
    public function insert_brand($brandName)
    {
        $brandName = $this->fm->validation($brandName);
        $brandName = mysqli_real_escape_string($this->db->link, $brandName);
        $result = $this->check_brandname($brandName);
        $result1 = $result->fetch_assoc();


        if (empty($brandName)) {
            $alert = "<span class='error'>Brand must be not empty</span>";
            return $alert;
        } else {

            if ($result1['count'] > 0) {
                $alert = "<span class='error'>Đã tồn tại brandName</span>";
                return $alert;
            } else {
                $query = "Insert into tbl_brand(brandName) values('$brandName')";
                $result = $this->db->insert($query);
                if ($result) {
                    $alert = "<span class='success'>Insert Brand successfully</span>";
                    return $alert;
                } else {
                    $alert = "<span class='error'>Insert Brand not successfully</span>";
                    return $alert;
                }
            }
        }
    }
    public function show_brand()
    {
        $query = "select * from tbl_brand order by brandId desc";
        $result = $this->db->select($query);
        return $result;
    }
    public function update_brand($brandName, $id)
    {

        $brandName = $this->fm->validation($brandName);
        $brandName = mysqli_real_escape_string($this->db->link, $brandName);
        $id = mysqli_real_escape_string($this->db->link, $id);
        $result = $this->check_brandname($brandName);
        $result1 = $result->fetch_assoc();

        if (empty($brandName)) {
            $alert = "<span class='error'> Brand must be not empty</span>";
            return $alert;
        } else {
            if ($result1['count'] > 0) {
                $alert = "<span class='error'>Đã tồn tại brandName</span>";
                return $alert;
            } else {
                $query = "UPDATE tbl_brand SET brandName ='$brandName' where brandId ='$id'";
                $result = $this->db->update($query);
                if ($result) {
                    $alert = "<span class='success'> Brand Update successfully</span>";
                    return $alert;
                } else {
                    $alert = "<span class='error'>Brand update not successfully</span>";
                    return $alert;
                }
            }
        }
    }
    public function del_brand($id)
    {
        $query = "delete  from tbl_brand where brandId='$id'";
        $result = $this->db->delete($query);
        if ($result) {
            $alert = "<span class='success'>Delete Brand successfully</span>";
            return $alert;
        } else {
            $alert = "<span class='error'>Delete Brand not successfully</span>";
            return $alert;
        }
    }
    public function getbrandbyId($id)
    {
        $query = "select * from tbl_brand where brandId='$id'";
        $result = $this->db->select($query);
        return $result;
    }
    
    public function check_catename($catName)
    {
        $catName = $this->fm->validation($catName);
        $catName = mysqli_real_escape_string($this->db->link, $catName);
        $query = "SELECT count(*)  AS count FROM `tbl_category` WHERE catName='$catName'";
        $result = $this->db->select($query);
        return $result;
    }
    public function check_brandname($brandName)
    {
        $brandName = $this->fm->validation($brandName);
        $brandName = mysqli_real_escape_string($this->db->link, $brandName);
        $query = "SELECT count(*)  AS count FROM `tbl_brand` WHERE brandName='$brandName'";
        $result = $this->db->select($query);
        return $result;
    }
}
