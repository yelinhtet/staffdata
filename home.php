<?php
   include('session.php');
  $user_check = $_SESSION['login_user'];
  if($user_check== null){
     header("Location: index.php");
  }
  else{
  $ses_sql = mysqli_query($conn,"SELECT * FROM staff where 1");
  $staff_nrc_no='';
  ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>1000DC</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>-->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="src/css/style.css"> 
  <link rel="stylesheet" href="src/css/modal.css">
  <style type="text/css">
    div#show_tbl_filter {
      float: right !important;
    }
  </style>
</head>
<body>
  <div>
    <div class="header-blue">
      <nav class="navbar navbar-dark navbar-expand-md navigation-clean-search">
        <div class="container">
          <img class="navbar-brand navbar-logo" src="src\logo\logo.png"/>
          <h1 class="label label-dc">1000 Donation Campaign</h1>
          <ul class="nav navbar-nav" style="float: right;">
            <li>
              <a style="background-color: white;" href="logout.php">Logout</a>
            </li>
          </ul>
        </div>
      </nav>
      <div class="container hero">
        <div class="row add-donor">
        	<div class="col-12 col-lg-12 col-xl-12">
        		<form class="form-horizontal export_csv" action="exportcsv.php" method="post" name="upload_excel"   
                    enctype="multipart/form-data">
              <div class="form-group">
                <div class="col-md-4">
                  <button type="submit" name="Export" class="btn btn-success">
                    Export CSV <span class="glyphicon glyphicon-export"></span>
                  </button>
                </div>
              </div>                    
          	</form>         
          	<button type="button" class="btn btn-info" data-toggle="modal" data-target="#ModalLoginForm" style="float: right;" data-keyboard="false" data-backdrop="static">
              <span class="glyphicon glyphicon-plus"></span> New Staff
            </button>
		      </div>
        </div>
        <div class="row tbl-box">
          <div class="col-12 col-lg-12 col-xl-12 table-responsive">
            <table id="show_tbl" class="table table-striped table-hover dt-responsive display nowrap"  style="width:100%">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>NRC</th>
                  <th>Dept</th>
                  <th>Position</th>
                  <th>CDM StartDate</th>
                  <th>Contact</th>
                  <th>Transfer Acc</th>
                  <th>CDM Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  $num_rows = mysqli_num_rows($ses_sql);
                  if( $num_rows > 0 ){
                    while($row = mysqli_fetch_assoc($ses_sql))
                    {
                      $staff_nrc_no = $row['staff_nrc'];
                ?>
                <tr>
                  <td>
                    <?php echo $row['staff_name'] ?>
                  </td>
                  <td>
                    <?php echo $row['staff_nrc'] ?>
                  </td>
                  <td>
                    <?php echo $row['staff_dept_name'] ?>
                  </td>
                  <td>
                    <?php echo $row['staff_position'] ?>
                  </td>
                  <td>
                    <?php echo $row['staff_cdm_start_date'] ?>
                  </td>
                  <td>
                    <?php echo $row['staff_contact'] ?>
                  </td>
                  <td>
                    <?php echo $row['staff_transfer_acc'] ?>
                  </td>
                  <td>
                    <?php if($row['staff_cdm_status'] == 1){ echo "CDM";}else{echo "Non-CDM";} ?>
                  </td>                
                  <td>
                    <button class="btn btn-warning edit_data" id="<?php echo $row['staff_id']?>" data-toggle="modal" data-target="#editdataModal" data-keyboard="false" data-backdrop="static">Edit</button>
                    <button class="btn btn-info view_data" id="<?php echo $row['staff_id']?>" data-toggle="modal" data-target="#dataModal" data-keyboard="false" data-backdrop="static">View</button>
                  </td>
                </tr>
                <?php
                  }
                }
                ?>
                <!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" integrity="sha512-K1qjQ+NcF2TYO/eI3M6v8EiNYZfA95pQumfvcVrTHtwQVDG+aHRqLi/ETn2uB+1JqwYqVG3LIvdm9lj6imS/pQ==" crossorigin="anonymous"></script> -->
              </tbody>
            </table>
          </div>
        </div>
    </div>
  </div>
