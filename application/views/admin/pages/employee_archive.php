<div class="contents">
  <div class="con-sub-head sp-btn">
      <h5>Archived Staff</h5>
      <a href="<?= site_url('admin/dashboard'); ?>" id="small-link"> <i class="fa fa-long-arrow-left" aria-hidden="true"></i> &nbsp;Go back to Dashboard</a>
      
  </div>
  <div class="sp-btn">
    <div class="emp-link">
      <a href="<?= site_url('admin/employee_list'); ?>" id="small-link">Staff List</a>
      <a href="<?= site_url('admin/employee_archive'); ?>" id="small-link">Archived Staff</a>
    </div>
  </div>
   <hr class="hr">
  <div class="box">
  <div class="box-head">
    <div class="sp-btn">
      <p>Archived Employees</p>
      <div class="arch-msg-div"></div>
    </div>
  </div>
  <div class="box-body table-responsive" style="overflow-x:auto; ">
    <table class="table table-bordered hover employee_table">
      <thead class="thead-dark">
        <tr>
          <th  style="width: 2%; background: linear-gradient(#fff, #d1d2d4); color: #000; border: 1px solid #dee2e6">Id</th>
          <th  style="width: 2%; background: linear-gradient(#fff, #d1d2d4); color: #000; border: 1px solid #dee2e6">Title</th>
          <th  style="width: 25%; background: linear-gradient(#fff, #d1d2d4); color: #000; border: 1px solid #dee2e6">Name</th>
          <th  style="width: 15%; background: linear-gradient(#fff, #d1d2d4); color: #000; border: 1px solid #dee2e6">Department</th>
          <th  style="width: 15%; background: linear-gradient(#fff, #d1d2d4); color: #000; border: 1px solid #dee2e6">Nationality</th>
          <th  style="width: 15%; background: linear-gradient(#fff, #d1d2d4); color: #000; border: 1px solid #dee2e6">Highest Degree</th>
          <th style="width: 15%; background: linear-gradient(#fff, #d1d2d4); color: #000; border: 1px solid #dee2e6">Action</th>

        </tr>
      </thead>
      <tbody>
        <?php 
        // echo $posts;  die();
            foreach ($posts as $post) {
              // check archived or not         ?>
              <tr id="<?php echo $post['emp_id']; ?>">
                <td><?php echo $post['emp_id']; ?></td>
                <td><?php echo $post['title']; ?></td>
                <td><?php echo $post['first_name'] . ' ' . $post['middle_name'] . ' ' .  $post['last_name']; ?></td>
                <td><?php echo $post['department_name']; ?></td>
                <td><?php echo $post['nationality']; ?></td>
                <td><?php echo $post['highest_degree']; ?></td>
                <td>
                  <button class="btn-archive tooltip1" title="Restore" id="<?php echo $post['emp_id']; ?>"><i class="fas fa-undo-alt res-color" aria-hidden="true"></i>
                    <div class="tooltiptext">
                      <p>Are you sure?</p>
                      <span class="tip-can">Cancel</span>
                      <span class="tip-arch tip-res" id="<?php echo $post['emp_id']; ?>" onclick="unArchiveEmployee(<?php echo $post['emp_id']; ?>)" >Restore</span>
                    </div>
                  </button>
                </td>
              </tr>

            <?php
            
            }
        ?>
      </tbody>
    </table>
    <div class="page-limit sp-btn">
    <i>
      <?php 
        if (!empty($showing_entries)) 
          echo 'Showing ' . $showing_entries['from'] . ' to ' . $showing_entries['to'] . ' of ' . $showing_entries['total'] . ' entries'; 
      ?>
    </i>
    <div>
    <?= $this->pagination->create_links(); ?>
    </div>
</div>
  </div>
</div>
</div>

<script type="text/javascript">

  $('.tip-can').click(function(ev) {
    $(this).parent().css({"display": "none"});
    ev.stopPropagation();
  });

  $('.table tr .btn-archive').click(function(ev) {
    $(this).children()[1].style.display = 'block';
    ev.stopPropagation();
  });

  </script>