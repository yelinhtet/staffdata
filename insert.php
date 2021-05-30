<?php
   include('config.php');
   session_start();
   
   if(isset($_POST['submit']))
   {    
         $name = $_POST['name'];
         $nrc_part = explode("|",$_POST['first_nrc']);
         $nrc_part1 = $nrc_part[1];
         $nrc_part2 = $_POST['second_nrc'];
         $nrc_part3 = $_POST['nrc_number'];
         $dept = $_POST['dept'];
         $position = $_POST['position'];
         $cdm_start_date = $_POST['cdm_start_date'];
         $contact = $_POST['contact'];
         $transfer_acc = $_POST['transfer_acc'];
         $crph_id = $_POST['crph_id'];
         $user_check = $_SESSION['login_user'];
         $cdm_status = $_POST['cdm_status'];
         $full_nrc_part= $nrc_part1."/".$nrc_part2."(နိုင်)".$nrc_part3;
         $full_nrc = str_replace("|","",$full_nrc_part);
         $file_full_nrc= "images/".$nrc_part[0]."_".explode("|",$_POST['second_nrc'])[0].$nrc_part3."/";
         $target=$file_full_nrc;
         /** staff photo **/
         $image1 = $_FILES['image_id']['tmp_name']; 
         $image1_name = $_FILES['image_id']['name']; 

         /** dismissal photo **/
         $image2 = $_FILES["image_dismissal"]["tmp_name"];
         $image2_name = $_FILES['image_dismissal']['name']; 

         $insert_date= date('Y-m-d H:i:s');
        $sql = "INSERT INTO staff (staff_name,staff_nrc,staff_dept_name,staff_position,
        staff_cdm_start_date,staff_crph_id,staff_contact,staff_transfer_acc,staff_nrc_photo,staff_dismissal_photo,
        staff_cdm_status,insert_user,insert_date,image_path,staff_delete_flag) 
        VALUES ('$name','$full_nrc','$dept','$position',
        '$cdm_start_date','$crph_id','$contact','$transfer_acc','$image1_name','$image2_name',
        '$cdm_status','$user_check','$insert_date','$file_full_nrc','0')";
        if (mysqli_query($conn, $sql)) {
            if ( ! is_dir($target)) {
               mkdir($target, 0755);
            }
            $target1=$target;
            $target .= "/".$image1_name;
            $target1 .= "/".$image2_name;
            if(move_uploaded_file($_FILES['image_id']['tmp_name'],$target) && move_uploaded_file($_FILES['image_dismissal']['tmp_name'],$target1)){
               echo "File uploaded.";
            }
            header("Location: home.php");
        } else {
           echo "Error: " . $sql . ":-" . mysqli_error($conn);
        }
        mysqli_close($conn);
   }
?>