<?php }?>
  
  <div class="modal fade" id="editdataModal" role="dialog">
    <div class="modal-dialog" role="document">  
         <div class="modal-content">
              <div class="modal-header">  
                   <button type="button" class="close" data-dismiss="modal">&times;</button>  
                   <h4 class="modal-title">staff Details</h4>  
              </div>  
              <div class="modal-body"> 
                <div id="edit_staff_detail"></div> 
              </div>  
              <div class="modal-footer">  
                   <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>  
              </div>  
         </div>  
    </div>  
  </div>  

  <div class="modal fade" id="dataModal" role="dialog">
    <div class="modal-dialog" role="document">  
         <div class="modal-content">
              <div class="modal-header">  
                   <button type="button" class="close" data-dismiss="modal">&times;</button>  
                   <h4 class="modal-title">staff Details</h4>  
              </div>  
              <div class="modal-body"> 
                <div id="staff_detail"></div> 
              </div>  
              <div class="modal-footer">  
                   <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>  
              </div>  
         </div>  
    </div>  
  </div>  
  <!-- Modal HTML Markup -->
  <div id="ModalLoginForm" class="modal fade">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title">New Staff</h1>
        </div>
        <div class="modal-body">
          <form role="form" method="POST" action="insert.php" enctype = "multipart/form-data">
            <input type="hidden" name="_token" value="">
            <div class="form-group">
              <label class="control-label">Name</label>
              <div>
                <input type="text" class="form-control input-md" name="name" value="" required="">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label">NRC</label>
              <div class="form-inline">
                <div class="form-group">
                  <div>
                    <select class="form-control select " id="add_first_nrc" name="first_nrc"  onchange="handleSelectChangeAdd(event)" data-container="body" required="">
                      <option value="" selected disabled hidden>select</option>
                    <?php
                      $state_sql =  "SELECT * FROM state_tbl where 1";
                      $state_result = mysqli_query($conn, $state_sql); 
                      $selected_state="";
                      while($state_row = mysqli_fetch_array($state_result)) {
                          $selected = "";
                          if(str_replace(' ','',$state_row['state_no_mm']) == substr($staff_nrc_no,0, 3))
                          {
                              $selected ="selected";
                              $selected_state = $state_row['state_no_eng'] ;
                          }
                          echo "<option value='".$state_row['state_no_eng']."|".$state_row['state_no_mm']."' ".$selected.">".$state_row['state_no_mm']."</option>";
                      }
                    ?>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <div>
                    <span class="">/</span>
                  </div>
                </div>
                <div class="form-group">
                  <div>
                    <select class="form-control select" id="add_second_nrc" name="second_nrc" data-container="body" required="">
                      <option value="" selected disabled>select</option>
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
                    <input type="number" class="form-control input-md" name="nrc_number" value="" required=""
                    oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="6">
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">
                <label class="control-label">Dept</label>
                <div>
                     <input type="text" class="form-control input-md" name="dept" value="" required="">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label">Position(mm/eng)</label>
                <div>
                     <input type="text" class="form-control input-md" name="position" value="" required="">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label">Cdm start date</label>
                <div>
                     <input type="date" class="form-control input-md" name="cdm_start_date" value="" required="">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label">CRPH_ID</label>
                <div>
                     <input type="text" class="form-control input-md" name="crph_id" value="">
                </div>
            </div>
            <div class="form-group">
              <label class="control-label">Contact</label>
              <div>
                   <input type="text" class="form-control input-md" name="contact" value="" required="">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label">Transfer Account</label>
              <div>
                 <input type="text" class="form-control transfer_acc"name="transfer_acc" required="" size="200" />
              </div>
            </div>
            <div class="form-group">
              <label class="control-label">Staff Photo</label>
              <div>
                   <input type="file" class="form-control upload_nrc"name="image_id" id="image_id" required="" />
              </div>
            </div>
            <div class="form-group">
              <label class="control-label">Dismissal Photo</label>
              <div>
                   <input type="file" class="form-control upload_dismissal"name="image_dismissal" id="image_dismissal" required="" />
              </div>
            </div>
            <div class="form-group">
              <label class="control-label">CDM Status</label>
              <div>
                   <select class="form-control select" id="cdm_status" name="cdm_status" data-container="body" required="">
                      <option value="" selected disabled>select</option>
                      <option value="0"> Non-CDM </option>
                      <option value="1" selected>CDM</option>
                    </select>
              </div>
            </div>
            <div class="form-group">
              <div>
                  <button type="submit" name="submit" class="btn btn-default" value="Submit">
                      Add
                  </button>
                  <button id="cancel" type="button" class="btn btn-default" data-dismiss="modal">
                    Cancel
                  </button>
              </div>
            </div>
          </form>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
  <!--<script src="https://code.jquery.com/jquery-3.5.1.js"></script>-->
  <script src="src/js/jquery.dataTables.min.js"></script>
  <script src="src/js/dataTables.bootstrap4.min.js"></script>
    <script>
      $(document).ready(function() {
        $('#show_tbl').DataTable();
      // clear input values
      $('#cancel').on('click', function() {
          $('form').find('input').val('');
      });
    });

  	$('.view_data').click(function(){  
      var staff_id = $(this).attr("id");  
      //alert(staff_id);
      $.ajax({  
        url:"select.php",  
        method:"post",  
        data:{staff_id:staff_id},  
        success:function(data){  
          console.log(data);
          $('#staff_detail').html(data); 
          $('#dataModal').modal("show");
        }  
      });  
    });
    $('.edit_data').click(function(){  
      var staff_id = $(this).attr("id");
      //alert(staff_id);
      $.ajax({  
        url:"edit.php",  
        method:"post",  
        data:{staff_id:staff_id,
          param: "geteditdata"},  
        success:function(data){  
          console.log(data);
          $('#edit_staff_detail').html(data); 
          $('#editdataModal').modal("show");
        }  
       });  
     });
       
    function handleSelectChange(event){
      var selectElement = event.target;
      var value = selectElement.value;
      //alert(value);
      var nrc_data = $("#edit_nrc_number").val();
      //alert(nrc_data);
      $.ajax({  
        url:"edit.php",  
        method:"post",  
        data:{param: "getdropdownvalues",
          selectedValue: value,
          nrc_data:nrc_data},  
          success:function(data){  
            console.log(data);
            $('#edit_second_nrc').html(data);
          }  
      });  
    }
    //select add-data
    function handleSelectChangeAdd(event){
      var selectElement = event.target;
      var value = selectElement.value;
      var str= value.split("|")[0];
      //alert("add-value :" +str);
      $.ajax({  
        url:"edit.php",  
        method:"post",  
        data:{param: "getadddata",
          selectedValue: str},  
          success:function(data){  
            console.log(data);
            $('#add_second_nrc').html(data);
          }  
      });
    }  
    </script>
</body>
</html>