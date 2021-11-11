<!-------f---------

    Assignment 3
    Name: Fergal Ingoldsby
    Date: 24/09/2021
    Description: Create a blog post webpage using php and html.

------------------>
<?php
    require('db_connect.php');
    
     $query = "SELECT dog_id, name, age, description, location, adoptable_since FROM dog ORDER BY dog_id DESC LIMIT 5";

     $statement = $db->prepare($query);

     $statement->execute(); 

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Dog Listings</title>
    <link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>
    <div id="wrapper">
      <div id="header">
          <h1><a href="index.php">Available Dogs</a></h1>
      </div> 
<ul id="menu">
    <li><a href="index.php" class='active'>Home</a></li>
    <li><a href="createListing.php" >New Post</a></li>
</ul> 
  <div id="all_blogs">
      <?php if($statement->rowCount() > 0) : ?>
        <div class="blog_post"> 
          <?php while($row = $statement->fetch()): ?> 
            <h2><a href="fullpage.php?dog_id=<?= $row['dog_id']?>"><?= $row['name'] ?></a></h2>               
              <p>
                <small>
                  <?= date('F d Y ', strtotime($row['adoptable_since']))?>
                  <a href="editanddelete.php?dog_id=<?=$row['dog_id']?>">edit</a>
                </small>
              </p>
              <div class='blog_content'>
                <?= substr($row['description'], 0, 200) ?>
                <?php if(strlen($row['description']) > 200): ?>
                <a href="fullpage.php?dog_id=<?=$row['dog_id']?>">..Read Full post</a>
                <?php endif ?>
              </div>
              <div>
                <p><?= $row['location'] ?></p>
              </div>
              <div>
                <p><?= $row['age'] ?></p>
              </div>
          <?php endwhile ?>
        </div>
      <?php endif ?>
  </div>
</div>
</body>
</html>
