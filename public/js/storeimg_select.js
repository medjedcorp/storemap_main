
'use strict';
// ページが読み込まれたら実行
$(() => {
    $('.img01-ajax').select2({
        ajax: {
            url: '/ajax/storeimg01',
            dataType: 'json',
            processResults(response) {  // データをselect2向けに加工
                let options = [];
                response.data.forEach((storeimage) => {
                    options.push({
                        id: storeimage.filename,
                        text: storeimage.filename
                    });
                });
                return {
                    results: options,
                    pagination: {
                        more: (response.next_page_url !== null)  // 次ページがあるかどうか
                    }
                };
            }
        },
        language: {"noResults": function(){ return "対象が見つかりません";}},
        escapeMarkup: function (markup) { return markup; },
        allowClear: true,
        placeholder: 'アップロードしたファイル名を入力(例：store_01.jpg)',
    });
    $('.img02-ajax').select2({
        ajax: {
            url: '/ajax/storeimg02',
            dataType: 'json',
            processResults(response) {  // データをselect2向けに加工
                let options = [];
                response.data.forEach((storeimage) => {
                    options.push({
                        id: storeimage.filename,
                        text: storeimage.filename
                    });
                });
                return {
                    results: options,
                    pagination: {
                        more: (response.next_page_url !== null)  // 次ページがあるかどうか
                    }
                };
            }
        },
        language: {"noResults": function(){ return "対象が見つかりません";}},
        escapeMarkup: function (markup) { return markup; },
        allowClear: true,
        placeholder: 'アップロードしたファイル名を入力(例：store_02.jpg)',
    });
    $('.img03-ajax').select2({
        ajax: {
            url: '/ajax/storeimg03',
            dataType: 'json',
            processResults(response) {  // データをselect2向けに加工
                let options = [];
                response.data.forEach((storeimage) => {
                    options.push({
                        id: storeimage.filename,
                        text: storeimage.filename
                    });
                });
                return {
                    results: options,
                    pagination: {
                        more: (response.next_page_url !== null)  // 次ページがあるかどうか
                    }
                };
            }
        },
        language: {"noResults": function(){ return "対象が見つかりません";}},
        escapeMarkup: function (markup) { return markup; },
        allowClear: true,
        placeholder: 'アップロードしたファイル名を入力(例：store_03.jpg)',
    });
    $('.img04-ajax').select2({
        ajax: {
            url: '/ajax/storeimg04',
            dataType: 'json',
            processResults(response) {  // データをselect2向けに加工
                let options = [];
                response.data.forEach((storeimage) => {
                    options.push({
                        id: storeimage.filename,
                        text: storeimage.filename
                    });
                });
                return {
                    results: options,
                    pagination: {
                        more: (response.next_page_url !== null)  // 次ページがあるかどうか
                    }
                };
            }
        },
        language: {"noResults": function(){ return "対象が見つかりません";}},
        escapeMarkup: function (markup) { return markup; },
        allowClear: true,
        placeholder: 'アップロードしたファイル名を入力(例：store_04.jpg)',
    });
    $('.img05-ajax').select2({
        ajax: {
            url: '/ajax/storeimg05',
            dataType: 'json',
            processResults(response) {  // データをselect2向けに加工
                let options = [];
                response.data.forEach((storeimage) => {
                    options.push({
                        id: storeimage.filename,
                        text: storeimage.filename
                    });
                });
                return {
                    results: options,
                    pagination: {
                        more: (response.next_page_url !== null)  // 次ページがあるかどうか
                    }
                };
            }
        },
        language: {"noResults": function(){ return "対象が見つかりません";}},
        escapeMarkup: function (markup) { return markup; },
        allowClear: true,
        placeholder: 'アップロードしたファイル名を入力(例：store_05.jpg)',
    });
});
