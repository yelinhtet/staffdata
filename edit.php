<?php  
include('config.php');
if(isset($_POST["staff_id"]) && isset($_POST['param'])== "geteditdata")  
{    
    $output = '';  
      $query = "SELECT * FROM staff WHERE staff_id = '".$_POST["staff_id"]."'";
      $result = mysqli_query($conn, $query);

      $state_sql =  "SELECT * FROM state_tbl where 1";
      $state_result = mysqli_query($conn, $state_sql); 

      
      $output .= 
        '<div class="modal-body">
            <form role="form" method="POST" action="update.php" enctype = "multipart/form-data">';

        while($row = mysqli_fetch_array($result))  
        { 
            if($row['staff_cdm_status']==1){
                $cdm = "CDM";
            }
            else{
                $cdm = "Non-CDM";
            }

            $output .= 
                '<input type="hidden" name="_token_edit" value="'.$row['staff_id'].'">
                <div class="form-group">
                    <label class="control-label">Name</label>
                        <div>
                            <input type="text" class="form-control input-md" name="edit_name" 
                            value="'.$row['staff_name'].'" required="">
                        </div>
                </div>
                <div class="form-group">
                    <label class="control-label">NRC</label>
                    <div class="form-inline">
                        <div class="form-group">
                            <div>
                                <select class="form-control select" id="edit_first_nrc" name="edit_first_nrc" data-container="body" required="" onchange="handleSelectChange(event)">
                                    <option value="'.explode("/",$row['staff_nrc'])[0].'"  disabled hidden>select</option>';
                                    $selected_state="";
                                    while($state_row = mysqli_fetch_array($state_result)) {
                                        $selected = "";
                                        if(str_replace(' ','',$state_row['state_no_mm']) == explode("/",$row['staff_nrc'])[0])
                                        {
                                            $selected ="selected";
                                            $selected_state = $state_row['state_no_eng'] ;
                                        }
                                        $output .= 
                                        '<option value="'.$state_row['state_no_eng']."|".$state_row['state_no_mm'].'" '.$selected.'>'.
                                        $state_row['state_no_mm'].'</option>';
                                    }
                                $output .= 
                                '</select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div>
                                <span class="">/</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="call_select_other">
                                <select class="form-control select" id="edit_second_nrc" name="edit_second_nrc" data-container="body" required="">
                                    <option value="'.$selected_state.'" disabled hidden>select</option>';
                                    $nrc_sql =  "SELECT * FROM nrc_tbl where no_id='".$selected_state."'";
                                    $nrc_result = mysqli_query($conn, $nrc_sql); 
                                    while($nrc_row = mysqli_fetch_array($nrc_result)) {
                                        //$output .=
                                        //'<option value="'.$nrc_row['nrc_mm'].'" disabled hidden>select</option>';
                                        $selected = "";
                                        if($nrc_row['nrc_mm'] == explode("(",explode("/",$row['staff_nrc'])[1])[0])
                                        {
                                            $selected ="selected";
                                        }
                                        $output .= 
                                        '<option value="'.$nrc_row['nrc_eng'].'|'.$nrc_row['nrc_mm'].'" '.$selected.'>'.
                                        $nrc_row['nrc_mm'].'</option>';
                                    }
                        $output.='
                                </select>
                            </div>  
                        </div>
                        <div class="form-group">
                            <div>
                                <span class="">(နိုင်)</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div>
                                <input type="number" class="form-control input-md" id="edit_nrc_number" name="edit_nrc_number"
                                oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" 
                                value="'.str_replace("/","",explode("_",$row['image_path'])[1]).'" required="" maxLength="6">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Dept</label>
                            <div>
                                <input type="text" class="form-control input-md" name="edit_dept" 
                                value="'.$row['staff_dept_name'].'" required="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Position(mm/eng)</label>
                            <div>
                                <input type="text" class="form-control input-md" name="edit_position" 
                                value="'.$row['staff_position'].'" required="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Cdm start date</label>
                            <div>
                                <input type="date" class="form-control input-md" name="edit_cdm_start_date" 
                                value="'.$row['staff_cdm_start_date'].'" required="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">CRPH ID</label>
                            <div>
                                <input type="text" class="form-control input-md" name="edit_crphid" 
                                value="'.$row['staff_crph_id'].'">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Contact</label>
                            <div>
                                <input type="text" class="form-control input-md" name="edit_contact" 
                                value="'.$row['staff_contact'].'" required="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Transfer Account</label>
                            <div>
                                <input type="text" class="form-control transfer_acc" name="edit_transfer_acc" 
                                value="'.$row['staff_transfer_acc'].'" required="" size="" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Staff Photo</label>
                            <div>
                                <input type="file" class="form-control upload_nrc" name="edit_image_id" 
                                 />
                                <input type="hidden" name="hidden_edit_image_id" value="'.$row['image_path'].'/'.$row['staff_nrc_photo'].'"/>
                                <img src="'.$row['image_path'].'/'.$row['staff_nrc_photo'].'" height="150px" width="150px"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Dismissal Photo</label>
                            <div>
                                <input type="file" class="form-control upload_dismissal" name="edit_image_dismissal" id="image_dismissal" />
                                <input type="hidden" name="hidden_edit_image_dismissal" value="'.$row['image_path'].'/'.$row['staff_dismissal_photo'].'"/>
                                <img src="'.$row['image_path'].'/'.$row['staff_dismissal_photo'].'" height="150px" width="150px"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div>
                                <select class="form-control select" name="edit_cmd_status" data-container="body" required="">
                                    <option value="" selected disabled hidden>select</option>
                                    <option value="1" ';
                                    if("CDM"==$cdm){ 
                                        $output .= 'selected';
                                    }
                                    $output .= '>CDM</option>
                                    <option value="0" ';
                                    if("Non-CDM"==$cdm){ 
                                        $output .= 'selected';
                                    }
                                    $output .= '>Non-CDM</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div>
                                <button type="submit" name="submit" class="btn btn-default update_btn" value="Submit">
                                Update
                            </button>
                        </div>
                    </div>
                </div>';  
      
        }
        $output .= "</form></div>";  
        header('Content-Type: image/jpeg');
        echo $output; 
}
else if(isset($_POST['param']) && $_POST['param']== "getdropdownvalues")
{
    if(isset($_POST['selectedValue']) && isset($_POST['nrc_data'])){
        $selectedvalue = $_POST['selectedValue'];
        $sbox= '';

        $sbox .='<select class="form-control select" name="edit_second_nrc" data-container="body" required="">
                    <option value="" disabled selected hidden>select</option>';
                    $nrc_sql =  "SELECT * FROM nrc_tbl where no_id='".$selectedvalue."'";
                    $nrc_result = mysqli_query($conn, $nrc_sql); 
                    while($nrc_row = mysqli_fetch_array($nrc_result)) {
                        $selected = "";
                        if($nrc_row['nrc_mm'] == $_POST['nrc_data'])
                        {
                            $selected ="selected";
                        }
                        $sbox .= 
                        '<option value="'.$nrc_row['nrc_eng'].'|'.$nrc_row['nrc_mm'].'" '.$selected.'>'.
                        $nrc_row['nrc_mm'].'</option>';
                    }
        $sbox .= '</select>';
        echo $sbox;   
    }
    else{
        echo "getting nrc error";
    }
}
else if(isset($_POST['param']) && $_POST['param']== "getadddata")
{
    if(isset($_POST['selectedValue'])){
        $selectedvalue = $_POST['selectedValue'];
        $addbox= '';

        $addbox .=' <select class="form-control select" id="add_second_nrc" name="second_nrc" data-container="body" required="">
                    <option value="" disabled selected hidden>select</option>';
                    $nrc_sql =  "SELECT * FROM nrc_tbl where no_id='".$selectedvalue."'";
                    $nrc_result = mysqli_query($conn, $nrc_sql); 
                    while($nrc_row = mysqli_fetch_array($nrc_result)) {
                        $addbox .= 
                        '<option value="'.$nrc_row['nrc_eng'].'|'.$nrc_row['nrc_mm'].'">'.$nrc_row['nrc_mm'].'</option>';                   
                    }
        $addbox .= '</select>';
        echo $addbox;   
    }
    else{
        echo "getting add-nrc error";
    }
}   
else{
    echo "error";
} 
?>