<?php
require 'userclass.php';


$sql = 'select * from users';
$op  = $db->doQuery($sql);



?>



<main>
    <div class="container-fluid">
        <h1 class="mt-4">llll</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">llllllll</li>
            <?php 
            echo '<br>';
           if(isset($_SESSION['Message'])){
             Messages($_SESSION['Message']);
          
              # Unset Session ... 
              unset($_SESSION['Message']);
              }
        
             ?>
        </ol>


        <div class="card mb-4">

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>title</th>
                                <th>content</th>
                                <th>image</th>
                                
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>title</th>
                                <th>content</th>
                                <th>image</th>
                              
                        </tfoot>
                        <tbody>

                            <?php 
                                        # Fetch Data ...... 
                                        while($data = mysqli_fetch_assoc($op)){
                                      
                                    ?>

                            <tr>
                                <td><?php echo $data['content']; ?></td>
                                <td><?php echo $data['title']; ?></td>
                                <td> <img src="./uploads/<?php echo $data['image']; ?>" height="40px" width="40px">  </td>



                            </tr>

                            <?php 
                                        }
                                    ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

