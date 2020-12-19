<!DOCTYPE html>
<html>
<?php $this->load->view('layouts/header'); ?>
<body>
<section class="contentPage">
    <div class="container">
        <div class="row">
            <form class="txtAlign formStyle" id="app_form" method="post">
           
                <div class="form-group">
                    <h3>Add Appointment</h3>
                </div>

                <div class="row">
                    <div class="col-md-12 form-group">
                        <label for="sel1">Select Hospital</label>
                        <select class="form-control" name="Hospital_ID" id="Hospital_ID">
                            <option value="">Select</option>
                            <?php foreach($hospitals as $value) : ?>
                                <option value="<?=$value['Id']?>"><?=$value['Hospital_name']?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 form-group">
                        <label for="sel1">Select Department</label>
                        <select class="form-control" name="Department_ID" id="Department_ID">
                            <option value="">Select</option>
                            <?php foreach($departments as $value) : ?>
                                <option value="<?=$value['Id']?>"><?=$value['Department_name']?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 form-group">
                        <label>Appointment Date</label>
                        <input type="date" min="<?php echo date("Y-m-d"); ?>" name="Appointment_date" class="form-control form-control-lg">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 form-group">
                        <label>Appointment Time</label>
                        <input type="time" name="Appointment_time" class="form-control form-control-lg">
                    </div>
                </div>
                <div class="form-group">
                    <input type="button" id="app_btn" value="Add Appointment" class="lastEventMore floatRight">
                </div>
            </form>
        </div>
    </div>
</section>
</body>
<?php $this->load->view('layouts/footer'); ?>
<script>
$('#app_btn').click(function(){
               
                
    // get form id & make formdata
    var myForm = document.getElementById("app_form");
    var fd = new FormData(myForm);
    console.log('fd',fd);
    $.ajax({
        url:"<?php echo base_url('store_appointment'); ?>",
        type:"POST",
        data:fd,
        processData:false,
        contentType:false,
        cache:false,
        async:false,
        dataType:"json",
        success:function(ans)
        {
            console.log(ans.error);
            if(ans.errors)
            {
                
                $('.err').remove();
                var key_array = [];
                if(ans.app_error){
                   
                    $('#app_btn').after("<div class='err'>"+ans.errors+"</div>");
                } else {
                    $.each(ans.errors, function(key, val) {
                        key_array.push(key);
                        $('[name="'+ key +'"]',myForm).after(val);
                                    
                    });
                    
                    $('html, body').animate({
                        scrollTop: $('[name="'+ key_array[0] +'"]').offset().top - 100
                    }, 2000);
                }
            } else if(ans.success==1) {

                $('.err').remove();
                
                setTimeout(function() { 
                    window.location.href="<?=base_url('appointment')?>";
                }, 1000);
                
            } else {
                setTimeout(function() { 
                    alert(ans.error);
                    location.reload();
                }, 1000);
            }
        }
    });
});
</script>
</html>
