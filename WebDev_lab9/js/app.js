/* js/app.js
   Лабораторна №9 — ініціалізація DayPilot Scheduler
   -------------------------------------------------- */

$(function () {

  // 1) Створюємо екземпляр Scheduler у контейнері #nav
  const dp = new DayPilot.Scheduler("nav");

  // 2) Базові налаштування таймлайна
  dp.startDate   = DayPilot.Date.today().firstDayOfMonth();
  dp.days        = dp.startDate.daysInMonth();
  dp.scale       = "Day";
  dp.cellWidth   = 80;
  dp.timeHeaders = [
    { groupBy: "Month" },
    { groupBy: "Day",   format: "yyyy-MM-dd" }
  ];

  // 3) Клік на пустий діапазон → new.php
  dp.onTimeRangeSelected = function (args) {
    const url = `new.php?start=${args.start}&end=${args.end}&resource=${args.resource}`;
    window.open(url, "_blank", "width=420,height=400");
    dp.clearSelection();
  };

  // 4) Клік на існуюче бронювання → edit.php
  dp.onEventClicked = function (args) {
    const url = `edit.php?id=${args.e.id()}`;
    window.open(url, "_blank", "width=420,height=460");
  };

  // 5) Перш ніж відмалювати кожний event — додаємо html
  dp.onBeforeEventRender = function(args) {
    const e = args.e;
    const sd = DayPilot.Date(e.start);
    const ed = DayPilot.Date(e.end).addDays(-1); // -1 щоб показати справжній останній день
    // текст + новий рядок + формат початку–кінця
    e.html = e.text + "<br/>" + sd.toString("yyyy-MM-dd") + " – " + ed.toString("yyyy-MM-dd");
  };

  // 6) AJAX → load_rooms.php та load_reservations.php
  $.when(
    $.getJSON("load_rooms.php"),
    $.getJSON("load_reservations.php")
  ).done(function (roomsData, reservationsData) {
    // 6.1 – кімнати
    dp.resources = roomsData[0].map(r => ({
      id:      String(r.id),
      name:    `${r.name} (${r.capacity} місць)`,
      tags:    r
    }));
    // 6.2 – бронювання
    dp.events.list = reservationsData[0].map(e => ({
      id:        String(e.id),
      resource:  String(e.resource),
      start:     e.start,
      end:       e.end,
      text:      e.name || e.text,     // залежить від того, як ви називаєте поле
      barColor:  e.barColor || "#4A90E2"
    }));
    // 6.3 – відмалювати Scheduler
    dp.init();

  }).fail(function () {
    alert("Не вдалося завантажити дані з сервера.");
  });
});