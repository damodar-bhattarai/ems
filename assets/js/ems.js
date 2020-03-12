


$(document).ready((function ($) {

  $(".menu-icon").on("click", function() {
    $("nav ul").toggleClass("showing");
  });
  $(".sidebar-dropdown > a").click(function() {
    $(".sidebar-submenu").slideUp(200);
    if (
      $(this)
      .parent()
      .hasClass("active")
      ) {
      $(".sidebar-dropdown").removeClass("active");
    $(this)
    .parent()
    .removeClass("active");
  } else {
    $(".sidebar-dropdown").removeClass("active");
    $(this)
    .next(".sidebar-submenu")
    .slideDown(200);
    $(this)
    .parent()
    .addClass("active");
  }
});

  $("#close-sidebar").click(function() {
    $(".page-wrapper").removeClass("toggled");
  });
  $("#show-sidebar").click(function() {
    $(".page-wrapper").addClass("toggled");
  });

}));


$(window).on("scroll", function() {
  if($(window).scrollTop()) {
    $('nav').addClass('black');
  }

  else {
    $('nav').removeClass('black');
  }
})






////////////////////  Disable submit button after a click and display Loading-Buttons /////////////////////

$('#load-btn').submit(function() {
  // $('#btn-leave-form').attr("disable",true);
  $(this).find('#submit #loading-btn').css('display', 'none');
  $(this).find('#submit').append('<div class="sub sub-loading">Processing&nbsp;&nbsp;<i class="fa fa-spinner fa-spin"></i></div>');
});




////////////////////  Trim days /////////////////////

function trim_day(dec_day) {
  
  var day;
  if (dec_day <= 1) 
    day = ' day ';
  else 
    day = ' days ';

  if (dec_day % 1 == 0) 
    return Math.round(dec_day) + day;
  else {
    if (dec_day < 1) {
      return '1/2 ' + day;
    }
    else {
      return Math.floor(dec_day) + ' and 1/2 ' + day;
    }
  }
}

////////////////////  Validating 'from-to' date in Employee Leave Request Form /////////////////////
  
  function validateNoOfDays(remainingDuration, noOfDuration) {
    if (noOfDuration == '1/2') noOfDuration = 0.50; 
    if (parseInt(remainingDuration) < parseInt(noOfDuration)) {
      $("#duration").addClass("bar-completed progress-bar-striped progress-bar-animated remDurationError");
    }
    else {
      $("#duration").removeClass("bar-completed progress-bar-striped progress-bar-animated remDurationError"); 
    }
  }

  $('#leave_name').change(function() {
      if ($('#leave_name').find("option:selected").attr('class') == 1 || $('#leave_name').find("option:selected").text() == 'Substitute Leave') {     // if selected value is 'Casual'
        $('#multiple-days').attr('disabled', true);
        $('#half-day').prop('checked', true);
        $('#to_date').attr('disabled', true);
        $('#duration').val('1/2');
        $('#to_date').val($('#from_date').val());
      }
      else if ($('#leave_name').find("option:selected").text().indexOf('Substitute') !== -1) {     // if selected value is 'Casual'
        $('#multiple-days').attr('disabled', true);
        $('#half-day').prop('checked', true);
        $('#to_date').attr('disabled', true);
        $('#duration').val('1/2');
        $('#to_date').val($('#from_date').val());
      }

      else {
        $('#multiple-days').attr('disabled', false);        
      }
      $('#remDuration').text(trim_day($('#leave_name').find("option:selected").attr('id')));
      validateNoOfDays($('#leave_name').find("option:selected").attr('id'), $('#duration').val());
  });

  $('#half-day').click(function() {
    $('#to_date').attr('disabled', true);
    $('#duration').val('1/2');
    $('#to_date').val($('#from_date').val());
    document.getElementById("from_date").setAttribute("max", false);      // remove max-date when selected
    validateNoOfDays($('#leave_name').find("option:selected").attr('id'), $('#duration').val());
  });

  $('#full-day').click(function() {
    $('#to_date').attr('disabled', true);
    $('#duration').val('1');
    $('#to_date').val($('#from_date').val());
    document.getElementById("from_date").setAttribute("max", false);      // remove max-date when selected
    validateNoOfDays($('#leave_name').find("option:selected").attr('id'), $('#duration').val());
  });

  $('#multiple-days').click(function() {
    $('#duration').val('1');
    $('#to_date').attr('disabled', false);
    document.getElementById("from_date").setAttribute("max", $('#to_date').val());      // from_date validation
    validateNoOfDays($('#leave_name').find("option:selected").attr('id'), $('#duration').val());
  });

  $('#from_date').change(function() {
    document.getElementById("to_date").setAttribute("min", $(this).val());
    if (document.getElementById('multiple-days').checked) {
      $('#duration').val(((Date.parse($('#to_date').val()) - Date.parse($('#from_date').val())) / 86400000)+1);
    } else {
      $('#to_date').val($(this).val());
    }
    validateNoOfDays($('#leave_name').find("option:selected").attr('id'), $('#duration').val());
  });

  $('#to_date').change(function() {
      document.getElementById("from_date").setAttribute("max", $('#to_date').val());      // from_date validation
      $('#duration').val(((Date.parse($('#to_date').val()) - Date.parse($('#from_date').val())) / 86400000)+1);
      validateNoOfDays($('#leave_name').find("option:selected").attr('id'), $('#duration').val());
  });





//####### delete
// var count = 0;

// function slide(form){

//   var count = form.value;
//   var btn = form.childNodes;

//   if (count === "1") {
//     form.nextElementSibling.style.display = 'none';
//     btn[3].innerHTML = '<i class="fa fa-angle-down" aria-hidden="true"></i>';   
//     form.value="0";
//   }
//   else{
//     btn[3].innerHTML = '<i class="fa fa-angle-up" aria-hidden="true"></i>'; 
//     form.nextElementSibling.style.display = 'block';
//     form.value="1";

//   }
// }

  

////////////////////  Drop-down Menu - When Clicking Profile Bar /////////////////////
var temp = 0;
function displayFunctionType() {
  var staff = document.getElementsByClassName('drop-down')[0];

  if (temp % 2 == 0) {
    staff.style.display = 'block';
    temp++; 
  }
  else {
    staff.style.display = 'none';
    temp++;         
  }
}


////////////////////  Notification Messages /////////////////////
$(document).ready(function(){
    // clears web browser cache and prevents from auto filling the input field
    $("form :input").attr("autocomplete", "off");
    $('.arch-msg').bind('animationend webkitAnimationEnd oAnimationEnd MSAnimationEnd', function(e) { $('.arch-msg-div .arch-msg').remove(); });
});

$('.arch-msg-div').click(function(){
    $('.arch-msg-div .arch-msg').addClass('msg-remove');
    $('.arch-msg').bind('animationend webkitAnimationEnd oAnimationEnd MSAnimationEnd', function(e) { $('.arch-msg-div .arch-msg').remove(); });
});





////////////////////  Add Employee through different Tabs /////////////////////

// changes in add 
 function addGeneral()
  {
    var xmlHttp = new XMLHttpRequest();
    xmlHttp.open('POST','addGeneral',true);
    var data = new FormData();
    var first_name =document.getElementById('first_name').value.trim();
    var last_name=document.getElementById('last_name').value.trim();
    var middle_name= document.getElementById('middle_name').value.trim();
    var join_date=document.getElementById('join_date').value.trim();
    var department= document.getElementById('department').value.trim();
    var password= 'changeme';

    var manager = document.getElementById('manager');
    
    //personal data
    var email=document.getElementById('email').value.trim();
    var dob= document.getElementById('birth_year').value+'-'+document.getElementById('birth_month').value+'-'+document.getElementById('birth_day').value;

    if (!vaildateEmail(email)) {  document.getElementById('email').style.borderColor="red";  }
    if (vaildateEmail(email))  { document.getElementById('email').style.borderColor="#ced4da";  }

    if(document.getElementById('birth_month').value == 2 && document.getElementById('birth_day').value> 29 )
    {
       msg="Select appropriate date.";
       showErrormessage(msg,'generalButton');
       return ; 

    }

    else if((document.getElementById('birth_month').value == 4 || document.getElementById('birth_month').value == 6 || document.getElementById('birth_month').value == 9 || document.getElementById('birth_month').value == 11 ) && document.getElementById('birth_day').value> 30 )
    {
       msg="Select appropriate date.";
      showErrormessage(msg,'generalButton');
      return ; 
    }

     else  if(getAge(dob)<18){
         msg="Age cannot be less than 18.";
         showErrormessage(msg,'generalButton');
         return ; 
      } 
      else{
         if(manager.checked)
          data.append('is_manager','true');
        else
          data.append('is_manager','false');

          data.append('gender',document.getElementById('gender').value);
          data.append('dob',dob);
          data.append('email',email);
          data.append('title',document.getElementById('title').value);
          data.append('first_name',first_name);
          data.append('middle_name',middle_name);
          data.append('last_name',last_name);
          data.append('join_date',join_date);
          data.append('password',password);
          data.append('department',department);
          xmlHttp.send(data);

      xmlHttp.onreadystatechange = function()
      {
          if(xmlHttp.readyState==4)
          {

            var status = xmlHttp.responseText;
            var id=JSON.parse(status);


            if(id=="error"){
              msg="Invalid Title Selected";
              showErrormessage(msg,'generalButton');
               return ; 
            }

            if(id=="textonly"){
              msg="Text only in name field";
             showErrormessage(msg,'generalButton');
                return ; 
            }

             if(id=="errorgender"){
              msg="Invalid Gender Selected";
              showErrormessage(msg,'generalButton');
                return ; 
              }

               if(id=="emailInvalid"){
                msg="Invalid Email Id";
               showErrormessage(msg,'generalButton');
                return ; 
              }

              
               if(id=="errorDate"){
                msg="Invalid Date";
               showErrormessage(msg,'generalButton');
                return ; 
              }

               if(id=="errordobDate"){
                msg="Invalid Date of Birth";
               showErrormessage(msg,'generalButton');
                return ; 
              }

           if(isNaN(id))
           {

            if(JSON.parse(status)=='true')
               { 
                $('#spinicon').remove();
                $('#generalButton').css('pointer-events','auto');
                showSuccessmessage('generalButton');
              }
            showresponse('general-form',status,'Added Successfully');

           }
            

          else  {
            location.href='employee_manage/'+id;
          }
          }
      }
}
    }
  

