/* js/app.js
   Лабораторна № 9 — ініціалізація DayPilot Scheduler
   -------------------------------------------------- */

$(function () {

  /* 1. Створюємо екземпляр Scheduler у контейнері #nav */
  const dp = new DayPilot.Scheduler("nav");

  /* 2. Базові налаштування таймлайна */
  dp.startDate   = DayPilot.Date.today().firstDayOfMonth();   // початок – 1-ше число поточного місяця
  dp.days        = dp.startDate.daysInMonth();                // стільки днів, скільки у місяці
  dp.scale       = "Day";                                     // одна клітинка = 1 день
  dp.cellWidth   = 80;                                        // ширина комірки, щоб влазила повна дата
  dp.timeHeaders = [
    { groupBy: "Month" },
    { groupBy: "Day", format: "yyyy-MM-dd" }
  ];

  /* 3. Обробники дій користувача (клік та створення) */
  dp.onTimeRangeSelected = function (args) {
    const url = `new.php?start=${args.start}&end=${args.end}&resource=${args.resource}`;
    window.open(url, "_blank", "width=420,height=400");
    dp.clearSelection();
  };

  dp.onEventClicked = function (args) {
    const url = `edit.php?id=${args.e.id()}`;
    window.open(url, "_blank", "width=420,height=460");
  };

  /* 4. AJAX-завантаження ресурсів (rooms) та подій (reservations) */
  $.when(
    $.getJSON("load_rooms.php"),
    $.getJSON("load_reservations.php")
  ).done(function (roomsData, reservationsData) {

      /* 4.1 Кімнати → dp.resources */
      dp.resources = roomsData[0].map(r => ({
        id:   String(r.id),
        name: `${r.name} (${r.capacity} місць)`,
        tags: r
      }));

      /* 4.2 Бронювання → dp.events.list */
      dp.events.list = reservationsData[0].map(e => ({
        id:        String(e.id),
        resource:  String(e.resource),
        start:     e.start,
        end:       e.end,
        text:      e.text,
        barColor:  e.barColor
      }));

      /* 5. Останнім кроком — ініціалізуємо Scheduler один раз */
      dp.init();

  }).fail(function () {
      alert("Не вдалося завантажити дані з сервера.");
  });

});