<?php
      include('config.php');
    if(isset($_POST["Export"])){
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream'); 
    header('Content-Disposition: attachment; filename=staffdata_1000dc.csv'); 
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');
     
    $output = fopen("php://output", "w");
    fputs($output, $bom =( chr(0xEF) . chr(0xBB) . chr(0xBF) ));

    $delimiter = ','; // keep the delimiter as a comma
    $enclosure = "'"; // set the enclosure to a single quote

    fputcsv($output, array('Staff Name', 'NRC', 'Department', 'Position', 'CDM Joining Date',
        'CRPH ID','Contact','Transfer Account'));  
    $query = "SELECT staff_name,staff_nrc,staff_dept_name,staff_position,staff_cdm_start_date,
        staff_crph_id,staff_contact,staff_transfer_acc FROM staff WHERE staff_cdm_status='1';";  
    $result = mysqli_query($conn, $query); 
    while($row = mysqli_fetch_assoc($result))  
    {  
        //fputcsv($output,implode("'", $row));  
        fputcsv($output, $row);
    }  
    fclose($output);  
 }  
?>