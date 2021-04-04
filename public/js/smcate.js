    // カテゴリ１階層目が変更されたときの処理
    jQuery(function($){
        $(document).ajaxSend(function() {
            // ローディング画面表示
            $("#overlay").fadeIn(100);
        });
          // #smLayer1が変更されたとき
        $('#smLayer1').change(function(){
            $.ajax({
              // ajax通信開始 指定のidでデータを取得
              // url: "{{ route('seller.smcate.getSecondLayer') }}?storemap_category_id=" + $(this).val(),
              url: "/smcate_seconde_api?storemap_category_id=" + $(this).val(),
              method: 'GET',
                success: function(data){ // 成功時
                  // 取得したhtmlデータを表示
                  $('#smLayer2').html(data.html);
                  // 各classを表示させたり、非表示にしたり
                  let elem2 = document.getElementById('smLayer2');
                  elem2.style.display = 'block';
                  let elem3 = document.getElementById('smLayer3');
                  elem3.style.display = 'none';
                  let elem4 = document.getElementById('smLayer4');
                  elem4.style.display = 'none';
                  let elem5 = document.getElementById('smLayer5');
                  elem5.style.display = 'none';
                  let elem6 = document.getElementById('smLayer6');
                  elem6.style.display = 'none';
                  // 検索側は要素を削除したり空欄にしたり
                  $("#sm_search_result").empty();
                  $("#sm_search").val("");
                }
            }).done(function() {
                // ローディング画面終了
                setTimeout(function(){
                    $("#overlay").fadeOut(100);
                },300);
            });
        });
    });



    jQuery(function($){
        $(document).ajaxSend(function() {
            $("#overlay").fadeIn(100);
        });
        $('#smLayer2').change(function(){
            $.ajax({
              url: "/smcate_third_api?storemap_category_id=" + $(this).val(),
              method: 'GET',
                success: function(data){
                  if(!data){
                    let elem = document.getElementById('smLayer3');
                    elem.style.display = 'none';
                    let elem4 = document.getElementById('smLayer4');
                    elem4.style.display = 'none';
                    let elem5 = document.getElementById('smLayer5');
                    elem5.style.display = 'none';
                    let elem6 = document.getElementById('smLayer6');
                    elem6.style.display = 'none';
                    $("#sm_search_result").empty();
                    $("#sm_search").val("");
                  } else {
                    $('#smLayer3').html(data.html);
                    let elem = document.getElementById('smLayer3');
                    elem.style.display = 'block';
                    let elem4 = document.getElementById('smLayer4');
                    elem4.style.display = 'none';
                    let elem5 = document.getElementById('smLayer5');
                    elem5.style.display = 'none';
                    let elem6 = document.getElementById('smLayer6');
                    elem6.style.display = 'none';
                    $("#sm_search_result").empty();
                    $("#sm_search").val("");
                }
                }
            }).done(function() {
                setTimeout(function(){
                    $("#overlay").fadeOut(100);
                },300);
            });
        });
    });

    jQuery(function($){
        $(document).ajaxSend(function() {
            $("#overlay").fadeIn(100);
        });
        $('#smLayer3').change(function(){
            $.ajax({
              url: "/smcate_fourth_api?storemap_category_id=" + $(this).val(),
              method: 'GET',
                success: function(data){
                  if(!data){
                    let elem = document.getElementById('smLayer4');
                    elem.style.display = 'none';
                    let elem5 = document.getElementById('smLayer5');
                    elem5.style.display = 'none';
                    let elem6 = document.getElementById('smLayer6');
                    elem6.style.display = 'none';
                  } else {
                    $('#smLayer4').html(data.html);
                    let elem = document.getElementById('smLayer4');
                    elem.style.display = 'block';
                    let elem5 = document.getElementById('smLayer5');
                    elem5.style.display = 'none';
                    let elem6 = document.getElementById('smLayer6');
                    elem6.style.display = 'none';
                }
                }
            }).done(function() {
                setTimeout(function(){
                    $("#overlay").fadeOut(100);
                },300);
            });
        });
    });


    jQuery(function($){
        $(document).ajaxSend(function() {
            $("#overlay").fadeIn(100);
        });

        $('#smLayer4').change(function(){
            $.ajax({
              url: "/smcate_fifth_api?storemap_category_id=" + $(this).val(),
              method: 'GET',
              success: function(data) {
                if(!data){
                  let elem = document.getElementById('smLayer5');
                  elem.style.display = 'none';
                  let elem6 = document.getElementById('smLayer6');
                  elem6.style.display = 'none';
                } else {
                  $('#smLayer5').html(data.html);
                  let elem = document.getElementById('smLayer5');
                  elem.style.display = 'block';
                  let elem6 = document.getElementById('smLayer6');
                  elem6.style.display = 'none';
                  console.log(data.html);
              }
            }
            }).done(function() {
                setTimeout(function(){
                    $("#overlay").fadeOut(100);
                },300);
            });
        });
    });
    jQuery(function($){
        $(document).ajaxSend(function() {
            $("#overlay").fadeIn(100);
        });
        $('#smLayer5').change(function(){
            $.ajax({
              url: "/smcate_sixth_api?storemap_category_id=" + $(this).val(),
              method: 'GET',
              success: function(data) {
                if(!data){
                  let elem = document.getElementById('smLayer6');
                  elem.style.display = 'none';
                } else {
                  $('#smLayer6').html(data.html);
                  let elem = document.getElementById('smLayer6');
                  elem.style.display = 'block';
              }
              }
            }).done(function() {
                setTimeout(function(){
                    $("#overlay").fadeOut(100);
                },300);
            });
        });
    });


    // SMカテゴリで検索したときの処理
    jQuery(function($){
        $(document).ajaxSend(function() {
          // ローディング画面表示
            $("#overlay").fadeIn(100);
        });
        // #sm_searchが変更されたとき
        $('#sm_search').change(function(){
            $.ajax({
              // idでデータ取得
              url: "/smsearch_api?sm_search=" + $(this).val(),
              method: 'GET',
              success: function(data) {
                  // htmlデータ取得
                  $('#sm_search_result').html(data.html);
                  let elem = document.getElementById('sm_search_result');
                  elem.style.display = 'block';
                  let elem2 = document.getElementById('smLayer2');
                  elem2.style.display = 'none';
                  let elem3 = document.getElementById('smLayer3');
                  elem3.style.display = 'none';
                  let elem4 = document.getElementById('smLayer4');
                  elem4.style.display = 'none';
                  let elem5 = document.getElementById('smLayer5');
                  elem5.style.display = 'none';
                  let elem6 = document.getElementById('smLayer6');
                  elem6.style.display = 'none';
                  // #smLayer1は初期状態に戻す
                  $('#smLayer1').prop("selectedIndex", 0);
              }
            }).done(function() {
                setTimeout(function(){
                  // ローディング画面終了
                    $("#overlay").fadeOut(100);
                },300);
            });
        });
    });
