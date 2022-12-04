<?php include 'include/header.php' ?>

<?php

$sql = "SELECT * FROM feedback_app ORDER BY id DESC LIMIT 30";
if ($result = mysqli_query($conn, $sql)) {
  $data = $result->fetch_all(MYSQLI_ASSOC);
}


?>

<?php if (!empty($data)) : ?>

  <?php foreach ($data as $row) : ?>

    <div class="feedback-block">
      <!-- Add image if exist -->
      <?php if (!empty($row['upload'])) : ?>
        <div class="feedback-image">
          <?php
          $img = imagecreatefromstring(base64_decode($row['upload']));
          ob_start();
          imagepng($img);
          $png = ob_get_clean();
          $uri = "data:image/png;base64," . base64_encode($png);
          echo "<img class='image' src=" . $uri . " alt=\"the image\" />";
          ?>
        </div>
      <?php endif; ?>

      <!-- Feedback -->
      <div class="feedback-content">
        <?php echo $row['feedback']; ?>
      </div>

      <!-- By who and date -->
      <div class="feedback-by">
        By <?php echo $row['name']; ?> at <?php echo $row['date']; ?>
      </div>

    </div>

  <?php endforeach; ?>

<?php else : ?>

  <div class="NoFeedback"> Currently there is no feedback.</div>

<?php endif; ?>



<?php include 'include/footer.php' ?>