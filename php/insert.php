<?php
    $con = mysqli_connect('localhost', 'root', '', 'dagr');
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    $name = mysqli_real_escape_string($con, $_POST['name']);
    $owner = mysqli_real_escape_string($con, $_POST['owner']);
    $path = mysqli_real_escape_string($con, $_POST['path']);
    $mod_time = mysqli_real_escape_string($con, $_POST['mod_time']);
    $source = mysqli_real_escape_string($con, $_POST['source']);
    $category = mysqli_real_escape_string($con, $_POST['category']);
    

    //$query = "BEGIN; INSERT INTO documents (Name, Owner, GUID, Path, Mod_Time, Source) VALUES ('$name', '$owner', uuid(), '$path', '$mod_time', '$source'); INSERT INTO document_category (document_id) values (last_insert_id()); COMMIT;";
    $begin = mysqli_query($con,'BEGIN');
    
    // A set of queries; if one fails, an exception should be thrown
    $r1 = $con->query("INSERT IGNORE INTO categories (name) VALUES ('$category')");
    $r2 = $con->query("INSERT INTO documents (Name, Owner, GUID, Path, Mod_Time, Source) VALUES ('$name', '$owner', uuid(), '$path', '$mod_time', '$source')");
    $r3 = $con->query("INSERT INTO document_category (document_id, category_id) values (last_insert_id(), (SELECT category_id from categories where name = '$category'))");

    if ($r1 and $r2){
        $begin = mysqli_query($con,'COMMIT');
        echo 'SUCCESS';
    } 
    else {
        $begin = mysqli_query($con,'ROLLBACK');   
        echo 'FAILURE';
    }
    
?>
