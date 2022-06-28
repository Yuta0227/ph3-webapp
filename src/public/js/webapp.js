const headerLogoutButton = document.getElementById('header-logout-button');
const headerDeleteButton = document.getElementById('header-delete-button');
const headerPostButton = document.getElementById('header-post-button');
const decideButton = document.getElementById('decide-button');
const smartphonePostButton = document.getElementById('smartphone-post-button');
const fullOverlay = document.getElementById('fullOverlay');
const exit = document.getElementById('exit');
const time = document.getElementById('time');
const date = document.getElementById('date');
const pcPost = document.getElementById('post-button');
const animationFilter = document.getElementById('animation-filter');
const animationText = document.getElementById('animation-text')
// const previousMonth = document.getElementById('previous-month');
// const nextMonth = document.getElementById('next-month');
// const yearMonth = document.getElementById('year-month');
// const month = document.getElementById('month');
// const year = document.getElementById('year');
const logoutForm = document.getElementById('logout-form');
// const deleteForm=document.getElementById('delete-form');
// const postForm=document.getElementById('post-form');
var now = new Date();
// var innerhtmlMonth = month.innerHTML;
// var innerhtmlYear = year.innerHTML;
var chosenDate;
var chosenMonth;
var chosenYear;
var submitData = [];
var checkedContents = [];
var checkedLanguage;
var writtenHours;
var writtenComment;
var boolShare;
var tmp;
//ラベルクリック時checked==trueならば青色をつける
for (let i = 1; i <= 11; i++) {
    document.getElementById(`label${i}`).addEventListener('click', function () {
        if (i >= 4 && i <= 11 && document.getElementById(`checkbox${i}`).checked == false) {
            for (let tmp = 4; tmp <= 11; tmp++) {
                //言語は一つしか選べないように
                document.getElementById(`checkbox${tmp}`).checked = false;
                document.getElementById(`my-checkbox${tmp}`).style.color = "black";
                document.getElementById(`label${tmp}`).style.backgroundColor = "rgb(215,215,215)";
            }
        }
        if (document.getElementById(`checkbox${i}`).checked == false) {
            document.getElementById(`my-checkbox${i}`).style.color = 'black';
            document.getElementById(`label${i}`).style.backgroundColor = "rgb(215,215,215)";
        } else if (document.getElementById(`checkbox${i}`).checked == true) {
            document.getElementById(`my-checkbox${i}`).style.color = "blue";
            document.getElementById(`label${i}`).style.backgroundColor = "#e7f5ff";
        }
    })
};
document.getElementById(`label12`).addEventListener('click', function () {
    if (document.getElementById(`checkbox12`).checked == true) {
        document.getElementById(`my-checkbox12`).style.color = "blue";
    } else if (document.getElementById(`checkbox12`).checked == false) {
        document.getElementById(`my-checkbox12`).style.color = "black";
    }
});
//右上の記録・投稿ボタン押すとオーバーレイ表示する
decideButton.addEventListener('click', function () {
    fullOverlay.removeAttribute('hidden');
    if (headerLogoutButton.selected == true) {
        logoutForm.removeAttribute('hidden');
    }
    if (headerDeleteButton.selected == true) {
        deleteForm.removeAttribute('hidden');
    }
    if (headerPostButton.selected == true) {
        postForm.removeAttribute('hidden');
    }
});
//×ボタン押すとオーバーレイが消えると同時に入力内容リセットされる
exit.addEventListener('click', function () {
    fullOverlay.setAttribute('hidden', "");
    comment.value = "";
    time.value = "";
    reset();
    window.location.href = `http://localhost:8080/webapp.php?month=${innerhtmlMonth - 0}&year=${innerhtmlYear - 0}`;
});
//ツイートボタン押してるかつ投稿ボタン押してるとツイートするロード画面始まる
//ロード完了と出てから消える入力内容も消える
function tweetPage() {
    if (document.getElementById('checkbox12').checked) {
        let comment = document.getElementById('comment').value;
        window.open("https://twitter.com/intent/tweet?text=" + comment);
    }
};
function startLoading() {
    animationFilter.removeAttribute("hidden");
    animationText.innerText = "Loading ...";
};
function hideLoading() {
    animationFilter.setAttribute("hidden", "")
};
function stopLoading() {
    animationText.innerText = "Loading Complete!";
    tweetPage();
    setTimeout(hideLoading, 1000);
    comment.value = "";
    time.value = "";
    fullOverlay.setAttribute("hidden", "");
    reset();
};
function reset() {
    for (let i = 1; i <= 12; i++) {
        if (document.getElementById(`checkbox${i}`).checked) {
            document.getElementById(`my-checkbox${i}`).style.color = "black";
            document.getElementById(`label${i}`).style.backgroundColor = "rgb(215,215,215)"
            document.getElementById(`checkbox${i}`).checked = false;
        }
    }
};
pcPost.addEventListener('click', function () {
    if (time.innerHTML != '') {
        startLoading();
        stopLoading();
        //データすぐ送られるのにアニメーション待つ必要ない
    }
});

