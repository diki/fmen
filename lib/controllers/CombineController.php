<?php 

    $app->get('/combines/:type', function ($type) use ($app){
        echo $type;
    });

    $app->get('/server/combines/manage', function () use ($app){
        if(isset($_SESSION['username']) && $_SESSION['username']){
            //echo "npooooooooooooooooooooooooooo";
            //echo "posting";
            //$app->redirect(HTTP_URL);
            $title = "Yeni kombin ekleyin";
            $bodyTitle = "Yeni kombin ekle";
            
            $view = $app -> view();
            $view -> setData(array('title' => $title));
            
            $app->render('addNewCombine.php');
        } else {
            $app->redirect(HTTP_URL);
        }
    });

    $app->post('/server/combines/add', function () use ($app){
        if(isset($_SESSION['username']) && $_SESSION['username']){
            $req = $app->request();
            $response = $app->response();
            $response['Content-Type'] = 'application/json';

            $imgID = $req->params("imgID");
            $name = $req->params("name");
            $notes = $req->params("notes");
            $sex = $req->params("sex");
            $category = $req->params("category");

            //echo randString(8);
            $newCombineID = randString(8);
            $newCombine = array(
                "id" => $newCombineID,
                "imgId" => $imgID,
                "name" => $name,
                "note" => $notes,
                "sex" => $sex,
                "category" => $category
            );

            $res = DB::insert("combines", $newCombine, true);

            if($res->success){
                echo json_encode(array('success'=>true, 'id'=>$newCombineID));
            }
            //var_dump($res);
        } else {
            $app->redirect(HTTP_URL);
        }
    });

    // $app->post('server/combines/add', function () use ($app){

    //     if(isset($_SESSION['username']) && $_SESSION['username']){
    //         //echo "npooooooooooooooooooooooooooo";
    //         //echo "posting";
    //         $app->redirect(HTTP_URL);
    //     } else {
    //         $app->redirect(HTTP_URL);
    //     }

    // });    

?>