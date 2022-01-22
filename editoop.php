<?php
require 'userclass.php';


$id = $_GET['id'];

$sql = "select * from users where id = $id";
$op  = $db->doQuery($sql);

if (mysqli_num_rows($op) == 1) {
    // code .....
    $UserData = mysqli_fetch_assoc($op);
} else {
    $_SESSION['Message'] = ['Message' => 'Invalid Id'];
    header('Location: index.php');
    exit();
}



# Code .....

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = Clean($_POST['title']);
    $content = Clean($_POST['content']);
    
    $user = new User();
    $user->Register($title, $content);

    # Validate Image
    if (Validate($_FILES['image']['name'], 1)) {
        $ImgTempPath = $_FILES['image']['tmp_name'];
        $ImgName = $_FILES['image']['name'];

        $extArray = explode('.', $ImgName);
        $ImageExtension = strtolower(end($extArray));

        if (!Validate($ImageExtension, 7)) {
            $errors['Image'] = 'Invalid Extension';
        } else {
            $FinalName = time() . rand() . '.' . $ImageExtension;
        }
    }

    if (count($errors) > 0) {
        $Message = $errors;
    } else {
        // DB CODE .....

        if (Validate($_FILES['image']['name'], 1)) {
            $disPath = './uploads/' . $FinalName;

            if (!move_uploaded_file($ImgTempPath, $disPath)) {
                $Message = ['Message' => 'Error  in uploading Image  Try Again '];
            } else {
                unlink('./uploads/' . $UserData['image']);
            }
        } else {
            $FinalName = $UserData['image'];
        }

        if (count($Message) == 0) {
            $sql = "update users set title='$title' , content='$content' ,  image ='$FinalName' where id = $id";

            $op = $db->doQuery($sql);

            if ($op) {
                $Message = ['Message' => 'Raw Updated'];
            } else {
                $Message = ['Message' => 'Error Try Again ' . mysqli_error($con)];
            }
        }
        # Set Session ......
        $_SESSION['Message'] = $Message;
        header('Location: index.php');
        exit();
    }
    $_SESSION['Message'] = $Message;
}


?>



<main>
    <div class="container-fluid">
        <h1 class="mt-4">lllllll</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">lllllllll</li>

            <?php
            echo '<br>';
            if (isset($_SESSION['Message'])) {
                Messages($_SESSION['Message']);
            
                # Unset Session ...
                unset($_SESSION['Message']);
            }
            
            ?>

        </ol>


        <div class="card mb-4">

            <div class="card-body">

                <form action="edit.php?id=<?php echo $UserData['id']; ?>" method="post" enctype="multipart/form-data">

                    <div class="form-group">
                        <label for="exampleInputName">title</label>
                        <input type="text" class="form-control" id="exampleInputName" name="title" aria-describedby=""
                            placeholder="Enter title" value="<?php echo $UserData['title']; ?>">
                    </div>


                    <div class="form-group">
                        <label for="exampleInputEmail">content</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" name="content"
                            aria-describedby="emailHelp" placeholder="Enter content" value="<?php echo $UserData['content']; ?>">
                    </div>




                    <div class="form-group">
                        <label for="exampleInputName">Image</label>
                        <input type="file" name="image">
                    </div>

                    <img src="./uploads/<?php echo $UserData['image']; ?>" alt="" height="50px" width="50px"> <br>


                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>





            </div>
        </div>
    </div>
</main>


