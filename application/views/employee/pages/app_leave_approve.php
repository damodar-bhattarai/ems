 <!-- X -->
 <!-- form -->
  <div class="contents">
    <div class="con-head">
      <h4>Leaves</h4>
    </div>
    <div class="box">
      <div class="box-head">
        <p>Approve Leaves</p>
        <div class="arch-msg-div"></div>
      </div>
        <div class="box-body" style="overflow-x:auto;">
        <table class="table table-bordered hover employee_table" id="datatable2" >
          <thead class="thead-dark">
            <tr>
              <th id="dt-head" style="width: 13%;"><div class="sp-btn"><span>Employee Name</span><i class="fa fa-sort" aria-hidden="true"></i></div></th>
              <th id="dt-head" style="width: 10%;"><div class="sp-btn"><span>Type of Leave</span><i class="fa fa-sort" aria-hidden="true"></i></div></th>
              <th id="dt-head" style="width: 10%;"><div class="sp-btn"><span>From</span><i class="fa fa-sort" aria-hidden="true"></i></div></th>
              <th id="dt-head" style="width: 10%;"><div class="sp-btn"><span>To</span><i class="fa fa-sort" aria-hidden="true"></i></div></th>
              <th id="dt-head" style="width: 10%;"><div class="sp-btn"><span>No. of Days</span><i class="fa fa-sort" aria-hidden="true"></i></div></th>
              <th id="dt-head" style="width: 13%;"><div class="sp-btn"><span>Duty Performed by</span><i class="fa fa-sort" aria-hidden="true"></i></div></th>
              <th id="dt-head" style="width: 13%;"><div class="sp-btn"><span>Recommended by</span><i class="fa fa-sort" aria-hidden="true"></i></div></th>
              <th id="dt-head" style="width: 10%; text-align: center;">Status</th>
              <th id="dt-head" style="width: 10%; text-align: center;">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
                foreach ($employee_leaves as $value) { ?>
                  <tr>
                    <td><?php echo $value['e_first_name'] .' '. $value['e_middle_name'] .' '. $value['e_last_name']; ?></td>
                    <td><?php echo $value['leave_name']; ?></td>
                    <td><?php echo $value['from_date']; ?></td>
                    <td><?php echo $value['to_date']; ?></td>
                    <td><?php if ($value['to_date'] != NULL) echo round((strtotime($value['to_date']) - strtotime($value['from_date'])) / 86400) + 1; ?></td>
                    <td><?php echo $value['dpb_first_name'] .' '. $value['dpb_middle_name'] .' '. $value['dpb_last_name']; ?></td>
                    <td><?php echo $value['eaid_first_name'] .' '. $value['eaid_middle_name'] .' '. $value['eaid_last_name']; ?></td>
                    <td class="status"><?php if ($value['is_approved'] == 'pending') { echo '<span class="pending">Pending</span>'; } else if ($value['is_approved'] == 'granted') { echo '<span class="granted">Granted</span>';  }?> </td>
                    <td>
                      <button class="btn-archive tooltip1" title="Approve" id="<?php echo $value['emp_id']; ?>" style="color: #17f089;" <?php if ($value['is_approved'] == 'granted') { echo ' disabled="disabled"';  }?>><i class="fa fa-check" aria-hidden="true"></i>
                        <div class="tooltiptext">
                          <p>Are you sure?</p>
                          <span class="tip-can">Cancel</span>
                          <span class="tip-arch tip-res" onclick="leaveApproveF(<?php echo $value['id']; ?>)" >Grant</span>
                        </div>
                      </button>
                      <button  class="" data-toggle="modal" data-target="">  <i class="fa fa-trash text-danger" aria-hidden="true"></i> </button>
                    </td>
                  </tr>
                <?php } ?>
          </tbody>
        </table>

      </div>


    </div>
  </div>

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



  <script type="text/javascript">

      $(document).ready(function(){
         $('#datatable2').DataTable({
            /* Disable initial sort */
              "aaSorting": [],

           /* disable sorting on specific columns */
           // 'columnDefs': [ {
              // 'targets': [1], /* column index */
              // 'orderable': false, /* true or false */
           // }]
         });
      });

  $('.tip-can').click(function(ev) {
    $(this).parent().css({"display": "none"});
    ev.stopPropagation();
  });

  $('.table tr .btn-archive').click(function(ev) {
    $(this).children()[1].style.display = 'block';
    ev.stopPropagation();
  });

  $('.table tbody tr').click(function() {
    // var id = $(this).attr('id');
    // window.location =  '<?= site_url('admin/employee_detail/'); ?>' + id;
  });

  $('.table tr .btn-edit').click(function(ev){
    $('.modal').css("display", "block");
    ev.stopPropagation();
  });



  function closeModal() {
    var modal = document.getElementById('simpleModal');
    modal.style.display = 'none';
  }

  window.addEventListener('click', outsideClick);
  
  function outsideClick(e) {
    var modal = document.getElementById('simpleModal');
    if (e.target == modal) {
      modal.style.display = 'none';
    }
  }



  $('.table tr .btn-archive .tip-arch').click(function(){
    var id = $(this).closest('tr').attr('id');
    // $(this).closest('tr').remove(); 

    $(this).closest('tr').find('.status span').remove(); 
    $(this).closest('tr').find('.status').append('<span class="granted">Granted</span>'); 
    $(this).closest('.tooltiptext').remove(); 
  
    // $(this).closest('tr').find('.btn-archive')attr('disabled', true);

    $('.arch-msg-div').append('<div class="arch-msg"><span><i class="fa fa-check" aria-hidden="true"></i></span><div class="msg-text"><p>Grant Successful !</p>Leave is granted successfully.</div></div>');
      $('.arch-msg').bind('animationend webkitAnimationEnd oAnimationEnd MSAnimationEnd', function(e) { $('.arch-msg-div .arch-msg').remove(); });
     });

  $('.arch-msg-div').click(function(){
    $('.arch-msg-div .arch-msg').addClass('msg-remove');
    $('.arch-msg').bind('animationend webkitAnimationEnd oAnimationEnd MSAnimationEnd', function(e) { $('.arch-msg-div .arch-msg').remove(); });
  });

    </script>





