 <?php

  include'INC/header.php';
  include'LIB/User.php';
  Session::checkLogin();
  ?> 

  <?php
    
    $user= new User();
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
        
        $userLogin= $user->userLogin($_POST);
    }

  ?> 
        <div class="panel panel-default">
          <div style="max-width: 600px; margin: 0 auto;"> 
			<?php
			if (isset($userLogin)) {
			echo "$userLogin";
			}

			?>
			
        	<div class="panel-heading">
        		<h2>User Login</h2>
        	</div> 

        	<div class="panel-body">

        		<form action="" method="POST">
              <div class="form-group">
                <label for="email">Email Address</label>
                <input type="text" name="email" id="email" class="form-control" required=" " />
              </div>

              <div class="form-group">
                <label for="email">Password</label>
                <input type="Password" name="Password" id="Password" class="form-control"/>
              </div>
               <button type="submit" name="login" class="btn btn-success">Login</button>
            </form>
            
             </div>
        	</div>

            </div>

            <?php include 'INC/footer.php'; ?>
	</div>

</body>
</html>