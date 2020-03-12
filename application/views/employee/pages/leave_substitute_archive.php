<div class="contents">
  <div class="con-sub-head sp-btn">
      <h5>Archived Substitute Leaves</h5>
      <a href="<?= site_url('employee/dashboard'); ?>" id="small-link"> <i class="fa fa-long-arrow-left" aria-hidden="true"></i> &nbsp;Go back to Dashboard</a>
      
  </div>
  <div class="sp-btn">
    <div class="emp-link">
      <a href="<?= site_url('employee/dashboard'); ?>" id="small-link">Active Leaves</a>
      <a href="<?= site_url('employee/leave_substitute_archive'); ?>" id="small-link">Archived Leaves</a>
    </div>
  </div>
   <hr class="hr">

<?php  if ($_SESSION['is_recommender'] == 1) {?>

  <div class="box"  id="liststab">
    <!-- area to show success and erorr messages -->
    <div class="ml-3  alert alert-success alert-dismissible fade show" style="display: none;" id="messagediv">
      <p id="showmessage"></p>
      <button type="button" class="close" >&times;</button>
    </div>
    <!-- area finishes here -->
  <div class="box-body">
  <table class="table table-bordered hover employee_table" id="datatable-recommender" >
  <thead >
  <tr>
  <th id="dt-head" width="15%"><div class="sp-btn"><span>Staff Name</span><i class="fa fa-sort" aria-hidden="true"></i></div></th>
  <th id="dt-head" width="10%" ><div class="sp-btn"><span>Date</span><i class="fa fa-sort" aria-hidden="true"></i></div></th>
  <th id="dt-head" width="40%" ><div class="sp-btn"><span>Description</span><i class="fa fa-sort" aria-hidden="true"></i></div></th>
  <th id="dt-head" width="10%" >Status</th>
  <th id="dt-head" width="10%" class="text-center;"  >Action</th>
  </tr>
  </thead>
  <tbody>
  <?php
  foreach ($employee_leaves_substitute as $value) { ?>
                  <tr id="<?php echo $value['slId']; ?>">
                    <td><?php echo $value['e_first_name'] .' '. $value['e_middle_name'] .' '. $value['e_last_name']; ?></td>
                    <td><?php echo $value['date']; ?></td>
                    <td id="substitute-div"><div id="substitute-desc"><?php echo $value['description']; ?></div><span class="tooltiptext-sbs"><?php echo $value['description']; ?></span></td>
                    <td class="status"><?php if ($value['is_approved'] == 'pending') { echo '<span class="pending">Pending</span>'; } else if ($value['is_approved'] == 'approved') { echo '<span class="granted">Granted</span>';  } else if ($value['is_approved'] == 'denied') { echo '<span class="denied">Denied</span>';  } ?> </td>
<!-- Restore button -->
<td>
    <button class="btn-archive tooltip1 " title="Restore" id="<?php echo $value['slId']; ?>"><i class="fas fa-undo-alt res-color " aria-hidden="true"></i>
      <div class="tooltiptext">
        <p>Are you sure?</p>
        <span class="tip-can">Cancel</span>
        <span class="tip-arch tip-res" id="<?php echo $value['slId']; ?>" onclick="unArchiveSubstituteRecord(<?php echo $value['slId']; ?> )">Restore</span>
      </div>
    </button>
  </td>
</tr>
<?php } ?>
</tbody>
</table>
</div>
</div>
<?php } ?>
<!-- leave approval table ends here -->
</div>


<script type="text/javascript">
    $(document).ready(function(){
       $('#datatable-recommender').DataTable({
        "lengthMenu": [ [3,5, 10, 25, -1], [3,5, 10, 25, "All"]],
            "aaSorting": [],  });
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