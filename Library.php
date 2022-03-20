<?php
    // copied from bildegalleri index.php login?
    error_reporting(0);
    require_once dirname(dirname(__DIR__)) . implode(DIRECTORY_SEPARATOR, ['', 'inc', 'include.php']);

    $pdo = new \PDO($dbDsn, $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $userManager = new \pvv\admin\UserManager($pdo);

    $as = new SimpleSAML_Auth_Simple('default-sp');
    $as->requireAuth();
    $attrs = $as->getAttributes();
    $loginname = $attrs['uid'][0];

    if(!$loginname) {
        header('Content-Type: text/plain', true, 403);
        echo "Du må være logget inn for å bruke biblioteket.\r\n";
        exit();
    }
    //end of copy

    //will need some refinement
    $bookTemplate = '<div class="book">
                        <div class="book-title">
                            <h1 class="book-title-text">%title</h1>
                        </div>
                        <div class="book-info">
                            <p class="book-info-isbn">%isbn</p>
                            <p class="book-info-publishDate">%publishDate</p>
                            <p class="book-info-numberOfPages">info-numberOfPages</p>
                            <p class="book-info-language">%language</p>
                            <p class="book-info-genre">%genre</p>
                            <p class="book-info-availableToBorrow">%availableToBorrow</p>
                            <p class="book-info-available">%available</p>
                            <p class="book-info-dateBorrowed">%dateBorrowed</p>
                        </div>
                    </div>'

    public function fetchBookData(String $isbn)
    {   
        // input validation
        $isbn = preg_replace( '/[^0-9]/', '', $isbn);
        if (strlen($isbn) != 10 || strlen($isbn) != 13) {
            throw new Exception("Invalid isbn", 1);
        }
        
        // code for database fetching
        
        exec("python dataFetcher.py ",$bookData); //not correct. needs to be reimplemented in php. But im lazy for now

        ###copied TODO: replace with working code
        // Initializing curl
        $curl = curl_init(); //probably a library
            
        // Sending GET request to reqres.in
        // server to get JSON data
        curl_setopt($curl, CURLOPT_URL, 'https://www.googleapis.com/books/v1/volumes?q=isbn:'.$isbn);
            
        // Telling curl to store JSON
        // data in a variable instead
        // of dumping on screen
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            
        // Executing curl
        $response = curl_exec($curl);
        
        // Checking if any error occurs 
        // during request or not
        if($e = curl_error($curl)) {
            echo $e;
        } else {
            
            // Decoding JSON data
            $decodedData = 
                json_decode($response, true); 
                
            // Outputing JSON data in
            // Decoded form
            var_dump($decodedData);
        }
        
        // Closing curl
        curl_close($curl);


        return $bookData
    }

?>


<!DOCTYPE html>
<html lang="en">
<head> 
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <link rel="shortcut icon" href="favicon.ico">
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/gallery.css">
    <meta name="theme-color" content="#024" />
    <title>Bibliotekverkstedet</title>
</head>
<body>
    <script src="dataFetcher.js"></script>
</body>
</html>
