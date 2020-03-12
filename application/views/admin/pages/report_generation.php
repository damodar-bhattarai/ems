<div class="contents">
  <div class="con-head sp-btn">
      <h4>Report Generation</h4>
      <a href="<?= site_url('admin/dashboard'); ?>" id="small-link"> <i class="fa fa-long-arrow-left" aria-hidden="true"></i> &nbsp;Go back to Dashboard</a>
  </div>
  
  <div class="box">
  <div class="box-head">
      <p>Search Staff</p>
  </div>
  <div class="box-body">
    <form>
      <div class="sp-btn" style="margin-right: 10px;">
        <div class="form-div"  style="width: 49%; margin-right: 10px;">
            <label>Staff Id</label>
            <input type="text" name="" required="required">
        </div>  
        <div class="form-div"  style="width: 49%; margin-right: 10px;">
          <label>From</label>
          <input type="date" name=""  value="<?php echo date('Y-m-d');?>">
        </div>
        <div class="form-div"  style="width: 49%; margin-right: 10px;">
          <label>To</label>
          <input type="date" name=""  value="<?php echo date('Y-m-d');?>">
        </div>
      <div class="form-div"  style="width: 49%; margin-right: 10px;">
          <label>Order</label>
          <select>
            <option>Ascending</option>
            <option>Descending</option>
          </select>
      </div>
    </div>
    <button type="submit" class="sub">Submit</button>
    </form>
   
  </div>
</div>

  <div class="box">
  <div class="box-head">
      <p>Search Results</p>
    </div>
  <div class="box-body table-responsive" style="overflow-x:auto; ">
    <table class="table table-bordered hover employee_table" id="report-generation">
      <thead class="thead-dark">
        <tr>
          <th style="width: 2%; background: linear-gradient(#fff, #d1d2d4); color: #000; border: 1px solid #dee2e6"><div class="sp-btn"><span>Id</span><i class="fa fa-sort" aria-hidden="true"></i></div></th>
          <th style="width: 2%; background: linear-gradient(#fff, #d1d2d4); color: #000; border: 1px solid #dee2e6"><div class="sp-btn"><span>Title</span><i class="fa fa-sort" aria-hidden="true"></i></div></th>
          <th style="width: 25%; background: linear-gradient(#fff, #d1d2d4); color: #000; border: 1px solid #dee2e6"><div class="sp-btn"><span>Name</span><i class="fa fa-sort" aria-hidden="true"></i></div></th>
          <th style="width: 15%; background: linear-gradient(#fff, #d1d2d4); color: #000; border: 1px solid #dee2e6"><div class="sp-btn"><span>Department</span><i class="fa fa-sort" aria-hidden="true"></i></div></th>
          <th style="width: 15%; background: linear-gradient(#fff, #d1d2d4); color: #000; border: 1px solid #dee2e6"><div class="sp-btn"><span>Nationality</span><i class="fa fa-sort" aria-hidden="true"></i></div></th>
          <th style="width: 15%; background: linear-gradient(#fff, #d1d2d4); color: #000; border: 1px solid #dee2e6"><div class="sp-btn"><span>Highest Degree</span><i class="fa fa-sort" aria-hidden="true"></i></div></th>
          <th style="width: 15%; background: linear-gradient(#fff, #d1d2d4); color: #000; border: 1px solid #dee2e6"><div class="sp-btn"><span>Action</th>

        </tr>
      </thead>
      <tbody>
        <?php 
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
   
  </div>
</div>

</div>


    <!-- js for datatable  -->
<script>
  $(document).ready(function(){
    $('#report-generation').dataTable();
  });
</script>
