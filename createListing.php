 <!-------f---------

    Assignment 3
    Name: Fergal Ingoldsby
    Date: 24/09/2021
    Description: Create a blog post webpage using php and html.

------------------>
<?php
    require 'authenticate.php';
    require('db_connect.php');
     
    if ($_POST && isset($_POST['name']) && isset($_POST['description']) && isset($_POST['location']) && isset($_POST['age']))  {

      function checkName(){
          return filter_input(INPUT_POST, 'name');
        }

      function checkDescription(){
          return filter_input(INPUT_POST, 'description');
        }

      function checkLocation(){
          return filter_input(INPUT_POST, 'location');
        }

      function checkAge(){
          return filter_input(INPUT_POST, 'age');
        }

          if(checkName() && checkAge() && checkDescription() && checkLocation()){
              $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
              $age = filter_input(INPUT_POST, 'age', FILTER_VALIDATE_INT) ;
              $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
              $location = filter_input(INPUT_POST, 'location', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
              
              
              $query = "INSERT INTO dog (name, age, description, location) VALUES (:name, :age, :description, :location)";
              $statement = $db->prepare($query);
              
              $statement->bindValue(':name', $name);
              $statement->bindValue(':age', $age);
              $statement->bindValue(':description', $description);
              $statement->bindValue(':location', $location);
                            
              $statement->execute();
            }
          else{
            $id = false;
          }
    }
    else {
        $id = false;
    }
    
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Listing Entry - New Post</title>
    <link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>
    <div id="wrapper">
        <div id="header">
            <h1><a href="index.php">Dog Listing - New Entry</a></h1>
        </div> 
        <ul id="menu">
            <li><a href="index.php" >Home</a></li>
            <li><a href="createListing.php" class='active'>New Listing</a></li>
        </ul>
            <div id="all_blogs">
              <form action="createListing.php" method="post">
                <fieldset>
                  <legend>New Dog Entry</legend>
                  <p>
                    <label for="name">Name</label>
                    <input name="name" id="name" />
                  </p>
                  <p>
                    <label for="description">Description</label>
                    <textarea name="description" id="description"></textarea>
                  </p>
                  <p>
                    <label for="location">Location</label>
                    <input name="location" id="location" />
                  </p>
                  <p>
                    <label for="age">Age</label>
                    <input name="age" id="age" />
                  </p>
                  <p>
                    <input type="submit" name="command" value="Create" />
                  </p>
                </fieldset>
              </form>
            </div>
    </div> 
  </body>
</html>