// previousMonth.addEventListener('click', function () {
//     innerhtmlMonth--;
//     if (innerhtmlMonth == 0) {
//         innerhtmlMonth = innerhtmlMonth + 12;
//         innerhtmlYear--;
//     };
//     window.location.href = `http://localhost:8080/webapp.php?month=${innerhtmlMonth - 0}&year=${innerhtmlYear - 0}`;
// });
// if (innerhtmlMonth - 0 >= now.getMonth() + 1 && innerhtmlYear - 0 >= now.getFullYear()) {
//     nextMonth.style.display = 'none';
//     nextMonth.style.pointerEvents = 'none';
// };
// nextMonth.addEventListener('click', function () {
//     innerhtmlMonth++;
//     if (innerhtmlMonth == 13) {
//         innerhtmlMonth = innerhtmlMonth - 12;
//         innerhtmlYear++;
//     };
//     window.location.href = `http://localhost:8080/webapp.php?month=${innerhtmlMonth - 0}&year=${innerhtmlYear - 0}`;
// });
var hourBargraphCtx = document.getElementById("hour-bargraph").getContext('2d');
var hourBargraph = document.getElementById('hour-bragraph');
var bargraphContainer = document.getElementById('bargraph-container');
// hourBargraphCtx.canvas.height=bargraphContainer.style.height;
// hourBargraphCtx.canvas.width=bargraphContainer.style.width;
const bargraph_data_array = Object.values(bargraph_data);
var gradient = hourBargraphCtx.createLinearGradient(15, 0, 15, 300);
//今はバーグラフの左上を基準にしたのグラデーション。各バーを基準にしたグラデーション。数値が12じゃないときグラデーション崩れる
gradient.addColorStop(0, '#137DC4');
gradient.addColorStop(0.9, '#38C7F9');
var myChart = new Chart(hourBargraphCtx, {
    type: "bar", // ★必須　グラフの種類
    data: {
        labels: [, "", "2", "", "4", "", "6", "", "8", "", "10", "", "12", "", "14", "", "16", "", "18", "",
            "20", "", "22", "", "24", "", "26", "", "28", "", "30"
        ], // Ｘ軸のラベル
        datasets: [{
            label: "Data", // 系列名
            data: bargraph_data_array, // ★必須　系列Ａのデータ
            backgroundColor: gradient, // 棒の塗りつぶし色
            borderColor: gradient, // 棒の枠線の色
            borderWidth: 1, // 枠線の太さ
        }]
    },

    options: { // オプション
        responsive: false, // canvasサイズ自動設定機能を使わない。HTMLで指定したサイズに固定
        title: { // タイトル
            display: false, // 表示設定
            fontSize: 18, // フォントサイズ
            fontFamily: "sans-serif",
            text: 'タイトル' // タイトルのラベル
        },
        legend: { // 凡例
            display: false // 表示の有無
            // position: 'bottom'              // 表示位置
        },
        scales: { // 軸設定
            xAxes: [ // Ｘ軸設定
                {
                    display: true, // 表示の有無
                    barPercentage: 0.4, // カテゴリ幅に対する棒の幅の割合
                    //categoryPercentage: 0.8,    // 複数棒のスケールに対する幅の割合
                    scaleLabel: { // 軸ラベル
                        display: false, // 表示設定
                        labelString: '横軸ラベル', // ラベル
                        fontColor: "#97b9d1", // 文字の色
                        fontSize: 8 // フォントサイズ
                    },
                    gridLines: { // 補助線
                        display: false // 補助線なし
                    },
                    ticks: { // 目盛り
                        fontColor: "#97b9d1", // 目盛りの色
                        fontSize: 14, // フォントサイズ
                    },
                }
            ],
            yAxes: [ // Ｙ軸設定
                {
                    display: true, // 表示の有無
                    scaleLabel: { // 軸ラベル
                        display: false, // 表示の有無
                        labelString: '縦軸ラベル', // ラベル
                        fontFamily: "sans-serif", // フォントファミリー
                        fontColor: "#97b9d1", // 文字の色
                        fontSize: 16 // フォントサイズ
                    },
                    gridLines: { // 補助線
                        display: false, // 補助線なし
                        color: "rgba(0, 0, 255, 0.2)", // 補助線の色
                        zeroLineColor: "black" // y=0（Ｘ軸の色）
                    },
                    ticks: { // 目盛り
                        min: 0, // 最小値
                        max: 20, // 最大値
                        stepSize: 4, // 軸間隔
                        fontColor: "#97b9d1", // 目盛りの色
                        fontSize: 14 // フォントサイズ
                    },
                }
            ],
        },
        layout: { // 全体のレイアウト
            padding: { // 余白
                left: 0,
                right: 0,
                top: 0,
                bottom: 1
            }
        },
        plugins: {
            labels: {
                display: false,
                // render: 'percentage',
                fontColor: '#00000000',
                fontSize: 20,
            },
            datalabels: {
                display: false
            }
        },
        maintainAspectRatio: true
    }
});



