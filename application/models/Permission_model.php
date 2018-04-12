<?php

/**
 * Created by PhpStorm.
 * User: Nexus
 * Date: 30.09.2017
 * Time: 12:01
 */
class Permission_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model("Users_model", "users");
    }

    public function getPermList(){
        $sql = "SHOW COLUMNS FROM pwell.permissions";
        $permQuery = $this->db->query($sql, array());
        $array = [];
        foreach($permQuery->result_array() as $value){
            if(substr( $value["Field"], 0, 5 ) ==  "perm_"){
                $array[] = $value["Field"];
            }
        }
        return $array;
    }

    public function getUserPermission($id){
        $perm = $this->getPermList();
        $sql = "SELECT ".join(", ", $perm)." FROM pwell.permissions WHERE id = ?";
        $permQuery = $this->db->query($sql, array($id));
        if($permQuery->num_rows() > 0){
            return $permQuery->result_array()[0];
        } else {
            $permNames = $this->getPermList();
            $perms = array();
            foreach($permNames as $value){
                $perms[$value] = 0;
            }
            return $perms;
        }
    }

    public function updatePermissions($perms = [],$id){

        if($this->users->getUserById($id) == NULL)
            return array(
                "success"=>false,
                "error"=>"Wrong user id.",
            );

        $allPerms = $this->getPermList();
        foreach($perms as $key=>$value){
            if(!in_array($key,$allPerms)){
                unset($perms[$key]);
            }
        }

        $data = $perms;
        $data["id"] = $id;

        $result = $this->db->replace('permissions',$data );
        if(!$result){
            return array(
                "success"=>false,
                "error"=> "",
            );
        } else
        return array(
            "success"=>true,
            "error"=>"",
        );
    }

    public function hasPermission($id,$perm){
        $allPerms = $this->getPermList();
        $sql = "SELECT * FROM permissions WHERE id = ? LIMIT 1";
        if(in_array($perm,$allPerms)){
            $query = $this->db->query($sql, array( $id));
            if($query->num_rows() > 0){
                return $query->result_array()[0][$perm] === "1";
            }
        }
        return false;
    }

}