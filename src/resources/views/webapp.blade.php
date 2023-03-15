<!DOCTYPE html>
<html lang="ja">


<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/webapp.css') }}">
    <title>Webapp</title>
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
</head>


<body>
    <header>
        <div class="logo-week">
            <img src="./img/posse_logo.png" alt="posseのロゴ" class="logo">
            <span class="week">{{ $week_number . '週目の' . Auth::user()->name . 'さんの勉強時間' }}
            </span>
        </div>
        @if(session('error'))
        <div>{{session('error')}}</div>
        @endif
        <select name="buttons" class="button-container">
            <option id="header-logout-button" class="post-button">ログアウト</option>
            <!-- <option id="header-delete-button" class="post-button">削除依頼</option> -->
            <option id="header-post-button" class="post-button">記録・投稿</option>
        </select>
        @if(Auth::user()->admin_bool===1)
        <a href="{{route('admin')}}">管理者画面</a>
        @endif
        <div style="align-items:center;display:flex;justify-content:center;padding-right:20px;">
            <input type="button" value="確定" id="decide-button">
        </div>
    </header>
    <div class="content-container">
        <!-- 一段目 -->
        <div class="first-container">
            <div class="today-month-total-container">
                <div class="today-container">
                    <div class="today">
                        {{ $year }}/{{ $month }}/{{ $date }}</div>
                    <div class="number">
                        {{ $hours_today }}
                    </div>
                    <div class="hour">時間</div>
                </div>
                <div class="month-container">
                    <div class="month">{{ $year . '/' . $month }}
                    </div>
                    <div class="number">
                        {{ $hours_month }}
                    </div>
                    <div class="hour">時間</div>
                </div>
                <div class="total-container">
                    <div class="total">合計</div>
                    <div class="number">
                        {{ $hours_total }}
                    </div>
                    <div class="hour">時間</div>
                </div>
            </div>
            <div class="bargraph-container">
                <canvas id="hour-bargraph" style="width:100%;height:90%;"></canvas>
            </div>
        </div>
        <!-- 二段目 -->
        <div class="second-container">
            <div class="language-chart-container">
                <div class="piechart-title">学習言語</div>
                <canvas id="language-chart-doughnut" width="15" height="10"></canvas>
                <div>
                    <ul class="language">
                        @foreach ($hours_language_array as $language)
                            <li><i class="fas fa-circle" style="color:{{ $language['color_code'] }}"></i>
                                {{ $language['language_name'] }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="material-chart-container">
                <div class="piechart-title">学習コンテンツ</div>
                <canvas id="material-chart-doughnut" width="15" height="10"></canvas>
                <div>
                    <ul class="material">
                        @foreach ($hours_content_array as $content)
                            <li><i class="fas fa-circle"
                                    style="color:{{ $content['color_code'] }}"></i>{{ $content['content_name'] }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- 月移動 -->
    <div class="calender">
        <div style="display:flex;">
            <form action="/month" method="POST">
                @csrf
                @if ($calender_month == 1)
                    <input name="month" value="12" hidden>
                    <input name="year" value="{{ session()->get('year') - 1 }}" hidden>
                @else
                    <input name="month" value="{{ $calender_month - 1 }}" hidden>
                    <input name="year" value="{{ session()->get('year') }}" hidden>
                @endif
                <input type="submit" value="<">
            </form>
            <div>{{ session()->get('year') . '年' . session()->get('month') . '月' }}</div>
            <form action="/month" method="POST">
                @csrf
                @if ($calender_month == 12)
                    <input name="month" value="1" hidden>
                    <input name="year" value="{{ session()->get('year') + 1 }}" hidden>
                @else
                    <input name="month" value="{{ $calender_month + 1 }}" hidden>
                    <input name="year" value="{{ session()->get('year') }}" hidden>
                @endif
                <input type="submit" value=">">
            </form>
        </div>
    </div>
    <!-- 記録投稿ボタンを押した時表示されるオーバーレイ -->
    <div id="fullOverlay" hidden>
        <div class="overlay">
            <form id="logout-form" hidden action="/logout" method="POST">
                @csrf
                <div>
                    <div style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);">
                        <input class="post-button" style="background-color:yellow;color:black;" type="submit"
                            value="ログアウトする" name="login_page">
                    </div>
                </div>
            </form>
            <form id="delete-form" hidden action="/delete_data" method="POST">
                <div class="delete-form">
                    削除依頼のためのフォーム（管理者へ送信）
                    <div style="width:100%;">
                        <div>過去5件の投稿を表示</div>
                        <table id="delete-table">
                            <tr>
                                <th>投稿ID</th>
                                <th>投稿時間</th>
                                <th>学習日</th>
                                <th>学習コンテンツ</th>
                                <th>学習言語</th>
                                <th>学習時間</th>
                                <th>削除依頼ボタン</th>
                            </tr>
                            <tr>
                                <?php
                                // $delete_data->delete_data_table(0);
                                // $delete_data->check_existence(0);
                                ?>

                            </tr>
                            <tr>
                                <?php
                                // $delete_data->delete_data_table(1);
                                // $delete_data->check_existence(1);
                                ?>
                            </tr>
                            <tr>
                                <?php
                                // $delete_data->delete_data_table(2);
                                // $delete_data->check_existence(2);
                                ?>
                            </tr>
                            <tr>
                                <?php
                                // $delete_data->delete_data_table(3);
                                // $delete_data->check_existence(3);
                                ?>
                            </tr>
                            <tr>
                                <?php
                                // $delete_data->delete_data_table(4);
                                // $delete_data->check_existence(4);
                                ?>
                            </tr>
                        </table>
                        <div id="delete-reason">
                            削除依頼理由記入欄:
                            <textarea type="text" name="delete_reason" placeholder="理由記入して下さい" required></textarea>
                        </div>
                        <input type="submit" value="削除依頼送信"
                            style="display:block;margin:auto;pointerEvents:none;"></input>
                    </div>
                </div>
            </form>
            <form id="post-form" style="width:100%;height:100%;"name="postForm" hidden action="{{route('post')}}" method="POST" onsubmit="false">
                @csrf
                <div id="loading" style="width:100%;height:100%;text-align:center;background-color:red;" hidden>ローディング</div>
                <div id="form-container" class="form">
                    <div class="form-direction">
                        <div class="form-left">
                            <div class="date-container">
                                <div>学習日</div>
                                <input id="date" type="date" name="date" size="20" class="textbox"
                                    value="{{ $today_post_calender }}" required>
                            </div>
                            <div class="study-content-container">
                                <div>学習コンテンツ</div>
                                @foreach($contents as $content)
                                <div>
                                    <label>
                                    <input name="contents[]" type="checkbox" value="{{ $content->id }}">
                                        {{ $content->content }}
                                    </label>
                                </div>
                                @endforeach
                            </div>
                            <div class="language-container">
                                <div>学習言語</div>
                                @foreach($languages as $language)
                                <div>
                                    <label>
                                    <input name="languages[]" type="checkbox" value="{{ $language->id }}">
                                        {{ $language->language }}
                                    </label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="form-right">
                            <div class="hour-container">
                                <div>学習時間</div>
                                <input type="number" name="hours" id="time" size="20" class="textbox"
                                    required>
                                <!-- 半角数字以外入力無効 -->
                            </div>
                            <div class="comment-container">
                                <div>Twitter用コメント</div>
                                <textarea id="comment" class="twitter-comment textbox" placeholder="ツイート内容を入力してください"></textarea>
                            </div>
                            <div class="share-container">
                                <label id="label12">
                                    <input id="checkbox12" type="checkbox">
                                    <i id="my-checkbox12" class="fas fa-check-circle fa-2x"></i>
                                    Twitterにシェアする
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="overlay-button-container">
                        <button type="button" value="記録・投稿" id="post-button" class="post-button">記録・投稿</button>
                    </div>
                </div>
            </form>
            <button id="exit" class="exit"><i class="fas fa-times"></i></button>
        </div>
    </div>
    <!-- ロード画面のアニメーション -->
    <div id="animation-filter" class="animation-filter" hidden>
        <div class="animation-container">
            <div id="animation-text"></div>
            <div class="animation"></div>
        </div>
    </div>
</body>
<script>
    const bargraph_data=@json($bargraph_data);
    const hours_language_array = @json($hours_language_array);
    const hours_content_array = @json($hours_content_array);
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.6.0/chart.min.js"
    integrity="sha512-GMGzUEevhWh8Tc/njS0bDpwgxdCJLQBWG3Z2Ct+JGOpVnEmjvNx6ts4v6A2XJf1HOrtOsfhv3hBKpK9kE5z8AQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.js"></script>
<!-- datalabelsプラグインを呼び出す -->
<script src="{{ asset('js/chartjs-plugin-labels.js') }}"></script>
<script src="{{ asset('js/webapp.js') }}"></script>
<script>
    
</script>

</html>


<!-- 最初はurlから情報取得せず現在の日時などを表示月移動するときurlから数値取得して$monthから引いたり足したりする -->
