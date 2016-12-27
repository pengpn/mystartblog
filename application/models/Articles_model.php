<?php
/**
 * Created by PhpStorm.
 * User: pnpeng
 * Date: 2016/12/20
 * Time: 17:04
 */
class Articles_model extends CI_Model
{
    public function getArticlesDuring($offset, $perpage)
    {
        $sql = "select * from articles order by published_at desc limit $offset,$perpage";
        $data = $this->db->query($sql)->result_array();
        return $data;
    }

    public function getArticle($id)
    {
        $query = $this->db->get_where('articles',array('id'=>$id));
        $data = $query->result_array();
        return $data;
    }

    public function delArticle($id)
    {
        $this->db->where('id',$id);
        $this->db->delete('articles');
    }

    public function getArticlesTag($tag_id)
    {
        $sql="select c.id, c.title,c.published_at,c.category, c.tag, a.id as tag_id, a.tag_name, a.tag_button_type from tag as a join article_tag as b on b.tag_id=a.id join articles as c on c.id=b.article_id where a.id='{$tag_id}'";
        $data = $this->db->query($sql)->result_array();
        return $data;
    }
}