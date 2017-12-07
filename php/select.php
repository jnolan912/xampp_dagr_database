<?php
  $con=mysqli_connect("localhost","root","","dagr");
  // Check connection
  if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

  function appendToQuery($string, $is_first) {
    if ($is_first) {
      return " WHERE " . $string;
    }
    else {
      return " AND " . $string;
    }
  }

  $firstWhere = true;

  $queryString = "SELECT * FROM Documents d LEFT OUTER JOIN Keywords k ON k.document_id = d.id";
  $doc_name = $_POST['name'];
  $keyword = $_POST['keyword'];  
  $extension = $_POST['extension'];
  $path = $_POST['path'];  
  $owner = $_POST['owner']; 
  $startTimeModified = $_POST['startDateCreated'];
  $endTimeModified = $_POST['endDateCreated'];  
  $startTimeAdded = $_POST['startDateAdded'];
  $endTimeAdded = $_POST['endDateAdded'];  
  
  if ($doc_name != "") {
    $queryString .= appendToQuery("d.name LIKE '$doc_name'", $firstWhere);
    $firstWhere = false;
  }
  if ($keyword != "") {
    $queryString .= appendToQuery("k.keyword = '$keyword'", $firstWhere);
    $firstWhere = false;
  }
  if ($extension != "") {
    $queryString .= appendToQuery("d.name LIKE '%$extension'", $firstWhere);
    $firstWhere = false;
  }
  if ($path != "") {
    $queryString .= appendToQuery("d.path LIKE '" . str_replace('\\', '\\\\\\\\', $path) . "'", $firstWhere);
    $firstWhere = false;
  }
  if ($owner != "") {
    $queryString .= appendToQuery("d.owner LIKE '" . str_replace('\\', '\\\\\\\\', $owner) . "'", $firstWhere);
    $firstWhere = false;
  }
  if ($startTimeModified) {
    $queryString .= appendToQuery("d.mod_time >= FROM_UNIXTIME('" . strtotime($startTimeModified) . "')", $firstWhere);
    $firstWhere = false;    
  }
  if ($endTimeModified) {
    $queryString .= appendToQuery("d.mod_time <= FROM_UNIXTIME('" . strtotime($endTimeModified) . "')", $firstWhere);
    $firstWhere = false;      
  }
  if ($startTimeAdded) {
    $queryString .= appendToQuery("d.time_added >= FROM_UNIXTIME('" . strtotime($startTimeAdded) . "')", $firstWhere);
    $firstWhere = false;          
  }
  if ($endTimeAdded) {
    $queryString .= appendToQuery("d.time_added <= FROM_UNIXTIME('" . strtotime($endTimeAdded) . "')", $firstWhere);
    $firstWhere = false;      
  }
  if ($_POST['source'] != 'either') {
    $queryString .= appendToQuery("d.source = '" . $_POST['source'] . "'", $firstWhere);
    $firstWhere = false;          
  }

  
  $queryString .= " GROUP BY d.id";
  $result = mysqli_query($con,$queryString);

?>

<style type="text/css">

  img { visibility: hidden; }
  tr:hover img { visibility: visible; }

</style>

<table id="results" border=1>
  <tr>
    <th>GUID</th>
    <th>Name</th>
    <th>Path</th>
    <th>Owner</th>
    <th>Last Modified</th>
    <th>Time Added to Database</th>
    <th>File Source</th>
  </tr>

  <?php
    while($row = mysqli_fetch_array($result))
     {        
      echo '<tr id=' . $row["ID"] . '>
          <td class="guid">' . $row['GUID'] . "</td>
          <td>" . $row["Name"] . "</td>
          <td>" . $row["Path"] . "</td>
          <td>" . $row["Owner"] . "</td>
          <td>" . $row["Mod_Time"] . "</td>
          <td>" . $row["Time_Added"] . "</td>
          <td>" . $row["Source"] . '</td>
          <td class="edit"><img src="../icons/edit.png" alt="edit" id="edit"></td>
      </tr>';  
    }
    mysqli_close($con);

  ?>

</table>

<script src=../edit.js></script>
