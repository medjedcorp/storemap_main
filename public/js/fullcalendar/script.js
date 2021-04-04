$(function(){

  $('.date-time').mask('0000/00/00 00:00:00');
  $('.time').mask('00:00:00');

  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });

  $("#newFastEvent").click(function(){
      clearMessages('.message');
      resetForm("#formFastEvent");
      $("#modalFastEvent input[name='id']").val('');
      // showModalCreateFastEvent = true;

      $('#modalFastEvent').modal('show');
      $("#modalFastEvent #titleModal").text('テンプレートイベントを登録');
      $("#modalFastEvent button.deleteFastEvent").css("display","none");
  });

  $('.fc-event').click(function(){
    // FastEvent 作ったとき
    clearMessages('.message');
    resetForm("#formFastEvent");

    let Event = JSON.parse($(this).attr('data-event'));
    // バリデーション多分
    $('#modalFastEvent').modal('show');
    $("#modalFastEvent #titleModal").text('テンプレートイベント');
    $("#modalFastEvent button.deleteFastEvent").css("display","flex");

    $("#modalFastEvent input[name='id']").val(Event.id);
    $("#modalFastEvent input[name='title']").val(Event.title);
    $("#modalFastEvent input[name='start']").val(Event.start);
    $("#modalFastEvent input[name='end']").val(Event.end);
    $("#modalFastEvent input:radio[name='color']").val([Event.color]);
    $("#modalFastEvent input[name='sid']").val(Event.store_id); //store_idからsidに修正
    // console.log(Event);
   });

  $(".saveFastEvent").click(function(){
    // fastEventを保存したとき
    let id = $("#modalFastEvent input[name='id']").val();
    let store_id = $("#modalFastEvent input[name='sid']").val();
    let title = $("#modalFastEvent input[name='title']").val();
    let start = $("#modalFastEvent input[name='start']").val();
    let end = $("#modalFastEvent input[name='end']").val();
    let color = $("#modalFastEvent input:radio[name='color']:checked").val();
    let Event = {
      title:title,
      store_id:store_id,
      start:start,
      end:end,
      color:color,
    };
    // console.log(Event);
    let route;

    if(id == ''){
      route = routeEvents('routeFastEventStore');
      // setTimeout("location.reload()",100);
    }else{
      route = routeEvents('routeFastEventUpdate');
      Event.id = id;
      Event._method = 'PUT';
    }
    sendEvent(route,Event);
  });

  $(".deleteFastEvent").click(function(){
    // 削除イベント
    let id =  $("#modalFastEvent input[name='id']").val();

    let Event = {
      id: id,
      _method: 'DELETE'
    };

    let route = routeEvents('routeFastEventDelete');
    // ルートイベントの設定。master.bladeのformにある
    sendEvent(route,Event);
    // イベント呼び出し
    $(`#boxFastEvent${id}`).remove();
  });

  $(".deleteEvent").click(function(){
    // 削除イベント
    let id =  $("#modalCalendar input[name='id']").val();

    let Event = {
      id: id,
      _method: 'DELETE'
    };

    let route = routeEvents('routeEventDelete');
    // ルートイベントの設定。master.bladeのformにある
    sendEvent(route,Event);
    // イベント呼び出し
  });

  $(".saveEvent").click(function(){
    // モーダルのsaveEventクラスを実行
    let id = $("#modalCalendar input[name='id']").val();

    let store_id = $("#modalCalendar input[name='sid']").val();

    let title = $("#modalCalendar input[name='title']").val();

    let start = moment($("#modalCalendar input[name='start']").val(),"YYYY/MM/DD HH:mm:ss").format("YYYY-MM-DD HH:mm:ss");
    //startのinput からYYYY/MM/DD HH:mm:ssで受け取り、momentがYYYY-MM-DD HH:mm:ssに整形
    let end = moment($("#modalCalendar input[name='end']").val(),"YYYY/MM/DD HH:mm:ss").format("YYYY-MM-DD HH:mm:ss");

    let color = $("#modalCalendar input:radio[name='color']:checked").val();

    let description = $("#modalCalendar textarea[name='description']").val();

    let Event = {
      title:title,
      store_id:store_id,
      start:start,
      end:end,
      color:color,
      description:description,
      //
    };

    let route;

    if(id == ''){
      route = routeEvents('routeEventStore');
    }else{
      route = routeEvents('routeEventUpdate');
      Event.id = id;
      Event._method = 'PUT';
    }
    sendEvent(route,Event);
      // console.log(Event);
  });
});

  function sendEvent(route, data_){

    $.ajax({
      url:route,
      data:data_,
      method:'POST',
      dataType:'json',
      success:function(json){
        // objCalendar.refetchEvents();
        if(route == routeEvents('routeFastEventStore')){
          setTimeout("location.reload()",500);
        }
        if(json){
          $("#modalCalendar").modal('hide');
          $("#modalFastEvent").modal('hide');
          objCalendar.refetchEvents();
        }
      },
      error:function(json){
        // エラーのリクエストがここに返ってくる
        // console.log(json);
        // console.logでどこにエラー入ってるか確認できる
        let responseJSON = json.responseJSON.errors;
        // responseJSON.errorsにエラーがある
        $(".message").html(loadErrors(responseJSON));
        // エラーがあるたびにloadErrors呼び出す
      }
    });
  }

  function loadErrors(response){
    let boxAlert = '<div class="alert alert-danger">';
    // for(let fields in response){ // レスポンスの回数繰り返す？
    //   boxAlert += '<span>${response[fields]}</span><br/>';
    //   // response[fields] がエラー作成してる
    // }
    for (let fields in response){
        boxAlert += `<span>${response[fields]}</span><br/>`;
        // バッククォートは変数もそのまま入れれるよ
    }
    boxAlert += '</div>';
    return boxAlert.replace(/\,/g,"<br/>");
    // 改行コードを<br>に置換
  }

  function routeEvents(route){
    return document.getElementById('calendar').dataset[route];
  }

  function clearMessages(element){
      $(element).text('');
      // エラーメッセージを消す
  }
  function resetForm(form){
    $(form)[0].reset();
  }
