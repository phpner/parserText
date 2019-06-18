<?php

mb_internal_encoding("UTF-8");

if (isset($_POST['text'])){
    $findre = explode("===========================================",$_POST['text']);
    $sub =  $_POST['sub'];
    $emailCheack = [];

    // var_dump($findre);
    // $arr = file('text.txt');
    // echo "<pre>";

    function finderName($findreData){
        $name='';
        $email='';
        $i = 0;
        $person = [];
        global $emailCheack;
        foreach ($findreData as $value){
            if (mb_stripos($value, 'Имя:', 0) !== false) {
                $name = trim(preg_replace("#^Имя:#",'',$value));
                $nameFound = ($name !==  "") ? $name : false;

                // $person[$i] .= $name;
            }elseif (mb_stripos($value, 'E-mail:', 0) !== false){
                $email = trim(preg_replace("#^E-mail:#",'',$value));
                $checkTheSameEmail = in_array($email,$emailCheack);

                if ($nameFound  && $email !== "" && !$checkTheSameEmail){
                    $person['person'] = $nameFound.",".$email."<br>";
                    $emailCheack[] = $email;
                }

            }
            $i++;
        }

        return $person;
    }
    function finderNameWidthSubOrNo($findreData,$yesOrNo){
        $name='';
        $email='';
        $i = 0;
        $person = [];
        global $emailCheack;
        //  global $emailCheack;
        global $emailCheack;
        foreach ($findreData as $value){
            if (mb_stripos($value, 'Имя:', 0) !== false) {
                $name = trim(preg_replace("#^Имя:#",'',$value));
                $nameFound = $name !==  "" ? $name : false;

                // $person[$i] .= $name;
            }elseif (mb_stripos($value, 'E-mail:', 0) !== false){
                $email = trim(preg_replace("#^E-mail:#",'',$value));
                $checkTheSameEmail = in_array($email,$emailCheack);
            }elseif (mb_stripos($value, 'Согласие на подписку:', 0) !== false){
                $subFiner = trim(preg_replace("#^Согласие на подписку:#",'',$value));
                if ($nameFound  && $email !== "" && mb_strtolower($subFiner) === $yesOrNo && !$checkTheSameEmail){
                    $person['person'] = $nameFound.",".$email." подписка: ".$subFiner."<br>";
                    $emailCheack[] = $email;
                }
            }
            $i++;
        }
        return $person;
    }

    $found = [];
    $resFunc = [];
    foreach ($findre as $v) {

        $findreData = str_replace(array('\r\n', '\r', '\n','\n\n','\n\n\n'), "*--*", $v);
        $findreData = explode("*--*",$findreData);

       // var_dump($findreData);

            if($sub === "sub"){
                $resFunc =  finderNameWidthSubOrNo($findreData,'да');
            }elseif ($sub === "nosub"){
                $resFunc =  finderNameWidthSubOrNo($findreData,'нет');
            }else{
                $resFunc = finderName($findreData);
            }

        if (!empty($resFunc)){
            array_push($found,$resFunc);
        }
    }


    $push = !empty($found) ? ['result' => $found, 'coll' => count($found)] : ['status' => 'no'];

    $emailCheack = [];
    echo json_encode($push, JSON_FORCE_OBJECT);
    die();
}
die();