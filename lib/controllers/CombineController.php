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
            $creation_date = date("Y-m-d H:i:s");

            var_dump($imgID);

            //echo randString(8);
            $newCombineID = randString(8);
            $newCombine = array(
                "id" => $newCombineID,
                "imgId" => $imgID,
                "name" => $name,
                "note" => $notes,
                "sex" => $sex,
                "category" => $category,
                "creation_date" => $creation_date
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

    $app->post('/server/combines/read', function () use ($app){
        $req = $app->request();
        $response = $app->response();
        $response['Content-Type'] = 'application/json';

        $sex = $req->params("sex");
        $category = $req->params("category");
        $startDate = $req->params("startDate");
        $endDate = $req->params("endDate");
        $offset = $req->params("offset");
        $limit = $req->params("limit");

        
        $query = 'SELECT * FROM combines';

        //sex is mandatory field here idont know why easier i guess
        $filter = ' WHERE sex="'. $sex . '"';

        if($category!=="0") { $filter = $filter . ' AND category="' . $category . '"'; }

        //to get total
        $total = DB::read('SELECT count(*) FROM combines' . $filter);
        $totalValue = $total->first["count(*)"];

        //order by creation date
        $query .= $filter;
        $query .= " ORDER BY creation_date DESC";
        $query = $query . ' LIMIT ' . $limit . ' OFFSET '.$offset;
        $res = DB::read($query);
        
        $combines = array();
        foreach($res->result as $line){
            # add to the list
            $combines[] = $line;
        }
        $response->body(json_encode(array('success'=>true, 'data'=>$combines, 'total'=>$totalValue)));
        //exit; 
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