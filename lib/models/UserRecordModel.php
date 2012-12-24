<?php

class UserRecord
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

    static function create($recordModel){


        //do not create if img source already exist
        // $recRes = DB::read('SELECT * from user_record WHERE imageUrl="'.$recordModel['imgUrl']. '"');
        // return $recRes;
        /*
            create id here that is why we need a global id generator here which is implemented on init.php
         */
        $id = randString(12);

        /*
            also checking username is done at controller at this point so i am sure that there is username
            TODO: double check here maybe
         */
        $owner = $_SESSION['username'];

        $md5 = md5($recordModel["imgUrl"]);
        // $recRes = DB::read('SELECT * from user_record WHERE md5="'.$md5. '"');
        
        // return $md5;

        $created_at = date("Y-m-d H:i:s");
        $newRecord = array(
            "id" => $id,
            "owner" =>  $owner,
            "created_at" => $created_at,
            "type"=> $recordModel["type"],
            "folder" => $recordModel["folder"],
            "sourceUrl" => $recordModel["srcUrl"],
            "imageUrl" => $recordModel["imgUrl"],
            "note" => $recordModel["note"],
            "md5" => $md5,
            "price" => $recordModel["price"]
        );

        $res = DB::insert("user_record", $newRecord, true);

        if($res->success){
            return $newRecord;
        } else {
            return false;
        }
        // if($res->success){
        //     echo json_encode(array('success'=>true, 'id'=>$id));
        // }
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