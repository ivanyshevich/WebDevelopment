<?php
session_start();

// 1) Ініціалізація гри
if (!isset($_SESSION['board']) || isset($_POST['reset'])) {
    $_SESSION['board'] = array_fill(0, 8, ''); // 9 клітинок
    $_SESSION['turn']  = 'X';                  // Х починає
    $_SESSION['winner'] = null;
}

// 2) Обробка ходу, якщо натиснули на клітинку
if (isset($_POST['cell']) && is_null($_SESSION['winner'])) {
    $cell = (int)$_POST['cell'];
    // якщо клітинка пуста
    if ($_SESSION['board'][$cell] === '') {
        $_SESSION['board'][$cell] = $_SESSION['turn'];
        // перевірка перемоги або нічиї
        $b = $_SESSION['board'];
        $wins = [
            [0,1,2],[3,4,5],[6,7,8], // рядки
            [0,3,6],[1,4,7],[2,5,8], // стовпці
            [0,4,8],[2,4,6]          // діагоналі
        ];
        foreach ($wins as $line) {
            if ($b[$line[0]] && 
                $b[$line[0]] === $b[$line[1]] && 
                $b[$line[1]] === $b[$line[2]]) {
                $_SESSION['winner'] = $b[$line[0]];
                break;
            }
        }
        // перевірка нічиєї
        if (is_null($_SESSION['winner']) && !in_array('', $b, true)) {
            $_SESSION['winner'] = 'Draw';
        }
        // чергу перемикаємо, лише якщо ще нема переможця
        if (is_null($_SESSION['winner'])) {
            $_SESSION['turn'] = $_SESSION['turn'] === 'X' ? 'O' : 'X';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="uk">
<head>
  <meta charset="UTF-8">
  <title>Гра «Хрестики-Нолики» на PHP</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <h1>Хрестики-Нолики</h1>
  <p>Зараз грає: <strong><?= htmlspecialchars($_SESSION['turn']) ?></strong></p>
  <?php if ($_SESSION['winner']): ?>
    <p class="result">
      <?php if ($_SESSION['winner']==='Draw'): ?>
        Нічия!
      <?php else: ?>
        Переміг <?= htmlspecialchars($_SESSION['winner']) ?>!
      <?php endif ?>
    </p>
  <?php endif ?>

  <form method="post">
    <table class="board">
      <?php for ($i = 0; $i < 9; $i++): ?>
        <?php if ($i % 3 === 0) echo '<tr>'; ?>
        <td>
          <?php if ($_SESSION['board'][$i] || $_SESSION['winner']): ?>
            <span class="cell"><?= $_SESSION['board'][$i] ?></span>
          <?php else: ?>
            <button type="submit" name="cell" value="<?= $i ?>" class="cell-btn"> </button>
          <?php endif ?>
        </td>
        <?php if ($i % 3 === 2) echo '</tr>'; ?>
      <?php endfor ?>
    </table>
    <button type="submit" name="reset" class="reset-btn">Нова гра</button>
  </form>
</body>
</html>