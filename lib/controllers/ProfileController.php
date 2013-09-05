<?php

    $app->get('/profile/:id', function ($id) use ($app){


        if(isset($_SESSION['user']) && $_SESSION['user']['id']==$id){
            $rows = DB::read("SELECT * FROM members WHERE id=':id'", $id);
            if(!empty($rows)){

                $title = "ginkatego kullanıcı kaydı";
                $bodyTitle = "Profilo";
                
                $view = $app -> view();
                $view -> setData(array('title' => $title));
                
                $app->render('profile.php');
            }
        } else {
            $app->redirect(HTTP_URL);
        }

    });

    $app->post('/server/profile/updateImage', function () use ($app){
        $req = $app->request();
        $response = $app->response();

        if(isset($_SESSION['user_id'])){

            $query = 'UPDATE members SET img_id="'.$req->params('src').'" where id="'.$_SESSION['user_id']. '"';
            $res = DB::query($query);

            if($res){
                echo json_encode(array('success'=>true));
                $_SESSION["user"]["img_id"] = $req->params('src');
            } else {
                $response->status(400);
            }
        } else {
            $response->status(401);
        }

    });


?>