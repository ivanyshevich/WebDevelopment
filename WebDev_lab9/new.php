<!DOCTYPE html>
<html lang="uk">
<head>
  <meta charset="UTF-8">
  <title>New Reservation</title>
  <link rel="stylesheet" href="css/style.css">
  <script src="js/jquery-1.9.1.min.js"></script>
</head>
<body style="padding:20px;">
<?php
require '_db.php';
$rooms = $db->query("SELECT * FROM rooms ORDER BY name");
$start = $_GET['start'] ?? date('Y-m-d');
$end   = $_GET['end']   ?? date('Y-m-d');
?>
<form id="fNew">
  <h2>Новe бронювання</h2>
  <div>Ім’я:</div>
  <input type="text" name="name" required>

  <div>Початок:</div>
  <input type="datetime-local" name="start" value="<?= $start ?>T12:00">

  <div>Кінець:</div>
  <input type="datetime-local" name="end" value="<?= $end ?>T10:00">

  <div>Кімната:</div>
  <select name="room">
    <?php foreach($rooms as $r): ?>
      <option value="<?= $r['id'] ?>"><?= htmlspecialchars($r['name']) ?></option>
    <?php endforeach; ?>
  </select>

  <div style="margin-top:1rem;">
    <button type="submit">Save</button>
    <button type="button" onclick="window.close();">Cancel</button>
  </div>
</form>

<script>
$('#fNew').on('submit', function(e){
  e.preventDefault();
  $.post('backend_create.php', $(this).serialize(), function(res){
    if(res.result==='OK'){ window.opener.location.reload(); window.close(); }
  }, 'json');
});
</script>
</body>
</html>