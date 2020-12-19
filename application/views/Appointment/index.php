<!DOCTYPE html>
<html>
<?php $this->load->view('layouts/header'); ?>
<body>
<section class="contentPage">
    <div class="container">
        <div class="row">
            <div>
            <a class="btn btn-primary" href="<?=base_url('appointment_add')?>" role="button">Add Appointment</a>
            </div>
            <div>
            <a class="btn btn-primary" href="<?=base_url('logout')?>" role="button">Logout</a>
            </div>

            <div>
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Hospital Name</th>
                    <th>Department Name</th>
                    <th>Appointment Date</th>
                    <th>Appointment Time</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($data as $value) : ?>
                <tr>
                    <td><?= $value['Hospital_name'] ?></td>
                    <td><?= $value['Department_name'] ?></td>
                    <td><?= $value['Appointment_date'] ?></td>
                    <td><?= $value['Appointment_time'] ?></td>
                    <td><?= $value['Created_at'] ?></td>
                    <td><a class="btn btn-primary" href="<?=base_url('delete_appointmet/').$value['Id']?>" role="button">Delete</a></td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            </div>
        </div>
    </div>
</section>
</body>
<?php $this->load->view('layouts/footer'); ?>
<script>
$('#login_btn').click(function(){
               
                
    // get form id & make formdata
    var myForm = document.getElementById("login_form");
    var fd = new FormData(myForm);
    console.log('fd',fd);
    $.ajax({
        url:"<?php echo base_url('login_check'); ?>",
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
                if(ans.login_error){
                   
                    $('#login_btn').after("<div class='err'>"+ans.errors+"</div>");
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
