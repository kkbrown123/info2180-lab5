<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

// $stmt = $conn->query("SELECT * FROM countries");
// $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

function displayCountry($results){
  echo(
    "<table>".
    "<colgroup>".
      "<col style=\"width:40%\">".
      "<col style=\"width:20%\">".
      "<col style=\"width:10%\">".
      "<col style=\"width:30%\">".
    "</colgroup>".
      "<thead>".
        "<tr>".
          "<th>Name</th> <th>Continent</th> <th>Independence</th> <th>Head of State</th>".
        "</tr>".  
      "</thead>".  
      "<tbody>"
  );
  
  foreach ($results as $row){
    echo "<tr>";
    echo "<td>".$row['name']."</td>" . "<td>".$row['continent']."</td>" . "<td>".$row['independence_year']."</td>" . "<td>".$row['head_of_state']."</td>";
    echo "</tr>";
  }
  
  echo(
      "<tbody>".
    "</table>"
  );
}

function displayCity($results){
  echo(
    "<table>".
    "<colgroup>".
      "<col style=\"width:40%\">".
      "<col style=\"width:40%\">".
      "<col style=\"width:20%\">".
    "</colgroup>".
      "<thead>".
        "<tr>".
          "<th>Name</th> <th>District</th> <th>Population</th>".
        "</tr>".  
      "</thead>".  
      "<tbody>"
  );
  
  foreach ($results as $row){
    echo "<tr>";
    echo "<td>".$row['name']."</td>" . "<td>".$row['district']."</td>" . "<td>".$row['population']."</td>";
    echo "</tr>";
  }
  
  echo(
      "<tbody>".
    "</table>"
  );
}

if($_SERVER['REQUEST_METHOD'] == 'GET'){

  $userInput = filter_input(INPUT_GET, 'country', FILTER_SANITIZE_STRING);
  $lookup = $_GET['lookup'];

  if($lookup == "country")
  {
    if(empty($userInput)){
      //IF INPUT IS EMPTY THEN SEARCH FOR ALL COUNTRIES
      $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
      $stmt = $conn->query("SELECT * FROM countries");
      $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
  
      echo "<h2>Results</h2>";
      echo "<hr>";

      displayCountry($results);
    }
  
    else{
      //SEARCH FOR ENTERED COUNTRY
      $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
      $stmt = $conn->prepare("SELECT * FROM countries WHERE name LIKE :userInput");
      $stmt->bindValue(':userInput', "%$userInput%", PDO::PARAM_STR);
      $stmt->execute();
      $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
  
      echo "<h2>Results</h2>";
      echo "<hr>";

      if(count($results) > 0){
        displayCountry($results);
      }
      else{
        echo "<p>No Results Found<p>";
        echo "<p>Enter a valid country or check spelling.<p>";
      }
      
  
    }
  }
  
  if($lookup == "city")
  {
    if(empty($userInput)){
      //IF INPUT IS EMPTY THEN SEARCH FOR ALL COUNTRIES
      echo "<h2>Results</h2>";
      echo "<hr>";

      echo "<p>No Results Found<p>";
      echo "<p>Enter a valid country.<p>";

    }
  
    else{
      //SEARCH FOR ENTERED COUNTRY
      $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
      $stmt = $conn->prepare("SELECT cities.name, cities.district, cities.population FROM cities INNER JOIN countries ON  countries.code = cities.country_code WHERE countries.name LIKE :userInput");
      $stmt->bindValue(':userInput', "$userInput", PDO::PARAM_STR);
      $stmt->execute();
      $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
      
      echo "<h2>Results</h2>";
      echo "<hr>";

      if(count($results) > 0){
        displayCity($results);
      }
      else{
        echo "<p>No Results Found<p>";
        echo "<p>Enter a valid country or check spelling.<p>";
      }
  
    }
  }
}

?>
