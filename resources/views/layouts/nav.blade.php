<!--　ヘッダー　-->
{{--<script src="https://code.jquery.com/jquery-3.0.0.js" integrity="sha256-jrPLZ+8vDxt2FnE1zvZXCkCcebI/C8Dt5xyaQBjxQIo=" crossorigin="anonymous"></script>--}}
<header class="header">
    <div class="header-left">
        <?php if(!empty(session('login_date'))): ?>
        <div class="header-msg">
            ようこそ
            @if(!empty(session('name_sei')))
                {{ session('name_sei') }}{{ session('name_mei') }}
            @endif
            様
        </div>
        <?php endif ?>
    </div>
    <div class="header-right">
        <ul>
            <li><a class="btn btn-header" href="{{ route('products.show') }}">商品一覧</a></li>
            <?php if(empty(session('login_date'))): ?>
            <li><a class="btn btn-header" href="{{ route('members.regist') }}">新規会員登録</a></li>
            <?php endif ?>
            <?php if(empty(session('login_date'))): ?>
            <li><a class="btn btn-header" href="{{ route('members.login') }}">ログイン</a></li>
            <?php endif ?>
            <?php if(!empty(session('login_date'))): ?>
            <li><a class="btn btn-header" href="{{ route('products.registForm') }}">新規商品登録</a></li>
            <?php endif ?>
            <?php if(!empty(session('login_date'))): ?>
            <li><a class="btn btn-header" href="{{ route('members.mypage') }}">マイページへ</a></li>
            <?php endif ?>
            <?php if(!empty(session('login_date'))): ?>
            <form method="post" action="{{ route('members.logout') }}">
                @csrf
                <li><button style="background-color: #ffe4d2; font-size: 16px; height: 32px; vertical-align: center; line-height: 16px" type="submit" class="btn btn-header">ログアウト</button></li>
            </form>
            <?php endif ?>
        </ul>
    </div>
</header>
