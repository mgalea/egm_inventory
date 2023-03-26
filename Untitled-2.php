<div class="container-fluid">
<div class="header-25">
  <a href="index.php"><img class="header-img" src="images/logo.png" alt="Random Systems"></a>
</div>
  <label class="header-user">Hi, <?php echo $username; ?></label>
  <div class="btn-group">
    <button type="button" class="btn-lg " onclick="window.location.assign('operator.php');">Operators</button>
    <button type="button" class="btn-lg " onclick="window.location.assign('establishment.php');">Establishments</button>
    <button type="button" class="btn-lg " onclick="window.location.assign('slot.php');">Slots</button>
    <button type="button" class="btn-lg " onclick="window.location.assign('device.php');">Tags</button>
    <?php if(isset($type_user) && $type_user=="1"){ ?>
      <button type="button" class="btn-lg" onclick="window.location.assign('modify.php');">Settings</button>
    <?php } ?>
    <button type="button" class="btn-lg" onclick="window.location.assign('PHP/logout.php');">Logout</button>
  </div>
</div>