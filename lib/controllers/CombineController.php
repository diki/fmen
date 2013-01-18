<?php 

    $app->get('/combines', function () use ($app){
        
        $req = $app->request();
        $id = $req->params("cid");

        $res = DB::read("SELECT * from combines  WHERE id=':id'", $id);

        if(!empty($res->result)){
            $rows = $res->result;
            $combine = $rows[0];
            $userId = $app->getEncryptedCookie('_gstuk');

            $view = $app -> view();
            if($combine['owner']==$userId){
                $title = "Edit combine";
                $view -> setData(array('title' => $title));
                $app->render('editCombine.php');
            } else {
                $title = "kombin-".$combine['note'];
                $view -> setData(array('title' => $title));
                $app->render('viewCombine.php');
            }
        } else {
            $app->redirect(HTTP_URL);
        }
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
            
            $app->render('createCombine.php');
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

            //echo randString(8);
            $newCombineID = randString(8);
            $newCombine = array(
                "id" => $newCombineID,
                "imgId" => $imgID,
                "name" => $name,
                "note" => $notes,
                "sex" => $sex,
                "category" => $category,
                "creation_date" => $creation_date,
                "owner" => $_SESSION['id']
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

    $app->post('/server/combines/updateElements', function () use ($app){
        if(isset($_SESSION['username']) && $_SESSION['username']){
            $req = $app->request();
            $response = $app->response();
            $response['Content-Type'] = 'application/json';

            $combineId = $req->params("combineId");
            $elements = json_decode($req->params('elements'), true);

            $combines = DB::read("SELECT * from combines  WHERE id=':combineId'", $combineId);

            //if not empty
            if (!empty($combines->result)) {
                //and belongs to this user
                $c = $combines->result;
                $combine = $c[0];

                if($combine['owner']==$_SESSION['id'] && isset($_SESSION['id'])){
                    //first delete all records related to this combine id on combine_elements table
                    $delQuery = "DELETE from combine_elements WHERE combineId='".$combineId."'";
                    DB::query($delQuery);

                    //then insert new elements
                    foreach ($elements as $el) {
                        DB::insert("combine_elements", $el, true);
                    }
                    echo json_encode(array('success'=>true));
                } else {
                    echo json_encode(array('success'=>false));
                }
            } else {
                echo json_encode(array('success'=>false));
            }
                        
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