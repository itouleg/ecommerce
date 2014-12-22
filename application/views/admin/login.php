<!DOCTYPE html>
<html lang="en">
    <head>
        <?= $this->load->view('admin/header'); ?>
    </head>
    <body>
        <style type="text/css">
            body { background: url(<?= base_url('themes/metro/img/bg-login.jpg'); ?>) !important; }
        </style>
        <div class="container-fluid-full">
            <div class="row-fluid">

                <div class="row-fluid">
                    <div class="login-box">
                        <div class="icons">
                            <a href="<?= base_url('main'); ?>"><i class="halflings-icon home"></i></a>
                            <a href="#"><i class="halflings-icon cog"></i></a>
                        </div>
                        <h2>Login to your account</h2>
                        <form id="frm-login" class="form-horizontal" action="<?= site_url('admin/login/signin'); ?>" method="post">
                            <div class="alert alert-danger center hidden"></div>
                            <fieldset>
                                <div class="input-prepend" title="Username">
                                    <span class="add-on"><i class="halflings-icon user"></i></span>
                                    <input class="input-large span10" name="username" id="username" type="text" placeholder="type username"/>
                                </div>
                                <div class="clearfix"></div>

                                <div class="input-prepend" title="Password">
                                    <span class="add-on"><i class="halflings-icon lock"></i></span>
                                    <input class="input-large span10" name="password" id="password" type="password" placeholder="type password"/>
                                </div>
                                <div class="clearfix"></div>
                                <div class="button-login">	
                                    <input type="button" id="login-btn" class="btn btn-primary" value="Login">
                                </div>
                                <div class="clearfix"></div>
                        </form>
                        <hr>
                        <h3>Forgot Password?</h3>
                        <p>
                            No problem, <a href="#">click here</a> to get a new password.
                        </p>	
                    </div><!--/span-->
                </div><!--/row-->


            </div><!--/.fluid-container-->

        </div><!--/fluid-row-->

        <!-- start: JavaScript-->
        <script  src="<?= base_url('themes/metro/js/jquery-1.9.1.min.js'); ?>"></script>
        <script>
            $(function(){
               $("#login-btn").click(function(){
                   login();
               }); 
               
               $("#username,#password").on("keyup",function(event){
                   if(event.keyCode==13)
                   {
                       login();
                   }
               });
            });
            
            function login()
            {
                var path = $("#frm-login").attr("action");
               $.ajax({
                   url:path,
                   type:"post",
                   data: $("#frm-login").serialize(),
                   dataType: "json",
                   success: function(response){
                       console.log(response);
                       if(response.status)
                       {
                           $(".alert").removeClass("hidden").removeClass("alert-danger").addClass("alert-success").html(response.message);
                           
                           window.location.href = "<?= site_url('admin/dashboard'); ?>";
                       }else{
                           $(".alert").removeClass("hidden").removeClass("alert-success").addClass("alert-danger").html(response.message);
                       }
                   }
               });
            }
        </script>
        <!-- end: JavaScript-->
    </body>
</html>