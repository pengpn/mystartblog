<?php
/**
 * Created by PhpStorm.
 * 友情链接
 * 数据表表friendship
 * User: pnpeng
 * Date: 2016/12/28
 * Time: 10:41
 */
class Friendship_model extends CI_Model
{

    public function getAllFriend()
    {

    }

    public function getFriendshipDuring($offset,$row){
        $sql="select * from friendship order by id DESC limit {$offset},{$row}";
        $data = $this->db->query($sql)->result_array();
        return $data;
    }

    public function getFriendship($id)
    {
        $query = $this->db->get_where('friendship',array('id' => $id));
        $data = $query->result_array();
        return $data;
    }

    public function addFriendship($link,$linkName,$linkOrder)
    {
        $data = array(
            'link' => $link,
            'link_name' => $linkName,
            'link_order' => $linkOrder,
        );
        $this->db->insert('friendship',$data);
    }

    public function editFriendship($link,$linkName,$linkOrder,$id)
    {
        $data = array(
            'link' => $link,
            'link_name' => $linkName,
            'link_order' => $linkOrder,
        );
        $this->db->where('id',$id);
        $this->db->update('friendship',$data);
    }
}