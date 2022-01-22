<?php
session_start();
require 'dbconnectionoop.php';
require 'Validate.php';

class User
{
    private $title;
    private $content;
    

   

    public function Register($val1, $val2 )
    {

        ## Create Obj From Validator  ......
        $validator = new Validator();
       
        # Clean ....
        $this->title     = $validator->Clean($val1);
        $this->content   = $validator->Clean($val2);

        # Validation .....
        $errors = [];

        # Validate title
        if (!$validator->Validate($this->title, 1)) {
            $errors['Name'] = 'Field Required';
        }

        # Validate content
        if (!$validator->Validate($this->content, 1)) {
            $errors['Email'] = 'Field Required';
        
           # Validate image
            if (!Validate($_FILES['image']['name'],1)) {
                $errors['Image'] = 'Field Required';
            }else{
        
                 $ImgTempPath = $_FILES['image']['tmp_name'];
                 $ImgName     = $_FILES['image']['name'];
        
                 $extArray = explode('.',$ImgName);
                 $ImageExtension = strtolower(end($extArray));
        
                 if (!Validate($ImageExtension,7)) {
                    $errors['Image'] = 'Invalid Extension';
                 }else{
                     $FinalName = time().rand().'.'.$ImageExtension;
                 }
        
            }
       # CHECK ERRORS ...   
        if (count($errors) > 0) {
            $Message = $errors;
        }else{
    
            $disPath = './uploads/'.$FinalName;


            if(move_uploaded_file($ImgTempPath,$disPath)){
     
         # Hashing password .... 
         $this->password = md5($this->password);
         
         # Create DB Obj ...
         $db = new DB();

         $sql = "insert into users (name,email,password) values ('$this->name','$this->email','$this->password')";
         $op  = $db->doQuery($sql);

         if($op){
             $Message = ['Raw Inserted'];
         }else{
             $Message = ['Error Try Again !!!!!'];
         }
 
        }
      
        $_SESSION['Message'] = $Message;
    
    }



   
}

?>