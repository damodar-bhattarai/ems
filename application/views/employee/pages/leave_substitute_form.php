 <!-- form -->
 <?php if($_SESSION['is_recommender']==1 || $_SESSION['is_approver']==1) 
 { redirect('employee/dashboard'); }?> 
  <div class="contents">
    <div class="con-head sp-btn">
      <h4>Substitute Application Form</h4>
      <a href="<?= site_url('employee/dashboard'); ?>" id="small-link"> <i class="fa fa-long-arrow-left" aria-hidden="true"></i> &nbsp;Go back to Dashboard</a>
    </div>
    
    <div class="box">
      <div class="box-head">
        <p class="form-title"> Add Substitute Leave </p>
         
        <div class="arch-msg-div">
      <?php if (isset($valid) && $valid==TRUE) { ?>
        <div class="arch-msg"><span><i class="fa fa-check" aria-hidden="true"></i></span><div class="msg-text"><p>Request Successful !</p>Your request has been successflly sent.</div></div>
      <?php } else if (isset($not_valid)) { ?>
        <div class="arch-msg failed"><span><i class="fa fa-times" aria-hidden="true"></i></span><div class="msg-text"><p>Request Failed !</p><?php if (isset($not_valid)) echo $not_valid; ?></div></div>
      <?php } ?>
    </div>
      </div>
     
      <div class="box-body">
        <form class="form" action="<?= site_url('employee/leave_substitute_form'); ?>" method="POST" id="load-btn">
          <input type="hidden" name="emp_id" value="">
          <div class="form-div">
            <label>Date</label>
            <input type="Date" name="date" class="col-md-3" max="<?php echo Date('Y-m-d'); ?>" value="<?php echo Date('Y-m-d'); ?>">
          </div>
          <div class="form-div">
            <label>Description</label>
            <textarea name="description" class="col-md-3" rows="4" required="required"></textarea>
          </div>
        <div class="sub-can" id="submit">
              <button type="submit" name="submit" class="sub" value="submit" id="loading-btn">Submit</button>
        </div>
        </form>
      </div>
    </div>

  </div>

