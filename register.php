  <?php

  include'INC/header.php';
  include'LIB/User.php';
  ?> 

  <?php
    
    $user= new User();
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['rgister'])) {
        
        $usrRegi= $user->userRegistration($_POST);
    }

  ?>
        <div class="panel panel-default">
          <div style="max-width: 600px; margin: 0 auto;"> 
          <?php
           if (isset($usrRegi)) {
               echo "$usrRegi";
           }

          ?>

        	<div class="panel-heading">
        		<h2>User Registration</h2>
        	</div> 

        	<div class="panel-body">

              <form action="" method="POST">

              <div class="form-group">
                <label for="name">Your Name</label>
                <input type="text" name="name" id="name" class="form-control"  />
              </div> 

              <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" class="form-control"/>
              </div> 

              <div class="form-group">
                <label for="email">Email Address</label>
                <input type="text" name="email" id="email" class="form-control"/>
              </div>

              <div class="form-group">
                <label for="Password">Password</label>
                <input type="Password" name="Password" id="Password" class="form-control"/>
              </div>

               <button type="submit" name="rgister" class="btn btn-success">Submit</button>
            </form>
             </div>
        	</div>

            </div>

            <?php include 'INC/footer.php'; ?>
	</div>

</body>
</html>