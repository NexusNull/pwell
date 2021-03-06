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
        if ($id === NULL || !is_numeric($id))
            return NULL;
        $post = NULL;

        $sqlPost = "SELECT * FROM posts WHERE posts.id = ? LIMIT 1";
        $sqlKeywords = "SELECT keyword FROM mapPostKeyword LEFT JOIN keywords ON mapPostKeyword.keywordId = keywords.id WHERE mapPostKeyword.postId = ?";
        $sqlHeadings = "SELECT name FROM headings WHERE headings.postId = ? ORDER BY position";

        $queryPost = $this->db->query($sqlPost, array($id));

        if ($queryPost->num_rows() > 0) {
            $row = $queryPost->result_array()[0];
            $queryKeywords = $this->db->query($sqlKeywords, array($id));
            $keywords = [];
            if ($queryPost->num_rows() > 0) {
                foreach ($queryKeywords->result_array() as $keyword) {
                    $keywords[] = $keyword['keyword'];
                }
            }

            $queryHeadings = $this->db->query($sqlHeadings, array($id));
            $headings = [];
            if ($queryHeadings->num_rows() > 0) {
                foreach ($queryHeadings->result_array() as $headingRow) {
                    array_push($headings,$headingRow['name']);
                }
            }


            $post = new Post(
                $row['id'],
                $row['title'],
                $row['thumbnail'],
                $row['date_written'],
                $row['date_changed'],
                $row['author'],
                $headings,
                $keywords,
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

    /**
     * @param int $max
     * @return array
     */
    public function getLastPosts($max = 40)
    {
        $max = max(min($max, 40), 1);

        $posts = array();
        $result = NULL;
        $sqlPost = "SELECT * FROM posts ORDER BY date_written DESC LIMIT ?";
        $sqlKeywords = "SELECT keyword FROM mapPostKeyword LEFT JOIN keywords ON mapPostKeyword.keywordId = keywords.id WHERE mapPostKeyword.postId = ?";
        $queryPost = $this->db->query($sqlPost, array($max));
        if ($queryPost->num_rows() > 0) {
            $result = $queryPost->result_array();

            foreach ($result as $key => $row) {

                $queryKeywords = $this->db->query($sqlKeywords, array($row['id']));
                $keywords = [];
                if ($queryPost->num_rows() > 0) {

                    foreach ($queryKeywords->result_array() as $keyword) {
                        $keywords[] = $keyword['keyword'];
                    }
                }

                $posts[] = new Post(
                    $row['id'],
                    $row['title'],
                    $row['thumbnail'],
                    $row['date_written'],
                    $row['date_changed'],
                    $row['author'],
                    $row['headings'],
                    $keywords,
                    $row['text']);
            }
        }
        return $posts;
    }

    public function updatePost($id = NULL, $text = "", $title = "", $thumbnail = "none", $keywords = [])
    {

        $sqlDelete = "DELETE FROM `pwell`.`headings` WHERE `headings`.`postId` = ?;";
        if ($id != NULL) {
            $this->db->query($sqlDelete, array($id));
        }


        $doc = new DOMDocument();
        libxml_use_internal_errors(1);
        $doc->loadHTML($text);
        $headings = $doc->getElementsByTagName("h2");
        $i =0;
        $sqlInsert = "INSERT INTO `pwell`.`headings`(`postId`, `position`, `name`) VALUES ";
        $value = [];

        foreach($headings as $key => $heading){
            $sqlInsert .= "(?,?,?),";
            $heading->setAttribute("id", "p".$id."_".$i);
            array_push($value, $id, $i, $heading->nodeValue);
            $i++;
        }

        if(count($value) > 0) {
            $sqlInsert = rtrim($sqlInsert, ",");
            $this->db->query($sqlInsert, $value);
            $text = str_replace( array('<html>', '</html>', '<body>', '</body>'), array('', '', '', ''), $doc->saveHTML());
            $text =  preg_replace('/^<!DOCTYPE.+?>/', '', $text);
            $text = preg_replace('/(\r\n|\n|\r)/', "", $text);
        }

        //Title
        $title = ucfirst($title);


        $date = date("Y-m-d");
        $sql = "UPDATE posts SET title=?,text=?,thumbnail=?, date_changed=? WHERE id = ?";
        if ($id != NULL) {
            $this->db->query($sql, array($title, $text, $thumbnail, $date, $id));
        }
    }

    public function createPost()
    {
        $date = date("Y-m-d");

        $sqlInsert = "INSERT INTO `posts`(`title`, `text`, `thumbnail`, `author`, `date_written`, `date_changed`) VALUES (?,?,?,?,?,?);";
        $sqlLastId = "SELECT LAST_INSERT_ID() AS lastID;";

        $query = $this->db->query($sqlInsert, array("", "", "none", "", $date, $date));
        $queryId = $this->db->query($sqlLastId, array());

        $postId = $queryId->result_array()[0]['lastID'];

        return $this->getPost($postId);
    }

    public function deletePost($id = NULL)
    {
        if ($id != NULL && is_numeric($id)) {

            $sqlDelete = "DELETE FROM `pwell`.`posts` WHERE `posts`.`id` = ?;";

            $query = $this->db->query($sqlDelete, array($id));

            return $query;
        }
        return false;
    }

    private function keywordParse($text = NULL){
        if($text ==  NULL)
            return [];
        $keywords = [];







    }

}