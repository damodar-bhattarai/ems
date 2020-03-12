<div class="contents">
  <div class="con-sub-head sp-btn">
      <h5>Archived Leaves</h5>
      <a href="<?= site_url('employee/dashboard'); ?>" id="small-link"> <i class="fa fa-long-arrow-left" aria-hidden="true"></i> &nbsp;Go back to Dashboard</a>
      
  </div>
  <div class="sp-btn">
    <div class="emp-link">
      <a href="<?= site_url('employee/dashboard'); ?>" id="small-link">Active Leaves</a>
      <a href="<?= site_url('employee/leave_approve_archive'); ?>" id="small-link">Archived Leaves</a>
    </div>
  </div>
   <hr class="hr">


<!-- leave approval table starts -->
    <?php if ($_SESSION['is_approver'] == 1) { ?>
    <div class="box">
        
        <div class="box-body" style="overflow-x:auto;">
        <div id="lists-approvelist">
        <table class="table table-bordered hover employee_table" id="datatable-approval" >
          <thead class="thead-dark">
            <tr>
              <th id="dt-head" style="width: 13%;"><div class="sp-btn"><span>Employee Name</span><i class="fa fa-sort" aria-hidden="true"></i></div></th>
              <th id="dt-head" style="width: 10%;"><div class="sp-btn"><span>Type of Leave</span><i class="fa fa-sort" aria-hidden="true"></i></div></th>
              <th id="dt-head" style="width: 8%;"><div class="sp-btn"><span>From</span><i class="fa fa-sort" aria-hidden="true"></i></div></th>
              <th id="dt-head" width="7%"><div class="sp-btn"><span>Type</span><i class="fa fa-sort" aria-hidden="true"></i></div></th>
              <th id="dt-head" style="width: 8%;"><div class="sp-btn"><span>To</span><i class="fa fa-sort" aria-hidden="true"></i></div></th>
              <th id="dt-head" style="width: 10%;"><div class="sp-btn"><span>No. of Days</span><i class="fa fa-sort" aria-hidden="true"></i></div></th>
              <th id="dt-head" style="width: 13%;"><div class="sp-btn"><span>Duty Performed by</span><i class="fa fa-sort" aria-hidden="true"></i></div></th>
              <th id="dt-head" style="width: 13%;"><div class="sp-btn"><span>Recommended by</span><i class="fa fa-sort" aria-hidden="true"></i></div></th>
              <th id="dt-head" style="width: 10%; text-align: center;"><div class="sp-btn"><span>Status</span><i class="fa fa-sort" aria-hidden="true"></i></div></th>
              <th id="dt-head" style="width: 10%; text-align: center;">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
                foreach ($employee_leaves_approve as $value) { ?>
                  <tr id="<?php echo $value['id']; ?>">
                    <td><?php echo $value['e_first_name'] .' '. $value['e_middle_name'] .' '. $value['e_last_name']; ?></td>
                    <td><?php echo $value['leave_name']; ?></td>
                    <td><?php echo $value['from_date']; ?></td>
                    <td><?php echo $value['duration_type']; ?></td>
                    <td><?php echo $value['to_date']; ?></td>
                    <td><?php if ($value['to_date'] != NULL) echo round((strtotime($value['to_date']) - strtotime($value['from_date'])) / 86400) + 1; ?></td>
                    <td><?php echo $value['dpb_first_name'] .' '. $value['dpb_middle_name'] .' '. $value['dpb_last_name']; ?></td>
                    <td><?php echo $value['eaid_first_name'] .' '. $value['eaid_middle_name'] .' '. $value['eaid_last_name']; ?></td>
                    <td class="status"><?php if ($value['is_approved'] == 'pending') { echo '<span class="pending">Pending</span>'; } else if ($value['is_approved'] == 'approved') { echo '<span class="granted">Granted</span>';  } else if ($value['is_approved'] == 'denied') { echo '<span class="denied">Denied</span>';  } ?> </td>
                      <td>
                        <!-- restore button -->
                        <button class="btn-archive tooltip1 " title="Restore" id="<?php echo $value['id']; ?>"><i class="fas fa-undo-alt res-color " aria-hidden="true"></i>
                          <div class="tooltiptext">
                            <p>Are you sure?</p>
                            <span class="tip-can">Cancel</span>
                            <span class="tip-arch tip-res" id="<?php echo $value['id']; ?>" onclick="unArchiveApprovedLeave(<?php echo $value['id']; ?> )">Restore</span>
                          </div>
                        </button>
                      </td>
                  </tr>
                <?php } ?>
          </tbody>
        </table>
      </div>
      </div>
    </div>
  
    <?php } ?>
<!-- leave approval table ends here -->
</div>


<script type="text/javascript">
$(document).ready(function(){
         $('#datatable-approval').DataTable({
            /* Disable initial sort */
              "aaSorting": [],        
              "lengthMenu": [ [3,5, 10, 25 ,-1], [3,5, 10, 25, "All"]],
           /* disable sorting on specific columns */
           'columnDefs': [ {
              'targets': [9], /* column index starting from 0*/
              'orderable': false, /* true or false */
           }]
         });
      });

// restore
 $('.tip-can').click(function(ev) {
    $(this).parent().css({"display": "none"});
    ev.stopPropagation();
  });

  $('.table tr .btn-archive').click(function(ev) {
    $(this).children()[1].style.display = 'block';
    ev.stopPropagation();
  });

</script>