<?php
    $con = mysqli_connect('localhost', 'root', '', 'dagr');
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    $path = $_POST['url'];
    $level = (int) $_POST['level'];
    $categoryName = $_POST['category'];

    if ($level < 3) {
        $dom = new DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTMLFile($path);


        $list = $dom->getElementsByTagName("title");
        if ($list->length > 0) {
            $title = $list->item(0)->textContent;
        }
        
        

        if ($title) {
            $url = 'http://localhost/xampp_dagr_database/php/create_category.php';
            if ($categoryName) {
                $categoryName .= '/';
            }
            $categoryName .= $title;
            $data = array('categoryPath' => $categoryName);
            
            // use key 'http' even if you send the request to https://...
            $options = array(
                'http' => array(
                    'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                    'method'  => 'POST',
                    'content' => http_build_query($data)
                )
            );
            $context  = stream_context_create($options);
            $category = file_get_contents($url, false, $context);        

            $r1 = $con->query("INSERT INTO documents (Name, GUID, Path, Source) VALUES ('$title', uuid(), '$path', 'web')");
            $r2 = $con->query("INSERT INTO document_category (document_id, category_id) values (last_insert_id(), '$category')");
            
        }


        //Get all links. You could also use any other tag name here,
        //like 'img' or 'table', to extract other tags.
        $links = $dom->getElementsByTagName('a');

        //Iterate over the extracted links and display their URLs
        foreach ($links as $link){
            //Extract and show the "href" attribute.
            $linkPath = $link->getAttribute('href') . '<br>';

            $url = 'http://localhost/xampp_dagr_database/php/html_parser.php';
            $data = array('category' => $categoryName, 'level' => $level + 1, 'url' => $linkPath);
            
            // use key 'http' even if you send the request to https://...
            $options = array(
                'http' => array(
                    'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                    'method'  => 'POST',
                    'content' => http_build_query($data)
                )
            );
            $context  = stream_context_create($options);
            file_get_contents($url, false, $context);        
        }
    }

?>