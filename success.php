<?php
if(session_id() == '' || !isset($_SESSION)){session_start();}
?>

<!doctype html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title> Athletic Park </title>
    <link rel="stylesheet" href="css/foundation.css" />
    <script src="js/vendor/modernizr.js"></script>
    <!-- Auto redirect after 3 seconds -->
    <meta http-equiv="refresh" content="3;url=index.php">
    <style>
      .success-message {
        max-width: 600px;
        margin: 50px auto;
        padding: 30px;
        text-align: center;
        border: 2px solid #28a745;
        border-radius: 10px;
        background-color: #d4edda;
        color: #155724;
        font-size: 1.2em;
      }
    </style>
  </head>
  <body>

    <?php include 'header.php'; ?>

    <div class="success-message">
        <p>Success! Your task has been executed successfully. 🎉</p>
        <p>If you purchased a product, please check your email (including spam) for the receipt.</p>
        <p>You will be redirected to the homepage shortly...</p>
    </div>

    <?php include 'footer.php'; ?>

    <script src="js/vendor/jquery.js"></script>
    <script src="js/foundation.min.js"></script>
    <script>
      $(document).foundation();
    </script>
  </body>
</html>
