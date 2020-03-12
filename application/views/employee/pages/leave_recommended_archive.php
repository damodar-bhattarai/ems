<div class="contents">
  <div class="con-sub-head sp-btn">
      <h5>Archived Leaves</h5>
      <a href="<?= site_url('employee/dashboard'); ?>" id="small-link"> <i class="fa fa-long-arrow-left" aria-hidden="true"></i> &nbsp;Go back to Dashboard</a>
      
  </div>
  <div class="sp-btn">
    <div class="emp-link">
      <a href="<?= site_url('employee/dashboard'); ?>" id="small-link">Active Leaves</a>
      <a href="<?= site_url('employee/leave_recommended_archive'); ?>" id="small-link">Archived Leaves</a>
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
  <div class="box-body" style="overflow-x:auto;">
  <table class="table table-bordered hover employee_table" id="datatable-recommender" >
  <thead >
  <tr>
  <th id="dt-head" width="20%"><div class="sp-btn"><span>Staff Name</span><i class="fa fa-sort" aria-hidden="true"></i></div></th>
  <th id="dt-head" width="10%"><div class="sp-btn"><span>Leave</span><i class="fa fa-sort" aria-hidden="true"></i></div></th>
  <th id="dt-head" width="10%" ><div class="sp-btn"><span>From</span><i class="fa fa-sort" aria-hidden="true"></i></div></th>
  <th id="dt-head" width="10%" ><div class="sp-btn"><span>To</span><i class="fa fa-sort" aria-hidden="true"></i></div></th>
  <th id="dt-head" width="10%" ><div class="sp-btn"><span>Type</span><i class="fa fa-sort" aria-hidden="true"></i></div></th>
  <th  id="dt-head" width="15%"><div class="sp-btn"><span>Performed by</span><i class="fa fa-sort" aria-hidden="true"></i></div></th>
  <th id="dt-head" width="10%" >Status</th>
  <th id="dt-head" width="15%" class="text-center;"  >Action</th>
  </tr>
  </thead>
  <tbody>
  <?php
  foreach ($recommendations as $posts) { ?>
  <tr>
  <td><?php echo $posts['first_name'].' '.$posts['middle_name']. ' '.$posts['last_name']  ; ?></td>
  <td><?php echo $posts['leave_name']; ?></td>
  <td><?php echo $posts['from_date']; ?></td>
  <td><?php echo $posts['to_date']; ?></td>
  <td><?php echo $posts['duration_type']; ?></td>

  <td><?php foreach ($duty_by as $key) {
  if($key['emp_id']==$posts['duty_performed_by'])
  {
  echo $key['first_name'].' '.$key['middle_name']. ' '. $key['last_name']; 
  } }?></td>

  <td><?php if($posts['is_recommended']=='pending'){?> <span class="pending">Pending</span> <?php } if($posts['is_recommended']=='recommended') {?><span class="granted">Recommended </span><?php } if($posts['is_recommended']=='denied') { ?><span class="denied">Denied </span> </td>
  <?php } ?>
<!-- Restore button -->
<td>
    <button class="btn-archive tooltip1 " title="Restore" id="<?php echo $posts['id']; ?>"><i class="fas fa-undo-alt res-color " aria-hidden="true"></i>
      <div class="tooltiptext">
        <p>Are you sure?</p>
        <span class="tip-can">Cancel</span>
        <span class="tip-arch tip-res" id="<?php echo $posts['id']; ?>" onclick="unArchiveRecommendedLeave(<?php echo $posts['id']; ?> )">Restore</span>
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