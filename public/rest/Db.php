<?php

 class Db 
{
    private static $db = null;
    private static function connect()
    {
        if(self::$db === null)
        {
            try 
            {
                $dsn = "mysql:host=localhost;port=3306;dbname=db_school";
                $user ="root";
                $pwd = "";
                self::$db = new PDO($dsn,$user,$pwd,array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8", PDO::ATTR_PERSISTENT => true));

            } 
            catch (PDOException $e) 
            {
                
                echo json_encode($e);
            }
        }
        return self::$db;
    }

    public static function query($sql, $params)
    {
        try 
        {

            $stmt = self::connect()->prepare($sql);
            $stmt->execute($params);
            return $stmt;

        } catch (PDOException $e) 
        {

            return [$e,$stmt->debugDumpParams()];
        
        }
    }


    // $where est un array à deux dimensions de format :
    //     ["field_name"=> [ "=","MonsieurTest"],"field_name"=> [ "=", "MonsieurTest"] ]...

    public static function select($table, $id = null, $where = null, $order = null )
    {
        $db_id_field = "Id_".$table;
        $sql = "SELECT * FROM $table WHERE $db_id_field ";
        $params = [];
        if ($table == null || !is_string($table)) 
        {
            echo json_encode('false : no table given');
            return false;
        }

        if($id>0)
        {
            $sql.= " = ? ";
            $params[] = $id;
        }

        if ($where !== null && is_array($where)) 
        {
            foreach($where as $key => $value)
            {
                $sql.= " AND $key ".$value[0]." ? ";
                $params[] = $value[1];
            }
        }

        if(is_string($order))
        {
            $sql .= " ORDER BY $order ";
        }

        $res = self::query($sql, $params);
        return $res;
        
    }

    public static function insert($table, $values)
    {
        $sql = "INSERT INTO $table ";
        if(is_array($values))
        {

            $fields_part = "(";
            $value_part = "(";
            $params = [];

            foreach($values as $key => $value)
            {
                $fields_part.= " $key ,";
                $value_part.= " ? ,";
                if(is_bool($value)===true)
                {
                    $value === true ? $value = 1 : $value = 0;
                }
                $params[] = $value;
            }

            $fields_part = trim($fields_part, ',');
            $value_part = trim($value_part, ',');
            $fields_part.= ")";
            $value_part .= ")";

            $sql.= $fields_part . " VALUES ". $value_part;
            $res = self::query($sql, $params);
            return (int) self::$db->lastInsertId();
        }
        else
        {
            return "false not array in Db.php";
        }

    }

    public static function update($table, $id, $fields)
    {
        $db_id_field = "Id_".$table;
        $sql = " UPDATE $table SET ";

        $params= [];

        foreach ($fields as $key => $value) 
        {
            $sql.= " $key = ? ,";
            if($value === false)
            {
                $params[] = 0;
            }
            elseif($value === true)
            {
                $params[] = 1;
            }
            else
            {
                $params[] = $value;

            }
        }
        $sql = trim($sql, ',');
        $sql.= " WHERE $db_id_field = ?";
        $params[] = $id;
        $res = self::query($sql, $params);
        return $res->rowCount();
    }

    public static function delete($table, $id)
    {
        $db_id_field = "Id_".$table;
        $sql = "DELETE FROM $table WHERE $db_id_field = ?";
        $params = [$id];
        return self::query($sql, $params)->rowCount();
    }
}