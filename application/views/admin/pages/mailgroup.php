<div class="container-fluid">
 <div class="row" style="justify-content: space-around;">
     
     <div class="col-lg-7">
     		
 


<p class=" h6 text-danger">Notify the following list of emails about the employees on leave everyday at 10 AM.  </p> 
	<h3>List of Emails</h3>
<div id="emailList">
<table id="emailTable" class="table table-striped table-hover table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">S.N</th>
      <th scope="col">Email</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
   <tbody>
   	<?php foreach ($mails as $index => $mail) { ?>
   		
    <tr>
      <th scope="row"><?php echo ++$index;?> </th>
      <td><?php echo $mail['email_address'];?></td>
      <td><i href="#deleteEmail<?php echo $mail['id']; ?>" class="fas fa-trash text-danger"  data-toggle="modal"></i></td>
    </tr>
      <!-- Modal HTML -->
                        <div id="deleteEmail<?php echo $mail['id']; ?>" class="modal fade">
                          <div class="modal-dialog modal-confirm">
                            <div class="modal-content" >
                              <div class="modal-header">
                                <h4 class="modal-title">Confirm Delete?</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                              </div>
                        
                              <div class="modal-footer">
                                <button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
                                <input type="button" class="btn btn-danger" value="Delete" onclick="deleteEmail(<?php echo $mail['id'];?>)">
                                </div>
                              </div>
                            </div>
                          </div>

    <?php } ?>
  </tbody>

</table>
</div>

     </div>
     <div class="col-lg-3">
     	<h3>Add Email</h3>
     <form id="addEmailForm" class="form" method="POST" action="">
            <input type="hidden" name="leave_id" id="leave_id" value="" autocomplete="off">
              <div class="form-div">
                <label>Email <i class="text-danger">*</i></label>
                <input type="text" name="" id="email_add" value="" autocomplete="off">
               
                </div>
                <div class="sub-can">
                  <input type="button" name="" id="addEmailBtn" class="btn btn-success" onclick="addEmail()" value="Save" autocomplete="off">
                  <input type="button" name="" class="btn btn-danger" onclick="this.form.reset()" value="Cancel" autocomplete="off">
                </div>
      </form>
     </div>
    
  </div>
</div>

    <script type="text/javascript" src="<?= base_url('assets/js/notify.min.js') ?>"></script>


<script>
	<?php if(isset($_SESSION['mailMsg'])){
		$msg=$_SESSION['mailMsg'];
		if($msg=="addEmail"){ ?>
			 $.notify("Added Successfully",{className:'success',autoHide:'false' ,autoHideDelay: 1500000});
		<?php } 
		
		if($msg=="maildelete"){ ?>
			$.notify("Deleted Successfully",{className:'success',autoHide:'false' ,autoHideDelay: 1500000});

		<?php } 
		if($msg=="error"){ ?>
			$.notify("Unable to Delete",{className:'error',autoHide:'false' ,autoHideDelay: 1500000});

		<?php } 
		unset($_SESSION['mailMsg']);


		
	}
?>
</script>