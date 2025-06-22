<?php
// просто сторінка–контейнер; всі дані підтягує JS/AJAX
?>
<!DOCTYPE html>
<html lang="uk">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>HTML5 Бронювання кімнат в готелі (JS/PHP/MySQL)</title>

  <!-- DayPilot CSS (помістіть daypilot-all.min.css у папку css/) -->
  <link
    rel="stylesheet"
    href="https://cdn.daypilot.org/daypilot-all.min.css"
  />

  <!-- ваші стилі -->
  <link rel="stylesheet" href="css/style.css">
</head>
<body>

  <header>
    <div class="bg-help">
      <div class="inBox">
        <h1 id="logo">HTML5 Бронювання кімнат в готелі (JavaScript/PHP)</h1>
        <p id="claim">AJAX-застосунок з JavaScript/HTML5/jQuery/DayPilot</p>
      </div>
    </div>
  </header>

  <main>
    <div id="side">
      <!-- тут ми можемо додати фільтр по capacity або status -->
    </div>
    <div id="nav"><!-- сюди ініціалізуємо Scheduler --></div>
  </main>

  <footer>
    <address>
      (с)Автор лабораторної роботи: студент спеціальності «Комп'ютерні науки», група «ІУСТ-2004м», Кривошея І.С.
    </address>
  </footer>

  <!-- бібліотеки -->
  <script src="js/jquery-1.9.1.min.js"></script>
  <script src="js/daypilot-all.min.js"></script>

  <!-- логіка ініціалізації Scheduler + завантаження даних -->
  <script src="js/app.js"></script>
</body>
</html>