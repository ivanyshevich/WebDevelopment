<!DOCTYPE html>
<html lang="uk">
<head>
  <meta charset="UTF-8">
  <title>New Reservation</title>
  <link rel="stylesheet" href="css/style.css">
  <script src="js/jquery-1.9.1.min.js"></script>
</head>
<body>
<?php
  require_once "_db.php";
  $rooms = $db->query("SELECT * FROM rooms")->fetchAll(PDO::FETCH_ASSOC);
  $start = $_GET['start'];
  $end   = $_GET['end'];
  $resId = $_GET['resource'];
?>
<form id="f" action="backend_create.php">
  <h1>New Reservation</h1>
  <label>Name:<br>
    <input name="name" value="">
  </label><br>
  <label>Start:<br>
    <input name="start" value="<?= htmlspecialchars($start) ?>">
  </label><br>
  <label>End:<br>
    <input name="end" value="<?= htmlspecialchars($end) ?>">
  </label><br>
  <label>Room:<br>
    <select name="room">
    <?php foreach($rooms as $r): ?>
      <option
        value="<?= $r['id'] ?>"
        <?= $r['id']==$resId? 'selected':'' ?>>
        <?= htmlspecialchars($r['name']) ?>
      </option>
    <?php endforeach; ?>
    </select>
  </label><br>
  <button type="submit">Save</button>
  <button type="button" onclick="closeModal()">Cancel</button>
</form>

<script>
  function closeModal(result) {
    parent.DayPilot.ModalStatic.close(result);
  }
  $("#f").submit(function(){
    $.post($(this).attr("action"), $(this).serialize(), function(res){
      closeModal(res);
    }, "json");
    return false;
  });
  $(function(){ $("#f input[name=name]").focus() });
</script>
</body>
</html>