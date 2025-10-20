<?php
$current_page = isset($_GET['page']) ? $_GET['page'] : 'home';
?>

<div class="sidebar">
    <img class="store-icon" src="assets/images/icons/store.svg" alt="Store">
    <div class="divider"></div>
  <a href="/na_wan/?page=home" class="icon <?php echo $current_page == 'home' ? "active" : "" ?>">
    <?php include 'assets/images/icons/home.svg'; ?>
  </a>
  <a href="/na_wan/?page=history" class="icon <?php echo $current_page == 'history' ? "active" : "" ?>">
    <?php include 'assets/images/icons/history.svg'; ?>
  </a>
</div>