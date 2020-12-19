<!DOCTYPE html>
<html>
<?php $this->load->view('layouts/header'); ?>
<body>
<section class="contentPage">
    <div class="container">
        <div class="row">
            <form class="txtAlign formStyle" id="login_form" method="post">
           
                <div class="form-group">
                    <h3>Login</h3>
                </div>

                <div class="row">
                    <div class="col-md-12 form-group">
                        <label>UserName</label>
                        <input type="text" name="username" class="form-control form-control-lg" placeholder="Enter Username">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control form-control-lg" placeholder="Enter Password">
                    </div>
                </div>
                <div class="form-group">
                    <input type="button" id="login_btn" value="Login" class="lastEventMore floatRight">
                </div>
            </form>
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
