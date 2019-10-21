<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LASHIC エラーベージ</title>
    <meta name="keywords" content="ラシク,見守り">
    <meta name="description" content="ラシクの管理画面です。">
    <meta name="robots" content="all">
    <meta property="og:type" content="website">
    <meta property="og:url" content="">
    <meta property="og:locale" content="ja_JP">
    <meta property="og:image" content="/images/common/ogp.jpg">
    <meta property="og:site_name" content="LASHIC（ラシク）　管理ページ">
    <meta property="og:description" content="LASHIC（ラシク）は高齢者の”自立”をささえ、”あんしん”を共有します。">
    <meta name="viewport" content="target-densitydpi=device-dpi, width=1000px, minimum-scale=0.1, maximum-scale=1.0, user-scalable=yes">
    <link rel="shortcut icon" href="/favicon.ico" type="image/vnd.microsoft.icon">
    <link rel="icon" href="/favicon.ico" type="image/vnd.microsoft.icon">
    <link rel="apple-touch-icon" href="/apple-touch-icon-precomposed.png">

    <link href="/css/reset.css" type="text/css" rel="stylesheet">
    <link href="/css/common.css" type="text/css" rel="stylesheet">
    <link href="/css/style.css" type="text/css" rel="stylesheet">
    <link href="/css/drawer.css" type="text/css" rel="stylesheet">
    <?php if (\Util::is_production()) { ?>
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-128509273-2"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());

            gtag('config', 'UA-128509273-2');
        </script>
    <?php } ?>
</head>

<body id="home" class="drawer drawer--right">
    <div class="clearfix content">
        <header class="drawer-navbar" role="banner">
            <div class="drawer-container">
                <div class="drawer-navbar-header">
                    <a class="logo" href="/"><img src="/images/common/logo.png" width="222" height="52" alt="" /></a>
                </div>
            </div>
        </header>
        <main>
            <div role="main" class="clearBoth" style="text-align:center;">
                <div class="content mgb15 flash-errors">
                    <ul>
                        <li>画面操作に誤りがありました。再度操作を行ってください。</li>
                    </ul>
                </div>
                <h1 class="content_h1">システムエラー</h1>
                <p>
                    いつもLASHIC-careをご利用いただきありがとうございます。<br />
                    誠に申し訳ありませんが、本サービスを継続することができません。<br />
                    以下、考えられる原因と対処方法をご確認ください。<br /><br />
                </p>

                <h1>１．画面操作による原因</h1>
                <p>
                    ①ブラウザの「戻る」・「進む」ボタンで画面の切り替えをされた場合<br />
                    ②ブックマークなどでＵＲＬを直接指定されている場合<br />
                    ③画面を長時間放置された場合<br />
                    【対処方法】再度トップページにアクセスいただき、ご利用ください。<br /><br />
                </p>

                <h1>２．その他の原因</h1>
                <p>
                    上記１に該当しない場合<br />
                    【対処方法】お問合せフォームよりお問い合わせください。<br /><br />
                </p>
            </div>
        </main>
        <footer>
            <ul>
                <li><a href="https://www.infic-c.net/LASHIC/index.php"><?php echo __('template.news'); ?></a></li>
                <li><a href="/page/terms"><?php echo __('template.terms'); ?></a></li>
                <li><a href="http://www.infic.net/" target="_blank"><?php echo __('template.company'); ?></a></li>
                <li><a href="/page/privacy"><?php echo __('template.privacy'); ?></a></li>
                <li><a href="/page/help"><?php echo __('template.help'); ?></a></li>
                <li><a href="/contact"><?php echo __('template.contact'); ?></a></li>
            </ul>
            <p><span class="ftr_copyrights">&copy;</span> LASHIC. All Rights Reserved.</p>
        </footer>
    </div>
    <p id="page-top"><a href="#home"><img src="/images/common/btn_pagetop.png" width="59" height="59" alt="" /></a></p>
</body>

</html>