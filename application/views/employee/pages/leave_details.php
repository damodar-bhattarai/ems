 <!-- form -->
 <?php extract($leaveDetail);?>
  <div class="contents">
    <div class="con-head sp-btn">
      <h4><?php echo $leave_name;?></h4>
      <a href="<?= site_url('employee/dashboard'); ?>" id="small-link"> <i class="fa fa-long-arrow-left" aria-hidden="true"></i> &nbsp;Go back to Dashboard</a>
    </div>
    <div class="box">
      <div class="box-head">
        <p>Leave Details for <?php echo $leave_name;?></p>
      </div>
      <div class="box-body">
        <div class="leave-dt">
          <div class="dt-part">
            <div class="pt-1">Package Name</div>
            <div class="pt-2">:</div>
            <div class="pt-3"><?php echo $package_name; ?></div>
          </div>
         <div class="dt-part">
            <div class="pt-1">Total No. of Days</div>
            <div class="pt-2">:</div>
            <div class="pt-3"><?php echo $duration; ?></div>
          </div>
          <div class="dt-part">
            <div class="pt-1">No of Leaves taken</div>
            <div class="pt-2">:</div>
            <div class="pt-3"><script type="text/javascript"> document.write(trim_day(<?php echo $taken;?>)); </script></div>
          </div>
          <div class="dt-part">
            <div class="pt-1">No of Leaves Remaining</div>
            <div class="pt-2">:</div>
            <div class="pt-3"><script type="text/javascript"> document.write(trim_day(<?php echo $remain_days;?>)); </script></div>
          </div> 
        </div>
      </div>
    </div>
    <!-- <div class="con-head"> -->
      <!-- <h4>Leaves</h4> -->
    <!-- </div> -->

    
    <div class="box">
      <div class="box-head">
        <p><?php echo $leave_name;?> Details</p>
      </div>
      <div class="box-body" style="overflow-x:auto;">
        
        <table class="table table-bordered hover employee_table" id="leave-details" >
          <thead class="thead-dark">
            <tr>
               <th id="dt-head" style="width: 15%; text-align: center;"><div class="sp-btn"><span>Reason</span><i class="fa fa-sort" aria-hidden="true"></i></div></th>
              <th id="dt-head" style="width: 15%;"><div class="sp-btn"><span>From</span><i class="fa fa-sort" aria-hidden="true"></i></div></th>
              <th id="dt-head" style="width: 15%;"><div class="sp-btn"><span>To</span><i class="fa fa-sort" aria-hidden="true"></i></div></th>
              <th id="dt-head" width="8%" ><div class="sp-btn"><span>Duration Type</span><i class="fa fa-sort" aria-hidden="true"></i></div></th>
              <th id="dt-head" style="width: 8%;"><div class="sp-btn"><span>No. of Days</span><i class="fa fa-sort" aria-hidden="true"></i></div></th>
              <th id="dt-head" style="width: 15%;"><div class="sp-btn"><span>Duty Performed by</span><i class="fa fa-sort" aria-hidden="true"></i></div></th>
              <th id="dt-head" style="width: 5%; text-align: center;"><div class="sp-btn"><span>Status</span><i class="fa fa-sort" aria-hidden="true"></i></div></th>

            </tr>
          </thead>
          <tbody>
            <?php
                foreach ($employee_leaves as $value) { ?>
                  <tr>
                    <td><?php echo $value['leave_name']; ?></td>
                    <td><?php echo $value['from_date']; ?></td>
                    <td><?php echo $value['to_date']; ?></td>
                    <td><?php echo $value['duration_type']; ?></td>
                    <td><?php if ($value['to_date'] != NULL) echo round((strtotime($value['to_date']) - strtotime($value['from_date'])) / 86400) + 1; ?></td>
                    <td><?php echo $value['first_name'] .' '. $value['middle_name'] .' '. $value['last_name']; ?></td>
                    <td><?php if ($value['is_approved'] == 'denied' || $value['is_recommended'] == 'denied') { echo '<span class="denied">Denied</span>';  } else if ($value['is_approved'] == 'approved') { echo '<span class="granted">Approved</span>'; } else if ($value['is_recommended'] == 'recommended') { echo '<span class="pending">Recommended</span>';  } else { echo '<span class="pending">Pending</span>';} ?></td>
                  </tr>
                <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>


<script type="text/javascript">
    $(document).ready(function(){
       $('#leave-details').DataTable({
          /* Disable initial sort */
            "aaSorting": [],        "lengthMenu": [ [5, 10, 25, 50 ,-1], [5 , 10, 25, 50, "All"]],
         /* disable sorting on specific columns */
         // 'columnDefs': [ {
            // 'targets': [1], /* column index */
            // 'orderable': false, /* true or false */
         // }]
       });
    });
  </script>