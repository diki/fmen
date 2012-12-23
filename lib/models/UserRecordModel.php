<?php

class UserList 
{

    static function read($recordId) {
        $res = DB::read("SELECT * FROM user_record WHERE id=':recordId'", $recordId);
        $result = array();
        foreach($res->result as $line){
            # add to the list
            $result[] = $line;
        }

        return $result;
    }

    static function create($src, $folder="not_assigned", $width=0, $height=0){

        /*
            create id here that is why we need a global id generator here which is implemented on init.php
         */
        $id = randString(12);

        /*
            also checking username is done at controller at this point so i am sure that there is username
            TODO: double check here maybe
         */
        $owner = $_SESSION['username'];

        $created_at = date("Y-m-d H:i:s");
        $newRecord = array(
            "id" => $id,
            "owner" =>  $owner,
            "created_at" => $created_at,
            "type"=> "record",
            "folder" => $folder,
            "src" => $src,
            "width" => $width,
            "height" => $height
        );

        $res = DB::insert("user_record", $newRecord, true);

        if($res->success){
            echo json_encode(array('success'=>true, 'id'=>$id));
        }
    }

    static function readRecordsOfUser($username) {
        $res = DB::read("SELECT * FROM user_record WHERE owner=':username'", $username);
        $result = array();
        foreach($res->result as $line){
            # add to the list
            $result[] = $line;
        }

        return $result;        
    }

}

?>