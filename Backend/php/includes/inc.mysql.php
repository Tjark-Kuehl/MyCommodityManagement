<?php

$GLOBALS['mysqlconnection'] = new mysqli($dbhost, $dbusername, $dbpassword, $dbdbname);
if (mysqli_connect_errno()) {
    printf("Datenbankverbindung fehlgeschlagen: %s\n", mysqli_connect_error());
    exit();
}
$GLOBALS['mysqlconnection']->set_charset("utf8");

class db
{
    static function get_row($sql)
    {
        $result = $GLOBALS['mysqlconnection']->query($sql);
        if ($result) {
            $ret_array = $result->fetch_assoc();
            return $ret_array;
        } else
            return false;
    }

    static function get_rows($sql)
    {
        $result = $GLOBALS['mysqlconnection']->query($sql);
        if ($result) {
            $ret_array = array();
            while ($row = $result->fetch_assoc())
                $ret_array[] = $row;
            return $ret_array;
        } else
            return false;
    }

    static function get_object($sql)
    {
        $result = $GLOBALS['mysqlconnection']->query($sql);
        if ($result)
            return $result->fetch_object();
        else
            return false;
    }

    static function get_objects($sql)
    {
        $result = $GLOBALS['mysqlconnection']->query($sql);
        $ret = array();
        if ($result) {
            while ($row = $result->fetch_object())
                $ret[] = $row;
            return $ret;
        } else
            return false;
    }

    static function execute($sql, $retval = "rows")
    {
        $result = $GLOBALS['mysqlconnection']->query($sql);
        if ($result)
            if ($retval == "rows") return $GLOBALS['mysqlconnection']->affected_rows;
            else return $GLOBALS['mysqlconnection']->insert_id;
        else
            return false;
    }

    static function res($String, $AutoKonvertToUTF = true)
    {

        if ($AutoKonvertToUTF && $String !== mb_convert_encoding(mb_convert_encoding($String, "UTF-32", "UTF-8"), "UTF-8", "UTF-32"))
            return $GLOBALS['mysqlconnection']->real_escape_string(utf8_encode($String));
        else
            return $GLOBALS['mysqlconnection']->real_escape_string($String);
    }

    static function close()
    {
        return $GLOBALS['mysqlconnection']->close();
    }
}
