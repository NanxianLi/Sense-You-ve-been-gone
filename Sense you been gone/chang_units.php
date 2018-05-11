<?php

function change_temp ($temp){
  if($_SESSION['temp_unit']=='F'){
    $f_temp=(($temp*9)/5)+32;
    return $f_temp;
  }
  else{return $temp;}
}

function change_bar ($bar){
  if($_SESSION['bar_unit']=='kPa'){
    $pa_bar=$bar*3.38639;
    return $pa_bar;
    }
    else{return $bar;}
}

?>
