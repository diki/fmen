<?php

class UserList 
{

    static function read($recordId) {
        $res = DB::read("SELECT * FROM user_list WHERE id=':recordId'", $recordId);
        $result = array();
        foreach($res->result as $line){
            # add to the list
            $result[] = $line;
        }

        return $result;
    }

    static function create($listName){

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
        $newList = array(
            "id" => $id,
            "owner" =>  $owner,
            "created_at" => $created_at,
            "name" => $listName
        );

        $res = DB::insert("user_list", $newList, true);

        if($res->success){
            echo json_encode(array('success'=>true, 'id'=>$id));
        }
    }

    static function readListsOfUser($username) {
        $res = DB::read("SELECT * FROM user_list WHERE owner=':username'", $username);
        $result = array();
        foreach($res->result as $line){
            # add to the list
            $result[] = $line;
        }

        return $result;        
    }

}

?>