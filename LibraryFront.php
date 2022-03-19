<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <script src="worblehattDatabaseBuilder.js"></script>

    <?php

    $data = file_get_contents('https://blockchain.info/ticker');
    $decodedData = json_decode($data);

    function getBookData(){
        
    }

    echo "hello world";
    

    ?>
    
</body>
</html>
