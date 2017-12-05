<?php
    $con = mysqli_connect('localhost', 'root', '', 'dagr');
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    $keyword = mysqli_real_escape_string($con, $_POST['keyword']);
    $id = mysqli_real_escape_string($con, $_POST['id']);

    $r1 = $con->query("INSERT INTO keywords (Document_Id, Keyword) VALUES ('$id', '$keyword')");

    if ($r1){
        echo 'Added Keyword to the Document';
    } 
    else {
        echo 'Failed to add keyword';
    }

?>