const language_object=Object.values(hours_language_array);
const language_color_array=[];
const language_data_array=[];
const language_name_array=[];
language_object.forEach(data=>{
    language_color_array.push(data.color_code);
    language_data_array.push(data.hours);
    language_name_array.push(data.language_name);
}
)
//学習言語と学習コンテンツのチャート
var language = document.getElementById('language-chart-doughnut');
var myLanguageChart = new Chart(language, {
    type: 'doughnut',
    data: {
        labels: language_name_array,
        datasets: [{
            data: language_data_array,
            backgroundColor: language_color_array,
            weight: 100,
        }],
    },
    options: {
        legend: {
            display: false
        },
        title: {
            display: true,
            text: '割合'
        },
        plugins: {
            labels: {
                render: 'percentage',
                fontColor: '#00000000',
                fontSize: 10
            }
        }
    }
});
const content_object=Object.values(hours_content_array);
const content_color_array=[];
const content_data_array=[];
const content_name_array=[];
content_object.forEach(data=>{
    content_color_array.push(data.color_code);
    content_data_array.push(data.hours);
    content_name_array.push(data.content_name);
}
)
var material = document.getElementById('material-chart-doughnut');
var myMaterialChart = new Chart(material, {
    type: 'doughnut',
    data: {
        labels: content_name_array,
        datasets: [{
            data:content_data_array,
            backgroundColor: content_color_array,
            weight: 100,
        }],
    },
    //表示順を大きい順にする方法がわからん。おそらくこのままだと数値は順番変更できてもそれがラベルの内容とずれるかも
    options: {
        legend: {
            display: false
        },
        title: {
            display: true,
            text: '割合'
        },
        plugins: {
            labels: {
                render: 'percentage',
                fontColor: '#00000000',
                fontSize: 10
            }
        }
    }
});