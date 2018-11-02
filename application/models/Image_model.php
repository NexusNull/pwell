<?php

/**
 * Created by PhpStorm.
 * User: patric
 * Date: 11/16/16
 * Time: 9:09 PM
 */
class Image_model extends CI_Model
{
    const IMAGE_NOT_INITIALISED = 0;
    const IMAGE_NOT_AN_IMAGE = 1;
    const IMAGE_MISSING_CAPTION = 2;
    const IMAGE_FILE_TO_BIG = 3;
    const IMAGE_UNSUPPORTED_FILE_TYPE = 4;


    private $valid = false;
    private $error = 0;
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function createImage($file = NULL, $user = NULL,  $caption = ""){
        if($file){
            $targetDir = "./uploads/original/";
            $imageFileType = strtolower(pathinfo(basename($file["name"]),PATHINFO_EXTENSION));
            $uploadOk = 1;
            $this->valid = true;
            $imageSize = getimagesize($file["tmp_name"]);

            if(!$imageSize) {
                $this->valid = false;
                (new Response("failure", "File is not an image"))->output(Response::HTTP_BAD_REQUEST);
            }

            if ($file["size"] > 50 * 1024 * 1024) {
                (new Response("failure", "Missing perm_create_post permission"))->output(Response::HTTP_REQUEST_ENTITY_TOO_LARGE);
            }

            if(!in_array($imageFileType, ["jpg", "png", "gif", "jpeg"])) {
                (new Response("failure", "Missing perm_create_post permission"))->output(Response::HTTP_UNSUPPORTED_MEDIA_TYPE);
            }

            if($uploadOk){
                $tries = 0;
                do{
                    $file_name = md5(uniqid(rand(), true)).".".$imageFileType;
                    $tries++;
                } while(($tries < 5 && file_exists($targetDir.$file_name)));
                if(!move_uploaded_file($file["tmp_name"], $targetDir.$file_name)){
                    (new Response("failure", "Action requires login"))->output(Response::HTTP_INTERNAL_SERVER_ERROR);
                } else {
                    $date = date("Y-m-d");
                    $sql = "INSERT INTO images (name, size_x, size_y, file_type, file_size, file_name, uploader_id, upload_date) VALUES (?,?,?,?,?,?,?,?)";
                    $userId = ($user->getId())?$user->getId():0;
                    $name = preg_replace('/\\.[^.\\s]{3,4}$/', '', $file["name"]);
                    $this->db->query($sql, array($name, $imageSize[0], $imageSize[1], $imageFileType, $file["size"], $file_name, $userId, $date));
                    $this->cloneImage($file_name);
                }
    }
        }

    }
    public function deleteImage($id = NULL){
        $targetDir = "./uploads/original/";
        if(is_numeric($id)){

            $sql = "SELECT file_name FROM images WHERE id = ?";
            $query = $this->db->query($sql, array($id));
            $fileName = $query->result_array()[0]["file_name"];
            if($fileName && file_exists($targetDir.$fileName)){
                $delete = unlink($targetDir.$fileName);
                //return stuff
            }

            $sqlDelete = "DELETE FROM images WHERE id = ?";
            $this->db->query($sqlDelete, array($id));
            if($this->db->affected_rows() == 1){
                //return stuff
            }
        }
    }

    public function getImagesById($id = NULL){
        if($id == NULL)
            return NULL;
        else {
            $sql = "SELECT * FROM images WHERE id = ?";
            $query = $this->db->query($sql, array($id));
            if($query->num_rows() == 1){
                return $query->result_array()[0];
            }
        }
        return NULL;
    }

    public function getImagesByName($name = NULL){
        if(strlen($name) > 255){
            return NULL;
        } else {
            $sql = "SELECT id, name, file_name FROM images WHERE name LIKE ? ORDER BY CHAR_LENGTH(name) LIMIT ?;";
            $query = $this->db->query($sql, array("%".$name."%", 18));
            if($query->num_rows() > 0){
                $result = [];
                for($i=0;$i<$query->num_rows();$i++){
                    $result[$i] = array(
                        "id" => $query->result_array()[$i]["id"],
                        "name" => $query->result_array()[$i]["name"],
                        "filename" => $query->result_array()[$i]["file_name"],
                    );
                }
                return $result;
            }
        }
        return NULL;
    }

    public function editCaption($id, $caption = ""){
        if(isset($id)){
            $sql = "UPDATE images SET caption = ? WHERE id = ?";
            $this->db->query($sql, array ($caption, $id));
            if($this->db->affected_rows() == 1){
                //return stuff
            }
        }
    }

    private function cloneImage($fileName){
        $this->resizeImage("./uploads/original/".$fileName,"./uploads/big/".$fileName, 1024, 768);
        $this->resizeImage("./uploads/original/".$fileName,"./uploads/small/".$fileName, 1024/2, 768/2);
    }

    private function resizeImage($sourceFileName, $targetFileName, $sizeMaxX, $sizeMaxY){
        if(function_exists("gd_info")){
            $ext = $imageFileType = strtolower(pathinfo(basename($sourceFileName),PATHINFO_EXTENSION));

            switch($ext){
                case "png":
                    $sourceFile = imagecreatefrompng($sourceFileName);
                    break;
                case "jpeg":
                case "jpg":
                    $sourceFile = imagecreatefromjpeg($sourceFileName);
                    break;
                case "gif":
                    $sourceFile = imagecreatefromgif($sourceFileName);
                    break;
                default:
                    $sourceFile = NULL;
                    break;
            }
            if($sourceFile == NULL){
                throw Exception("FIX IT!!!");
            }
            $size = getimagesize($sourceFileName);
            $currentRatio = $size[0]/$size[1];
            $targetRatio = $sizeMaxX/$sizeMaxY;
            $targetSize = array(
                "x"=> 0,
                "y"=> 0
            );

            if($currentRatio > $targetRatio){
                $targetSize["x"] = $sizeMaxX;
                $targetSize["y"] = $sizeMaxX/$currentRatio;
            } else {
                $targetSize["x"] = $sizeMaxY*$currentRatio;
                $targetSize["y"] = $sizeMaxY;
            }

            $targetFile = imagecreatetruecolor($targetSize["x"], $targetSize["y"]);
            imagecopyresized($targetFile, $sourceFile, 0, 0, 0, 0, $targetSize["x"], $targetSize["y"], $size[0], $size[1]);
            switch($ext){
                case "png":
                    imagepng($targetFile, $targetFileName,0);
                    break;
                case "jpg":
                    imagejpeg($targetFile, $targetFileName,0);
                    break;
                case "gif":
                    imagegif($targetFile, $targetFileName);
                    break;
                default:
                    $sourceFile = NULL;
                    break;
            }
        }
    }

    public function valid(){
        return $this->valid;
    }
}