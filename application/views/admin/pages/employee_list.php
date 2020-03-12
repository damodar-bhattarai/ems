<div class="contents">
  <div class="con-sub-head sp-btn">
      <h5>Staff</h5>
      <a href="<?= site_url('admin/dashboard'); ?>" id="small-link"> <i class="fa fa-long-arrow-left" aria-hidden="true"></i> &nbsp;Go back to Dashboard</a>
  </div>
    <?php if(isset($post['errorpage'])&&$post['errorpage']=="true"){ ?>
          <div class="h1 text-center" id="showerror">
              No Staff Found
          </div>
        <?php } ?>
        
  <div class="sp-btn align-bottom">
    <div class="emp-link">
      <a href="<?= site_url('admin/employee_list'); ?>" id="small-link">Staff List</a>
      <a href="<?= site_url('admin/employee_archive'); ?>" id="small-link">Archived Staff</a>
    </div>
  </div>
   <hr class="hr">
  <div class="box" id="table-area">
  <div class="box-head">
    <div class="sp-btn">
<!-- user icon -->
       <p><i class="fa fa-users" aria-hidden="true" style="font-size: 0.9em;"></i> Registered Users</p>
       <div class="arch-msg-div"></div>
        <!-- <form class="form-inline my-2 my-lg-0" method="POST" action=" <?= site_url('admin/employee_search'); ?>">
      <input class="form-control mr-sm-2" type="text" style="width: 300px;" placeholder="Search" aria-label="Search" name="search_emp" required="required">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
   </form> -->
    </div>
  </div>
  <div class="box-body table-responsive" style="overflow-x:auto;">
    <table class="table table-bordered hover employee_table" id="datatable" >
      <thead class="thead-dark">
        <tr>
          <th id="dt-head" style="width: 2%;"><div class="sp-btn"><span>Id</span><i class="fa fa-sort" aria-hidden="true"></i></div></th>
          <th id="dt-head" style="width: 2%;"><div class="sp-btn"><span>Title</span><i class="fa fa-sort" aria-hidden="true"></i></div></th>
          <th id="dt-head" style="width: 25%;"><div class="sp-btn"><span>Name</span><i class="fa fa-sort" aria-hidden="true"></i></div></th>
          <th id="dt-head" style="width: 15%;"><div class="sp-btn"><span>Department</span><i class="fa fa-sort" aria-hidden="true"></i></div></th>
          <th id="dt-head" style="width: 15%;"><div class="sp-btn"><span>Nationality</span><i class="fa fa-sort" aria-hidden="true"></i></div></th>
          <th id="dt-head" style="width: 15%;"><div class="sp-btn"><span>Highest Degree</span><i class="fa fa-sort" aria-hidden="true"></i></div></th>
          <th id="dt-head" style="width: 15%;">Action</th>

        </tr>
      </thead>
      <tbody>
        <?php
          $user_not_found = FALSE;
          if (isset($posts['user_not_found']) && $posts['user_not_found']==TRUE) $user_not_found=TRUE;
        // echo $posts;  die();
          if ($user_not_found != TRUE) {
 
            foreach ($posts as $value=>$post) { 
              // check archived or not           ?>
              <tr id="<?php echo $post['emp_id']; ?>">
                <td><?php echo $post['emp_id']; ?></td>
                <td><?php echo $post['title']; ?></td>
                <td><?php echo $post['first_name'] . ' ' . $post['middle_name'] . ' ' .  $post['last_name']; ?></td>
                <td><?php echo $post['department_name']; ?></td>
                <td><?php echo $post['nationality']; ?></td>
                <td><?php echo $post['highest_degree']; ?></td>
                <td>
                  <button class="btn-edit" title="Edit"><i class="fas fa-edit" aria-hidden="true"></i></button>
                  <button class="btn-archive tooltip1" title="Delete" id="<?php echo $post['emp_id']; ?>"><i class="fa fa-trash" aria-hidden="true"></i>
                    <div class="tooltiptext">
                      <p>Are you sure?</p>
                      <span class="tip-can">Cancel</span>
                      <span class="tip-arch" id="<?php echo $post['emp_id']; ?>" onclick="archiveEmployee(<?php echo $post['emp_id']; ?>)" >Delete</span>
                    </div>
                  </button>
                </td>
              </tr>

            <?php
            
            }
          }
        ?>
      </tbody>
    </table>
        <?php
          if ($user_not_found == TRUE) {
             echo  '<h4 style="text-align: center; margin-top: 30px;">Staff Not Found!!!</h4>';
          }
        ?>
