<!-------f---------

    Assignment 3
    Name: Fergal Ingoldsby
    Date: 24/09/2021
    Description: Create a blog post webpage using php and html.

------------------>
<?php
    require 'authenticate.php';
    require('db_connect.php');

    if (isset($_GET['dog_id'])){
          $query = "SELECT * FROM dog WHERE dog_id = :dog_id LIMIT 1";
          $statement = $db->prepare($query);

          $dog_id = filter_input(INPUT_GET, 'dog_id', FILTER_SANITIZE_NUMBER_INT);

          $statement->bindValue(':dog_id', $dog_id, PDO::PARAM_INT);
          $statement->execute();

          $row = $statement->fetch();
        }
        else{
          $dog_id = false;
        }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Dogs</title>
    <link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>
    <div id="wrapper">
      <div id="header">
          <h1><a href="index.php">Dog</a></h1>
      </div> 
          <ul id="menu">
              <li><a href="index.php" class='active'>Home</a></li>
              <li><a href="createListing.php" >New Listing</a></li>
          </ul> 
          <?php if ($dog_id): ?>

          <div id="all_blogs">
              <div class="blog_post">                
                <h2><?= $row['name'] ?></h2>                 
                  <p>
                    <small>
                      <?= $row['adoptable_since'] ?>
                    </small>
                  </p>
                  <p>
                    <div class='blog_content'>
                    <?= $row['description'] ?></div>                  
                  </p>                 
              </div>
        </div>
        <?php endif ?>
            
    </div>
</body>
</html>
