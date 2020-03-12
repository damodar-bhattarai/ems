<!-- X -->
  <div class="contents">
  <div class="con-head">
  <h4>Recommendation Lists</h4>
  </div>

  <div>
  <div class="con-sub-head">
  <!-- <h5>Recent Messages</h5> -->  
  </div>
  <div class="box">
  <div class="box-head">
  <div class="sp-btn">
  <!-- <p>Recent Messages</p> -->
  </div>
  </div>

    <!-- area to show success and erorr messages -->
    <div class="ml-3  alert alert-success alert-dismissible fade show" style="display: none;" id="messagediv">
      <p id="showmessage"></p>
      <button type="button" class="close" >&times;</button>
    </div>
    <!-- area finishes here -->


  <div class="box-body" style="overflow-x:auto;">
    <div class="lists">
  <table class="table table-bordered hover employee_table" id="datatable1" >
  <thead >
  <tr>
  <th width="20%"><div class="sp-btn"><span>Staff Name</span><i class="fa fa-sort" aria-hidden="true"></i></div></th>
  <th width="10%"><div class="sp-btn"><span>Leave</span><i class="fa fa-sort" aria-hidden="true"></i></div></th>
  <th width="10%" ><div class="sp-btn"><span>From</span><i class="fa fa-sort" aria-hidden="true"></i></div></th>
  <th width="10%" ><div class="sp-btn"><span>To</span><i class="fa fa-sort" aria-hidden="true"></i></div></th>
  <th width="10%" ><div class="sp-btn"><span>Type</span><i class="fa fa-sort" aria-hidden="true"></i></div></th>
  <th  width="15%"><div class="sp-btn"><span>Performed by</span><i class="fa fa-sort" aria-hidden="true"></i></div></th>
  <th  width="10%" >Status</th>
  <th  width="15%" class="text-center;"  >Action</th>
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

  <td> 
  <?php if($posts['is_recommended']=='pending') {?>
  <button class="btn btn-primary" onclick="recommendLeave(<?php echo $posts['id']; ?>)">
  <i class="fa fa-arrow-right" aria-hidden="true"></i>Recommend</button> 

   
    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModalCenter<?php  echo $posts['id']; ?>">  Deny </button>
  <?php } else { ?>

    <button  class="" data-toggle="modal" data-target="">  <i class="fa fa-trash text-danger" aria-hidden="true"></i> </button>
  <?php } ?>

<!-- Modal -->
<div class="modal fade" id="exampleModalCenter<?php  echo $posts['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Enter reason for denial</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
     
          <div class="form-group">
          <input class="form-control" type="text" name="" id="denial_reason">
          </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="denyLeave(<?php echo $posts['id']; ?>)">Submit</button>
      </div>
    </div>
  </div>
</div>
  </td>
</tr>
<?php } ?>
</tbody>
</table>
</div>
</div>
</div>
</div>


  <script type="text/javascript">
    $(document).ready(function(){
       $('#datatable1').DataTable({
            "aaSorting": [],  });
    });

    
  </script>
    