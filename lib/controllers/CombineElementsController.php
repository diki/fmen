<?php

    $app->post('/server/celements/manage/:operation', function ($operation) use ($app){

        //echo json_encode(array('success'=>true, 'op'=>$operation));
        
        $req = $app->request();

        switch ($operation) {
            case 'create':
                # code...
                $newElement = json_decode($req->params('model'), true);

                $newID = randString(8);
                $newElement['id'] = $newID;

                //var_dump($newElement);
                $res = DB::insert("elements", $newElement, true);

                if($res->success){
                    echo json_encode(array('success'=>true, 'id'=>$newID));
                }
                
                break;
            
            default:
                # code...
                break;
        }

    });

?>