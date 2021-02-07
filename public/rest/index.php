<?php 


header("Access-Control-Allow-Origin: *");
header('Access-Control-Request-Headers: Content-Type');
header("Content-Type: application/json; charset=UTF-8");
header('Accept: application/json');
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


include_once("Db.php");
    switch ($_SERVER['REQUEST_METHOD']) {

        case 'GET':

            $_get = validate_request($_GET);
            $table = isset($_get['table']) ? $_get['table'] : NULL;
            if ($table == NULL) 
            {
                echo json_encode("false table is NULL in GET index.php");
                break;
            }
    
            $rowid = isset($_get['rowid']) ? $_get['rowid'] : NULL;
            $where = isset($_get['where']) ? $_get['where'] : NULL;
            $order = isset($_get['orderby']) ? $_get['orderby'] : NULL;
    
    
            $res = Db::select($table, $rowid, $where ,$order); 
            echo json_encode($res->fetchAll(5));
            break;
        
        case 'POST':
    
            
            $_post = file_get_contents('php://input');
            $_post = json_decode($_post, true);
            $_post = validate_request($_post);
            $table = isset($_post['table']) ? $_post['table'] : NULL;
            $fields = isset($_post['fields']) ? $_post['fields'] : NULL;
            if($table == NULL)
            {
                echo json_encode("false table is null in POST index.php");
                break;
            }
            $res = Db::insert($table, $fields);
            echo json_encode($res);
            
        break;
        
        case 'PUT' :
    
            
            $_put = file_get_contents('php://input');
            $_put = json_decode($_put, true);
            $_put = validate_request($_put);
            $table = isset($_put['table']) ? $_put['table'] : NULL;
            if($table == NULL)
            {
                echo json_encode("false table is NULL in PUT index.php");
                break;
            }
            $rowid = isset($_put['rowid']) ? $_put['rowid'] : NULL;
            if($rowid == NULL)
            {
                echo json_encode("false rowid is NULL in PUe index.php");
                break;
            }
            $fields = isset($_put['fields']) ? $_put['fields'] : NULL;
    
            if ($fields == NULL)
            {
                echo json_encode($_put);
                break;
    
            }
            $res = Db::update($table,$fields,$rowid);
            echo json_encode($res);
            break;
            
        case 'DELETE' : 
    
            $_del = array(); //tableau qui va contenir les données reçues
            parse_str(file_get_contents('php://input'), $_del);
            $_del = validate_request($_del);
            $table = isset($_del['table']) ? $_del['table'] : NULL;
            if($table == NULL)
            {
                echo json_encode("false table is NULL is DELETE index.php");
                break;
            }
            $rowid = isset($_del['rowid']) ? $_del['rowid'] : NULL;
            if($rowid == NULL)
            {
                echo json_encode("false rowid is NULL in DELETE index.php");
                break;
            }
    
            if($_del['soft'] === "false")
            {
                $res = Db::delete($table,$rowid,false);
                echo json_encode($res);
                break;
            }
    
            $res = Db::delete($table,$rowid);
            echo json_encode($res);
            break;
    
    
    
        default:
            echo json_encode("default shit");
            break;
    
    }





function validate_request($request)
{
    foreach ($request as $k => $v) {

        if(!is_array($v))
        {
            $request[$k] = htmlspecialchars(strip_tags(stripslashes(trim($v))));
        }
        else 
        {
            validate_request($request[$k]);
        }

    }
    return $request;
}

?>