<?php

/**
 * Created by PhpStorm.
 * User: patric
 * Date: 11/16/16
 * Time: 9:09 PM
 */
class Posts_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getPost($id = NULL)
    {
        if ($id === NULL)
            return NULL;

        $post = NULL;
        $sql = "SELECT * FROM posts WHERE posts.id = ? LIMIT 1";
        $query = $this->db->query($sql, array($id));
        if ($query->num_rows() > 0) {
            $row = $query->result_array()[0];
            $post = new Post(
                $row['id'],
                $row['title'],
                $row['image_link'],
                $row['teaser'],
                $row['date_written'],
                $row['date_changed'],
                $row['author'],
                json_decode($row['keywords'])->keywords,
                json_decode($row['sections'])->sections,
                $row['text']);
        }
        return $post;
    }

    /**
     * @param int $max
     * @return array  An array filled with post Ids.
     */
    public function getLastPostIds($max = 40)
    {
        $max = max(min($max, 40), 1);

        $result = array();
        $sql = "SELECT id FROM posts ORDER BY date_written DESC LIMIT ?";
        $query = $this->db->query($sql, array($max));
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $value) {
                $result[] = (int)$value['id'];
            }
        }

        return $result;
    }

    public function getLastPosts($max = 40)
    {
        $max = max(min($max, 40), 1);

        $posts = array();
        $result = NULL;
        $sql = "SELECT * FROM posts ORDER BY date_written DESC LIMIT ?";
        $query = $this->db->query($sql, array($max));
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            foreach ($result as $key => $row) {
                $posts[] = new Post(
                    $row['id'],
                    $row['title'],
                    $row['image_link'],
                    $row['teaser'],
                    $row['date_written'],
                    $row['date_changed'],
                    $row['author'],
                    json_decode($row['keywords'])->keywords,
                    json_decode($row['sections'])->sections,
                    $row['text']);
            }
        }

        return $posts;
    }

}