// update general information
 function updateGeneral()
  {
    var xmlHttp = new XMLHttpRequest();
    xmlHttp.open('POST','updateGeneral',true);
    var data = new FormData();
    var first_name =document.getElementById('first_name').value.trim();
    var last_name=document.getElementById('last_name').value.trim();
    var middle_name= document.getElementById('middle_name').value.trim();
    var join_date=document.getElementById('join_date').value.trim();
    var department= document.getElementById('department').value.trim();
    //personal data
    var email=document.getElementById('email').value.trim();
    var dob= document.getElementById('birth_year').value+'-'+document.getElementById('birth_month').value+'-'+document.getElementById('birth_day').value;
    
    var manager = document.getElementById('manager');

    if (!vaildateEmail(email))  { document.getElementById('email').style.borderColor="red";  }
    if (vaildateEmail(email))  { document.getElementById('email').style.borderColor="#ced4da";  }

     if(document.getElementById('birth_month').value == 2 && document.getElementById('birth_day').value> 29 )
    {
       msg="Select appropriate date.";
       showErrormessage(msg,'generalButton');
       return ; 

    }

    else if((document.getElementById('birth_month').value == 4 || document.getElementById('birth_month').value == 6 || document.getElementById('birth_month').value == 9 || document.getElementById('birth_month').value == 11 ) && document.getElementById('birth_day').value> 30 )
    {
       msg="Select appropriate date.";
      showErrormessage(msg,'generalButton');
      return ; 
    }

    else if(new Date(dob)> new Date())
      {
         msg="Invalid Date of Birth";
          showErrormessage(msg,'generalButton');
            return ; 
      }

     else  if(getAge(dob)<18){
         msg="Age cannot be less than 18.";
         showErrormessage(msg,'generalButton');
         return ; 
      } 
      else{
      
          
         if(manager.checked)
          data.append('is_manager','true');
        else
          data.append('is_manager','false');

          data.append('gender',document.getElementById('gender').value);
          data.append('dob',dob);
          data.append('email',email);
          data.append('title',document.getElementById('title').value);
          data.append('first_name',first_name);
          data.append('middle_name',middle_name);
          data.append('last_name',last_name);
          data.append('join_date',join_date);
          data.append('department',department);
          xmlHttp.send(data);

      xmlHttp.onreadystatechange = function()
      {
          if(xmlHttp.readyState==4)
          {

            var status = xmlHttp.responseText;
            var id=JSON.parse(status);


            if(id=="error"){
              msg="Invalid Title Selected";
              showErrormessage(msg,'generalButton');
               return ; 
            }

            if(id=="textonly"){
              msg="Text only in name field";
             showErrormessage(msg,'generalButton');
                return ; 
            }

             if(id=="errorgender"){
              msg="Invalid Gender Selected";
              showErrormessage(msg,'generalButton');
                return ; 
              }

               if(id=="emailInvalid"){
                msg="Invalid Email Id";
               showErrormessage(msg,'generalButton');
                return ; 
              }

              
               if(id=="errorDate"){
                msg="Invalid Date";
               showErrormessage(msg,'generalButton');
                return ; 
              }

           if(isNaN(id))
           {
             $('#spinicon').remove();
               $('#generalButton').css('pointer-events','auto');
               if(id=="true")
            showCustomSuccessmessage('generalButton',"Updated Successfully");
            showresponse('general-form',status,'Updated Successfully');
            
           }
            

          else  {
            location.href='employee_manage/'+id;
          }
          }
      }
}
    }
 
  
  // update general by employee on their profile
 function updateGeneralbyEmployee()
  {
    var xmlHttp = new XMLHttpRequest();
    xmlHttp.open('POST','updateGeneralbyEmployee',true);
    var data = new FormData();
    var email=document.getElementById('email').value;
    var dob= document.getElementById('birth_year').value+'-'+document.getElementById('birth_month').value+'-'+document.getElementById('birth_day').value;
    var gender =document.getElementById('gender').value;

    if (!vaildateEmail(email))  { document.getElementById('email').style.borderColor="red";  }
    if (vaildateEmail(email))  { document.getElementById('email').style.borderColor="#ced4da";  }

     if(document.getElementById('birth_month').value == 2 && document.getElementById('birth_day').value> 29 )
    {
       msg="Select appropriate date.";
       showErrormessage(msg,'generalButton');
       return ; 

    }

    else if((document.getElementById('birth_month').value == 4 || document.getElementById('birth_month').value == 6 || document.getElementById('birth_month').value == 9 || document.getElementById('birth_month').value == 11 ) && document.getElementById('birth_day').value> 30 )
    {
       msg="Select appropriate date.";
      showErrormessage(msg,'generalButton');
      return ; 
    }

    else if(new Date(dob)> new Date())
      {
         msg="Invalid Date of Birth";
          showErrormessage(msg,'generalButton');
            return ; 
      }

     else  if(getAge(dob)<18){
         msg="Age cannot be less than 18.";
         showErrormessage(msg,'generalButton');
         return ; 
      } 
      else{
          data.append('gender',document.getElementById('gender').value);
          data.append('dob',dob);
          data.append('email',email);
          xmlHttp.send(data);

      xmlHttp.onreadystatechange = function()
      {
          if(xmlHttp.readyState==4)
          {

            var status = xmlHttp.responseText;
            var id=JSON.parse(status);

            if(id=="error"){
              msg="Invalid Title Selected";
              showErrormessage(msg,'generalButton');
               return ; 
            }

            if(id=="textonly"){
              msg="Text only in name field";
             showErrormessage(msg,'generalButton');
                return ; 
            }

             if(id=="errorgender"){
              msg="Invalid Gender Selected";
              showErrormessage(msg,'generalButton');
                return ; 
              }

               if(id=="emailInvalid"){
                msg="Invalid Email Id";
               showErrormessage(msg,'generalButton');
                return ; 
              }

              
               if(id=="errorDate"){
                msg="Invalid Date";
               showErrormessage(msg,'generalButton');
                return ; 
              }

           if(isNaN(id))
           {
            if(JSON.parse(status)=='true')
            showSuccessmessage('generalButton');
            showresponse('general-form',status,'Updated Successfully');
           }
            

          else  {
            location.href='profile_update/'+id;
          }
          }
      }
}
    }


  // display current entering employee's name
  function displayName(fname,mname="",lname)
  {
    $('#current_employee_name').text(fname+" "+mname+" "+lname);
  }


function addDocument(){
$('#document').append('<i >Title <b class="text-danger">*</b> </i><input type="text" name="doc_title" class=" col-md-2" placeholder="Enter the title">');
$('#document').append('<input type="file" id="doc_file" name="userfile"  class=" col-md-4">');
$('#document').append('<i class="fa fa-times fa-2x" onclick="removeDocument(this)" class="form-group col-md-2 "></i>');
$('#document').append('<hr>');
$('#subDoc').css('display','block');
}

function removeDocument(doc){


  doc.nextSibling.remove();
  doc.previousSibling.remove();
  doc.previousSibling.remove();
  doc.previousSibling.remove();
  doc.remove();
    var area = document.getElementById('document');
 if(area.innerHTML.trim()==''){
  $('#subDoc').css('display','none');

 }

}

