document.addEventListener('DOMContentLoaded', function() {
  var Calendar = FullCalendar.Calendar;
  var Draggable = FullCalendarInteraction.Draggable

  /* initialize the external events
  -----------------------------------------------------------------*/

  var containerEl = document.getElementById('external-events-list');
  new Draggable(containerEl, {
    itemSelector: '.fc-event',
    eventData: function(eventEl) {
      return {
        title: eventEl.innerText.trim()
      }
    }
  });

   /* initialize the calendar
  -----------------------------------------------------------------*/

  var calendarEl = document.getElementById('calendar');
  var calendar = new FullCalendar.Calendar(calendarEl, {
    plugins: [ 'interaction', 'dayGrid', 'timeGrid', 'list' ],
    header: {
      left: 'prev,next today',
      center: 'title',
      right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
    },
    locale:'ja', // 日本語
    navLinks: true, // 日付クリック
    eventLimit: true, // 日付の予定数が越えたら＋表示になる
    editable: true,
    selectable: true,
    droppable: true, // this allows things to be dropped onto the calendar

    drop: function(element) {
      // ドラッグ&ドロップのときの処理
      let Event = JSON.parse(element.draggedEl.dataset.event);

      // is the "remove after drop" checkbox checked?
      if (document.getElementById('drop-remove').checked) {
        // if so, remove the element from the "Draggable Events" list
        element.draggedEl.parentNode.removeChild(element.draggedEl);

        Event._method = "DELETE";
        sendEvent(routeEvents('routeFastEventDelete'), Event);
      }

      let start = moment(`${element.dateStr} ${Event.start}`).format("YYYY-MM-DD HH:mm:ss");
      let end = moment(`${element.dateStr} ${Event.end}`).format("YYYY-MM-DD HH:mm:ss");

      Event.start = start;
      Event.end = end;

      delete Event.id;
      delete Event._method;

      sendEvent(routeEvents('routeEventStore'), Event);
      // console.log(element.draggedEl.dataset.event);
      // console.log(Event);
    },
    eventDrop: function(element){
      // momentで日付からYYMMDDのデータベースに保存できる形式に変換
      let start = moment(element.event.start).format("YYYY-MM-DD HH:mm:ss");
      let end = moment(element.event.end).format("YYYY-MM-DD HH:mm:ss");
      let color = element.event.backgroundColor;

      let newEvent = {
        _method:'PUT',
        title: element.event.title,
        id: element.event.id,
        start: start,
        end: end,
        color: color,
      };

      console.log(newEvent);

      sendEvent(routeEvents('routeEventUpdate'), newEvent);
      // master で設定したroute。script.jsの関数を呼び出し

    },
    eventClick:function(element){
      // 既にあるイベントをクリックしたときの処理
      clearMessages('.message');
      //エラーメッセージを消す

      resetForm("#formEvent");
      // scriptjs のresetForm呼び出し。前に表示したフォームの中身を削除

      $("#modalCalendar").modal('show'); // モーダル表示
      $("#modalCalendar #titleModal").text('スケジュールを変更'); // タイトル設定
      $("#modalCalendar button.deleteEvent").css("display","flex"); // deleteボタンを表示

      console.log(element);

      let id = element.event.id;
      $("#modalCalendar input[name='id']").val(id);

      let store_id = element.event.extendedProps.store_id;
      $("#modalCalendar input[name='sid']").val(store_id);

      let title = element.event.title;
      // element の中の event の中の title を title変数に入れる
      $("#modalCalendar input[name='title']").val(title);
      // インプットのタイトルの中に、タイトルを代入

      let start = moment(element.event.start).format("YYYY/MM/DD HH:mm:ss");
      $("#modalCalendar input[name='start']").val(start);
      // moment.jsでfomatを整形

      let end = moment(element.event.end).format("YYYY/MM/DD HH:mm:ss");
      $("#modalCalendar input[name='end']").val(end);

      let color = element.event.backgroundColor;
      $("#modalCalendar input:radio[name='color']").val([color]);
      // $("#modalCalendar input[name='color']").val(color);

      let description = element.event.extendedProps.description;
      // descriptionはelementの中のeventの中のextendedPropsの中にいるよ
      $("#modalCalendar textarea[name='description']").val(description);

    },
    eventResize:function(element){
      // 既にあるイベントの期間を変更したときの処理
      // momentで日付からYYMMDDのデータベースに保存できる形式に変換
      let start = moment(element.event.start).format("YYYY-MM-DD HH:mm:ss");
      let end = moment(element.event.end).format("YYYY-MM-DD HH:mm:ss");
      let color = element.event.backgroundColor;
      let store_id = element.event.extendedProps.store_id;

      let newEvent = {
        _method:'PUT',
        title: element.event.title,
        id: element.event.id,
        start: start,
        end: end,
        color: color,
        store_id:store_id,
      };
      sendEvent(routeEvents('routeEventUpdate'), newEvent);
      // master で設定したroute。script.jsの関数を呼び出し
      console.log(newEvent);
    },
    select:function(element){
      // 何もないところの日付をクリックしたときの処理

      clearMessages('.message');
      //エラーメッセージを消す
      resetForm("#formEvent"); // scriptjs のresetForm呼び出し

      // console.log(element);

      $("#modalCalendar").modal('show');
      $("#modalCalendar #titleModal").text('スケジュールを登録');
      $("#modalCalendar button.deleteEvent").css("display","none");

      // let store_id = element.event.extendedProps.store_id;
      // $("#modalCalendar input[name='sid']").val(store_id);

      let start = moment(element.start).format("YYYY/MM/DD HH:mm:ss");
      $("#modalCalendar input[name='start']").val(start);
      // moment.jsでfomatを整形

      let end = moment(element.end).format("YYYY/MM/DD HH:mm:ss");
      $("#modalCalendar input[name='end']").val(end);

      // $("#modalCalendar input[name='event_color_id']").val("1");

      calendar.unselect();
    },
    eventReceive: function(element){
      element.event.remove();
    },
    events: routeEvents('routeLoadEvents'),
  });
  // objCalendarを受信
  objCalendar = calendar;
  calendar.render();

});
