document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    console.log(sid);
    var calendar = new FullCalendar.Calendar(calendarEl, {
        plugins: [ 'interaction', 'dayGrid', 'timeGrid', 'list' ],
        //プラグイン読み込み
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
        },
        locale:'ja', // 日本語  
        navLinks: true, // 日付クリック
        eventLimit: true, // 日付の予定数が越えたら＋表示になる
        defaultView: 'dayGridMonth',
        //カレンダーを月ごとに表示
        editable: false,
        //イベント編集
        firstDay : 1,
        //秋の始まりを設定。1→月曜日。defaultは0(日曜日)
        eventDurationEditable : false,
        //イベントの期間変更
        selectLongPressDelay:0,
        // スマホでタップしたとき即反応
        events: `/calendar/load-events/${sid}`,
        //一旦イベントのサンプルを表示。動作確認用。
        // aspectRatio: 1.15,
        height:650
    });
    // objCalendarを受信
    objCalendar = calendar;
    calendar.render();
 
});
