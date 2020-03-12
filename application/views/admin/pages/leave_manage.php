<div class="contents">
  <!-- title area -->
  <div class="con-sub-head sp-btn">
    <h5 class="ml-2">Leaves</h5>
    <a href=" <?= site_url('admin/dashboard'); ?>" id="small-link" class="mr-3">
      <i class="fa fa-long-arrow-left" aria-hidden="true"></i> &nbsp;Go back to Dashboard
    </a>
  </div>
        <!-- area to show success and erorr messages -->
    <div class="ml-3  alert alert-success alert-dismissible fade show" style="display: none;" id="messagediv">
      <p id="showmessage"></p>
      <button type="button" class="close" >&times;</button>
    </div>
    <!-- area finishes here -->

  <!-- View list div -->
  <div class="row leave-packages"  >

    <!-- left table area box-->
    <div class="box col-md-7  shadow-sm p-3 mb-5 bg-white rounded">
      <div class="box-head">
        List
      </div>
      <div class="box-body overflow-auto"  style="height:25em;">
        <div id="leavetable">
        <table  id="leave" class="table table-striped table-bordered  ">
          <thead class="">
            <tr>
              <th class="text-center" width="1%">SN</th>
              <th class="text-center" width="80%">Leave Name</th>
              <th class="text-center" width="19%">Action</th>
            </tr>
          </thead>
          <!-- table body -->
          <tbody>
            <?php $sn =1; ?>
            <?php foreach ($posts as $value=>$post) { 
              if($post['leave_name']=="Substitute") continue;
              $assigned=false;
              foreach($assignedLeave as $aLeave){
                if($aLeave['leave_id']==$post['leave_id']){
                  $assigned=true; 
                  break;
                }
                
              } ?>
            <tr id="
              <?php echo $post['leave_id']; ?>">
              <td class="text-center">
                <?php echo $sn; $sn++ ?>
              </td>
              <td class="">
                <?php echo $post['leave_name'];?>
              </td>
              <td class="text-center">
             
                    <button  class="btn" onclick="editLeave(<?php echo $post['leave_id'];?>)" >
                <i class="fas fa-edit" aria-hidden="true"></i>
                </button>

               <!-- delete leave button start -->
               <?php if($assigned==false){ ?>
                <a href="#leaveModal<?php echo $post['leave_id']; ?>" class="trigger-btn" data-toggle="modal">
                  <i class="fa fa-trash text-danger" aria-hidden="true"></i>
                </a>
               <!-- delete leave button end -->
              <?php } ?>
              <!-- restrict delete leave button start -->
               <?php if($assigned==true){ ?>
                <a href="#resleaveModal<?php echo $post['leave_id']; ?>" class="trigger-btn" data-toggle="modal">
                  <i class="fa fa-trash text-danger" aria-hidden="true"></i>
                </a>
               <!-- restrict delete leave button end -->
              <?php } ?>


                <div id="leaveModal<?php echo $post['leave_id']; ?>" class="modal fade">
                  <div class="modal-dialog modal-confirm">
                    <div class="modal-content" >
                      <div class="modal-header">

                        <h4 class="modal-title">Confirm Delete?</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      </div>

                      <div class="modal-footer">
                        <button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
                        <input type="button" class="btn btn-danger" value="Delete" onclick="deleteLeave(<?php echo $post['leave_id']; ?>)">
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- restrict deleting leave assigned to package  -->

                   <div id="resleaveModal<?php echo $post['leave_id']; ?>" class="modal fade">
                  <div class="modal-dialog modal-confirm">
                    <div class="modal-content" >
                      <div class="modal-header">
                        <h4 class="modal-title text-danger">Unable to delete</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      </div>
                      <div class="modal-body text-danger">
                        <p>Leave is assigned to package so can't be deleted</p>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-info" data-dismiss="modal">Go Back</button>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- restrict message box eends here -->

                </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
          </div>
        </div>
      </div>
      <!-- left box ends -->

      <!-- right form area -->
      <div class="box col-md-4 shadow-sm p-3 mb-5 bg-white rounded"  >
        <div class="box-head" >
        Add new Leave Type
      </div>
        <div class="box-body" >
  
          <form class="form" method="POST" action="">
            <input type="hidden" name="leave_id" id="leave_id" value="<?php if(isset($detailLeave['leave_id'])) echo $detailLeave['leave_id']; ?>">
              <div class="form-div">
                <label>Title</label>
                <input type="text" name="leave_name" id="leave_name" value="<?php if(isset($detailLeave['leave_name'])) echo $detailLeave['leave_name']; ?>">
                </div>
                <div class="sub-can">
                  <input type="button" name="" class="btn btn-success" onclick="saveLeave()" value="Save">
                  <input type="button" name="" class="btn btn-danger" onclick="cancel()" value="Cancel">

                  </div>

                   <div class="form-check ">
                  <input type="checkbox" class="form-check-input" id="is_one_day" <?php if (isset($detailLeave['is_one_day'])) 
                  {if($detailLeave['is_one_day']=='1') {  echo "checked";  } }?>>
                  <label class="form-check-label" for="is_one_day">One day leave only</label>
                </div>
                </form>
              </div>
            </div>
            <!-- right box ends -->
          </div>
          <!-- upper div ends -->
          <!-- for package div -->
          <div class="con-sub-head sp-btn">
            <h5 class="ml-2">Packages</h5>
          </div>
                 <!-- area to show success and erorr messages -->

     <div class="ml-3 alert alert-success alert-dismissible fade show" style="display: none;" id="messagediv1">
      <p id="showmessage1"> </p>
    <button type="button" class="close close1" >&times;</button>
        </div>
 <!-- area finishes here -->
         
          <!-- lower div for packages -->
          <div class="row leave-packages">
            <!-- left table area box-->
            <div class="box col-md-7  shadow-sm p-3 mb-5 bg-white rounded">
              <div class="box-head">
        List
      </div>
              <div class="box-body overflow-auto" style="height:25em;">
              <div id="packagetable">
                <table id="package"  class="table table-bordered ">
                  <thead class="">
                    <tr>

                      <th class="text-center" width="1%">SN</th>
                      <th class=""  width="39%">Package Name</th>
                      <th class=""  width="25%">Leaves</th>
                      <th class="text-center" width="20%">Duration (Days)</th>
                      <th class="text-center"  width="15%">Action</th>

                    </tr>
                  </thead>
                  <!-- table body -->
                  <tbody>
                    <?php 
                    $sn =1;
                     $counts = array_count_values( array_column($packages, 'package_id')); 

                     ?>
                    <?php foreach ($packages as $pack=>$package) {
                      $pkgAssign=false;
                      foreach ($assignedPackage as $apkg) {
                        if($apkg['package_id']==$package['package_id']){
                          $pkgAssign=true;
                          break;
                        }
                       } 
                      ?>
                    
                    <tr id="
                      <?php echo $package['package_id']; ?>">
                      <td class="text-center">
                        <?php echo $sn; $sn++ ?>
                      </td>
                    <!-- packagename -->

                     <td class="">
                        <?php echo $package['package_name']; ?>
                      </td>
                       <?php   
                          $p_id= $package['package_id'];

                            $package_leave= $this->Database_model->find('leave_packages','package_id',$p_id);
                            ?>

                      <td class="">
                         <?php

                            foreach ($package_leave as $key => $value) 
                            {
                              $leave_name= $this->Database_model->find('leaves','leave_id',$value['leave_id']);
                               foreach ($leave_name as $key => $leave_array) 
                               {
                                echo $leave_array['leave_name'].'<br>';
                                }
                            }
                          
                           ?>

                      </td>

                      <!-- duration -->

                     <td class="text-center">
                          <?php   
                          foreach ($package_leave as $key => $value) 
                            {
                              $leave_name= $this->Database_model->find('leaves','leave_id',$value['leave_id']);
                               foreach ($leave_name as $key => $leave_array) 
                               {
                                echo $value['duration'].'<br>';
                                }
                            }
                          
                           ?>

                      </td>

                      <!-- action -->
                      <td class="text-center">
                       <button onclick="editPackage(<?php echo $package['package_id'];?>)" class="btn" title="Edit">

                          <i class="fas fa-edit" aria-hidden="true"></i>
                        </button>
                        <?php if($pkgAssign==false){?>
                        <a href="#packageModal<?php echo $package['package_id']; ?>" class="trigger-btn" data-toggle="modal">
                          <i class="fa fa-trash text-danger" aria-hidden="true"></i>
                        </a>
                      <?php } if($pkgAssign==true){ ?> 
                        <!-- restrict delete btn start -->
                          <a href="#respackageModal<?php echo $package['package_id']; ?>" class="trigger-btn" data-toggle="modal">
                          <i class="fa fa-trash text-danger" aria-hidden="true"></i>
                        </a>
                        <!-- restrict delete btn end -->
                      <?php } ?>

                        <!-- Modal HTML -->
                        <div id="packageModal<?php echo $package['package_id']; ?>" class="modal fade">
                          <div class="modal-dialog modal-confirm">
                            <div class="modal-content" >
                              <div class="modal-header">
                                <h4 class="modal-title">Confirm Delete?</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                              </div>
                        
                              <div class="modal-footer">
                                <button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
                                <input type="button" class="btn btn-danger" value="Delete" onclick="deletePackage(<?php echo $package['package_id']; ?>)">
                                </div>
                              </div>
                            </div>
                          </div>

                            <!-- restrict Modal HTML -->
                        <div id="respackageModal<?php echo $package['package_id']; ?>" class="modal fade">
                          <div class="modal-dialog modal-confirm">
                            <div class="modal-content" >
                              <div class="modal-header">
                                <h4 class="modal-title text-danger">Unable to Delete</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                              </div>
                              <div class="modal-body">
                              <p class="text-danger">This package is assigned to employee.</p>
                              </div>
                        
                              <div class="modal-footer">
                                <button type="button" class="btn btn-info" data-dismiss="modal">Go back</button>
                                
                                </div>
                              </div>
                            </div>
                          </div>

                          <!-- restrict message end -->

                        </td>
                      </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                  </div>
                </div>
              </div>
              <!-- left box ends -->
           
  <!-- right form area -->
    <div class="box col-md-4 shadow-sm p-3 mb-5 bg-white rounded" >
      <div class="box-head">
        Create new Package
      </div>

      <div class="box-body">
        <div id="formdiv">
        <form class="form" method="POST" action="" id="package-form">
          
            <input type="hidden" name="package_id" id="package_id" value="<?php if(isset($detailPackage['package_id'])) echo $detailPackage['package_id']; ?>">
          <div class="form-div">
            <label>Title</label>
            <input type="text" name="package_name" value="<?php if(isset($detailPackage['package_name'])) echo $detailPackage['package_name'];?>" id="package_name">
          </div>

          <div class="form-group row" style="max-height: 300px; overflow-y: scroll;">
            <div class="col-sm-12 text-danger" >
              Select leave type and no. of days for each:
              <hr>
            </div>
            <!-- hiding the substitute leave from leave list on package -->
            <?php foreach ($posts as $key => $leave) { if($leave['leave_name']=="Substitute") continue;?>
            <div class="col-sm-12 "  >
            
        
              <div class="custom-control custom-switch">
              <input 
              <?php 
              if(isset($selectedPackages))
              { 
                foreach ($selectedPackages as $row){
                  if($row['leave_id']==$leave['leave_id']){
                    echo "checked"; 
                    break;
                  }
                } 
              } 
              ?>
              type="checkbox" name="leave-list" onchange="toggleLeave(this)" class="custom-control-input" value="<?php echo $leave['leave_id'];?>" id="pkg-<?php echo $leave['leave_id']; ?>" value="<?php echo $leave['leave_id']; ?>">
              <label class="custom-control-label col-md-8 mb-3" for="pkg-<?php echo $leave['leave_id']; ?>"><?php echo $leave['leave_name']; ?></label>
                <input
              <?php 
              $found=false;
                if(isset($selectedPackages))
                { 
                  foreach ($selectedPackages as $row){
                    $found=false;
                      if($row['leave_id']==$leave['leave_id']){
                        echo 'value="'.$row['duration'].'"';
                        $found=true;
                        break;
                      }  
                  }
                 

                }
                 if($found==false) echo "disabled";
                 
              ?>
               type="number" min="1"  max="365"  style=" width: 5em; height: 2em;" name="duration" id="duration" >
            
            </div>
              </div>
          <?php } ?>
          </div>
          <div class="sub-can">
                <input type="button" name="" class="btn btn-success" onclick="savePackage()" value="Save">
                <input type="button" name="" class="btn btn-danger" onclick="cancel()" value="Cancel">
                
            </div>
         
        </form>
         </div>
        </div>
      </div>  
    </div>
    <!-- right box ends -->
  </div>
  <!-- lower div ends -->


</div>

                </div>
                <!-- end of the template -->
<!-- js -->
 <script >
  $(document).ready(function(){
    $(".close").click(function(){
        $("#messagediv").css('display','none');
    });
});  

   $(document).ready(function(){
    $(".close1").click(function(){
        $("#messagediv1").css('display','none');
    });
});  

</script>