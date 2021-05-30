<?php
   include('config.php');
   session_start();
   
   if(isset($_POST['submit']))
   {    
         $name = $_POST['edit_name'];
         $nrc_part = explode("|",$_POST['edit_first_nrc']);
         $nrc_part1 = $nrc_part[1];
         $nrc_part_2 = explode("|",$_POST['edit_second_nrc']);
         $nrc_part2 = $nrc_part_2[1];
         $nrc_part3 = $_POST['edit_nrc_number'];
         $dept = $_POST['edit_dept'];
         $position = $_POST['edit_position'];
         $cdm_start_date = $_POST['edit_cdm_start_date'];
         $contact = $_POST['edit_contact'];
         $transfer_acc = $_POST['edit_transfer_acc'];
         $cdm_status = $_POST['edit_cmd_status'];
         $crph_id = $_POST['edit_crphid'];
         $staff_id = $_POST['_token_edit'];
         $user_check = $_SESSION['login_user'];

         $exist_nrc_image = $_POST['hidden_edit_image_id'];
         $exist_dismissal = $_POST['hidden_edit_image_dismissal'];
         $nrc_file_name = explode("//",$exist_nrc_image);
         $get_nrc_file_name = $nrc_file_name[1];

         $dismissal_file_name = explode("//",$exist_dismissal);
         $get_dismissal_file_name = $dismissal_file_name[1];


         $full_nrc_part= $nrc_part1."/".$nrc_part2."(နိုင်)".$nrc_part3;
         $full_nrc = str_replace("|","",$full_nrc_part);

         $file_full_nrc= "images/".$nrc_part[0]."_".explode("|",$_POST['edit_second_nrc'])[0].$nrc_part3."/";
         $target1=$file_full_nrc;
         $target2=$file_full_nrc;
         /** staff photo **/
         $image1 = $_FILES['edit_image_id']['tmp_name']; 
         $image1_name = $_FILES['edit_image_id']['name']; 

         /** dismissal photo **/
        $image2 = $_FILES["edit_image_dismissal"]["tmp_name"];
        $image2_name = $_FILES['edit_image_dismissal']['name']; 

        $update_date= date('Y-m-d H:i:s');
        if(
            (!file_exists($_FILES['edit_image_id']['tmp_name']) || !is_uploaded_file($_FILES['edit_image_id']['tmp_name']))
            &&
            (!file_exists($_FILES['edit_image_dismissal']['tmp_name']) || !is_uploaded_file($_FILES['edit_image_dismissal']['tmp_name']))
        ) {
            $sql = "
            UPDATE 
                staff
            SET
                staff_name ='$name',
                staff_nrc ='$full_nrc',
                staff_dept_name = '$dept',
                staff_position = '$position',
                staff_cdm_start_date = '$cdm_start_date',
                staff_crph_id = '$crph_id',
                staff_contact = '$contact',
                staff_transfer_acc = '$transfer_acc',
                staff_cdm_status = '$cdm_status',
                update_user = '$user_check',
                update_date = '$update_date',
                image_path = '$file_full_nrc',
                staff_delete_flag = '0'
            WHERE
                staff_id = '$staff_id';";
            //move update picture to new location
            if ( ! is_dir($target1)) {
               mkdir($target1, 0755);
            }
            $target1 .= "/".$get_nrc_file_name;
            $target2 .= "/".$get_dismissal_file_name;
            if(rename($exist_nrc_image, $target1) && rename($exist_dismissal, $target2)){
                echo 'File Upload Success!';
            }
            else
            {
                echo "File can't upload";
            }
        }
        else if(
            (file_exists($_FILES['edit_image_id']['tmp_name']) || is_uploaded_file($_FILES['edit_image_id']['tmp_name']))
            &&
            (!file_exists($_FILES['edit_image_dismissal']['tmp_name']) || !is_uploaded_file($_FILES['edit_image_dismissal']['tmp_name']))
        ) {
            $sql = "
            UPDATE 
                staff
            SET
                staff_name ='$name',
                staff_nrc ='$full_nrc',
                staff_dept_name = '$dept',
                staff_position = '$position',
                staff_cdm_start_date = '$cdm_start_date',
                staff_contact = '$contact',
                staff_transfer_acc = '$transfer_acc',
                staff_nrc_photo = '$image1_name',
                staff_cdm_status = '$cdm_status',
                staff_crph_id = '$crph_id',
                update_user = '$user_check',
                update_date = '$update_date',
                image_path = '$file_full_nrc',
                staff_delete_flag = '0'
            WHERE
                staff_id = '$staff_id';";
            //move update picture to new location
            if ( ! is_dir($target1)) {
               mkdir($target1, 0755);
            }
            $target1 .= "/".$image1_name;
            $target2 .= "/".$get_dismissal_file_name;
            if(move_uploaded_file($_FILES['edit_image_id']['tmp_name'],$target1)){
                $fileMoved = rename($exist_dismissal, $target2);

                if($fileMoved){
                    echo 'File Upload Success!';
                }
            }
            else
            {
                echo "File can't upload";
            }
        }
        else if(
            (!file_exists($_FILES['edit_image_id']['tmp_name']) || !is_uploaded_file($_FILES['edit_image_id']['tmp_name']))
            &&
            (file_exists($_FILES['edit_image_dismissal']['tmp_name']) || is_uploaded_file($_FILES['edit_image_dismissal']['tmp_name']))
        ) {
            $sql = "
            UPDATE 
                staff
            SET
                staff_name ='$name',
                staff_nrc ='$full_nrc',
                staff_dept_name = '$dept',
                staff_position = '$position',
                staff_cdm_start_date = '$cdm_start_date',
                staff_contact = '$contact',
                staff_transfer_acc = '$transfer_acc',
                staff_dismissal_photo = '$image2_name',
                staff_cdm_status = '$cdm_status',
                staff_crph_id = '$crph_id',
                update_user = '$user_check',
                update_date = '$update_date',
                image_path = '$file_full_nrc',
                staff_delete_flag = '0'
            WHERE
                staff_id = '$staff_id';";
            //move update picture to new location
            if ( ! is_dir($target1)) {
               mkdir($target1, 0755);
            }
            $target1 .= "/".$get_nrc_file_name;
            $target2 .= "/".$image2_name;
            if(move_uploaded_file($_FILES['edit_image_dismissal']['tmp_name'],$target2)){
                $fileMoved = rename($exist_nrc_image, $target1);

                if($fileMoved){
                    echo 'File Upload Success!';
                }
            }
            else
            {
                echo "File can't upload";
            }
        }
        else{
            $sql .= "
            UPDATE 
                staff
            SET
                staff_name ='$name',
                staff_nrc ='$full_nrc',
                staff_dept_name = '$dept',
                staff_position = '$position',
                staff_cdm_start_date = '$cdm_start_date',
                staff_contact = '$contact',
                staff_transfer_acc = '$transfer_acc',
                staff_nrc_photo = '$image1_name',
                staff_dismissal_photo = '$image2_name',
                staff_cdm_status = '$cdm_status',
                staff_crph_id = '$crph_id',
                update_user = '$user_check',
                update_date = '$update_date',
                image_path = '$file_full_nrc',
                staff_delete_flag = '0'
            WHERE
                staff_id = '$staff_id';";
            //move update picture to new location
            if ( ! is_dir($target1)) {
               mkdir($target1, 0755);
            }
            $target1 .= "/".$image1_name;
            $target2 .= "/".$image2_name;
            if(move_uploaded_file($_FILES['edit_image_id']['tmp_name'],$target1) && 
                move_uploaded_file($_FILES['edit_image_dismissal']['tmp_name'],$target2)){
               echo "File uploaded.";
            }
            else
            {
                echo "File can't upload";
            }
        }
        if (mysqli_query($conn, $sql)) {
            header("Location: home.php");
        } else {
           echo "Error: " . $sql . ":-" . mysqli_error($conn);
        }
        mysqli_close($conn);
   }
?>