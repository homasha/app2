<?php

class UniversalConnect
{
    const HOSTNAME = "localhost";
    const USERNAME = "root";
    const PASSWORD = "";
    const DATABASE = "sakila";

    public function doConnect()
    {
        self::$connectInfo = mysqli_connect(self::HOSTNAME, self::USERNAME, self::PASSWORD, self::DATABASE);

//        function __construct() {
//            $this->doConnect();
//        }
//            if (self::$hookup)
//            {
//            	echo "Połączono z bazą danych ".self::$currentDB;
//            }
//            elseif (mysqli_connect_error(self::$hookup)) {
//            	echo "Przyczyną błędu połączenia z bazą jest: ".mysqli_connect_error();
//            }
            return self::$connectInfo;
    }
}

?>
