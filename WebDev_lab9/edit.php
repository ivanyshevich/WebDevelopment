<!DOCTYPE html>
<html lang="uk">
<head>
  <meta charset="UTF-8">
  <title>Edit Reservation</title>
  <link rel="stylesheet" href="css/style.css">
  <script src="js/jquery-1.9.1.min.js"></script>
</head>
<body style="padding:20px;">
<?php
require '_db.php';
$id = (int)($_GET['id'] ?? 0);
$reservation = $db->query("SELECT * FROM reservations WHERE id=$id")->fetch();
$rooms = $db->query("SELECT * FROM rooms ORDER BY name");
?>
<form id="fEdit">
  <h2>Редагувати бронювання #<?= $id ?></h2>
  <input type="hidden" name="id" value="<?= $id ?>">

  <div>Ім’я:</div>
  <input type="text" name="name" value="<?= htmlspecialchars($reservation['name']) ?>" required>

  <div>Початок:</div>
  <input type="datetime-local" name="start" value="<?= substr($reservation['start'],0,16) ?>">

  <div>Кінець:</div>
  <input type="datetime-local" name="end" value="<?= substr($reservation['end'],0,16) ?>">

  <div>Кімната:</div>
  <select name="room">
    <?php foreach($rooms as $r):
      $sel = $r['id']==$reservation['room_id']?'selected':''; ?>
      <option value="<?= $r['id'] ?>" <?= $sel ?>><?= htmlspecialchars($r['name']) ?></option>
    <?php endforeach; ?>
  </select>

  <div>Status:</div>
  <select name="status">
    <?php $opts=["New","Confirmed","Arrived","CheckedOut","Expired"];
    foreach($opts as $opt): $sel=$opt==$reservation['status']?'selected':''; ?>
      <option value="<?= $opt ?>" <?= $sel ?>><?= $opt ?></option>
    <?php endforeach; ?>
  </select>

  <div>Paid:</div>
  <select name="paid">
    <?php foreach([0,50,100] as $perc): $sel=$perc==$reservation['paid']?'selected':''; ?>
      <option value="<?= $perc ?>" <?= $sel ?>><?= $perc ?>%</option>
    <?php endforeach; ?>
  </select>

  <div style="margin-top:1rem;">
    <button type="submit">Save</button>
    <button type="button" id="btnDel">Delete</button>
    <button type="button" onclick="window.close();">Cancel</button>
  </div>
</form>

<script>
$('#fEdit').on('submit', function(e){
  e.preventDefault();
  $.post('backend_update.php', $(this).serialize(), function(res){
    if(res.result==='OK'){ window.opener.location.reload(); window.close(); }
  }, 'json');
});
$('#btnDel').on('click', function(){
  if(confirm('Delete?')){
    $.post('backend_delete.php', {id:<?= $id ?>}, function(res){
      if(res.result==='OK'){ window.opener.location.reload(); window.close(); }
    }, 'json');
  }
});
</script>
</body>
</html>