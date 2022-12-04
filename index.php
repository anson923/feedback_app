<?php include 'include/header.php' ?>

<?php

//POST submit
$allowed_ext = array('png', 'jpg', 'jpeg');
$allowed_ext_str = implode( ',', $allowed_ext );
if (isset($_POST['submit'])) {
  $name = $nameErr = $email = $feedback = $feedbackErr = $image = $imageErr = "";

  if (!empty($_FILES['upload'])) {
    //Check extension
    $path = $_FILES['upload']['name'];
    $ext = pathinfo($path, PATHINFO_EXTENSION);
    if (in_array($ext, $allowed_ext)) {
      $file_tmp = $_FILES['upload']['tmp_name'];
      $img = file_get_contents($file_tmp);
      $data = base64_encode($img); 
      $image = $data;
    }
  }

  $imageErr = empty($_FILES['upload']) || !in_array($ext, $allowed_ext) ? "<p style='color:red'> File Type is not a supported image type({$allowed_ext_str}) </p>" : "";
  $nameErr = empty($_POST['name']) ? "<p style='color:red'> Name cannot be empty </p>" : "";
  $feedbackErr = empty($_POST['feedback']) ? "<p style='color:red'> Feedback cannot be empty </p>" : "";

  if (empty($nameErr) && empty($feedbackErr) && empty($imageErr)) {
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $feedback = filter_input(INPUT_POST, 'feedback', FILTER_SANITIZE_SPECIAL_CHARS);

    $sql = "INSERT INTO feedback_app (name,email,feedback,upload) VALUES ('$name', '$email', '$feedback', '$image')";

    if($result = mysqli_query($conn,$sql))
    {
      header('Location: feedback.php');
    }
  }
}

?>

<div class="feedback-form">
  <div class="banner">
    <img class="banner-img" src="res/Yummy_Restaurant_Banner.png" alt="Yummy Restaurant banner" />
  </div>

  <div>
    <form class="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
      <div class="form-element">
        <label for="name" class="form-label"> *Name:</label>
        <input type="text" class="form-control <?php echo !$nameErr ?: 'is-invalid'; ?>" placeholder="Enter Your Name" name="name">
        <div class="is-invalid">
          <?php echo $nameErr ?? null ?>
        </div>
      </div>

      <div class="form-element">
        <label for="email" class="form-label"> Email:</label>
        <input type="email" class="form-control" placeholder="Enter Your Email" name="email">
      </div>

      <div class="form-element">
        <label for="feedback" class="form-label"> *Feedback:</label>
        <textarea name="feedback" class="form-control <?php echo !$nameErr ?: 'is-invalid'; ?>" name="feedback"></textarea>
        <div class="is-invalid">
          <?php echo $feedbackErr ?? null ?>
        </div>
      </div>

      <div class="form-element">
        <label for="upload" class="form-label"> Food Image:</label>
        <input type="file" value="Upload Image" name="upload">
        <div class="is-invalid">
          <?php echo $imageErr ?? null ?>
        </div>
      </div>


      <input class="submit" type="submit" value="Submit" name="submit">
    </form>
  </div>
</div>

<?php include 'include/footer.php' ?>