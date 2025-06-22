<!DOCTYPE html>
<html lang="uk">
<head>
  <meta charset="UTF-8">
  <title>New Room</title>
  <link rel="stylesheet" href="css/style.css">
  <script src="js/jquery-1.9.1.min.js"></script>
</head>
<body>
<form id="f" action="backend_room_create.php">
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
