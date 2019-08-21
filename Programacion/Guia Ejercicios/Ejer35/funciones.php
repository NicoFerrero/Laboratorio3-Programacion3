<?php
       
       echo '<span><b>Valor de viaje:</b></span><br>';
       
            switch($_POST["opcion"]){
                case 1:
                    echo "$900";
                break;
                case 2:
                    echo "$550";
                break;
                case 3:
                    echo "$1000";
                break;
                case 4:
                    echo "$1250";
                break;
                case 5:
                    echo "$1500";
                break;
            }
        
        
    ?>