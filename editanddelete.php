<!-------f---------

    Assignment 3
    Name: Fergal Ingoldsby
    Date: 24/09/2021
    Description: Create a blog post webpage using php and html.

------------------>
<?php
    require 'authenticate.php';
    require('db_connect.php'); 

   
    if (isset($_POST['update']) && isset($_POST['name']) && isset($_POST['age']) && isset($_POST['description']) && isset($_POST['location']) && isset($_POST['dog_id'])) {

      function checkName(){
          return filter_input(INPUT_POST, 'name');
        }

      function checkAge(){
          return filter_input(INPUT_POST, 'age');
        }

      function checkDescription(){
          return filter_input(INPUT_POST, 'description');
        }

      function checkLocation(){
          return filter_input(INPUT_POST, 'location');
        }

          if(checkName() && checkAge() && checkDescription() && checkLocation()){
              $name  = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
              $age = filter_input(INPUT_POST, 'age', FILTER_SANITIZE_NUMBER_INT);
              $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
              $location = filter_input(INPUT_POST, 'location', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
              $dog_id      = filter_input(INPUT_POST, 'dog_id', FILTER_SANITIZE_NUMBER_INT);
              

              $query     = "UPDATE dog SET name = :name, age = :age, description = :description, location = :location WHERE dog_id = :dog_id";
              $statement = $db->prepare($query);
              $statement->bindValue(':name', $name);        
              $statement->bindValue(':age', $age);
              $statement->bindValue(':description', $description);
              $statement->bindValue(':location', $location);        
              $statement->bindValue(':dog_id', $dog_id, PDO::PARAM_INT);
              
              $statement->execute();
              
              header("Location: editanddelete.php?dog_id={$dog_id}");
              exit;
            }
          else{
            $dog_id = false;
          }
    }

    else if(isset($_POST['delete']) && isset($_POST['dog_id'])){

      $dog_id      = filter_input(INPUT_POST, 'dog_id', FILTER_SANITIZE_NUMBER_INT);

      $query     = "DELETE FROM dog WHERE dog_id = :dog_id LIMIT 1";

      $statement = $db->prepare($query);
      $statement->bindValue(':dog_id', $dog_id, PDO::PARAM_INT);

      $statement->execute();
        
      header("Location: index.php");
      exit;
    }
    

    else if (isset($_GET['dog_id'])){
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
    <title>Dog Listing - Edit Listing</title>
    <link rel="stylesheet" href="style.css" type="text/css">
    <script src="script.js"></script>
</head>
<body>
    <div id="wrapper">
        <div id="header">
            <h1><a href="index.php">Dog Listing - Edit Listing</a></h1>
        </div> 
<ul id="menu">
    <li><a href="index.php" >Home</a></li>
    <li><a href="createListing.php" class='active'>New Listing</a></li>
</ul> 
<div id="all_blogs">
  <?php if ($dog_id): ?>
  <form action="editanddelete.php" method="post">
    <fieldset>
      <legend>Edit Dog Listing</legend>
      <p>
        <input type="hidden" name="dog_id" value="<?= $row['dog_id'] ?>">
        
        <label for="name">Name</label>
        <input name="name" id="name" value="<?= $row['name']?>"/>
      </p>
      <p>
        <label for="description">Description</label>
        <textarea name="description" id="description" ><?= $row['description']?></textarea>
      </p>
      <p>
        <label for="age">Age</label>
        <input name="age" id="age" value="<?= $row['age']?>"/>
      </p>
      <p>
        <label for="location">Location</label>
        <input name="location" id="location" value="<?= $row['location']?>"/>
      </p>
      <p>      
        <input type="submit" name="update" value="Update" />
        <input type="submit" name="delete" value="Delete" onClick="return confirm('Do you want to delete post?')"/>
      </p>
    </fieldset>
  </form>
 <?php else: ?>
    <?php header("Location: index.php")?>
  <?php endif ?>
    </div>
  </div> 
</body>
</html>
