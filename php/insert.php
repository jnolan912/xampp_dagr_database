<?php
    $con = mysqli_connect('localhost', 'root', '', 'my_test');
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    $name = mysqli_real_escape_string($con, $_POST['name']);
    $owner = mysqli_real_escape_string($con, $_POST['owner']);

    $query = "INSERT INTO documents (Name, Owner, GUID) VALUES ('$name', '$owner', uuid_short())";
    if($con->query($query)) {
        echo 'Success';
    }
?>
