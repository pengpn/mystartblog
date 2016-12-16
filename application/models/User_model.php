<?php
/**
 * Created by PhpStorm.
 * User: pnpeng
 * Date: 2016/12/16
 * Time: 10:49
 */
class User_model extends CI_Model{
    public function checkUserByUsername($username){
        if($username != null){
            $query = $this->db->get_where('user',array('username'=>$username));
            $row = $query->row_array();
            if(isset($row)){
                return $row;
            }
            return false;
        }
        return false;
    }
}