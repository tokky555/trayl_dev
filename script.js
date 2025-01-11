window.addEventListener('DOMContentLoaded', (event) => {
  // ハンバーガーメニューのクリックイベントのリスナーを追加
  const hamburgerMenu = document.querySelector('.hamburger-menu');
  hamburgerMenu.addEventListener('click', toggleMenu);
});

function toggleMenu() {
  // メニューの表示・非表示を切り替える処理を記述
  // ここではコンソールに表示するだけの例としています
  console.log('Menu clicked!');
}

$(".slider").slick({
  autoplay: true,//自動的に動き出すか。初期値はfalse。
  arrows: false,
  infinite: true,//スライドをループさせるかどうか。初期値はtrue。
  speed: 500,//スライドのスピード。初期値は300。
  slidesToShow: 3,//スライドを画面に3枚見せる
  slidesToScroll: 1,//1回のスクロールで1枚の写真を移動して見せる
  centerMode: true,//要素を中央ぞろえにする
  variableWidth: true,//幅の違う画像の高さを揃えて表示
  dots: false,//下部ドットナビゲーションの表示
  centerPadding: '0',
});

$(".openbtn").click(function () {//ボタンがクリックされたら
	$(this).toggleClass('active');//ボタン自身に activeクラスを付与し
    $(".menu-open").toggleClass('panelactive');//ナビゲーションにpanelactiveクラスを付与
});

$("#g-nav a").click(function () {//ナビゲーションのリンクがクリックされたら
    $(".openbtn").removeClass('active');//ボタンの activeクラスを除去し
    $(".menu-open").removeClass('panelactive');//ナビゲーションのpanelactiveクラスも除去
});

$(function () {
  // ハンバーガーメニューボタンがクリックされたときのイベントハンドラを設定
  // ▼参考URL
  // https://build-web.org/css/drawer-bg-scroll/
  $(".openbtn").click(function () {

    // 現在のbodyタグのoverflowスタイルを確認
    if ($("body").css("overflow") === "hidden") {

      // もしoverflowがhiddenなら、bodyのスタイルを元に戻す
      $("body").css({ height: "", overflow: "" });

    } else {

      // そうでなければ、bodyにheight: 100%とoverflow: hiddenを設定し、スクロールを無効にする
      $("body").css({ height: "100%", overflow: "hidden" });

    }
  });
});

document.addEventListener("DOMContentLoaded", function() {
  const marqueeText = document.querySelector('.marquee p');

  // テキストの長さをチェック
  if (marqueeText.offsetWidth < marqueeText.parentElement.offsetWidth) {
      // テキストが親要素より短い場合、スクロールを無効にする
      marqueeText.classList.add('no-scroll');
  }
});