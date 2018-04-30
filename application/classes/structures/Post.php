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
    private $id;
    /**
     * @var string title
     */
    private $title;
    /**
     * @var int image_id
     */
    private $thumbnail;
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
     * @var string text
     */
    private $text;

    public function __construct($id = NULL, $title = NULL, $thumbnail = NULL, $date_written = NULL, $date_changed = NULL, $author = NULL, $keywords = array(), $text = NULL)
    {
        $this->id = $id;
        $this->title = $title;
        $this->text = $text;
        $this->thumbnail = $thumbnail;
        $this->author = $author;
        $this->date_written = $date_written;
        $this->date_changed = $date_changed;

        $this->keywords = $keywords;
    }

    public function toArray(){
        return array(
            'id' =>  $this->id,
            'text' =>  $this->text,
            'title' =>  $this->title,
            'thumbnail' =>  $this->thumbnail,
            'author' =>  $this->author,
            'date_written' =>  $this->date_written,
            'date_changed' =>  $this->date_changed,

            'keywords' =>  $this->keywords,
        );
    }

    /**
     * @return number
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return number
     */
    public function getThumbnail()
    {
        return $this->thumbnail;
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
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }
}