// add document to table
function submitDocument(btn){

  var doc_title = document.getElementsByName('doc_title');
  var doc_file = document.getElementsByName('userfile');
  var count=0;



  for( i = 0; i < doc_title.length; i++ )
     {

      if(doc_title[i].value==''){
          msg="Provide title for all files";
              showErrormessage(msg,'docaddbtn');
               return ; 
      }

     if(doc_file[i].files.length==0){
      $("#docaddbtn").notify("Select a file first",{position:"right top"});
      return false;
     }

     if( doc_file[i].files[0]['type']=="application/vnd.openxmlformats-officedocument.wordprocessingml.document"||doc_file[i].files[0]['type']=="application/msword"||doc_file[i].files[0]['type']=="application/pdf"||doc_file[i].files[0]['type']=="application/PDF"||doc_file[i].files[0]['type']=="image/png"||doc_file[i].files[0]['type']=="image/jpeg"||doc_file[i].files[0]['type']=="image/jpg" ) {

     }
     else{
       msg="Invalid File Selected";
              showErrormessage(msg,'docaddbtn');
               return ; 
     }

    
  }
   //changing button menu-icon
      $("#btn-group").prepend('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
      btn.className="btn btn-light";
      btn.value="Uploading ...";

      btn.onclick='';
      btn.disabled=true;
    for( i = 0; i < doc_title.length; i++ )
     {
     

     
      var xmlHttp = new XMLHttpRequest();
      xmlHttp.open('POST','addDocuments',true);
      var data = new FormData();
      data.append('doc_title',doc_title[i].value);
      data.append('doc_file',doc_file[i].value);
      data.append('document',doc_file[i].files[0])
      xmlHttp.send(data);
      xmlHttp.onreadystatechange = function()
      {
          if(xmlHttp.readyState==4)
          {
           var status = xmlHttp.responseText;

            if(status=='false'){
              msg="Invalid File Selected";
              showErrormessage(msg,'docaddbtn');
               return ; 
            }

           if(status=='true')
           {
             msg="Files Uploaded";
              showCustomSuccessmessage('docaddbtn',msg);
              location.reload();
               return ; 
           }
           else if(status=="fileerror"){
            $.notify("Error File Type", "error");
           }
          else{
            count++;
             msg="Choose file";

               $('#messagediv').removeClass('alert-success');
               $('#messagediv').addClass('alert-danger');
               $('#messagediv').css('display','block');
              $('#showmessage').html(msg); 
        }

           
                 
          }

      }
      
    }
}

//editing file and name
// add document to table
function editDocument(btn,value){

  var doc_title = document.getElementById('edit_doc_title');
  var doc_file = document.getElementsByName('edit_userfile');
  var count=0;




if(doc_title.value==''){
          msg="Please Enter the File Title";
              showErrormessage(msg,'editFileBtn');
               return ; 
      }



      
      

      

      var xmlHttp = new XMLHttpRequest();
      xmlHttp.open('POST','editDocuments',true);
      var data = new FormData();
      data.append('doc_id',value);
      data.append('fileCount',doc_file[0].files.length);
      data.append('doc_title',doc_title.value);
      data.append('doc_file',doc_file[0].value);
      data.append('document',doc_file[0].files[0])
      xmlHttp.send(data);
      xmlHttp.onreadystatechange = function()
      {
          if(xmlHttp.readyState==4)
          {
           var status = xmlHttp.responseText;
           console.log(status);


            if(status=='false'){
              msg="Invalid File Selected";
              showErrormessage(msg,'editFileBtn');
               return ; 
            }

           if(status=='true')
           {

    //changing button menu-icon
       btn.remove();
      $("#df"+value).append('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
      $("#df"+value).append('Uploading...');
      
             msg="Files Updated";
              showCustomSuccessmessage('editFileBtn',msg);
              location.reload();
               return ; 
           }
           else if(status=="errorFileType"){
            $.notify("Error File Type", "error");
           }
          else{
            
             msg="Choose file";

               $('#messagediv').removeClass('alert-success');
               $('#messagediv').addClass('alert-danger');
               $('#messagediv').css('display','block');
                $('#showmessage').html(msg); 
        }

           
                 
          }

      }
      
    }




//show hide visa info
function showHideVisa(visa){
  if(visa.value=='Nepalese')
    document.getElementById('non_nepali').style.display='none';
  else
  document.getElementById('non_nepali').style.display='block';

}

// show the allergy description textbox if the user selects yes
function showHideAllergy(allergy)
{
     if(allergy.value=='Yes')
    document.getElementById('allergy').style.display='block';
  else
  document.getElementById('allergy').style.display='none';
}


////////////////////  Update Employee through different Tabs /////////////////////
  // delete/archive employee
   function archiveEmployee(id)
  {
          var xmlHttp = new XMLHttpRequest();
          xmlHttp.open('POST','archiveEmployee',true);
          var data = new FormData();
          data.append('emp_id', id);
          xmlHttp.send(data);

          xmlHttp.onreadystatechange = function()
          {
              if(xmlHttp.readyState==4)
              {
                // $('#datatable').ajax.reload();

              }
          }
  }


    // restore/ unarchive employee
   function unArchiveEmployee(id)
  {
          var xmlHttp = new XMLHttpRequest();
          xmlHttp.open('POST','unArchiveEmployee',true);
          var data = new FormData();
          data.append('emp_id', id);
          xmlHttp.send(data);

          xmlHttp.onreadystatechange = function()
          {
              if(xmlHttp.readyState==4)
              {
              }
          }
  }



  // this function returns the value of radio button of same group
  function getSelectedValue(groupName) {
      var radios = document.getElementsByName(groupName);
      for( i = 0; i < radios.length; i++ ) {
          if( radios[i].checked ) {
              return radios[i].value;
          }
      }
      return null;
  }

  // display message if added successfully and red textbox if the required fields are empty
function showresponse(formname,status,msg)
{
  var check=false;
  var JSONObject;
  JSONObject=JSON.parse(status);
  var elements= document.getElementById(formname).elements;
  for(var k in elements)
  {
     if(elements[k].type=="text"||elements[k].type=="number"||elements[k].type=="date"||elements[k].type=="email"||elements[k].nodeName=="select")
     {
       document.getElementById(elements[k].id).style.borderColor="#ced4da";
        for(var l in JSONObject)
        { 
           if(elements[k].id==l && l!="true")
          {
            // red color for border error
            document.getElementById(l).style.borderColor="#dc3545";
            showErrormessage2('Please fill in the field',l); 
          }
        }
// once the data is inserted, the red border disappears
        if(check)
        { 
           for(var m in elements)
           {
              if(elements[m].type=="text"||elements[m].type=="number"||elements[m].type=="date"||elements[m].type=="email"||elements[m].nodeName=="select")
              { document.getElementById(elements[m].id).style.borderColor="#ced4da"; }
           }
           break;
         }      
      }
  }
  // change tab icon
  check_complete();
}



  function general()
  {
          var xmlHttp = new XMLHttpRequest();
          xmlHttp.open('POST','updateGeneral',true);
          var data = new FormData();
          data.append('title',document.getElementById('title').value);
          data.append('firstname',document.getElementById('firstname').value);
          data.append('middlename',document.getElementById('middlename').value);
          data.append('surname',document.getElementById('surname').value);
          xmlHttp.send(data);

          xmlHttp.onreadystatechange = function()
          {
              if(xmlHttp.readyState==4)
              {
                var status = xmlHttp.responseText;
               showresponse('general-form',status,'Updated Successfully');
              }
          }
  }

/**
* address form
*/
  function addAddress()
  {
          var xmlHttp = new XMLHttpRequest();
          xmlHttp.open('POST','addAddress',true);
          var data = new FormData();
          data.append('permanentaddress_street',document.getElementById('permanentaddress_street').value.trim());
          data.append('permanentaddress_municipality',document.getElementById('permanentaddress_municipality').value.trim());
          data.append('permanentaddress_district',document.getElementById('permanentaddress_district').value.trim());
          data.append('permanentaddress_state',document.getElementById('permanentaddress_state').value.trim());
          data.append('permanentaddress_country',document.getElementById('permanentaddress_country').value.trim());
          
          data.append('currentaddress_street',document.getElementById('currentaddress_street').value.trim());
          data.append('currentaddress_municipality',document.getElementById('currentaddress_municipality').value.trim());
          data.append('currentaddress_district',document.getElementById('currentaddress_district').value.trim());
          data.append('currentaddress_state',document.getElementById('currentaddress_state').value.trim());
        
     
          xmlHttp.send(data);

          xmlHttp.onreadystatechange = function()
          {
              if(xmlHttp.readyState==4)
              {
                var status = xmlHttp.responseText;
                if(JSON.parse(status)=='textonlyMunicipality')
                {
                   msg="Municipality cannot have numbers(1,2,..)";
                   showErrormessage(msg,'addressbutton');
                    return ; 
                }

                // for district
                if(JSON.parse(status)=='textonlyDistrict')
                {
                   msg="District cannot start with numbers(1,2,..)";
                   showErrormessage(msg,'addressbutton');
                    return ; 
                }

                if(JSON.parse(status)=='true')
                {
                 showSuccessmessage('addressbutton');
                }
                showresponse('address-form',status,'Updated Successfully');
                
              }

          }
        
  }

// contact form
  function addContact()
  {
          var xmlHttp = new XMLHttpRequest();
          xmlHttp.open('POST','addContact',true);
          var data = new FormData();
          data.append('home_phone',document.getElementById('home_phone').value.trim());
          data.append('mobile_phone',document.getElementById('mobile_phone').value.trim());
          data.append('other_phone1',document.getElementById('other_phone1').value.trim());
          data.append('other_phone2',document.getElementById('other_phone2').value.trim());
          data.append('other_phone3',document.getElementById('other_phone3').value.trim());
          xmlHttp.send(data);

          xmlHttp.onreadystatechange = function()
          {
              if(xmlHttp.readyState==4)
              {
                var status = xmlHttp.responseText;
                var id=JSON.parse(status);
                if(id=="errorContactHome")
                {
                  msg="Enter proper contact no. format for Home Phone";
                  showErrormessage(msg,'contactbutton');
                  return ;
                }
                if(id=="errorContactOther")
                {
                  msg="Enter proper contact no. format for Other Phone";
                  showErrormessage(msg,'contactbutton');
                  return ;
                }

                if(id=="errorContactMobile")
                {
                  msg="Enter proper contact no. format for Mobile Phone";
                  showErrormessage(msg,'contactbutton');
                  return ;
                }
                if(isNaN(id)){
                  if(JSON.parse(status)=='true')
                   showSuccessmessage('contactbutton');
                  showresponse('contact-form',status,'Updated Successfully');}
              }
          }
  }

// nationality info
  function addNationality()
  {
          var xmlHttp = new XMLHttpRequest();
          xmlHttp.open('POST','addNationality',true);
          var data = new FormData();
          var radioValue = $("input[name='nationality']:checked").val();
          data.append('nationality',getSelectedValue('nationality'));
          data.append('visa_permission',getSelectedValue('visa_permission'));
          data.append('visa_type',document.getElementById('visa_type').value.trim());
          data.append('visa_expiry_date',document.getElementById('visa_expiry_date').value.trim());
          data.append('passport_no',document.getElementById('passport_no').value.trim());
          data.append('passport_issue_place',document.getElementById('passport_issue_place').value.trim());
          xmlHttp.send(data);
        if(!radioValue)
        {
           msg="Select nationality";
           showErrormessage(msg,'nationalitybutton');
           return ;
        }

     // if(checkCurrentDate('visa_expiry_date'))
     //  {
     //     msg="Invalid Visa Expiry date";

     //          $('#messagediv').removeClass('alert-success');
     //           $('#messagediv').addClass('alert-danger');
     //           $('#messagediv').css('color','red');
     //          $('#messagediv').css('display','block');
     //           $('#showmessage').html(msg); 
     //  }
     //  else{

      xmlHttp.onreadystatechange = function()
          {
              if(xmlHttp.readyState==4)
              {
                var status = xmlHttp.responseText;
                var id=JSON.parse(status);
                if(id=="errorVisatype")
                {
                  msg="Enter proper Visa type";
                  showErrormessage(msg,'nationalitybutton');
                  showresponse('nationality-form',status,'Updated Successfully');
                  return ;
                }

                if(id=="errorPassportIssue")
                {
                  msg="Enter proper Passport Issue Place";
                  showErrormessage(msg,'nationalitybutton');
                  showresponse('nationality-form',status,'Updated Successfully');
                  return ;
                }

                if(isNaN(id))
                { 
                  if(JSON.parse(status)=='true')
                    showSuccessmessage('nationalitybutton');
                  showresponse('nationality-form',status,'Updated Successfully');}
              }
          }
  // }
  
      }

  // Emergency contact
  function addEmergency()
  {
          var xmlHttp = new XMLHttpRequest();
          xmlHttp.open('POST','addEmergency',true);
          var data = new FormData();
          var e_relation=document.getElementById('e_relation').value.trim();

          // checking if the relation is other
          if(e_relation=='Other')
            { var othere= document.getElementById('otherRelation').value.trim();
              if(othere=='')
              {
                   msg="Enter Other Relation Name";
                  showErrormessage(msg,'emergencybutton');
                  return ;
              }
              data.append('e_relation',othere);
            }
          else{   data.append('e_relation',e_relation);  }

          data.append('e_name',document.getElementById('e_name').value.trim());
          
          data.append('e_address',document.getElementById('e_address').value.trim());
          data.append('e_phone',document.getElementById('e_phone').value.trim());
          xmlHttp.send(data);

          xmlHttp.onreadystatechange = function()
          {
              if(xmlHttp.readyState==4)
              {
                var status = xmlHttp.responseText;
                var id=JSON.parse(status);
                if(id=="errorEmergencyName")
                {
                  msg="Enter proper Name";
                  showErrormessage(msg,'emergencybutton');
                  return ;
                }

                if(id=="errorEmergencyContact")
                {
                  msg="Enter proper Contact no.";
                  showErrormessage(msg,'emergencybutton');
                  return ;
                }

                if(id=="errorEmergencyAddress")
                {
                  msg="Enter proper Address";
                  showErrormessage(msg,'emergencybutton');
                  return ;
                }

                if(id=="errorEmergencyRelation")
                {
                  msg="Enter proper Relation";
                  showErrormessage(msg,'emergencybutton');
                  return ;
                }




                if(isNaN(id)){
                   if(JSON.parse(status)=='true')
                     showSuccessmessage('emergencybutton');
                    showresponse('emergency-form',status,'Updated Successfully');}
              }
          }
  }

  //Education info to table 
  function addEducation()
  {

    var xmlHttp = new XMLHttpRequest();
    xmlHttp.open('POST','addEducation',true);
    var data = new FormData();
    data.append('highest_degree',document.getElementById('highest_degree').value.trim());
    data.append('degree_title',document.getElementById('degree_title').value.trim());
    data.append('university',document.getElementById('university').value.trim());
    xmlHttp.send(data);
    xmlHttp.onreadystatechange = function()
    {
        if(xmlHttp.readyState==4)
        {
          var status = xmlHttp.responseText;
          var id=JSON.parse(status);
          if(id=="error")
          {
            msg=" Enter valid Highest Degree.";
            showErrormessage(msg,'educationbutton');
            return ;
           }
           if(id=="errorEducationdegree")
            {
            msg=" Enter valid degree title.";
            showErrormessage(msg,'educationbutton');
            return ;
           }
            if(id=="errorEducationuniversity")
            {
            msg=" Enter valid university name.";
            showErrormessage(msg,'educationbutton');
            return ;
           }
           if(JSON.parse(status)=='true')
           showSuccessmessage('educationbutton');
         showresponse('education-form',status,'Updated Successfully');
        }
    }
  }

  // add health information
  function addHealth()
  {
      var blood_group=document.getElementById('blood_group').value.trim();
      if(blood_group==''){
           msg="Select a blood group.";
            showErrormessage(msg,'healthbutton');
            return ;  
      }

          var xmlHttp = new XMLHttpRequest();
          xmlHttp.open('POST','addHealth',true);
          var data = new FormData();
          data.append('blood_group',blood_group);
          data.append('medical_complications',document.getElementById('medical_complications').value.trim());
          data.append('regular_medication',document.getElementById('regular_medication').value.trim());
          data.append('allergies',getSelectedValue('allergies'));
          data.append('allergy_description',document.getElementById('allergy_description').value.trim());
          xmlHttp.send(data);
          xmlHttp.onreadystatechange = function()
          {
              if(xmlHttp.readyState==4)
              {
                var status = xmlHttp.responseText;
                 var id=JSON.parse(status);
                if(id=="error")
                {
                  msg="Invalid Blood group Selected";
                   showErrormessage(msg,'healthbutton');
                   return ;
                 }

                 if(id=="errorMedicalComplication")
                  {
                  msg="Invalid Medical complication information.";
                   showErrormessage(msg,'healthbutton');
                    return ;
                 }

                 if(id=="errorMedicalRegular")
                  {
                  msg="Invalid Regular medication information.";
                   showErrormessage(msg,'healthbutton');
                    return ;
                 }

                 if(id=="errorMedicalAllergy")
                  {
                  msg="Invalid Allergy description.";
                   showErrormessage(msg,'healthbutton');
                    return ;
                 }
                 if(JSON.parse(status)=='true')
                 showSuccessmessage('healthbutton');
               showresponse('health-form',status,'Updated Successfully');
              }
          }
  }

  // add PAN
  function addPan()
  {
    var xmlHttp = new XMLHttpRequest();
    xmlHttp.open('POST','addPan',true);
    var data = new FormData();
    data.append('pan',document.getElementById('pan').value.trim());
    xmlHttp.send(data);

   xmlHttp.onreadystatechange = function()
   {
        if(xmlHttp.readyState==4)
        {
          var status = xmlHttp.responseText;
            var id=JSON.parse(status);
          if(id=="errorPan")
          {
            msg="Invalid Pan Number";
            showErrormessage('Enter proper format','panbutton');
           return ;
          }
          if(JSON.parse(status)=='true'){  showSuccessmessage('panbutton');}
          showresponse('pan-form',status,'Updated Successfully');
        }
    }
  }

  //to add personal details
    function addPersonalInformation()
  {
    var email=document.getElementById('email').value.trim();
    var dob= document.getElementById('birth_year').value+'-'+document.getElementById('birth_month').value+'-'+document.getElementById('birth_day').value;
    if (!vaildateEmail(email)) {
         document.getElementById('email').style.borderColor="red";
      }

    if(document.getElementById('birth_month').value == 2 && document.getElementById('birth_day').value> 29 )
    {
       msg="Select appropriate date.";

              $('#messagediv').removeClass('alert-success');
               $('#messagediv').addClass('alert-danger');
              $('#messagediv').css('display','block');
               $('#showmessage').html(msg); 

    }

    else if((document.getElementById('birth_month').value == 4 || document.getElementById('birth_month').value == 6 || document.getElementById('birth_month').value == 9 || document.getElementById('birth_month').value == 11 ) && document.getElementById('birth_day').value> 30 )
    {
       msg="Select appropriate date.";

              $('#messagediv').removeClass('alert-success');
               $('#messagediv').addClass('alert-danger');
              $('#messagediv').css('display','block');
               $('#showmessage').html(msg); 

    }

    else if(new Date(dob)> new Date())
      {
         msg="Invalid Date of Birth";

              $('#messagediv').removeClass('alert-success');
               $('#messagediv').addClass('alert-danger');
              $('#messagediv').css('display','block');
               $('#showmessage').html(msg); 
      }

     else  if(getAge(dob)<18){
         msg="Age cannot be less than 18.";

              $('#messagediv').removeClass('alert-success');
               $('#messagediv').addClass('alert-danger');
              $('#messagediv').css('display','block');
               $('#showmessage').html(msg); 
      }
          else{
        var xmlHttp = new XMLHttpRequest();
          xmlHttp.open('POST','addPersonalInformation',true);
          var data = new FormData();
          data.append('gender',document.getElementById('gender').value);
          data.append('dob',dob);
          data.append('email',email);

          xmlHttp.send(data);

         xmlHttp.onreadystatechange = function()
          {
              if(xmlHttp.readyState==4)
              {
                var status = xmlHttp.responseText;
                var id=JSON.parse(status);
                if(id=="error"){
                msg="Invalid Gender Selected";
               $('#messagediv').removeClass('alert-success');
               $('#messagediv').addClass('alert-danger');
              $('#messagediv').css('display','block');
               $('#showmessage').html(msg); 
               return ;
            }
               showresponse('personal-form',status,'Updated Successfully');
              }
          } 
        }
}

 // to make enter button submit form 
   $(document).ready(function() {
    $(window).keydown(function(event){
        if((event.keyCode == 13) && ($(event.target)[0]!=$("textarea")[0])) {
            event.preventDefault();
            return false;
        }
    });
  });

function clearExpForm(){
  document.getElementById('expTitle').innerHTML='Add New Experience';
 document.getElementById('expTitle').classList.remove('text-info');
 document.getElementById('id').value='';
 document.getElementById('submitExp').value='Add Experience';
  document.getElementById('expForm').reset();
  
$('#organization').css('border', '1px solid #ced4da');
$('#responsibility').css('border', '1px solid #ced4da');
$('#position').css('border', '1px solid #ced4da');
$('#from_date').css('border', '1px solid #ced4da');
$('#to_date').css('border', '1px solid #ced4da');
$('#contact_person_number').css('border', '1px solid #ced4da');


}


function saveExp(){
  var expid = document.getElementById('id');
  var organization = document.getElementById('organization');
  var responsibility = document.getElementById('responsibility');
  var position = document.getElementById('position');
  var from_date = document.getElementById('from_date');
  var to_date = document.getElementById('to_date');
  var contact_person_number = document.getElementById('contact_person_number');

var data = [organization,responsibility,position,from_date,to_date,contact_person_number];
var error = false;  // to track error in fields
for(k in data){
  if(!data[k].value.trim()){
    $(data[k]).css('border', '1px solid red');
    error =true;
  }
  else{
     $(data[k]).css('border', '1px solid #ced4da');
  }
}


if(error){
 $('#submitExp').notify('Please Fill Highlighted Fields',{position:'bottom'});
 return ;
}


    var xmlHttp = new XMLHttpRequest();
    xmlHttp.open('POST','addWork',true);
    var data = new FormData();
    data.append('id',expid.value);
    data.append('from_date',from_date.value);
    data.append('to_date',to_date.value);
    data.append('organization',organization.value.trim());
    data.append('responsibility',responsibility.value.trim());
    data.append('position',position.value.trim());
    data.append('contact_person_number',contact_person_number.value.trim());

    xmlHttp.send(data);
     xmlHttp.onreadystatechange = function()
              {
                  if(xmlHttp.readyState==4){
                    var id='';
                      var status=xmlHttp.responseText;
                       id= JSON.parse(status);
                       // alert(id);
                       if(id=="errorOrganization")
                      {
                         $('#submitExp').notify('Invalid organization name',{position:'bottom'});
                         return;
                      }
                      else if(id=="errorResponsibility")
                      {
                         $('#submitExp').notify('Invalid responsibility name',{position:'bottom'});
                         return;
                      }

                      else if(id=="errorPosition")
                      {
                         $('#submitExp').notify('Invalid position name',{position:'bottom'});
                         return;
                      }
                       else if(id=="errorContact")
                      {
                         $('#submitExp').notify('Invalid contact number',{position:'bottom'});
                         return;
                      }
                      else if(id=="errorContact")
                      {
                         $('#submitExp').notify('Invalid contact number',{position:'bottom'});
                         return;
                      }

                      else if(id=="fromdateGreater")
                      {
                         $('#submitExp').notify('From date is greater than To date',{position:'bottom'});
                         return;
                      }
                      else if(id=="fromdateError")
                      {
                         $('#submitExp').notify('Invalid From date',{position:'bottom'});
                         return;
                      }

                      else if(id=="todateError")
                      {
                         $('#submitExp').notify('Invalid To date',{position:'bottom'});
                         return;
                      }

                      else if(id=="update"){
                         $('#submitExp').notify('Experience Updated Successfully',{position:'bottom',className:'success'});
                        }

                       else if(!id.isNaN){
                         $('#submitExp').notify('Experience Added Successfully',{position:'bottom',className:'success'});
                      }
                     
                      
                      else{
                         $('#submitExp').notify('Please Provide Proper Data',{position:'bottom'});
                      }
                     
                        clearExpForm();
                        $( "#mainWork" ).load(window.location.href + " #childWork" );
                   }

                   check_complete();

              }
}
                     

function editExp(id){
    document.getElementById('expTitle').innerHTML='Edit Experience';
    document.getElementById('expTitle').className='text-info';

   var submitBtn= document.getElementById('submitExp');
   submitBtn.value="Update Experience";
  submitBtn.setAttribute( "onClick", "saveExp()" );


  var expid = document.getElementById('id');
  var organization = document.getElementById('organization');
  var responsibility = document.getElementById('responsibility');
  var position = document.getElementById('position');
  var from_date = document.getElementById('from_date');
  var to_date = document.getElementById('to_date');
  var contact_person_number = document.getElementById('contact_person_number');



      var xmlHttp = new XMLHttpRequest();
         xmlHttp.open('POST','getWork',true);
          var data = new FormData();
          data.append('id',id);
           xmlHttp.send(data);

            xmlHttp.onreadystatechange = function()
            {
              if(xmlHttp.readyState==4){
                var exp= JSON.parse(xmlHttp.responseText);
                for(k in exp){
                  if(k=="id") expid.value=exp[k];
                  if(k=="organization") {organization.value=exp[k]; organization.title=exp[k];}
                  if(k=="responsibility") {responsibility.value=exp[k]; responsibility.title=exp[k];}
                  if(k=="position") {position.value=exp[k]; position.title=exp[k];}
                  if(k=="from_date") {from_date.value=exp[k]; from_date.title=exp[k];}
                  if(k=="to_date") {to_date.value=exp[k]; to_date.title=exp[k];}
                  if(k=="contact_person_number") {contact_person_number.value=exp[k]; contact_person_number.title=exp[k];}
                  
                }
              }
            }



}



function deleteExp(value) {
 var id = parseInt(value, 10);
       var xmlHttp = new XMLHttpRequest();
         xmlHttp.open('POST','deleteWorkExp',true);
          var data = new FormData();
          data.append('id',id);
           xmlHttp.send(data);

            xmlHttp.onreadystatechange = function()
            {
              if(xmlHttp.readyState==4){
                var status= xmlHttp.responseText;
                if(status=="success"){
                $('#submitExp').notify('Experience Deleted successfully.',{position:'bottom',className:'success'});
                }
                else{
                $('#submitExp').notify('Unable to delete.',{position:'bottom',className:'error'});
                }
                  $('#del'+value).css('display','none');
                  $('#del'+value).attr('aria-hidden', 'true');
                  $('body').removeClass('modal-open');
                  $('.modal-backdrop').remove();

                   $( "#mainWork" ).load(window.location.href + " #childWork" );
              }
              check_complete();
            }
  


}
function editExperience(id){
  var textarea = 'experience'+id;
  var idtextarea='#'+textarea;
  var exp= document.getElementById(textarea);
     var xmlHttp = new XMLHttpRequest();
         xmlHttp.open('POST','editWork',true);
          var data = new FormData();
          data.append('experience',exp.value);
          data.append('id',id);
           xmlHttp.send(data);

            xmlHttp.onreadystatechange = function()
            {
                if(xmlHttp.readyState==4){
                  var status=xmlHttp.responseText;


                if(status=="error"){
                  $(idtextarea).notify("Please fill the text area",{position:"bottom left"});
                }
               if(status=="success"){
                  exp.value='';
                   $("#expModel").css('display','none');
                   $("#expModel").css('aria-hidden','true');
                   $("#expModel").css('aria-modal','false');
                     $('.modal-backdrop').remove();
                   $('body').removeClass('modal-open');

                  $("#experiencelist").notify("Experience Edited Successfully",{className:'success',position:"top"});
                  $( "#experiencelist" ).load(window.location.href + " #listexp" );

                }

              }
              }    
              check_complete();  
      
}

function confirmAction (value, ele, message, action ) {
   alertify.confirm('Delete ?'  , message, function(){action(value)}
                , function(){ });
}





// check email id 
function vaildateEmail(email)
{
var mailformat = /^(?=.*[a-zA-Z])\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
if(email.match(mailformat))
{ return true; }
else 
  return false; 
}




// for the icon status on each tab

function check_complete(){
 
  //general tab
  var first_name =document.getElementById('first_name').value;
  var last_name=document.getElementById('last_name').value;
  //personal details
  var email=document.getElementById('email').value;
  var dob= document.getElementById('birth_year').value+'-'+document.getElementById('birth_month').value+'-'+document.getElementById('birth_day').value;
  //address
  var current_street=document.getElementById('currentaddress_street').value;
  var current_municipality=document.getElementById('currentaddress_municipality').value;
  var current_district=document.getElementById('currentaddress_district').value;
  var current_state=document.getElementById('currentaddress_state').value;
  // var current_country= document.getElementById('currentaddress_country').value;
  //contact
  var mobile_phone=document.getElementById('mobile_phone').value;
  //nationality
  var passport_no=document.getElementById('passport_no').value;
  var issue_place=document.getElementById('passport_issue_place').value;
  //emergency contact
  var e_name=document.getElementById('e_name').value;
  var e_relation=document.getElementById('e_relation').value;
  var e_phone=document.getElementById('e_phone').value;
  //Education
  var institute=document.getElementById('university').value;
  //Health
  var blood_group = document.getElementById('blood_group').value;
  //PAN
  var pan=document.getElementById('pan').value;
  //assign
  var recommender= document.getElementById('recommender').value;
  var approver = document.getElementById('approver').value;
  //documents
  var documents =document.getElementById('document-list');
 



    if(first_name!=''&&last_name!=''&&email!=''&&dob!='') completeIcon('nav-general-tab'); else inCompleteIcon('nav-general-tab');
    // if(email!=''&&dob!='') completeIcon('nav-personal-tab'); else inCompleteIcon('nav-personal-tab');
    if(current_street!='') completeIcon('nav-address-tab'); else inCompleteIcon('nav-address-tab');
    if(mobile_phone!='') completeIcon('nav-contact-tab'); else inCompleteIcon('nav-contact-tab');
    if(passport_no!='' && issue_place!='') completeIcon('nav-nationality-tab'); else inCompleteIcon('nav-nationality-tab');
    if(e_name!=''&& e_relation!=''&& e_phone!='') completeIcon('nav-eContact-tab'); else inCompleteIcon('nav-eContact-tab');
    if(institute!='') completeIcon('nav-education-tab'); else inCompleteIcon('nav-education-tab');
    if(blood_group!='') completeIcon('nav-health-tab'); else inCompleteIcon('nav-health-tab');
    if(pan!='') completeIcon('nav-pan-tab'); else inCompleteIcon('nav-pan-tab');
    if(recommender!=''&&approver!='') completeIcon('nav-assign-tab'); else inCompleteIcon('nav-assign-tab');
    //changes icon if at least one document is added
    if(typeof(documents) != 'undefined' && documents != null) 
      completeIcon('nav-document-tab');
    else inCompleteIcon('nav-document-tab');
    // changes icon if at least one erience is added
 
   
    checkExp();

   
    
    

}
function  checkExp(){
  var status="";
  var xmlHttp = new XMLHttpRequest();
     xmlHttp.open('POST','checkExp',true);
      var data = new FormData();
       xmlHttp.send(data);

        xmlHttp.onreadystatechange = function()
        {
          if(xmlHttp.readyState==4){
          status = xmlHttp.responseText;
           if(status=="true")
             completeIcon('nav-work-tab');
           else inCompleteIcon('nav-work-tab');
          }
        }
            
  }
  


function completeIcon(tabId){
  document.getElementById(tabId).childNodes[1].className="fa fa-check-circle prog-com";
}

function toggleNav(status=''){
  if(status=="show"){
    // document.getElementById('nav-personal-tab').style.display="block";
    document.getElementById('nav-address-tab').style.display="block";
    document.getElementById('nav-contact-tab').style.display="block";
    document.getElementById('nav-nationality-tab').style.display="block";
    document.getElementById('nav-eContact-tab').style.display="block";
    document.getElementById('nav-health-tab').style.display="block";
    document.getElementById('nav-education-tab').style.display="block";
    document.getElementById('nav-pan-tab').style.display="block";
    document.getElementById('nav-work-tab').style.display="block";
    document.getElementById('nav-document-tab').style.display="block";
    document.getElementById('nav-assign-tab').style.display="block";
  
  }
  if(status=="hide"){
        // document.getElementById('nav-personal-tab').style.display="none";
        document.getElementById('nav-address-tab').style.display="none";
        document.getElementById('nav-contact-tab').style.display="none";
        document.getElementById('nav-nationality-tab').style.display="none";
        document.getElementById('nav-eContact-tab').style.display="none";
        document.getElementById('nav-health-tab').style.display="none";
        document.getElementById('nav-education-tab').style.display="none";
        document.getElementById('nav-pan-tab').style.display="none";
        document.getElementById('nav-work-tab').style.display="none";
        document.getElementById('nav-document-tab').style.display="none";
        document.getElementById('nav-assign-tab').style.display="none";

  }
}


function inCompleteIcon(tabId){
    document.getElementById(tabId).childNodes[1].className="fa fa-info-circle prog-incom";
}



// delete files permanently from the edit option
 function removeFile(id)
  {       
          var xmlHttp = new XMLHttpRequest();
          xmlHttp.open('POST','deleteFile',true);
          var data = new FormData();
          data.append('doc_id', id);
          xmlHttp.send(data);

          xmlHttp.onreadystatechange = function()
          {
              if(xmlHttp.readyState==4)
              {
             msg="Deleted Successfully.";

               // $('#messagediv').removeClass('alert-success');
               $('#messagediv').addClass('alert-success');
               $('#messagediv').css('display','block');
              $('#showmessage').html(msg); 
              location.reload();

              }

          }
  }


  // delete erience data from edit form
  function deleteWorkExperience(id)
  {

    var xmlHttp = new XMLHttpRequest();
          xmlHttp.open('POST','deleteWorkExperience',true);
          var data = new FormData();
          data.append('id', id);
          xmlHttp.send(data);

          xmlHttp.onreadystatechange = function()
          {
              if(xmlHttp.readyState==4)
              {

                msg="Deleted Successfully.";

               // $('#messagediv').removeClass('alert-success');
               $('#messagediv').addClass('alert-success');
               $('#messagediv').css('display','block');
              $('#showmessage').html(msg); }
              location.reload();
          }
  }


  // start and end date validation
  function DateCheck()
  {
    var StartDate= document.getElementById('from_date').value;
    var EndDate= document.getElementById('to_date').value;
    var eDate = new Date(EndDate);
    var sDate = new Date(StartDate);
    if(StartDate!= '' && EndDate!= '' && sDate> eDate) {  return false; }
    else return true;

  }


  // check date is not more than current date 
function checkCurrentDate($date)
{
  var date = document.getElementById($date).value;
  var curDate = new Date();
  var enterDate= new Date(date);
  if(enterDate> curDate )
    return false;
  else
    return true;
}

// function to assign employee
function assign()
{
  var package_id = document.getElementById('package_id').value;
  var recommender=document.getElementById('recommender').value;
  var approver= document.getElementById('approver').value;

  if(package_id==''){
    showErrormessage("Select package first!", 'assignbutton');
     return 0;
            }
  if(recommender==''||approver==''){
    showErrormessage("Select recommender and approver!", 'assignbutton');
     return 0;
            }
  var xmlHttp = new XMLHttpRequest();
          xmlHttp.open('POST','assignEmployee',true);
          var data = new FormData();
          data.append('recommender_id',recommender);
          data.append('approver_id',approver);
          data.append('package_id',package_id);
          xmlHttp.send(data);

          xmlHttp.onreadystatechange = function()
          {
              if(xmlHttp.readyState==4)
              {
            
              showSuccessmessage('assignbutton');
               }
              check_complete();

          }
 }


 // add leave
  function saveLeave()
  {
  var leave_name=document.getElementById('leave_name').value;
  var leave_id=document.getElementById('leave_id').value;
  var is_one_day= document.getElementById('is_one_day').checked;
  if(leave_name=='')
  {
     msg="Enter leave name  ";
     $('#messagediv').addClass('alert-danger');
     $('#messagediv').css('display','block');
    $('#showmessage').html(msg); 

    return 0;
  }
  else
  {
    var xmlHttp = new XMLHttpRequest();
    xmlHttp.open('POST','saveLeave',true);
    var data = new FormData();
    data.append('leave_name',leave_name);
    data.append('leave_id',leave_id);
    data.append('is_one_day',is_one_day);
    xmlHttp.send(data);

    xmlHttp.onreadystatechange = function()
    {
        if(xmlHttp.readyState==4)
        {

          var msg='';
         $('#messagediv').removeClass('alert-danger');
          $('#messagediv').removeClass('alert-warning');

          var reply= xmlHttp.responseText;
          console.log(reply);
          if(reply=="inserted"){
           msg="Leave Added Successfully";
           $('#messagediv').addClass('alert-success');
           
          }
          if(reply=="updated"){
             msg="Leave Updated Successfully";
             $('#messagediv').addClass('alert-success');
         }
         if(reply=="already"){
             msg="Leave Already Exists";
             $('#messagediv').addClass('alert-warning');
           
         }
        $('#messagediv').css('display','block');
        $('#showmessage').html(msg); 
        $( "#leavetable" ).load(window.location.href + " #leave" );
        $( "#formdiv" ).load(window.location.href + " #package-form" );
        $( "#packagetable" ).load(window.location.href + " #package" );
        $('#leave_id').val('');
        $('#leave_name').val('');

        }
 }
}
}

 // delete Leave
 function deleteLeave(id)
 {
   var xmlHttp = new XMLHttpRequest();
    xmlHttp.open('POST','deleteLeave',true);
    var data = new FormData();
    data.append('leave_id', id);
    xmlHttp.send(data);

    xmlHttp.onreadystatechange = function()
    {
        if(xmlHttp.readyState==4)
        {
          reply=xmlHttp.responseText;

         if(reply=="assigned") msg="Leave has been assigned to package. Unable to Delete";
         else msg="Deleted Successfully.";

         $('#messagediv').addClass('alert-danger');
         $('#messagediv').css('display','block');
        $('#showmessage').html(msg); 
         dismissModal();
        $( "#leavetable" ).load(window.location.href + " #leave" );
        $( "#formdiv" ).load(window.location.href + " #package-form" );


        }

    }
 }

// for delete button to dismiss the modal
function dismissModal()
{
         $('#leaveModal').css('display','none');
        $('#leaveModal').attr('aria-hidden', 'true');
        $('body').removeClass('modal-open');
        $('.modal-backdrop').remove();
} 

function dismissDenyModal()
{
      $('.modal').css('display','none');
        $('#exampleModalCenter').attr('aria-hidden', 'true');
        $('body').removeClass('modal-open');
        $('.modal').removeClass('show');
        $('.modal-backdrop').remove();
} 

// delete Package
 function deletePackage(id)
 {
   var xmlHttp = new XMLHttpRequest();
    xmlHttp.open('POST','deletePackage',true);
    var data = new FormData();
    data.append('package_id', id);
    xmlHttp.send(data);

    xmlHttp.onreadystatechange = function()
    {
        if(xmlHttp.readyState==4)
        {
        var reply=xmlHttp.responseText;
         if(reply=="assigned") msg="Package has been assigned to employee. Unable to Delete";
         else msg="Deleted Successfully.";
        // $('#messagediv').removeClass('alert-success');
         $('#messagediv1').addClass('alert-danger');
         $('#messagediv1').css('display','block');
        $('#showmessage1').html(msg); 
          dismissModal();
          $( "#packagetable" ).load(window.location.href + " #package" );

          $( "#formdiv" ).load(window.location.href + " #package-form" );

        }

    }
 }

 // add package
  function savePackage(){
  var package_name=document.getElementById('package_name').value;
  var package_id=document.getElementById('package_id').value;
  var leave_list= document.getElementsByName('leave-list');
  var duration= document.getElementsByName('duration');
      // getting all the leaves and their durations
      var leave = document.getElementsByName('leave-list');
  var msg;
  var leaveArr=[];
  var durationArr=[];
      for( i = 0; i < leave.length; i++ ) {
          if( leave[i].checked ) {
             var duration=leave[i].nextElementSibling.nextElementSibling.value;
             var leaveID=leave[i].value;
             leaveArr.push(leaveID);
             durationArr.push(duration);
          }
      }


   if(package_name==''||leaveArr.length==0||durationArr.length==0)
   {
     msg="Enter package name and select leave type";
     $('#messagediv1').addClass('alert-danger');
     $('#messagediv1').css('display','block');
     $('#showmessage1').html(msg); 

    return 0;
  }
 
  var xmlHttp = new XMLHttpRequest();
  xmlHttp.open('POST','savePackage',true);
  var data = new FormData();
  data.append('package_name',package_name);
  data.append('package_id',package_id);
  data.append('leaveArr',JSON.stringify(leaveArr));
  data.append('durationArr',JSON.stringify(durationArr));
  xmlHttp.send(data);

  xmlHttp.onreadystatechange = function()
{
    if(xmlHttp.readyState==4)
    {
    
     $('#messagediv1').removeClass('alert-danger');
     $('#messagediv1').removeClass('alert-warning');

      var reply= xmlHttp.responseText
      if(reply=="inserted"){
       msg="Package Added Successfully";
       $('#messagediv1').addClass('alert-success');
      }
      if(reply=="updated"){
         msg="Package Updated Successfully";
         $('#messagediv1').addClass('alert-success');
     }
     if(reply=="already"){
         msg="Package Already Exists";
         $('#messagediv1').addClass('alert-warning');
       
     }
      if(reply=="invalidDuration"){
         msg="Invalid leave duration";
         $('#messagediv1').addClass('alert-warning');
       
     }

    $('#messagediv1').css('display','block');
    $('#showmessage1').html(msg); 
  var form= document.getElementById('package-form');
  clearForm(form);
    $( "#packagetable" ).load(window.location.href + " #package" );







    }
 }
}


function editLeave(id){
  console.log(id);
    var xmlHttp = new XMLHttpRequest();
    xmlHttp.open('POST','leaveManage',true);
    var data = new FormData();
    data.append('id',id);
    xmlHttp.send(data);
    xmlHttp.onreadystatechange=function(){
      if(xmlHttp.readyState==4){
       document.open();
       document.write(xmlHttp.responseText);
       document.close();
      }
    }
} 
function editPackage(id){
    var xmlHttp = new XMLHttpRequest();
    xmlHttp.open('POST','leaveManage',true);
    var data = new FormData();
    data.append('pkgId',id);
    xmlHttp.send(data);
    xmlHttp.onreadystatechange=function(){
      if(xmlHttp.readyState==4){
       document.open();
       document.write(xmlHttp.responseText);
       document.close();
      }
    }
} 




// check age
 function getAge(dateString) 
{
    var today = new Date();
    var birthDate = new Date(dateString);
    var age = today.getFullYear() - birthDate.getFullYear();
    var m = today.getMonth() - birthDate.getMonth();
    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) 
    {
        age--;
    }
    return age;
}


 function toggleLeave(box){
      if(box.checked==true){
      box.nextElementSibling.nextElementSibling.disabled=false;
      box.nextElementSibling.nextElementSibling.value=1;
    }
     else{  
      box.nextElementSibling.nextElementSibling.disabled=true;
      box.nextElementSibling.nextElementSibling.value='';

    }
  }

  function clearForm(oForm) {
    
  var elements = oForm.elements; 
    
  oForm.reset();

  var duration = document.getElementsByName('duration');
  for(i=0;i<duration.length;i++){
    duration[i].value='';
    duration[i].disabled=true;
  }

  for(i=0; i<elements.length; i++) {
      
  field_type = elements[i].type.toLowerCase();
  
  switch(field_type) {
  
    case "text": 
    case "password": 
    case "textarea":
          case "hidden":  
      
      elements[i].value = ""; 
      break;
        
    case "radio":
    case "checkbox":
        if (elements[i].checked) {
          elements[i].checked = false; 
      }
      break;

    case "select-one":
    case "select-multi":
                elements[i].selectedIndex = -1;
      break;

    default: 
      break;
  }
    }
}


// recommend leaves to approver
function recommendLeave(btn,l_id)
{
  var parent = btn.parentElement;
  var gparent = parent.parentElement;
  parent.innerHTML='';
  parent.className="spinner-border spinner-border-sm  text-warning";
  parent.onclick="#";
  var el ='checkicon'+l_id;
  $('#'+ el).remove();
  var xmlHttp = new XMLHttpRequest();
  xmlHttp.open('POST','recommendLeave',true);
  var data = new FormData();
  data.append('l_id',l_id);
  xmlHttp.send(data);

  xmlHttp.onreadystatechange=function(){
  if(xmlHttp.readyState==4)
  {
    // console.log(xmlHttp.responseText);
   location.reload();
  }
}
}



//deny leave by recommender
function denyLeaveFromRecommender(btn,id)
{
  btn.onclick="#";
  btn.innerHTML='';
  var el ='btn'+id;
  $('#'+ el).append('<div class="spinner-border spinner-border-sm" role="status"> <span class="sr-only">Loading...</span> </div>');

  var reason = document.getElementById('denial_reason'+id).value;
  var xmlHttp = new XMLHttpRequest();
  xmlHttp.open('POST','denyLeaveFromRecommender',true);
  var data = new FormData();
  data.append('denial_reason',reason);
  data.append('id',id);
  xmlHttp.send(data);
  if(xmlHttp.readyState==4)
  xmlHttp.onreadystatechange=function(){
  {
    location.reload();
  }
}
}


// approve Substitute leave by recommender
function leaveSubstitute(id, emp_id)
{
  var xmlHttp = new XMLHttpRequest();
  xmlHttp.open('POST','leaveSubstitute',true);
  var data = new FormData();
  data.append('id', id);
  data.append('emp_id', emp_id);
 
  xmlHttp.send(data);
  xmlHttp.onreadystatechange=function(){
  if(xmlHttp.readyState==4)
    {
     location.reload();
    }
  }
}

//deny substitute leave by recommender
function denySubstituteLeave(btn, id)
{
  btn.onclick="#";
  btn.innerHTML='';
  var el ='btn'+id;
  $('#'+ el).append('<div class="spinner-border spinner-border-sm" role="status"> <span class="sr-only">Loading...</span> </div>');

  var reason = document.getElementById('denial_reason_substitute'+id).value;
  var xmlHttp = new XMLHttpRequest();
  xmlHttp.open('POST','denySubstituteLeave',true);
  var data = new FormData();
  data.append('denial_reason',reason);
  data.append('id',id);
  xmlHttp.send(data);
  xmlHttp.onreadystatechange=function(){
  if(xmlHttp.readyState==4)
  {
    location.reload();
  }
}
}




// archive Substitute Leave by recommender

function archiveSubstituteRecord(id)
{
  var xmlHttp = new XMLHttpRequest();
  xmlHttp.open('POST','archiveSubstituteRecord',true);
  var data = new FormData();
  data.append('id',id);
  xmlHttp.send(data);
  xmlHttp.onreadystatechange=function(){
  if(xmlHttp.readyState==4)
  {
    location.reload();
  }
}
}

// unarchive archived recommended leaves
function unArchiveSubstituteRecord(id) {
  var xmlHttp = new XMLHttpRequest();
    xmlHttp.open('POST','unArchiveSubstituteRecord',true);
    var data = new FormData();
    data.append('id',id);
    xmlHttp.send(data);
    xmlHttp.onreadystatechange=function(){
      if(xmlHttp.readyState==4){
       location.reload();
      }
    }
}



// approve leave by approver

function leaveApprove(d_type, id, e_id, leave_id, no_of_days = '0')
{
  // var parent = btn.parentElement;
  // var gparent = parent.parentElement;
  // parent.innerHTML='';
  // parent.className="spinner-border spinner-border-sm  text-warning";
  // parent.onclick="#";
  // var el ='checkicon'+id;
  // $('#'+ el).remove();

  var xmlHttp = new XMLHttpRequest();
  xmlHttp.open('POST','leaveApprove',true);
  var data = new FormData();
  data.append('d_type', d_type);
  data.append('id',id);
  data.append('e_id',e_id);
  data.append('leave_id',leave_id);
  data.append('no_of_days',no_of_days);
  // alert(d_type + ' ' + id + ' ' + e_id + ' ' + leave_id + ' ' + no_of_days);
  xmlHttp.send(data);
  xmlHttp.onreadystatechange=function(){
  if(xmlHttp.readyState==4)
  {
   location.reload();
  }
}
}

//deny leave by approver
function denyLeaveFromApprover(btn, id)
{
  btn.onclick="#";
  btn.innerHTML='';
  var el ='btn'+id;
  $('#'+ el).append('<div class="spinner-border spinner-border-sm" role="status"> <span class="sr-only">Loading...</span> </div>');

  var reason = document.getElementById('denial_reason_approver'+id).value;
  var xmlHttp = new XMLHttpRequest();
  xmlHttp.open('POST','denyLeaveFromApprover',true);
  var data = new FormData();
  data.append('denial_reason',reason);
  data.append('id',id);
  xmlHttp.send(data);
  xmlHttp.onreadystatechange=function(){
  if(xmlHttp.readyState==4)
  {
    location.reload();
  }
}
}

// archive approval requests
function archiveApprovalRecord(id)
{
  var xmlHttp = new XMLHttpRequest();
  xmlHttp.open('POST','archiveApprovalRecord',true);
  var data = new FormData();
  data.append('id',id);
  xmlHttp.send(data);
  xmlHttp.onreadystatechange=function(){
  if(xmlHttp.readyState==4)
  {
    location.reload();
  }
}
}

// archive approval requests
function archiveRecommendRecord(id)
{
  var xmlHttp = new XMLHttpRequest();
  xmlHttp.open('POST','archiveRecommendRecord',true);
  var data = new FormData();
  data.append('id',id);
  xmlHttp.send(data);
  xmlHttp.onreadystatechange=function(){
  if(xmlHttp.readyState==4)
  {
    location.reload();
  }
}
}

// unarchive archived recommended leaves
function unArchiveRecommendedLeave(id) {
  var xmlHttp = new XMLHttpRequest();
    xmlHttp.open('POST','unArchiveRecommendedLeave',true);
    var data = new FormData();
    data.append('id',id);
    xmlHttp.send(data);
    xmlHttp.onreadystatechange=function(){
      if(xmlHttp.readyState==4){
       location.reload();
      }
    }
}

// unarchive archived approved leaves
function unArchiveApprovedLeave(id) {
  var xmlHttp = new XMLHttpRequest();
    xmlHttp.open('POST','unArchiveApprovedLeave',true);
    var data = new FormData();
    data.append('id',id);
    xmlHttp.send(data);
    xmlHttp.onreadystatechange=function(){
      if(xmlHttp.readyState==4){
       location.reload();
      }
    }
}

// reload entire page
function cancel(){
    var xmlHttp = new XMLHttpRequest();
    xmlHttp.open('POST','leaveManage',true);
    var data = new FormData();
    xmlHttp.send(data);
    xmlHttp.onreadystatechange=function(){
      if(xmlHttp.readyState==4){
       document.open();
       document.write(xmlHttp.responseText);
       document.close();
      }
    }
} 

//assign temporary recommender

function assignRecTemp(id){
  var recId=document.getElementById('tempRecommender').value;
    var xmlHttp = new XMLHttpRequest();
    xmlHttp.open('POST','assignTemp',true);
    var data = new FormData();
    data.append('id',id)
    data.append('tempRecommender',recId)
    xmlHttp.send(data);
    xmlHttp.onreadystatechange=function(){
      if(xmlHttp.readyState==4){

    window.location.hash = '#datatable1';
    window.location.reload(true); 
      }
    }
}

 function approveByAdmin(id){
    var xmlHttp = new XMLHttpRequest();
    xmlHttp.open('POST','approveTemp',true);
    var data = new FormData();
    data.append('id',id)
    xmlHttp.send(data);
    xmlHttp.onreadystatechange=function(){
      if(xmlHttp.readyState==4){
        console.log(xmlHttp.responseText);
    window.location.hash = '#datatable1';
    window.location.reload(true); 
      }
    }
}

 function approveAllByAdmin(id){
    var xmlHttp = new XMLHttpRequest();
    xmlHttp.open('POST','approveTempAll',true);
    var data = new FormData();
    data.append('id',id)
    xmlHttp.send(data);
    xmlHttp.onreadystatechange=function(){
      if(xmlHttp.readyState==4){
        console.log(xmlHttp.responseText);
    window.location.hash = '#datatable1';
    window.location.reload(true); 
      }
    }
}


 function rejectByAdmin(id){
  var reason= document.getElementById('rejectText').value;
    var xmlHttp = new XMLHttpRequest();
    xmlHttp.open('POST','approveTemp',true);
    var data = new FormData();
    data.append('id',id)
    data.append('reason',reason)

    xmlHttp.send(data);
    xmlHttp.onreadystatechange=function(){
      if(xmlHttp.readyState==4){
    window.location.hash = '#datatable1';
    window.location.reload(true); 
      }
    }


}


  //function to display message onthe right of the button

  function showSuccessmessage(id) {
     $('#'+id).notify("Added Successfully",{className:'success',position:"right top",autoHide:'false' ,autoHideDelay: 1500000});
  }
   function showCustomSuccessmessage(id,msg) {
     $('#'+id).notify(msg,{className:'success',position:"right top",autoHide:'false',autoHideDelay: 1500000});
  }

  function showErrormessage(msg,id) {
     $('#'+id).notify(msg,{position:"right",className:'error',autoHide:'false',autoHideDelay: 150000000});
  }
  function showErrormessage2(msg,id) {
     $('#'+id).notify(msg,{position:"bottom",className:'error',autoHide:'false',autoHideDelay: 15000});
  }



//function add email

function addEmail(){
    var email_add= document.getElementById('email_add').value;
    var xmlHttp = new XMLHttpRequest();
    xmlHttp.open('POST','addEmail',true);
    var data = new FormData();
    data.append('email',email_add)

    xmlHttp.send(data);
    xmlHttp.onreadystatechange=function(){
      if(xmlHttp.readyState==4){
        var status= xmlHttp.responseText;
        if(status=="empty"){
       showErrormessage2('Enter Email','addEmailBtn');
        }
       else if(status=="invalid"){
        showErrormessage2('Enter Valid Email','addEmailBtn');
        }
        else{
        location.reload();
        addEmailForm.reset();
      }
        
      }
    }
}


//function delete email

function deleteEmail(id){
  // alert(id);
    var xmlHttp = new XMLHttpRequest();
    xmlHttp.open('POST','deleteEmail',true);
    var data = new FormData();
    data.append('id',id)

    xmlHttp.send(data);
    xmlHttp.onreadystatechange=function(){
      if(xmlHttp.readyState==4){

     
                 $('#deleteEmail'+id).css('display','none');
                  $('#deleteEmail'+id).attr('aria-hidden', 'true');
                  $('body').removeClass('modal-open');
                  $('.modal-backdrop').remove();
                  location.reload();
                  // console.log(xmlHttp.responseText);

        }
      }
    }
