<?php
$insert = false;
$update=false;
$delete=false;
//connect top database
$servername = "localhost";
$username = "root";
$password = "";
$database = "notes";

//creat a connection
$conn = mysqli_connect($servername, $username, $password, $database);

//Die if connection is not successfull
if (!$conn) {
  die("Sorry we failed to connect:" . mysqli_connect_error());
}

if(isset($_GET['delete'])){
  $sno=$_GET['delete'];
  $delete=true;
  $sql="DELETE FROM `notes` WHERE `notes`.`sno` = $sno";
  $result = mysqli_query($conn, $sql); 
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (isset($_POST['snoEdit'])) {
    //Update the record
    $sno = $_POST['snoEdit'];
    $title = $_POST['titleEdit'];
    $description = $_POST['descriptionEdit'];

    //sql query to be executed
    $sql = "UPDATE `notes` SET `title` = '$title', `description` = '$description' WHERE `notes`.`sno` = $sno";
    $result = mysqli_query($conn, $sql);
    if($result){
      $update=true;
    }
    else{
      echo"we could not update the record successfully";  
    }
  } else {
    $title = $_POST['title'];
    $description = $_POST['description'];

    //sql query to be executed
    $sql = "INSERT INTO `notes` (`title`, `description`) VALUES ('$title', '$description')";
    $result = mysqli_query($conn, $sql);

    //Add a new trip to the trip table in the database
    if ($result) {
      $insert = true;
    } else {
      echo "The record was not inserted successfully because of this erorr --->"
        . mysqli_error($conn);
    }
  }
}
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Project The CRUD</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <link rel="stylesheet" href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
</head>

<body>
  <!-- edit modal -->
  <!-- <button type="button" class="btn btn-primary" data-bs-toggle="editmodalLable" data-bs-target="#exampleModal">
    Edit
  </button>  -->

  <!-- Modal -->
  <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="editModalLabel">Edit this Note</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="/Project3/index.php" method="POST">
        <div class="modal-body">
            <input type="hidden" name="snoEdit" id="snoEdit">
            <div class="mb-3">
              <label for="title" class="form-label">Note Title</label>
              <input type="text" class="form-control" id="titleEdit" name="titleEdit" aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
              <label for="description" class="form-label">Note Discription</label>
              <textarea class="form-control" id="descriptionEdit" name="descriptionEdit" rows="3"></textarea>
            </div>
            <!-- <button type="submit" class="btn btn-primary">Update Note</button> -->
        </div>
        <div class="modal-footer d-block mr-auto">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Update Note</button>
        </div>
        </form>
      </div>
    </div>
  </div>

  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="#"><img src="logo.svg.png" alt="logo" height="30px"></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Contact Us</a>
          </li>
        </ul>
        <form class="d-flex" role="search">
          <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-primary" color="$orange-500" type="submit">Search</button>
        </form>
      </div>
    </div>
  </nav>


<?php
    if ($insert) {
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
    <strong>Sucess!</strong> Your note has been inserted successfully.
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
    </div>";
    }
   ?>

<?php
  if ($update) {
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
    <strong>Sucess!</strong> Your note has been updated successfully.
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
  </div>";
  } 
  ?>

<?php
  if ($delete) {
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
    <strong>Sucess!</strong> Your note has been deleted successfully.
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
  </div>";
  }
  ?>

  <div class="container my-4">
    <h2>Add a Note</h2>
    <form action="/Project3/index.php" method="POST">
      <div class="mb-3">
        <label for="title" class="form-label">Note Title</label>
        <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
      </div>
      <div class="mb-3">
        <label for="description" class="form-label">Note Discription</label>
        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
      </div>
      <button type="submit" class="btn btn-primary">Add Note</button>
    </form>
  </div>

  <div class="container my-4">
    <table class="table" id="myTable">
      <thead>
        <tr>
          <th scope="col">S.NO</th>
          <th scope="col">Title</th>
          <th scope="col">Description</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $sql = "SELECT * FROM `notes`";
        $result = mysqli_query($conn, $sql);
        $sno = 0;
        while ($row = mysqli_fetch_assoc($result)) {
          $sno = $sno + 1;
          echo " <tr>
      <th scope='row'>" . $sno . "</th>
      <td>" . $row['title'] . "</td>
      <td>" . $row['description'] . "</td>
      <td> <button class= 'edit btn btn-sm btn-primary' id=" . $row['sno'] . ">Edit</button> <button class= 'delete btn btn-sm btn-primary' id=d" . $row['sno'] . ">Delete</button>
    </tr>";
        }
        ?>
      </tbody>
    </table>
  </div>
  <hr>

  <script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
  </script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
  <script src="//cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#myTable').DataTable();
    });
  </script>
  <script>
    edits = document.getElementsByClassName('edit');
    Array.from(edits).forEach((element) => {
      element.addEventListener("click", (e) => {
        console.log("edit", );
        tr = e.target.parentNode.parentNode;
        title = tr.getElementsByTagName("td")[0].innerText;
        description = tr.getElementsByTagName("td")[1].innerText;
        console.log(title, description);
        titleEdit.value = title;
        descriptionEdit.value = description;
        snoEdit.value = e.target.id;
        console.log(e.target.id);
        $('#editModal').modal('toggle');
      })
    })

    deletes = document.getElementsByClassName('delete');
    Array.from(deletes).forEach((element) => {
      element.addEventListener("click", (e) => {
        console.log("delete", );
        sno=e.target.id.substr(1,);

        if(confirm("Are you sure you want to delete this note.")){
          console.log("yes");
          window.location=`/Project3/index.php?delete=${sno}`;
        }
      else{
        console.log("no");
      }
      })
    })
  </script>
</body>

</html>