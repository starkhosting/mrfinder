<?php

    try {
        //host
        $host = "localhost";

        //dbname
        $dbname = "id19973346_project_db";

        //user
        $user = "id19973346_tony";

        //pass
        $pass = "^39HoodYEQOd2X~j";


        $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    } catch(PDOException $e) {
        echo $e->getMessage();

    }


    


    // if($conn == true) {
    //     echo "conn works fine";
    // } else {
    //     echo "conn err";
    // }