/* js/app.js — Лаб.10: клієнтська логіка Scheduler */
$(function () {

  // 1) Ініціалізуємо Scheduler у блоці #dp
  var dp = new DayPilot.Scheduler("dp");

  // 2) Налаштовуємо часову шкалу
  dp.startDate   = DayPilot.Date.today().firstDayOfMonth();
  dp.days        = dp.startDate.daysInMonth();
  dp.scale       = "Day";
  dp.timeHeaders = [
    { groupBy: "Month", format: "MMMM yyyy" },
    { groupBy: "Day",   format: "d" }
  ];

  // 3) Додаємо три колонки зліва: Room, Capacity, Status
  dp.rowHeaderColumns = [
    { title: "Room",     width: 100 },
    { title: "Capacity", width:  80 },
    { title: "Status",   width:  80 }
  ];

  // 4) Перед рендером заголовків ряду виводимо дані та привласнюємо клас
  dp.onBeforeResHeaderRender = function (args) {
    args.resource.columns[1].html = args.resource.capacity + " місць";
    args.resource.columns[2].html = args.resource.status;
    switch (args.resource.status) {
      case "Dirty":
        args.resource.cssClass = "status_dirty";
        break;
      case "Cleanup":
        args.resource.cssClass = "status_cleanup";
        break;
    }
  };

  // 5) Форма створення бронювання (модальне вікно)
  dp.onTimeRangeSelected = function (args) {
    var modal = new DayPilot.Modal();
    modal.closed = function () {
      dp.clearSelection();
      if (this.result && this.result.result === "OK") {
        loadEvents();
      }
    };
    modal.showUrl(
      "new.php?start=" + args.start +
      "&end="   + args.end   +
      "&resource=" + args.resource
    );
  };

  // 6) Форма редагування бронювання
  dp.onEventClick = function (args) {
    var modal = new DayPilot.Modal();
    modal.closed = function () {
      if (this.result && this.result.result === "OK") {
        loadEvents();
      }
    };
    modal.showUrl("edit.php?id=" + args.e.id());
  };

  // 7) AJAX: завантажуємо ресурси (кімнати)
  function loadResources() {
    $.post("backend_rooms.php", function (data) {
      dp.resources = data.map(function (r) {
        return {
          id:       r.id.toString(),
          name:     r.name,
          capacity: r.capacity,
          status:   r.status
        };
      });
      dp.update();
    });
  }

  // 8) AJAX: завантажуємо бронювання
  function loadEvents() {
    var start = dp.visibleStart(),
        end   = dp.visibleEnd();
    $.post("backend_events.php",
      { start: start.toString(), end: end.toString() },
      function (data) {
        dp.events.list = data.map(function (e) {
          return {
            id:       e.id.toString(),
            resource: e.resource.toString(),
            start:    e.start,
            end:      e.end,
            text:     e.text
          };
        });
        dp.update();
      }
    );
  }

  // 9) Першоразове завантаження + init()
  loadResources();
  loadEvents();
  dp.init();

});