<?php
include 'authHeader.php';
?>
<div class="container">
    <div class="row mt-5 p-2 justify-content-center">
        <div class="col-md-6">
            <div class="card">
                
                    <h3 class="  text-mute text-dark text-center mt-3">Login Here</h3>
                
                <div class="card-body">
                    <form action="" method="post">
                        <div class="input-group p-3">
                           <div class="icons bg-primary">
                                <i class="fa fa-user text-light p-3" ></i>
                           </div> 
                            <input type="email" class="form-control p-2" placeholder="Email" name="email">
                        </div>
                        <div class="input-group p-3">

                        <div class="icons bg-primary">
                                <i class="fa fa-lock text-light p-3" ></i>
                           </div> 

                            <input type="password" class="form-control p-2" placeholder="Password" name="userpassword">
                        </div>

                        <button type="submit" name="submit" class="w-100 btn btn-lg btn-primary mt-4 mb-4 ">Login</button>
                    </form>
                    <p class="mt-2 p-2 text-center">Don't have an account? <a class="text-decoration-none" href="register">Register here</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

