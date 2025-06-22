/* js/app.js — Лаб.11: клієнтська логіка Scheduler з додатковими функціями */
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

  // 7) AJAX: завантажуємо ресурси (кімнати) з урахуванням фільтра
  function loadResources() {
    $.post("backend_rooms.php",
      { capacity: $("#filter").val() },
      function (data) {
        dp.resources = data.map(function (r) {
          return {
            id:       r.id.toString(),
            name:     r.name,
            capacity: r.capacity,
            status:   r.status
          };
        });
        dp.update();
      }
    );
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

  // 8a) Переміщення бронювань drag&drop
  dp.onEventMoved = function (args) {
    $.post("backend_move.php",
    {
        id: args.e.id(),
        newStart: args.newStart.toString(),
        newEnd: args.newEnd.toString(),
        newResource: args.newResource
    },
    function(data) {
        dp.message(data.message);
    });
  };

  // 8b) Видалення бронювань
  dp.eventDeleteHandling = "Update";
  dp.onEventDeleted = function(args) {
    $.post("backend_delete.php", { id: args.e.id() }, function() {
      dp.message("Deleted.");
    });
  };

  // 8c) Додаткова інформація про бронювання
  dp.onBeforeEventRender = function(args) {
    var start = new DayPilot.Date(args.e.start);
    var end = new DayPilot.Date(args.e.end);

    var today = DayPilot.Date.today();
    var now = new DayPilot.Date();

    args.e.html = args.e.text + " (" + start.toString("M/d/yyyy") + " - " + end.toString("M/d/yyyy") + ")";

    switch (args.e.status) {
        case "New":
            var in2days = today.addDays(1);
            if (start < in2days) {
                args.e.barColor = 'red';
                args.e.toolTip = 'Застаріле (не підтверджено вчасно)';
            } else {
                args.e.barColor = 'orange';
                args.e.toolTip = 'Новий';
            }
            break;
        case "Confirmed":
            var arrivalDeadline = today.addHours(18);
            if (start < today || (start.getDatePart() === today.getDatePart() && now > arrivalDeadline)) {
                args.e.barColor = "#f41616";
                args.e.toolTip = 'Пізнє прибуття';
            } else {
                args.e.barColor = "green";
                args.e.toolTip = "Підтверджено";
            }
            break;
        case 'Arrived':
            var checkoutDeadline = today.addHours(10);
            if (end < today || (end.getDatePart() === today.getDatePart() && now > checkoutDeadline)) {
                args.e.barColor = "#f41616";
                args.e.toolTip = "Пізній виїзд";
            } else {
                args.e.barColor = "#1691f4";
                args.e.toolTip = "Прибув";
            }
            break;
        case 'CheckedOut':
            args.e.barColor = "gray";
            args.e.toolTip = "Перевірено";
            break;
        default:
            args.e.toolTip = "Невизначений стан";
            break;
    }

    args.e.html = args.e.html + "<br /><span style='color:gray'>" + args.e.toolTip + "</span>";

    var paid = args.e.paid;
    var paidColor = "#aaaaaa";

    args.e.areas = [
        { bottom: 10, right: 4, html: "<div style='color:" + paidColor + "; font-size: 8pt;'>Paid: " + paid + "%</div>", v: "Visible"},
        { left: 4, bottom: 8, right: 4, height: 2, html: "<div style='background-color:" + paidColor + "; height: 100%; width:" + paid + "%'></div>", v: "Visible" }
    ];
  };

  dp.allowEventOverlap = false;

  // 9) Першоразове завантаження + init()
  window.loadResources = loadResources; // expose for filter change
  loadResources();
  loadEvents();
  dp.init();

});
