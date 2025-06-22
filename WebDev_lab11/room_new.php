<!DOCTYPE html>
<html lang="uk">
<head>
  <meta charset="UTF-8">
  <title>New Room</title>
  <link rel="stylesheet" href="css/style.css">
  <script src="js/jquery-1.9.1.min.js"></script>
</head>
<body>
<?php
  require_once "_db.php";
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $stmt = $db->prepare("INSERT INTO rooms (name, capacity, status) VALUES (:name, :capacity, :status)");
      $stmt->execute([
          ':name' => $_POST['name'],
          ':capacity' => $_POST['capacity'],
          ':status' => $_POST['status']
      ]);
      $response = ['result' => 'OK', 'message' => 'Room added'];
      header('Content-Type: application/json');
      echo json_encode($response);
      exit;
  }
?>
<form id="f" method="post" action="room_new.php">
  <h1>New Room</h1>
  <label>Name:<br>
    <input name="name" value="">
  </label><br>
  <label>Capacity:<br>
    <select name="capacity">
      <option value="1">1</option>
      <option value="2">2</option>
      <option value="4">4</option>
    </select>
  </label><br>
  <label>Status:<br>
    <select name="status">
      <option value="Ready">Ready</option>
      <option value="Dirty">Dirty</option>
      <option value="Cleanup">Cleanup</option>
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
    $.post("room_new.php", $(this).serialize(), function(res){
      closeModal(res);
    }, "json");
    return false;
  });
  $(function(){ $("#f input[name=name]").focus() });
</script>
</body>
</html>
