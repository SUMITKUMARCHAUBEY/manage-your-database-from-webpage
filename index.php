<?php
$update=false;
$alert=false;
$delete=false;
//connecting to database
$username="root";
$server="localhost";
$password="";
$database="todolist";

$conn=mysqli_connect($server,$username,$password,$database);
//die on connection faliur
if(!$conn){
  die("connection failed!!  ".mysqli_connect_error());
 }
 if(isset($_GET['del'])){
   $sno=$_GET['del'];
   $sql="DELETE FROM `list` WHERE `list`.`sl.no` = $sno;";
   $result =mysqli_query($conn, $sql);
   if($result){
     $delete= true;
   }

 }
 if($_SERVER['REQUEST_METHOD']=='POST'){
   if(isset($_POST['slnoedit'])){
     $title=$_POST['titleedit'];
     $slno=$_POST['slnoedit'];
     $desc=$_POST['descedit'];
     $sql="UPDATE `list` SET `title` = '$title', `des` = '$desc' WHERE `list`.`sl.no` = $slno";
      $result =mysqli_query($conn, $sql);
      if($result){
        $update= true;
      }
   }
   else{
   $title=$_POST['title'];
   $desc=$_POST['desc'];
   $sql="INSERT INTO `list` (`title`, `des`) VALUES ('$title', '$desc')"; 
   $r2=mysqli_query($conn, $sql);
   if($r2==true){
     $alert=true;
   }
  }
 }
//INSERT INTO `list` (`sl.no`, `title`, `des`, `time`) VALUES ('1', 'buy books', 'ncert physic 12th ki 2nd hand.', current_timestamp());  

?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
     <link rel="stylesheet" href="//cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
     
    <title>Manage Your Database</title>
  </head>
  <body>
  <div class="modal" id="editmodal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit your entry</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form Actions="/crud/index.php" method="POST">
      <div class="modal-body">
     
        <input type="hidden" id="slnoedit"  name="slnoedit">
            <div class="form-group">
              <label for="title" >Title</label>
              <input type="text" class="form-control" id="titleedit" name="titleedit" aria-describedby="emailHelp">
              <div id="emailHelp" class="form-text">What's in your mind.</div>
            </div>
            
            <div class="form-group my-2">
                <label for="desc" class="form-label">Discribe</label>
                <textarea class="form-control" id="descedit" name="descedit" rows="3"></textarea>
              </div>
           
      </div>
      <div class="modal-footer d-block mr-auto">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Update</button>
      </div>
      </form>
    </div>
  </div>
</div>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
          <a class="navbar-brand mx-5" href="#" >Manage Your Database</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">About</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Contect</a>
              </li>
              <li class="nav-item">
                <a class="nav-link disabled">Inspiration</a>
              </li>
            </ul>
          </div>
        </div>
      </nav>
      <?php
      if($alert==true){
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong> Added!! </strong> your todo list has been updated successfully. check below!!
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>";
      }
      ?>
      <?php
      if($update==true){
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong> updated!! </strong> your todo list has been updated successfully. check below!!
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>";
      }
      ?>
      
      <?php
      if($delete==true){
        echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
        <strong> deleted!! </strong> your todo list has been updated successfully. check below!!
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>";
      }
      ?>
      <div class="container my-5">
          <h1>To Do List</h1>
          <h2></h2>
        <form Actions="/crud/index.php" method="POST">
            <div class="form-group">
              <label for="title" >Title</label>
              <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
              <div id="emailHelp" class="form-text">What's in your mind.</div>
            </div>
            
            <div class="form-group my-2">
                <label for="desc" class="form-label">Discribe</label>
                <textarea class="form-control" id="desc" name="desc" rows="3"></textarea>
              </div>
            <button type="submit" class="btn btn-primary my-3">Add</button>
          </form>
      </div>
      <div class="container">
          
         <table class="table" id="myTable">
  <thead>
    <tr>
      <th scope="col">sl.no</th>
      <th scope="col">Title</th>
      <th scope="col">Discription</th>
      <th scope="col">Actions</th>
    </tr>
  </thead>
  <tbody>
  <?php
          $sql= "SELECT * FROM `list`";
          $r1=mysqli_query($conn,$sql);
          $sl=1;
          while($row=mysqli_fetch_assoc($r1)){
            
            echo'<tr>
            <th scope="row">'.$sl.'</th>
            <td>'.$row['title'].'</td>
            <td>'.$row['des'].'</td>
            <td><button class="btn btn-sm btn-primary edit" id='.$row['sl.no'].' >edit</button> <button class="del btn btn-sm btn-primary" id=d'.$row['sl.no'].'>delete</button></td>
          </tr>';
          $sl++;
          }
         ?>
    
    
  </tbody>
</table>
      </div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    
    <script src="//cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
     <script>
       $(document).ready( function () {
      $('#myTable').DataTable();
      } );
     </script>
     <script>
       edits=document.getElementsByClassName('edit');
       Array.from(edits).forEach((element)=>{
       element.addEventListener("click",(e)=>{
      //  console.log("edit ",);
       tr=e.target.parentNode.parentNode
       title=tr. getElementsByTagName('td')[0].innerText;
       disc=tr. getElementsByTagName('td')[1].innerText;
       titleedit.value=title;
       descedit.value=disc;
       slnoedit.value=e.target.id;
       console.log(slnoedit.value);
       $('#editmodal').modal('toggle')
    })
  })
  dels=document.getElementsByClassName("del");
       Array.from(dels).forEach((element)=>{
       element.addEventListener("click",(e)=>{
      //  console.log("edit ",);
       tr=e.target.parentNode.parentNode;
       title=tr. getElementsByTagName('td')[0].innerText;
       disc=tr. getElementsByTagName('td')[1].innerText;
       sno=e.target.id.substr(1,); 
       if(confirm("Are you sure you want to delete!")){
        window.location= `/crud/index.php?del=${sno}`;
       }
       else{
         console.log("no");
       }
    })
  })
     </script>
  </body>
</html>