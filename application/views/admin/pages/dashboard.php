  <div class="contents">
    <div class="con-head">
      <h4>Dashboard</h4>

  
    </div>
    <div class="con-sum">
          <div class="sum-item">
          <a href="<?= base_url('admin');?>/employee_list">
            <div class="item-1 sp-btn">
              <div>
                <i class="fa fa-users" aria-hidden="true"></i>
              </div>
              <div class="hgh-lgt">
                <div class="hl-title">Total Employees</div>
                <div class="hl-cont"><?php echo $count; ?></div>
              </div>
            </div>
             <div class="item-2 sp-btn">
                <div><span>Since this month</span></div>
                <div><span><?php echo $emp_added_this_month; ?> emp. added</span></div>
            </div>
          </a>
          </div>
          <div class="sum-item">
          <a href="<?= base_url('admin');?>/employee_list">
            <div class="item-1 sp-btn">
              <div>
                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
              </div>
              <div class="hgh-lgt">
                <div class="hl-title">Assign Employee</div>
                <div class="hl-cont"><span><em> no. of emp. left to be assigned &nbsp;</em></span><?php echo $remaining; ?></div>
              </div>
            </div>
             <div class="item-2 sp-btn">
                <div><span>Since this month</span></div>
                <div><span>5.35%</span></div>
            </div>
          </a>
          </div>

          <div class="sum-item">
          <a href="<?= base_url('admin');?>/report_generation">
            <div class="item-1 sp-btn">
              <div>
                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
              </div>
              <div class="hgh-lgt">
                <div class="hl-title">Report Generation</div>
                <div class="hl-cont"><span><em>generate report for staff</em></span></div>
              </div>
            </div>
             <div class="item-2 sp-btn">
                <div><span>Since this month</span></div>
                <div><span>5.35%</span></div>
            </div>
          </a>
          </div>


          <!-- <div class="sum-item">
          <a href="<?= base_url('admin'); ?>">
            
          </a>
          </div>
          <div class="sum-item">
          <a href="<?= base_url('admin'); ?>">
            
          </a>
          </div> -->
    </div>
        <!-- <div>
      <div class="con-sub-head">
          <h5>Leave Details</h5>
      </div>
      <div class="box">
      <div class="box-head">
        <div class="sp-btn">
          <p>Employees currently on leave</p>
          <a href="<?= base_url('admin'); ?>">View All</a>
        </div>
      </div>
      <div class="box-body" style="overflow-x:auto;">
        <table class="table" id="datatable-employeesonleave">
          <thead>
            <tr>
              <th>Type of Leave<i class="fa fa-sort" aria-hidden="true"></i></th>
              <th>From<i class="fa fa-sort" aria-hidden="true"></i></th>
              <th>To<i class="fa fa-sort" aria-hidden="true"></i></th>
              <th>No. of Days<i class="fa fa-sort" aria-hidden="true"></i></th>
              <th>Duty Performed by<i class="fa fa-sort" aria-hidden="true"></i></th>
              <th>Recommended By<i class="fa fa-sort" aria-hidden="true"></i></th>
              <th>Approved By<i class="fa fa-sort" aria-hidden="true"></i></th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Casual</td>
              <td>06-19-2019</td>
              <td>06-25-2019</td>
              <td>2</td>
              <td>Graham Mathew</td>
              <td>Asad Cox</td>
              <td>Andrew Dimitri</td>
            </tr>
            <tr>
              <td>Yearly</td>
              <td>06-19-2019</td>
              <td>06-25-2019</td>
              <td>1</td>
              <td>Adam Stevensor</td>
              <td>Benjamin Corke</td>
              <td>Japhet Horton</td>
            </tr>
            <tr>
              <td>Subtitutional</td>
              <td>06-19-2019</td>
              <td>06-25-2019</td>
              <td>3</td>
              <td>Aneseley Brown</td>
              <td>Daneil Gridlestor</td>
              <td>Ian Riggs</td>
            </tr>
            <tr>
              <td>Sick</td>
              <td>06-19-2019</td>
              <td>06-25-2019</td>
              <td>7</td>
              <td>Gerrsd Swan</td>
              <td>Jyane Dodd</td>
              <td>Jaime Well</td>
            </tr>
            <tr>
              <td>Casual</td>
              <td>06-19-2019</td>
              <td>06-25-2019</td>
              <td>4</td>
              <td>Lalita Hunt</td>
              <td>Michael Su</td>
              <td>Peter Gornall</td>
            </tr>
            <tr>
              <td>Yearly</td>
              <td>06-19-2019</td>
              <td>06-25-2019</td>
              <td>6</td>
              <td>Kapil Hunt</td>
              <td>Mike Jhonson</td>
              <td>Mario Dave</td>
            </tr>
            <tr>
              <td>Substitutional</td>
              <td>06-19-2019</td>
              <td>06-25-2019</td>
              <td>1</td>
              <td>Peter Marquis</td>
              <td>Justin Brown</td>
              <td>Mohammad Albert</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    </div> -->


