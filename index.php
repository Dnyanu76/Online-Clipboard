<?php
session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
    header("location: login.php");
    exit;
}

?>

<?php
  
  $insert=false;
  $update=false;
  $delete=false;


  $servername="localhost";
  $username="root";
  $password="";
  $database="Notes";

  $conn=mysqli_connect($servername,$username,$password,$database);
  if(!$conn){
      die("Sorry we failed to connect: ". mysqli_connect_error());
  }
  if(isset($_GET['delete'])){
    $sno = $_GET['delete'];
    $delete = true;
    $sql = "DELETE FROM `note` WHERE `SrNo.` = $sno";
    $result = mysqli_query($conn, $sql);
    header("location: index2.php");

  }

  
  if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    if (isset( $_POST['snoEdit'])){
      // Update the record
        $sno = $_POST["snoEdit"];
        $title = $_POST["titleEdit"];
        $description = $_POST["descriptionEdit"];
    
      // Sql query to be executed
      $sql = "UPDATE `note` SET `Note Title` = '$title' , `descri` = '$description' WHERE `SrNo.` = '$sno'";
      $result = mysqli_query($conn, $sql);
      if($result){
        $update = true;
      }
      else{
        echo "We could not update the record successfully";
      }
    }
    else{
      $title= $_POST['title'];
      $description = $_POST['description'];
      // $Desc = $_post['Descri'];

      $sql="SELECT * FROM `note` ORDER BY date desc";
      $isDupli = 0;
      $result=mysqli_query($conn,$sql);
          while($row= mysqli_fetch_assoc($result)){
            if($row["Note Title"] == $title &&
              $row["Descri"] == $description ){
              $isDupli = 1;
            }
          }
            
          if($isDupli == 1){
            $insert=false;
          }

          else{
            $sql="INSERT INTO `note` (`Note Title`, `Descri`) VALUES ('$title', '$description')";
            $result=mysqli_query($conn,$sql);
    
            if($result){
              // echo "<br>The note has been inserted successfully!<br>";
              $insert=true;
            }
            else{
              $insert=false;
            }
          }

      
    }
    
  }
?>


<!doctype html>
<html lang="en">
  <head>
    <style>
      body{
        background:linear-gradient(to right,#9c27b0,#8ecdff) ;
      }

      *{
      margin: 10px;
      padding: 0;
      font-family: sans-serif;
      /* background:linear-gradient(to right,#9c27b0,#8ecdff) ; */
      }

      .textspace{
        border: 5px solid black;
        border-radius: 10px;
        border-style: outset;
      }

      textarea {
        /* width: 100%;
        height: 150px; */
        padding: 12px 20px;
        box-sizing: border-box;
        border: 2px solid #ccc;
        border-radius: 4px;
        background-color: #f8f8f8;
        font-size: 16px;
        resize: none;
      }
      

      textarea::placeholder {
        color: rgb(11, 11, 11);
        font-size: 1.5em;
        font-style: italic;
      }

      h2{
        background-color: mediumspringgreen;
      }
    
      tr:hover {background-color: #f5f5f5}
    </style>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PHP CRUD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">

  </head>
  <body>
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
    aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="editModalLabel">Edit this Note</h5>
            
          </div>
          <form action="./index2.php" method="POST">
            <div class="modal-body">
              <input type="hidden" name="snoEdit" id="snoEdit">
              <div class="form-group">
                <label for="title">Note Title</label>
                <input type="text" class="form-control" id="titleEdit" name="titleEdit" aria-describedby="emailHelp">
              </div>

              <div class="form-group">
                <label for="desc">Note Description</label>
                <textarea class="form-control" id="descriptionEdit" name="descriptionEdit" rows="3"></textarea>
              </div> 
            </div>
            <div class="modal-footer d-block mr-auto">
              
              <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>


    <?php
      if($insert){
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>Success!</strong> Your note has been inserted successfully
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
        <span aria-hidden='true'>×</span>
        </button>
        </div>";
      }
      
    ?>
    <?php
      if($update){
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>Success!</strong> Your note has been updated successfully
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
          <span aria-hidden='true'>×</span>
        </button>
      </div>";
      }
    ?>
    <?php
      if($delete){
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>Success!</strong> Your note has been deleted successfully
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
          <span aria-hidden='true'>×</span>
        </button>
        </div>";
      }
    ?>



    <div class="container my-4">
      <center><h2>****Add a Note*****</h2></center>
      <form action="./index2.php?update=true" method="Post">
        <div class="mb-3">
          <label for="notes" class="form-label"><h4>Note Title</h4></label>
          <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
    
        </div>
        <div class="mb-3">
          <label for="text" class="form-label"><h4>Note Description</h4> </label>
          <br>
          <textarea name="description" id="description" cols="127" rows="5"></textarea>
        </div>
  
        <button type="submit" class="btn btn-primary">Add Note</button>
      </form>
    </div>
    <!-- </div> -->

    

    <table class="table" id="myTable" >
      <thead>
        <tr>
          <th scope="col">SrNo.</th>
          <th scope="col">Title</th>
          <th scope="col">Description</th>
          <th scope="col">Date & Time</th>
          <th scope="col">Actions </th>
        </tr>
      </thead>
    <tbody>
        <?php
          $mysql="SELECT * FROM `note`";
          $result=mysqli_query($conn,$mysql);
          $srno=0;
          while($row= mysqli_fetch_assoc($result)){
            // echo var_dump($row);
            $srno=$srno+1;
            echo"<tr>";
            echo"<th scope='row'>".$srno. "</th>
            <td>". $row['Note Title'] . "</td>
            <td>". $row['Descri'] . "</td>
            <td>". $row['date'] . "</td>
            <td><button class='delete btn btn-sm btn-primary' id=d".$row['SrNo.'].">Delete</button>   <button class='edit btn btn-sm btn-primary' id=".$row['SrNo.'].">Edit</button></td></tr>";
          
          }
  
  
        ?>
    
    </tbody>
    </table>
    </div>
    <hr>


    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
      integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
      crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
      integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
      crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
      integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
      crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script>
      $(document).ready(function () {
        $('#myTable').DataTable();

      });
    </script>

    <script>
      edits = document.getElementsByClassName('edit');
      Array.from(edits).forEach((element) => {
      element.addEventListener("click", (e) => {
        console.log("edit ");
        tr = e.target.parentNode.parentNode;
        title = tr.getElementsByTagName("td")[0].innerText;
        description = tr.getElementsByTagName("td")[1].innerText;
        console.log(title, description);
        titleEdit.value = title;
        descriptionEdit.value = description;
        snoEdit.value = e.target.id;
        console.log(e.target.id)
        $('#editModal').modal('toggle');
      })
    })

    deletes = document.getElementsByClassName('delete');
    Array.from(deletes).forEach((element) => {
      element.addEventListener("click", (e) => {
        console.log("edit ");
        sno = e.target.id.substr(1);

        if (confirm("Are you sure you want to delete this note!")) {
          console.log("yes");
          window.location = `./index2.php?delete=${sno}`;
          
        }
        else {
          console.log("no");
        }
      })
    })
    </script>

    <div><center>
      <h5><p class="mb-3">Click here to<a href="\loginSystem\logout.php" class="text-blue-200 fw-bold">logout</a>
      </p></h5>
    </div></center>

    
  </body>
</html>