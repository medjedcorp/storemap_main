@extends('adminlte::page')

@section('title', 'ユーザー承認 - Storemap Cockpit')

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">ユーザー承認</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/home">Home</a></li>
                <li class="breadcrumb-item active">ユーザー承認</li>
            </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
</div>
@stop

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- left column -->
            <div id="app" class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-mouse"></i> 承認ボタンを押すことでログインできるようになります。メール認証がまだのユーザーには登録メールが自動送信されます。非公開を押すと会社情報も該当ユーザーはログイン不可となり、会社情報も非公開になります。関連ユーザーはログインできるのでご注意ください。
                        <br>※担当者名・会社名・電話番号・メールアドレスで検索可能
                        </h3>
                        <div class="card-tools">
                            <div class="input-group input-group-sm" style="width: 150px;">
                                <input type="text" v-model="keyword" class="form-control float-right">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>

                    </div>
                </div>
                <div>
                    <table class="table table-bordered">
                        <thead>
                            <th style="width: 5%;">user_id</th>
                            <th style="width: 20%;">担当者名</th>
                            <th style="width: 25%;">会社名</th>
                            <th style="width: 15%;">登録日時</th>
                            <th style="width: 10%;">承認状態</th>
                            <th style="width: 15%;">承認</th>
                        </thead>
                        <tbody v-for="(user, index) in filteredUsers" :key="user.id">
                            <tr data-toggle="collapse" v-bind:data-target="['#hoge-' + index]">
                                <td style="width: 5%;" v-text="user.id"></td>
                                <td style="width: 20%;" v-text="user.name"></td>
                                <td style="width: 25%;" v-text="user.company_name"></td>
                                <td style="width: 15%;">@{{ user.created_at | moment }}</td>
                                <td style="width: 10%;">
                                    <div class="text-success" v-if="user.accepted">承認済み</div>
                                    <div class="text-danger" v-else>未承認</div>
                                </td>
                                <td style="width: 15%;">
                                    <button type="button" class="btn btn-sm btn-primary" @click="accept(user.id, true)">承認する</button>
                                    <button type="button" class="btn btn-sm btn-danger" @click="accept(user.id, false)">取消</button>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="6" class="p-0">
                                    <div v-bind:id="['hoge-' + index]" class="collapse p-3">
                                        <dl class="row userlsit">
                                            <dt class="col-sm-2">担当者名カナ</dt>
                                            <dd class="col-sm-10">@{{ user.manager_kana }}</dd>
                                            <dt class="col-sm-2">会社名カナ</dt>
                                            <dd class="col-sm-10">@{{ user.company_kana }}</dd>
                                            <dt class="col-sm-2">メールアドレス</dt>
                                            <dd class="col-sm-10">@{{ user.email }}</dd>
                                            <dt class="col-sm-2">法人番号</dt>
                                            <dd class="col-sm-10">@{{ user.corporate_number }}</dd>
                                            <!-- <dd class="col-sm-8 offset-sm-4">Donec id elit non mi porta gravida at eget metus.</dd> -->
                                            <dt class="col-sm-2">会社住所</dt>
                                            <dd class="col-sm-10">〒@{{ user.company_postcode }} @{{ user.prefecture }} @{{ user.company_city }} @{{ user.company_adnum }} @{{ user.company_apart }}</dd>
                                            </dd>
                                            <dt class="col-sm-2">代表者名</dt>
                                            <dd class="col-sm-10">@{{ user.president_name }}</dd>
                                            <dt class="col-sm-2">担当者電話番号</dt>
                                            <dd class="col-sm-10">@{{ user.company_phone_number }}</dd>
                                            <dt class="col-sm-2">FAX番号</dt>
                                            <dd class="col-sm-10">@{{ user.company_fax_number }}</dd>
                                            <dt class="col-sm-2">サイトURL</dt>
                                            <dd class="col-sm-10"><a href="@{{ user.site_url }}" target="_blank">@{{ user.site_url }}</a></dd>
                                            <dt class="col-sm-2">公開設定</dt>
                                            <dd class="col-sm-10"><span class="text-success" v-if="user.display_flag">公開中</span>
                                                <span class="text-danger" v-else>非公開中</span>
                                            </dd>
                                            <dt class="col-sm-2">メーカー設定</dt>
                                            <dd class="col-sm-10"><span class="text-success" v-if="user.maker_flag">メーカーON</span>
                                                <span class="text-danger" v-else>メーカーOFF</span>
                                            </dd>
                                            <dt class="col-sm-2">GS1事業者コード</dt>
                                            <dd class="col-sm-10">@{{ user.gs1_company_prefix }}</dd>
                                            <dt class="col-sm-2">画像利用</dt>
                                            <dd class="col-sm-10"><span class="text-success" v-if="user.img_flag">画像利用可</span>
                                                <span class="text-danger" v-else>画像利用不可</span>
                                            </dd>
                                        </dl>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div><!-- /.container-fluid -->
</section>
@stop

@section('right-sidebar')
@stop


@section('footer')
<div class="float-right d-none d-sm-block">{!! config('const.manage.version') !!}</div>
{!! config('const.manage.footer') !!}
@stop

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}">
<style>
    .table tbody+tbody {
        border: 1px solid #dee2e6;
    }

    .userlsit dd,
    .userlsit dt {
        line-height: 2rem;
        border-bottom: 1px solid #dee2e6;
        margin-bottom: 0.5rem;
    }
</style>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/vue@2.6.10/dist/vue.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.0/axios.min.js"></script>
<script src="{{ asset('js/moment.min.js') }}"></script>
<script>
    new Vue({
        el: '#app',
        data: {
            keyword: '',
            users: []
        },
        methods: {
            getUsers() {

                const url = '/ajax/user_accept';
                axios.get(url)
                    .then(response => {

                        this.users = response.data;
                    });

            },
            accept(userId, accepted) {

                if (confirm('承認状態を変更します。よろしいですか？')) {

                    const url = '/ajax/user_accept/accept';
                    const params = {
                        user_id: userId,
                        accept: accepted
                    };
                    axios.post(url, params)
                        .then(response => {
                            console.log(response);
                            if (response.data.result) {

                                this.getUsers();

                            }

                        });

                }

            }
        },
        mounted() {

            this.getUsers();

        },
        filters: {
            moment: function(date) {
                return moment(date).format('YYYY/MM/DD HH:mm')
            }
        },
        computed: {
            filteredUsers: function() {
                var users = [];
                for (var i in this.users) {
                    var user = this.users[i];
                    if (user.name.indexOf(this.keyword) !== -1 ||
                        user.email.indexOf(this.keyword) !== -1 ||
                        user.company_phone_number.indexOf(this.keyword) !== -1 ||
                        user.company_name.indexOf(this.keyword) !== -1                        
                        ) {
                        users.push(user);
                    }
                }
                return users;
            }
        }
    });
</script>
@stop