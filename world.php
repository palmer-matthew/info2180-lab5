<?php

  $host = 'localhost';
  $username = 'lab5_user';
  $password = 'password123';
  $dbname = 'world';

  if($_SERVER['REQUEST_METHOD'] == 'GET'){
      $country = filter_var($_GET['country'], FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
      $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
      if($country == ""){
          $stmt = $conn->query("SELECT * FROM countries");
          $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
          $intial = "<ul>";
          $end = "</ul>";
          foreach ($results as $row){
            $intial .= "<li>".$row['name'] . ' is ruled by ' . $row['head_of_state']."</li>";
          }
          $intial .= $end;
          echo $intial;
      }else{
          $stmt = $conn->query("SELECT * FROM countries WHERE name LIKE '%$country%'");
          $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
          $intial = "<ul>";
          $end = "</ul>";
          foreach ($results as $row){
            $intial .= "<li>".$row['name'] . ' is ruled by ' . $row['head_of_state']."</li>";
          }
          $intial .= $end;
          echo $intial;
      }
  }

?>

