<?php

  function fetchAssoc($res) {
    while( $r = mysqli_fetch_assoc($res)){
      $assoc[] = $r;
    }
    return($assoc);
  }

  function sql2array($conn, $sql){
    $res = mysqli_query($conn, $sql);
    while( $r = mysqli_fetch_array($res, MYSQLI_NUM)){
      $array[] = $r;
    }
    return($array);
  }

?>
