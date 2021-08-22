<?php
$email=$_POST["email"];
$subject=$_POST["subject"];
$message=$_POST["message"];
//testing my first php mail()
if(!empty($email)){
$success=mail('techelonstudios@gmail.com', $subject, $message, "From: $email");

if($success){
    $mess="Mail Sent Successfully";
}
}
?>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <!-- Bootstrap CSS -->
  

    <title>Hello, world!</title>
    <style type="text/css">
    @keyframes fadeIn {
  from {
    transform: scale(0.8);
  }

  to {
    transform: scale(1);
  }
}
.fadeIn{
  animation-name: fadeIn;
  animation-duration: 3s;
}
    body { 
      background: url(4.png) no-repeat center center fixed; 
      -webkit-background-size: cover;
      -moz-background-size: cover;
      -o-background-size: cover;
      background-size: cover;
      font-family: Arial narrow;
      font-family: Arial bold;
      font-family: Arial regular;
    }
    #mImage{
      width: 40%;
    }
    #forBidCen{
      margin-top: 5px;
    }
    #p1{
      text-align: center;
      color: white;font-size: 30px;
    }
    #p2{
     text-align: center; 
     color: black;font-size: 40px;
    }
    #p3{
     text-align: center;
     color: black;font-size: 15px;
    }
    #textCol{
      text-align: center;
    }
    #b1{
      width: 80%;
      margin-right: -30px;
    }
    #b2{
     width: 80%;
     margin-left: -30px; 
    }
    
    
    @media only screen and (min-width: 600px) {
      
    #forBidCen{
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%,-50%);
    }
    #mImage{
      width: 60%;
    }
    #textCol{
      margin-top: 30px;
    }
    #p1{
      color: white;font-size: 35px; margin-top: 17px; text-align: left;
    }
    #p2{
      color: white; font-size: 60px; font-weight: bold; text-align: left;
    }
    #p3{
      color: white; font-size: 17px; text-align: left;
    }
    #b1{
      width: 90%;
    }
    #b2{
     width: 90%; 
    }
    #p4{
      color: black;
      text-align: left;
    }
    #he{
      text-align: left;
    }
    }


    </style>
  </head>
  <body>
      <div class="spinner-grow text-primary" id="lo" role="status" style="
  display: block;
  position: fixed;
  z-index: 1031;
  top: 50%;
  right: 50%; /* or: left: 50%; */
  margin-top: -..px; /* have of the elements height */
  margin-right: -..px;">
  <span class="sr-only">Loading...</span>
</div>
    
      <div id="forBidCen" class="container">
          <?php if(!empty($mess)){ ?>
            <div class="alert text-center" role="alert" style="background-color:#dd53fc; color:white;">
  <?php
    echo $mess;
  ?>
</div>
<?php } ?>
        <div class="row">
          <div class="col-md-6 text-center">
            <img id="mImage" src="new2.png" style="visibility:hidden">
          </div>
          <div id="textCol" class="col-md-6">
            <p id="p1" >Lorem Ipsum</p>
            <p id="p2" >Lorem Ipsum</p>
            <p id="p3" >Lorem Ipsum is dummy text of the printing
             and typesetting industry. Lorem Ipsum has been
              the industry's standard dummy text ever since the 1500s</p><br><br>
              <div class="row" id="he">
                <div class="col-md-6 col-6">
                  <img id="b1" src="1.png">
                </div>
                <div class="col-md-6 col-6">
                  <img id="b2" src="2.png">
                </div>
              </div><br>
              <p id="p4">Also available for  Iphone and Android <button type="button" class="btn" style="color:white; background-color:#dd53fc;" data-toggle="modal" data-target="#exampleModalCenter">
  Contact Us
</button></p>
          </div>
        </div>
      </div>
      
     

<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content" style="background: url(4.png) no-repeat center center fixed; 
      -webkit-background-size: cover;
      -moz-background-size: cover;
      -o-background-size: cover;
      background-size: cover;">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Contact Us</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container">
            <?php if(!empty($mess)){ ?>
            <div class="alert alert-success text-center" role="alert">
  <?php
    echo $mess;
  ?>
</div>
<?php } ?>

        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
          <div class="form-group">
            <label for="email">Email address:</label>
            <input type="text" class="form-control" name="email" size="10" required>
          </div>
          <div class="form-group">
            <label for="pwd">Subject:</label>
            <input type="text" class="form-control" name="subject" required>
          </div>
          <div class="form-group">
            <label for="pwd">Message:</label>
            <textarea class="form-control" name="message"></textarea>
          </div>
          
          <button type="submit" class="btn btn-default">Submit</button>
        </form>
        </div>
      </div>
      
    </div>
  </div>
</div>
  
    
<!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script>
      $( window ).on( "load", function() {
          $("#lo").remove();
        $("#mImage").css("visibility","visible");  
        $("#mImage").addClass("fadeIn");
        console.log("ho");
    });
  </script>
  </body>
</html>