<!DOCTYPE html>
<html lang="uk">
<head>
  <meta charset="UTF-8">
  <title>Edit Reservation</title>
  <link rel="stylesheet" href="css/style.css">
  <script src="js/jquery-1.9.1.min.js"></script>
</head>
<body>
<?php
  require_once "_db.php";
  $id   = intval($_GET['id']);
  $res  = $db->prepare("SELECT * FROM reservations WHERE id=:id");
  $res->execute([':id'=>$id]);
  $row  = $res->fetch(PDO::FETCH_ASSOC);
  $rooms = $db->query("SELECT * FROM rooms")->fetchAll(PDO::FETCH_ASSOC);
?>
<form id="f" action="backend_update.php">
  <h1>Edit Reservation</h1>
  <input type="hidden" name="id"    value="<?= $row['id'] ?>">
  <label>Name:<br>
    <input name="name" value="<?= htmlspecialchars($row['name']) ?>">
  </label><br>
  <label>Start:<br>
    <input name="start" value="<?= $row['start'] ?>">
  </label><br>
  <label>End:<br>
    <input name="end"   value="<?= $row['end'] ?>">
  </label><br>
  <label>Room:<br>
    <select name="room">
    <?php foreach($rooms as $r): ?>
      <option value="<?= $r['id'] ?>" <?= $r['id']==$row['room_id'] ? 'selected':'' ?>>
        <?= htmlspecialchars($r['name']) ?>
      </option>
    <?php endforeach; ?>
    </select>
  </label><br>
  <label>Status:<br>
    <select name="status">
      <?php foreach(["New","Confirmed","Arrived","CheckedOut"] as $opt): ?>
        <option value="<?= $opt?>" <?= $opt==$row['status']?'selected':''?>>
          <?= $opt ?>
        </option>
      <?php endforeach; ?>
    </select>
  </label><br>
  <label>Paid:<br>
    <select name="paid">
      <?php foreach([0,50,100] as $p): ?>
        <option value="<?= $p?>" <?= $p==$row['paid']?'selected':''?>>
          <?= $p ?>%
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
