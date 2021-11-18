<?php include('functions.php'); ?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>MEF Visitor Form</title>
    <link rel="stylesheet" href="style.css" />
    <script src="https://kit.fontawesome.com/64d58efce2.js"></script>
    <!-- google font -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet" type="text/css" />
	<!-- icons -->
    <link href="assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
	<link rel="stylesheet" href="assets/plugins/iconic/css/material-design-iconic-font.min.css">
    <!-- bootstrap -->
	<link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- style -->
 
     <style> 

	.container-login100 {
  width: 100%;  
  min-height: 100vh;
  display: -webkit-box;
  display: -webkit-flex;
  display: -moz-box;
  display: -ms-flexbox;
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  align-items: center;
  padding: 15px;

  background-repeat: no-repeat;
  background-position: center;
  background-size: cover;
  position: relative;
  z-index: 1;  
} 
.page-background {
    background-image: url(../../img/bg-01.jpg);
}

.form {
  width: 100%;
}
.container-login100::before {
  content: "";
  display: block;
  position: absolute;
  z-index: -1;
  width: 100%;
  height: 100%;
  top: 0;
  left: 0;
  background-color: rgba(255,255,255,0.9);
}

.wrap-login100 {
  width: 500px;
  border-radius: 10px;
  overflow: hidden;
  padding: 30px 30px 30px 30px;

  background: linear-gradient(to right, #13355b 10%, #276c9c 70%);
}

/*------------------------------------------------------------------
[ Button ]*/
.container-login100-form-btn {
  width: 100%;
  display: -webkit-box;
  display: -webkit-flex;
  display: -moz-box;
  display: -ms-flexbox;
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
}

.login100-form-btn {
  font-size: 16px;
  color: #555555;
  line-height: 1.2;

  display: -webkit-box;
  display: -webkit-flex;
  display: -moz-box;
  display: -ms-flexbox;
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 0 20px;
  min-width: 120px;
  height: 50px;
  border-radius: 25px;

  background: linear-gradient(to right, #13355b 10%, #276c9c 70%);
  border:2px solid #fff;
  position: relative;
  z-index: 1;

  -webkit-transition: all 0.4s;
  -o-transition: all 0.4s;
  -moz-transition: all 0.4s;
  transition: all 0.4s;
}

.login100-form-btn::before {
  content: "";
  display: block;
  position: absolute;
  z-index: -1;
  width: 100%;
  height: 100%;
  border-radius: 25px;
  background-color: #fff;
  top: 0;
  left: 0;
  opacity: 1;

  -webkit-transition: all 0.4s;
  -o-transition: all 0.4s;
  -moz-transition: all 0.4s;
  transition: all 0.4s;
}


.login100-form-btn {
  color: #fff;
}
.login100-form-btn:hover {
  color: #fff;
  cursor: pointer;
}

.login100-form-btn:hover:before {
  opacity: 0;

}

.login100-form-btn { 
width: 50%; 
padding: .5em 1em;
 }
/*------------------------------------------------------------------
[ Responsive ]*/

@media (max-width: 576px) {
  .wrap-login100 {
    padding: 55px 15px 37px 15px;
  }
}


</style>
    
  </head>
  <body>
    <div class="container">
      
       <div class="container-login100 page-background">
	  
        <div class="contact-form wrap-login100">
         
            <center><img src="assets/img/favicon-96x96.png" /></center>
          <form action="MEF_Visitor_form.php" method="post" autocomplete="off">
		      
            <center><h3 class="title"><strong>MEF Visitor Form</h3></center>
            <div class="input-container">
              <input type="text" name="name" class="input" placeholder="Name" required />
            </div>
            <div class="input-container">
              <input type="email" name="email" class="input" placeholder="Email" required />
              
            </div>
            <div class="input-container">
              <input type="tel" name="contact" class="input" placeholder="Mobile No" required />
              
            </div>
            <div class="input-container">
              <input type="text" name="purposeofvisit" class="input" placeholder="Purpose of Visit" required />
            
            </div>
			<div class="input-container">
              <input type="text" name="contactperson" class="input" placeholder="Contact Person" required />
             
            </div>
			<div class="input-container">
			  <textarea name="remarks" class="input" placeholder="Remarks"></textarea>
            </div>
			
            <center><input type="submit" name="submit" value="Submit" class="login100-form-btn" /></center>
			
          </form>
        </div>
    </div>

</div>
    
    <script src="app.js"></script>
  </body>
</html>
