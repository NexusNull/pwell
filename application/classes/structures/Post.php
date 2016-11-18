<?php

/**
 * Created by PhpStorm.
 * User: patric
 * Date: 11/16/16
 * Time: 9:24 PM
 */
class Post
{
    /**
     * @var int post_id
     */
    private $post_id;
    /**
     * @var int image_id
     */
    private $image_id;
    /**
     * @var string teaser
     */
    private $teaser;
    /**
     * @var string date_written YYYY-MM-DD HH:MM:SS
     */
    private $date_written;
    /**
     * @var string date_changed YYYY-MM-DD HH:MM:SS
     */
    private $date_changed;
    /**
     * @var string author
     */
    private $author;
    /**
     * @var array keywords
     */
    private $keywords;
    /**
     * @var array sections
     */
    private $sections;
    /**
     * @var string text
     */
    private $text;

    public function __construct($id, $image_id, $teaser, $date_written, $date_changed, $author, $keywords, $sections, $text)
    {

        $this->text = $text;
        $this->post_id = $id;
        $this->image_id = $image_id;
        $this->teaser = $teaser;
        $this->date_written = $date_written;
        $this->date_changed = $date_changed;
        $this->author = $author;

        $this->keywords = $keywords;
        $this->sections = $sections;
    }

    /**
     * @return number
     */
    public function getPostId()
    {
        return $this->post_id;
    }

    /**
     * @return number
     */
    public function getImageId()
    {
        return $this->image_id;
    }

    /**
     * @return string
     */
    public function getTeaser()
    {
        return $this->teaser;
    }

    /**
     * @return int
     */
    public function getDateWritten()
    {
        return $this->date_written;
    }

    /**
     * @return int
     */
    public function getDateChanged()
    {
        return $this->date_changed;
    }

    /**
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @return array
     */
    public function getKeywords()
    {
        return $this->keywords;
    }

    /**
     * @return array
     */
    public function getSections()
    {
        return $this->sections;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }


}