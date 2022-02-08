  <?php
      
  include 'LIB/User.php';
  include'INC/header.php';
  Session::checkSession();
  ?> 

  <?php 
  if (isset($_GET['id'])){
     $userid = (int)$_GET['id'];
      $sesId = Session::get("id");
        if ($userid != $sesId){
           header("Location: index.php");
        }
  }
      $user = new User();
     if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['updatepass'])) {
        
        $updatepass= $user->updatePassword($userid , $_POST);
    }
  ?>

       <div class="panel-heading">
            <h2>Change Password <span class="pull-right"><strong><a class="btn btn-primary" href="profile.php?id=<?php echo $userid;?>">BACK</a></strong></h2>
          </div>

        <div class="panel panel-default">
          <div style="max-width: 600px; margin: 0 auto;"> 
            <?php
            if (isset($updatepass)) {
              echo "$updatepass";
            }
            ?>

        	<div class="panel-body">
        		<form action="" method="POST">

              <div class="form-group">
                <label for="old_pass">Old Password</label>
                <input type="password" name="old_pass" id="old_pass" class="form-control"/>
              </div> 

              <div class="form-group">
                <label for="Password">New Password</label>
                <input type="password" name="Password" id="Password" class="form-control"/>
              </div> 
            
               <button type="submit" name="updatepass" class="btn btn-success">Update</button>
            </form>
             </div>
        	   </div>
            </div>

            <?php include 'INC/footer.php'; ?>
	</div>

</body>
</html>