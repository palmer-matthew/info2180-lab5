<?php

  function build_table($results,$context){
    if($context == "country"){
      $intial = <<<STR
      <table>
      <thead>
      <tr>
        <th>Country</th>
        <th>Continent</th>
        <th>Indepedence Year</th>
        <th>Head of State</th>
      </tr>
      </thead>
      <tbody>
      STR;
      $end = "</tbody></table>";
      foreach ($results as $row){
        $current = <<<WRD
        <tr>
          <td>{$row['name']}</td>
          <td>{$row['continent']}</td>
          <td>{$row['independence_year']}</td>
          <td>{$row['head_of_state']}</td>
        </tr>
        WRD;
        $intial .= $current;
      }
      $intial .= $end;
    }else{
      $intial = <<<STR
      <table>
      <thead>
      <tr>
        <th>Name</th>
        <th>District</th>
        <th>Population</th>
      </tr>
      </thead>
      <tbody>
      STR;
      $end = "</tbody></table>";
      foreach ($results as $row){
        $current = <<<WRD
        <tr>
          <td>{$row['name']}</td>
          <td>{$row['district']}</td>
          <td>{$row['population']}</td>
        </tr>
        WRD;
        $intial .= $current;
      }
      $intial .= $end;
    }
    return $intial;
  }

  $host = 'localhost';
  $username = 'lab5_user';
  $password = 'password123';
  $dbname = 'world';
  try{
    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        $country = filter_var($_GET['country'], FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
        $context = filter_var($_GET['context'], FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
        $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
        switch ($context) {
          case 'city':
            if($country == ""){
                $stmt = $conn->query("SELECT c.name , c.country_code, cs.code, c.district, c.population FROM cities c join countries cs on c.country_code = cs.code;");
                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
                echo build_table($results, $context);
            }else{
                $stmt = $conn->query("SELECT c.name , c.country_code, cs.name as country, cs.code, c.district, c.population FROM countries cs join cities c on c.country_code = cs.code WHERE cs.name LIKE '%$country%'");
                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if($results == null){
                  echo strtoupper("No search results found");
                }else{
                  echo build_table($results, $context);
                }
            }
            break;
          
          default:
            if($country == ""){
                $stmt = $conn->query("SELECT * FROM countries");
                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
                echo build_table($results, $context);
            }else{
                $stmt = $conn->query("SELECT * FROM countries WHERE name LIKE '%$country%'");
                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if($results == null){
                  echo strtoupper("No search results found");
                }else{
                  echo build_table($results, $context);
                }
            }
            break;
        }
        
    }

  }catch(error $e){
    echo json_encode(array(
        'error' => 'Help'
    ));
  }catch(exception $e){
    echo json_encode(array(
      'error' => 'Help'
  ));
  }

?>