<!-- <div class="page-limit sp-btn">
    <i id="sh-ent">
      <?php 
        if (!empty($showing_entries)) 
          echo 'Showing <i id="from">' . $showing_entries['from'] . '</i> to <i id="to">' . $showing_entries['to'] . '</i> of <i id="total">' . $showing_entries['total'] . '</i> entries'; 
      ?>
    </i>
    <div>
    <?= $this->pagination->create_links(); ?>
    </div>
</div> -->
  </div>
</div>
</div>

<?php if(isset($_SESSION['empFindError'])&&$_SESSION['empFindError']==true){
 unset($_SESSION['empFindError']); ?>
  <script>
   $('.arch-msg-div').append('<div class="arch-msg text-danger" style="background-color:lightyellow !important"><span><i class="fa fa-info" aria-hidden="true"></i></span><div class="msg-text" ><p>Error</p>Staff Not Found</div></div>');
   $('.arch-msg').bind('animationend webkitAnimationEnd oAnimationEnd MSAnimationEnd', function(e) { $('.arch-msg-div .arch-msg').remove(); });
 </script>

<?php } ?>
  

<script type="text/javascript">


  $('.tip-can').click(function(ev) {
    $(this).parent().css({"display": "none"});
    ev.stopPropagation();
  });

  $('.table tr .btn-archive').click(function(ev) {
    $(this).children()[1].style.display = 'block';
    ev.stopPropagation();
  });

  $('.table tbody tr').click(function() {
    var id = $(this).attr('id');
    window.location =  '<?= site_url('admin/employee_detail/'); ?>' + id;
  });

  $('.table tr .btn-edit').click(function(ev){
    var id = $(this).closest('tr').attr('id');
    window.location =  '<?= site_url('admin/employee_manage/'); ?>' + id;
    ev.stopPropagation();
  });




  $('.table tr .btn-archive .tip-arch').click(function(){
    var id = $(this).closest('tr').attr('id');
    $(this).closest('tr').remove(); 
    
    // $('#datatable').dataTable().reload();
    // var mytbl = $("#datatable").datatable();
    // mytbl.ajax.reload;
    // $('#datatable').DataTable().ajax.reload();
    // table = $("#datatable").dataTable(); 
     // $("#datatable").fnDestroy();
    




    $('.arch-msg-div').append('<div class="arch-msg"><span><i class="fa fa-check" aria-hidden="true"></i></span><div class="msg-text"><p>Delete Successful !</p>Employee with Id no. ' + id + '  deleted successfully.</div></div>');
    $('.arch-msg').bind('animationend webkitAnimationEnd oAnimationEnd MSAnimationEnd', function(e) { $('.arch-msg-div .arch-msg').remove(); });
    // window.location =  '<?= site_url('admin/employee_list'); ?>';
    // alert('1');

    // // $("#datatable").fnDestroy();
    // $('#datatable').DataTable().clear().destroy();
    // // $("#datatable").dataTable();
    // $(document).ready(function(){

    // alert('3');
    //   $('#datatable').dataTable();
    // alert('4');
    // });
    // // $("#my-button").click(function() {
        
    // // });
    // alert('1');
     // $("#datatable").DataTable().fnReloadAjax('employee_list.php');
     // $("#datatable").api().ajax.reload();
     // $('#datatable').dataTable().api().ajax.reload();

     // $('#datatable').DataTable().destroy();
     // fetch_data();

     // $('#datatable').dataTable().api().ajax.reload();


  });

  $('.arch-msg-div').click(function(){
    $('.arch-msg-div .arch-msg').addClass('msg-remove');
    $('.arch-msg').bind('animationend webkitAnimationEnd oAnimationEnd MSAnimationEnd', function(e) { $('.arch-msg-div .arch-msg').remove(); });
  });

  // $('.tip-arch').click(function(ev) {
  //   alert($(this).attr('id'));
  //   ev.stopPropagation();
  // });


  $(document).ready(function(){
    $('#datatable').dataTable();
  });
</script>