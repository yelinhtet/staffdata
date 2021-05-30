<?php  
include('config.php');
if(isset($_POST["staff_id"]))  
 {    
    $output = '';  
      $query = "SELECT * FROM staff WHERE staff_id = '".$_POST["staff_id"]."'";  
      $result = mysqli_query($conn, $query);  
      $output .= '  
      <div class="table-responsive">  
           <table class="table table-bordered">';  
      while($row = mysqli_fetch_array($result))  
      { 
        if($row['staff_cdm_status']==1){
            $cdm = "CDM";
        }
        else{
            $cdm = "Non-CDM";
        }
           $output .= '  
                <tr>  
                     <td width="30%"><label>Name</label></td>  
                     <td width="70%">'.$row['staff_name'].'</td>  
                </tr>  
                <tr>  
                     <td width="30%"><label>NRC</label></td>  
                     <td width="70%">'.$row['staff_nrc'].'</td>  
                </tr>  
                <tr>  
                     <td width="30%"><label>Deptartment</label></td>  
                     <td width="70%">'.$row['staff_dept_name'].'</td>  
                </tr>  
                <tr>  
                     <td width="30%"><label>Position</label></td>  
                     <td width="70%">'.$row['staff_position'].'</td>  
                </tr>  
                <tr>  
                     <td width="30%"><label>CDM Start Date</label></td>  
                     <td width="70%">'.$row['staff_cdm_start_date'].'</td>  
                </tr>
                <tr>  
                     <td width="30%"><label>CRPH ID</label></td>  
                     <td width="70%">'.$row['staff_crph_id'].'</td>  
                </tr>
                <tr>  
                     <td width="30%"><label>Contact</label></td>  
                     <td width="70%">'.$row['staff_contact'].'</td>  
                </tr>
                <tr>  
                    <td width="30%"><label>Transfer by</label></td>  
                    <td width="70%">'.$row['staff_transfer_acc'].'</td>  
                </tr>
                <tr>  
                    <td width="30%"><label>NRC Photo</label></td>  
                    <td width="70%">
                        <img src="'.$row['image_path']."/".$row['staff_nrc_photo'].'" height="250px" width="250px"/>
                    </td>  
                </tr>
                <tr>  
                    <td width="30%"><label>Dismissal Photo</label></td>  
                    <td width="70%">
                        <img src="'.$row['image_path']."/".$row['staff_dismissal_photo'].'" height="250px" width="250px"/>
                    </td>  
                </tr>
                <tr>  
                     <td width="30%"><label>CDM Status</label></td>  
                     <td width="70%">'.$cdm.'</td>  
                </tr>
                ';  
        }
      $output .= "</table></div>";  
      header('Content-Type: image/jpeg');
      echo $output; 
 } 
 else{
    echo "error";
 } 
 ?>