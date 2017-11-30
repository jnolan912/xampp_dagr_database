<?php
    $con = mysqli_connect('localhost', 'root', '', 'dagr');
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    // This gets all documents who need to have their links replaced
    $result = mysqli_query($con,"SELECT d.id as oldid, t.id as newid FROM documents d, (SELECT d.path, min(id) as id from documents d group by d.path having count(*) > 1) t where t.path = d.path and t.id != d.id");
    
    $count = 0;
    while($row = mysqli_fetch_array($result)) {
        $count = $count + 1;
        $oldid = $row["oldid"];
        $newid = $row["newid"];
        mysqli_query($con,"UPDATE document_category SET document_id = '$newid' WHERE document_id = '$oldid'");
        mysqli_query($con,"DELETE FROM documents WHERE id = '$oldid'");        
    }

    if ($count == 0){
        echo "No duplicate content found";
    }
    else {
        echo "Successfully identified and deleted $count duplicate documents";        
    }
    mysqli_close($con);
?>