<!-- leave requested by self starts here -->
    <div>
      <div class="con-sub-head">
          <h4>Leave Requests</h4>
      </div>
      <div class="box">
      <div class="box-head">
        <p>Recently Requested Leaves by Employees</p>
      </div>
      <div class="box-body"  style="overflow-x:auto; padding-top: 0px;">
        <table class="table table-bordered hover employee_table" id="datatable-leaverequests" >
          <thead class="thead-dark">
            <tr>
               <th id="dt-head" style="width: 8%;"><div class="sp-btn"><span>Staff Name</span><i class="fa fa-sort" aria-hidden="true"></i></div></th> 
              <th id="dt-head" style="width: 8%;"><div class="sp-btn"><span>Type of Leave</span><i class="fa fa-sort" aria-hidden="true"></i></div></th>
              <th id="dt-head" width="5%" ><div class="sp-btn"><span>Type</span><i class="fa fa-sort" aria-hidden="true"></i></div></th>
              <th id="dt-head" style="width: 7%;"><div class="sp-btn"><span>From</span><i class="fa fa-sort" aria-hidden="true"></i></div></th>
              
              <th id="dt-head" style="width: 7%;"><div class="sp-btn"><span>To</span><i class="fa fa-sort" aria-hidden="true"></i></div></th>
              <th id="dt-head" style="width: 1%;"><div class="sp-btn"><span>Duration</span><i class="fa fa-sort" aria-hidden="true"></i></div></th>

              <th id="dt-head" style="width: 8%;"><div class="sp-btn"><span>Recommender</span><i class="fa fa-sort" aria-hidden="true"></i></div></th>
              <th id="dt-head" style="width: 9%;"><div class="sp-btn"><span>Approver</span><i class="fa fa-sort" aria-hidden="true"></i></div></th>

              <th id="dt-head" style="width: 15%;"><div class="sp-btn"><span>Duty Performed by</span><i class="fa fa-sort" aria-hidden="true"></i></div></th>
              <th id="dt-head" style="width: 5%; text-align: center;"><div class="sp-btn"><span>Status</span><i class="fa fa-sort" aria-hidden="true"></i></div></th>
            </tr>
          </thead>
          <tbody>
            <?php
                foreach ($employee_leaves_all as $value) { 
                $CI =& get_instance(); $checkRecommender=$CI->checkstatus($value['recommender_id']);
                 $CI =& get_instance(); $checkApprover=$CI->checkstatus($value['approver_id']);

                  if($checkRecommender=="absent"&&$checkApprover=="absent") 
                    $bothabsent="true";
                  else $bothabsent="false";
                  ?>
                  <tr>
                    <td><?php echo $this->Admin_model->getName($value['emp_id']); ?></td>
                    <td><?php echo $value['leave_name']; ?></td>

                    <td><?php echo ucfirst($value['duration_type']).'-day'; ?></td>
                    <td><?php echo $value['from_date']; ?></td>
                    <td><?php echo $value['to_date']; ?></td>
                    <td><?php if ($value['to_date'] != NULL) echo round((strtotime($value['to_date']) - strtotime($value['from_date'])) / 86400) + 1; ?></td>
                    <td>
                      <?php  
                $rec= $value['is_recommended'];
                $app= $value['is_approved'];
                if($rec=="pending" ){
                        if($checkRecommender=="present"){?>
                        <i class="fa fa-circle " style="color: green" aria-hidden="true"></i>
                       <?php } else{ ?>
                        <i class="fa fa-circle " style="color: red" aria-hidden="true"></i>
                       <?php } }?>
                       &nbsp;

                     <?php echo $this->Admin_model->getName($value['recommender_id']);?>
<?php if($checkRecommender!="present" &&$value['is_recommended']=="pending" ){ ?>
<?php if($bothabsent=="false"){ ?>
<center>                                          
<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#exampleModal">
 Assign Another
</button>
</center>
                                         <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">List of Present Employees</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Select a temporary recommender for the staff from the dropdown below.
        <br><br>
                      <select class="custom-select" style="width: 100%;"  id="tempRecommender" >
                          <option value="">Select option</option>
                          <?php foreach ($managerList as $row) {
                          if($_SESSION['current_employee_id']==$row['emp_id']) continue;
                          ?>

                          <option <?php if($assigned!=''&&$assigned['recommender_id']==$row['emp_id']) echo "selected";?>  value="<?php echo $row['emp_id'];?>"><?php echo $row['first_name'].' '.$row['middle_name'].' '.$row['last_name'];?></option>
                          <?php } ?>
                        </select> 
        <br>
        <br>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" onclick="assignRecTemp(<?php echo $value['id'];?>)" class="btn btn-primary">Assign</button>
      </div>
    </div>
  </div>
</div>
<?php } }?> 
                    </td>
                    <td>
                      <?php 
                      
                        $rec= $value['is_recommended'];
                        $app= $value['is_approved'];
                  if($app=="pending"){
                        if($checkApprover=="present"){?>
                        <i class="fa fa-circle " style="color: green" aria-hidden="true"></i>
                       <?php } else{ ?>
                      <i class="fa fa-circle " style="color: red" aria-hidden="true"></i>
                       <?php } }?>
                       &nbsp;
                    <?php echo $this->Admin_model->getName($value['approver_id']);?>
                          <br>
                          <?php if($checkApprover!="present" &&$value['is_recommended']=="recommended") { ?>

          <button type="button" onclick="approveByAdmin(<?php echo $value['id'];?>)" class="btn btn-success btn-sm" style="width: 100%;" >Approve</button>
<?php } ?>
                      

                    </td>
                    <td><?php echo $value['first_name'] .' '. $value['middle_name'] .' '. $value['last_name']; ?></td>
                    <td><?php if ($value['is_approved'] == 'denied' || $value['is_recommended'] == 'denied') { echo '<span class="denied">Denied</span>';  } else if ($value['is_approved'] == 'approved') { echo '<span class="granted">Approved</span>'; } else if ($value['is_recommended'] == 'recommended') { echo '<span class="pending">Recommended</span>';  } else { echo '<span class="pending">Pending</span>';} ?>
                      <?php if($bothabsent=="true" && $value['is_recommended']!="recommended"){ ?>
                         <button type="button" onclick="approveAllByAdmin(<?php echo $value['id'];?>)" class="btn btn-success btn-sm" style="width: 100%;" >Approve</button>
                       <?php }?>
                    </td>
                  </tr>
                <?php }
                 ?>
          </tbody>
        </table>

      </div>
    </div>
    </div>
  </div>  
<!-- leave requested by self ends here -->
</div>  
    


    <!-- js for datatable  -->
<script>
  $(document).ready(function(){
    $('#datatable-leaverequests').dataTable();
  });

   $(document).ready(function(){
    $('#datatable-employeesonleave').dataTable();
  });
</script>