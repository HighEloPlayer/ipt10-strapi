<?php
require "vendor/autoload.php";

use GuzzleHttp\Client;

function getBooks() {
    $token = '5854a6192d0f7debdf2a89c7cb5dd342bb675e84da690e349b525b8e3eab10e388f672941ad1f6d210dcbb811aacd8750465431206d1a516357f9a85c79eba9e38151b99981b24a5afe071ca002a651ea9ca54b2fd026cf6ccfca5e31fb234d6d1a37fad1d6701cb51f78edf1cc50d61079cea0e20b85a45a288c6457a2a2d8f';

    try {
        $client = new Client([
            'base_uri' => 'http://localhost:1337/api/'
        ]);
    
        $headers = [
            'Authorization' => 'Bearer ' . $token,        
            'Accept'        => 'application/json',
      ];
  
      $response = $client->request('GET', 'books?pagination[pageSize]=65', [
            'headers' => $headers
      ]);
    
        $body = $response->getBody();
        $decoded_response = json_decode($body);
        return $decoded_response;
    } catch (Exception $e) {
        error_log($e->getMessage());
        echo '<pre>';
        var_dump($e);
    }
    return null; 
}

$books = getBooks();
?>

<html>
    <head>
        <!-- CSS only -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
        <title>BOOKS IN THE BIBLE</title>
    </head>
    <body>
        <div class = "container">
            <h1 style = "padding-bottom: 20px;">SCRIPTURE BOOK LIST</h1>
            <div class = "row">
                <div class = "col-10">
                    <table class = "table">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Author</th>
                            <th scope="col">Category</th>
                        </tr>
                        <?php
                            foreach ($books->data as $bookData) {
                            $book = $bookData->attributes;
                        ?>
                        <tr>
                            <th scope="row"><?php echo $bookData->id; ?></td>
                            <td><?php echo $book->name; ?></td>
                            <td><?php echo $book->author; ?></td>
                            <td><?php echo $book->category; ?></td>
                        </tr>
                        <?php
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>
    </body>