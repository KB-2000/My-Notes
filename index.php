<?php
         // connection to the Database
         $insert = false;
         $update = false;
         $delete = false;

         $servername = "localhost";
         $username = "root";
         $password = "root";
         $database = "Notes";

         $conn = mysqli_connect($servername,$username,$password,$database);

         if(!$conn) {
          die("Sorry we failed to connect due to ".mysqli_connect_error());
         } 

         if(isset($_GET['delete'])) {
          $sno = $_GET['delete'];
          $delete = true;
          $sql = "DELETE FROM `notes` WHERE `sno` = $sno";
          $result = mysqli_query($conn,$sql);
         }
          
         if($_SERVER['REQUEST_METHOD'] == 'POST') {
          if(isset( $_POST['snoEdit'])) {
              //update the record
              $sno = $_POST["snoEdit"];
              $title = $_POST["titleEdit"];
              $description = $_POST["descriptionEdit"];

              $sql = "UPDATE `notes` SET `title` = '$title', `description` = '$description' WHERE `notes`.`sno` = $sno;";
              $result = mysqli_query($conn, $sql);
              if($result) {
                $update = true;
              } else {
                echo "We could not update the record successfully";
              }

          } else {
          $title = $_POST['title'];
          $description = $_POST['description'];

          $sql = "INSERT INTO `notes` (`sno`, `title`, `description`, `tstamp`) VALUES (NULL, '$title', '$description', current_timestamp())";
          $result = mysqli_query($conn,$sql);

          if($result) {
            // echo "the record inserted successfully! <br>";
            $insert = true;
         } else {
            echo "failed due to --->". mysqli_error($conn);
         }
        }
      }      
?>


<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CRUD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    
  </head>
  <body>
    <!-- Button trigger modal -->
<!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal">
  Edit
</button> -->

<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="editModalLabel">Edit Note</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form action="/CRUD/index.php" method="POST">
        <input type="hidden" name="snoEdit" id="snoEdit">
            <div class="mb-3">
              <label for="title" class="form-label">Title</label>
              <input type="text" class="form-control" id="titleEdit" aria-describedby="emailHelp" name="titleEdit">
              
            </div>
            <div class="mb-3">
                <label for="desc" class="form-label">Note Description</label>
                <textarea class="form-control" id="descriptionEdit" name="descriptionEdit" rows="3"></textarea>
                <!-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> -->
              </div>
    
            <button type="submit" class="btn btn-primary">Update Note</button>
          </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
    <nav class="navbar navbar-expand-lg bg-dark-subtle">
        <div class="container-fluid">
          <a class="navbar-brand" href="#">MyNotes</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">about</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Contact Us</a>
              </li>
            </ul> 
            <form class="d-flex" role="search">
              <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
              <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
          </div>
        </div>
      </nav>

<?php

if($insert) {
 echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
 <strong>Successful!</strong> Note inserted Successfully.
 <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
</div>";
      }

      if($update) {
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>Successful!</strong> Note updated Successfully.
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
       </div>";
             }

             if($delete) {
              echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
              <strong>Successful!</strong> Note deleted Successfully.
              <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
             </div>";
                   }
?>

      <div class="container my-4" >
        <h2>Add a Note!</h2>
        <form action="/CRUD/index.php" method="POST">
            <div class="mb-3">
              <label for="title" class="form-label">Title</label>
              <input type="text" class="form-control" id="title" aria-describedby="emailHelp" name="title">
              
            </div>
            <div class="mb-3">
                <label for="desc" class="form-label">Note Description</label>
                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                <!-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> -->
              </div>
    
            <button type="submit" class="btn btn-primary">Add Note</button>
          </form>

      </div>
      <div class="container">
           
           <table class="table" id="myTable">
  <thead>
    <tr>
      <th scope="col">S.No</th>
      <th scope="col">Title</th>
      <th scope="col">Description</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  
  <tbody>
  <?php
              $sql = "SELECT * FROM `notes`";
              $result = mysqli_query($conn,$sql);
              $sno = 0;
    while($row = mysqli_fetch_assoc($result)) {
      $sno = $sno + 1;
           echo " <tr>
                <th scope='row'>". $sno ."</th>
                <td>". $row['title'] ."</td>
                <td>". $row['description'] ."</td>
                <td><button class='edit btn btn-sm btn-primary' id=".$row['sno'].">Edit</button> <button class='delete btn btn-sm btn-primary' id=d".$row['sno'].">Delete</button></td>
              </tr>";
              
              }
              
    ?>
    
    
  </tbody> 
</table>
      </div>
      <hr>
    <!-- <h1>Hello, world!</h1> -->
   
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script>
    $(document).ready( function () {
    $('#myTable').DataTable();
} );
</script>

<script>
      edits = document.getElementsByClassName('edit');
      Array.from(edits).forEach((element) => {
        element.addEventListener("click",(e)=>{
            tr = e.target.parentNode.parentNode;
            title = tr.getElementsByTagName("td")[0].innerText;
            description = tr.getElementsByTagName("td")[1].innerText;
            console.log(title,description);

            titleEdit.value = title;
            description.value = description;
            snoEdit.value = e.target.id; 
            $('#editModal').modal('toggle'); 

        })
      })

      deletes = document.getElementsByClassName('delete');
      Array.from(deletes).forEach((element) => {
        element.addEventListener("click",(e)=>{
            
          sno = e.target.id.substr(1,)

            if(confirm("press a button")) {
              window.location = `/crud/index.php?delete=${sno}`;
            }
            

        })
      })


    </script>
  </body>
</html>