<?php
// index.php — клієнтський контейнер для Лаб.11
?>
<!DOCTYPE html>
<html lang="uk">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Лаб.11: Клієнтська логіка — HTML5 Бронювання кімнат</title>

  <!-- DayPilot CSS -->
  <link rel="stylesheet" href="https://cdn.daypilot.org/daypilot-all.min.css" />

  <!-- Власні стилі -->
  <link rel="stylesheet" href="css/style.css">

  <!-- Вбудовані CSS для rowHeaderColumns -->
  <style>
    .scheduler_default_rowheader_inner {
      border-right: 1px solid #ccc;
    }
    .scheduler_default_rowheader.scheduler_default_rowheadercol2 {
      background: #fff;
    }
  </style>
</head>
<body>

  <header>
    <h1>HTML5 Бронювання кімнат в готелі (JavaScript/PHP)</h1>
    <p>AJAX-застосунок з JavaScript/HTML5/jQuery/DayPilot</p>
  </header>

  <main>
    <div id="side">
      Показати кімнати:
      <select id="filter">
        <option value="0">Всі</option>
        <option value="1">Одномісні</option>
        <option value="2">Двомісні</option>
        <option value="4">Сімейні</option>
      </select>
      <button id="addRoomBtn">Додати кімнату</button>
    </div>
    <div id="dp"><!-- сюди ініціалізується Scheduler --></div>
  </main>

  <footer>
    <address>
      (с) Автор лабораторної роботи: студент спеціальності «Комп'ютерні науки»,
      група «ІУСТ-2004м», Кривошея І.С.
    </address>
  </footer>

  <!-- jQuery та DayPilot з локальної папки -->
  <script src="js/jquery-1.9.1.min.js"></script>
  <script src="js/daypilot-all.min.js"></script>
  <!-- Ваша клієнтська логіка -->
  <script src="js/app.js"></script>

  <script>
    $(document).ready(function() {
      $("#filter").change(function() {
        loadResources();
      });
      $("#addRoomBtn").click(function() {
        var modal = new DayPilot.Modal();
        modal.closed = function() {
          if (this.result && this.result.result === "OK") {
            loadResources();
          }
        };
        modal.showUrl("room_new.php");
      });
    });
  </script>

</body>
</html>
