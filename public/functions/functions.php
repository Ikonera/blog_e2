<?php

    function get_date(){
        date_default_timezone_set("Europe/Paris");
        $today = getdate();

        $assocDay = array("Monday" => "Lundi", "Tuesday" => "Mardi", "Wednesday" => "Mercredi", "Thursday" => "Jeudi", "Friday" => "Vendredi", "Saturday" => "Samedi", "Sunday" => "Dimanche");
        $assocMonth = array("January" => "Janvier", "February" => "Février", "March" => "Mars", "April" => "Avril", "Mai" => "Mai", "June" => "Juin", "July" => "Juillet", "August" => "Aôut", "September" => "Septembre", "October" => "Octobre", "November" => "Novembre", "December" => "Décembre");

        $englishDay = $today["weekday"];
        $frenchDay = $assocDay[$englishDay];

        $englishMonth = $today["month"];
        $frenchMonth = $assocMonth[$englishMonth];

        $numDay = $today["mday"];

        return $frenchDay." ".$numDay." ".$frenchMonth." ".$today["year"];
    }
