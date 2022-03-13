<!--　ヘッダー　-->
{{--<script src="https://code.jquery.com/jquery-3.0.0.js" integrity="sha256-jrPLZ+8vDxt2FnE1zvZXCkCcebI/C8Dt5xyaQBjxQIo=" crossorigin="anonymous"></script>--}}
<header class="admin-header">
    <div class="header-left">

    </div>
    <div class="header-right">

        <ul>
            <?php if(!empty(session('admin_login_date'))): ?>
            <li>
                ようこそ
                @if(!empty(session('admin_name')))
                    {{ session('admin_name') }}
                @endif
                さん
            </li>
            <?php endif ?>
{{--            <li><a class="btn btn-header" href="">商品一覧</a></li>--}}
            <?php if(empty(session('admin_login_date'))): ?>
            <li><a style="border: solid 1px #000" class="btn btn-admin-header" href="">ログイン</a></li>
            <?php endif ?>

            <?php if(!empty(session('admin_login_date'))): ?>
            <form method="post" action="">
                @csrf
                <li><button style="background-color: #cfcfcf; font-size: 16px; height: 32px; vertical-align: center; line-height: 16px" type="submit" class="btn btn-header">ログアウト</button></li>
            </form>
            <?php endif ?>
        </ul>
    </div>
</header>
