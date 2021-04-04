
'use strict';
// ページが読み込まれたら実行
$(() => {
    $('.img01-ajax').select2({
        ajax: {
            url: '/ajax/itemimg01',
            dataType: 'json',
            processResults(response) {  // データをselect2向けに加工
                let options = [];
                response.data.forEach((itemimage) => {
                    options.push({
                        id: itemimage.filename,
                        text: itemimage.filename
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
        placeholder: 'アップロードしたファイル名を入力(例：item_01.jpg)',
    });
});
// ページが読み込まれたら実行
$(() => {
    $('.img02-ajax').select2({
        ajax: {
            url: '/ajax/itemimg02',
            dataType: 'json',
            processResults(response) {  // データをselect2向けに加工
                let options = [];
                response.data.forEach((itemimage) => {
                    options.push({
                        id: itemimage.filename,
                        text: itemimage.filename
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
        placeholder: 'アップロードしたファイル名を入力(例：item_02.jpg)',
    });
});
// ページが読み込まれたら実行
$(() => {
    $('.img03-ajax').select2({
        ajax: {
            url: '/ajax/itemimg03',
            dataType: 'json',
            processResults(response) {  // データをselect2向けに加工
                let options = [];
                response.data.forEach((itemimage) => {
                    options.push({
                        id: itemimage.filename,
                        text: itemimage.filename
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
        placeholder: 'アップロードしたファイル名を入力(例：item_03.jpg)',
    });
});
// ページが読み込まれたら実行
$(() => {
    $('.img04-ajax').select2({
        ajax: {
            url: '/ajax/itemimg04',
            dataType: 'json',
            processResults(response) {  // データをselect2向けに加工
                let options = [];
                response.data.forEach((itemimage) => {
                    options.push({
                        id: itemimage.filename,
                        text: itemimage.filename
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
        placeholder: 'アップロードしたファイル名を入力(例：item_04.jpg)',
    });
});
// ページが読み込まれたら実行
$(() => {
    $('.img05-ajax').select2({
        ajax: {
            url: '/ajax/itemimg05',
            dataType: 'json',
            processResults(response) {  // データをselect2向けに加工
                let options = [];
                response.data.forEach((itemimage) => {
                    options.push({
                        id: itemimage.filename,
                        text: itemimage.filename
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
        placeholder: 'アップロードしたファイル名を入力(例：item_05.jpg)',
    });
});
// ページが読み込まれたら実行
$(() => {
    $('.img06-ajax').select2({
        ajax: {
            url: '/ajax/itemimg06',
            dataType: 'json',
            processResults(response) {  // データをselect2向けに加工
                let options = [];
                response.data.forEach((itemimage) => {
                    options.push({
                        id: itemimage.filename,
                        text: itemimage.filename
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
        placeholder: 'アップロードしたファイル名を入力(例：item_06.jpg)',
    });
});
// ページが読み込まれたら実行
$(() => {
    $('.img07-ajax').select2({
        ajax: {
            url: '/ajax/itemimg07',
            dataType: 'json',
            processResults(response) {  // データをselect2向けに加工
                let options = [];
                response.data.forEach((itemimage) => {
                    options.push({
                        id: itemimage.filename,
                        text: itemimage.filename
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
        placeholder: 'アップロードしたファイル名を入力(例：item_07.jpg)',
    });
});
// ページが読み込まれたら実行
$(() => {
    $('.img08-ajax').select2({
        ajax: {
            url: '/ajax/itemimg08',
            dataType: 'json',
            processResults(response) {  // データをselect2向けに加工
                let options = [];
                response.data.forEach((itemimage) => {
                    options.push({
                        id: itemimage.filename,
                        text: itemimage.filename
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
        placeholder: 'アップロードしたファイル名を入力(例：item_08.jpg)',
    });
});
// ページが読み込まれたら実行
$(() => {
    $('.img09-ajax').select2({
        ajax: {
            url: '/ajax/itemimg09',
            dataType: 'json',
            processResults(response) {  // データをselect2向けに加工
                let options = [];
                response.data.forEach((itemimage) => {
                    options.push({
                        id: itemimage.filename,
                        text: itemimage.filename
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
        placeholder: 'アップロードしたファイル名を入力(例：item_09.jpg)',
    });
});
// ページが読み込まれたら実行
$(() => {
    $('.img10-ajax').select2({
        ajax: {
            url: '/ajax/itemimg10',
            dataType: 'json',
            processResults(response) {  // データをselect2向けに加工
                let options = [];
                response.data.forEach((itemimage) => {
                    options.push({
                        id: itemimage.filename,
                        text: itemimage.filename
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
        placeholder: 'アップロードしたファイル名を入力(例：item_10.jpg)',
    });
});
