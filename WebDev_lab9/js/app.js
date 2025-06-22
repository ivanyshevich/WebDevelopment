// js/app.js

$(function() {
  // 1) Ініціалізуємо DayPilot Scheduler
  var dp = new DayPilot.Scheduler("nav");

  // 2) Базові налаштування календаря
  dp.startDate = DayPilot.Date.today().firstDayOfMonth();
  dp.days      = dp.startDate.daysInMonth();
  dp.scale     = "Day";

  // 3) Задаємо ширину комірки, щоб вміщувалася повна дата
  dp.cellWidth = 80;

  // 4) Кастомні заголовки: місяць + день у форматі YYYY-MM-DD
  dp.timeHeaders = [
    { groupBy: "Month" },
    { groupBy: "Day", format: "yyyy-MM-dd" }
  ];

  // 5) Ініціалізуємо порожній Scheduler
  dp.resources     = [];
  dp.events.list   = [];
  dp.init();

  // 6) Завантажуємо дані через AJAX
  $.when(
    $.getJSON("load_rooms.php"),
    $.getJSON("load_reservations.php")
  ).done(function(roomsData, reservationsData) {
    var rooms  = roomsData[0];
    var events = reservationsData[0];

    // 7) Мапимо масив кімнат у формат, потрібний Scheduler-у
    dp.resources = rooms.map(function(r) {
      return {
        id:   r.id.toString(),
        name: r.name + " (" + r.capacity + " місць)"
      };
    });

    // 8) Мапимо масив бронювань у формат DayPilot-ів
    dp.events.list = events.map(function(e) {
      return {
        id:        e.id.toString(),
        resource:  e.resource.toString(),
        start:     e.start,
        end:       e.end,
        text:      e.text,
        barColor:  e.barColor
      };
    });

    // 9) Оновлюємо Scheduler правильною інформацією
    dp.update();

    dp.onTimeRangeSelected = function(args) {
      var url = "new.php?start=" + args.start + "&end=" + args.end + "&resource=" + args.resource;
      window.open(url, "_blank", "width=420,height=400");
      dp.clearSelection();
    };

    dp.onEventClicked = function(args) {
      var url = "edit.php?id=" + args.e.id();
      window.open(url, "_blank", "width=420,height=460");
    };

  }).fail(function() {
    alert("Не вдалося завантажити дані з сервера.");
  });
});