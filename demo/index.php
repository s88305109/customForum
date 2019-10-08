<!doctype html>
<html lang="zh-TW">
  <head>
    <?php require("./head_css_js.php"); ?>
    <title>欣亞 - 排排購</title>
  </head>
  <body>
    <div class="container_fluid">
        <?php require("./header.php"); ?>
    </div>
    <!-- Owl Carousel -->
    <link rel="stylesheet" href="./lib/owl-carousel/owl.carousel.css">
    <link rel="stylesheet" href="./lib/owl-carousel/owl.theme.css">
    <script src="./lib/owl-carousel/owl.carousel.js"></script>
    <div class="container">
        <div class="banner_block">
            <div id="slide-banner" class="owl-carouse1">
                <div class="item"><a href="#" ><img src="./images/banner1.jpg"></a></div>
                <div class="item"><a href="#" ><img src="./images/banner2.jpg"></a></div>
            </div>
            <script type="text/javascript">
            $(document).ready(function() {
                if($(window).width()>900){
                    $("#slide-banner").owlCarousel({
                        slideSpeed : 300,
                        paginationSpeed : 400,
                        singleItem:true,
                        autoPlay : true,
                        navigation : false,
                    });
                }
                else{
                    $("#slide-banner").owlCarousel({
                        slideSpeed : 300,
                        paginationSpeed : 400,
                        singleItem:true,
                        autoPlay : false,
                        navigation : false,
                        pagination:false,
                    });
                }
            });
            </script>
        </div>

        <div class="row news">
            <div class="col-md-4 col-sm-12">
                <h3 class="green2">最新貼文</h3>
                <ul>
                    <li><a href="#">開箱文測試開箱文測試開箱文測試開箱文測試</a></li>
                    <li><a href="#">開箱文測試開箱文測試開箱文測試開箱文測試</a></li>
                    <li><a href="#">開箱文測試開箱文測試開箱文測試開箱文測試</a></li>
                    <li><a href="#">開箱文測試開箱文測試開箱文測試開箱文測試</a></li>
                    <li><a href="#">開箱文測試開箱文測試開箱文測試開箱文測試</a></li>
                </ul>
            </div>
            <div class="col-md-4 col-sm-12">
                <h3 class="green2">最新回覆</h3>
                <ul>
                    <li><a href="#">開箱文測試開箱文測試開箱文測試開箱文測試</a></li>
                    <li><a href="#">開箱文測試開箱文測試開箱文測試開箱文測試</a></li>
                    <li><a href="#">開箱文測試開箱文測試開箱文測試開箱文測試</a></li>
                    <li><a href="#">開箱文測試開箱文測試開箱文測試開箱文測試</a></li>
                    <li><a href="#">開箱文測試開箱文測試開箱文測試開箱文測試</a></li>
                </ul>
            </div>
            <div class="col-md-4 col-sm-12">
                <h3 class="green2">人氣熱帖</h3>
                <ul>
                    <li><a href="#">開箱文測試開箱文測試開箱文測試開箱文測試</a></li>
                    <li><a href="#">開箱文測試開箱文測試開箱文測試開箱文測試</a></li>
                    <li><a href="#">開箱文測試開箱文測試開箱文測試開箱文測試</a></li>
                    <li><a href="#">開箱文測試開箱文測試開箱文測試開箱文測試</a></li>
                    <li><a href="#">開箱文測試開箱文測試開箱文測試開箱文測試</a></li>
                </ul>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-9 col-sm-12">
                <div class="green_big_title">
                    <h3 class="float-left">王牌大活動</h3>
                    <h4 class="float-right">分區版主：神愛世人</h4>
                </div>
                <section class="list_dash">
                    <a href="#">
                        <div class="name">
                            <h5><i class="fas fa-donate"></i>優惠情報</h5>
                            <p>欣亞優惠活動專區，關注本館搶好康！</p>
                        </div>
                        <div class="num">
                            <span>211</span> / <span>487</span>
                        </div>
                        <div class="time">
                            <p>最後發表於</p>
                            <p>昨天 20:53 欣亞-酥酥</p>
                        </div>
                    </a>
                    <a href="#">
                        <div class="name">
                            <h5><i class="fas fa-bullhorn"></i>最新資訊</h5>
                            <p>欣亞優惠活動專區，關注本館搶好康！</p>
                        </div>
                        <div class="num">
                            <span>211</span> / <span>487</span>
                        </div>
                        <div class="time">
                            <p>最後發表於</p>
                            <p>昨天 20:53 欣亞-酥酥</p>
                        </div>
                    </a>
                    <a href="#">
                        <div class="name">
                            <h5><i class="fas fa-users"></i>軟體分享區</h5>
                            <p>欣亞優惠活動專區，關注本館搶好康！</p>
                        </div>
                        <div class="num">
                            <span>211</span> / <span>487</span>
                        </div>
                        <div class="time">
                            <p>最後發表於</p>
                            <p>昨天 20:53 欣亞-酥酥</p>
                        </div>
                    </a>
                    <a href="#" class="red">
                        <div class="name">
                            <h5><i class="far fa-bell"></i>欣亞官方公告</h5>
                        </div>
                        <div class="num">
                            <span>211</span> / <span>487</span>
                        </div>
                        <div class="time">
                            <p>最後發表於</p>
                            <p>昨天 20:53 欣亞-酥酥</p>
                        </div>
                    </a>
                </section>
            </div>

            <div class="col-lg-3 col-sm-12">
                <div class="green_big_title">
                    <h3 class="float-left">論壇站務</h3>
                </div>
                <section class="list_dash">
                    <a href="#">
                        <div>
                            <h5><i class="far fa-user"></i>註冊、帳務問題</h5>
                        </div>
                    </a>
                    <a href="#">
                        <div>
                            <h5><i class="far fa-newspaper"></i>文章投訴、申訴問題</h5>
                        </div>
                    </a>
                    <a href="#">
                        <div>
                            <h5><i class="far fa-newspaper"></i>過期、失效文章</h5>
                        </div>
                    </a>
                </section>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="green_big_title">
                    <h3 class="float-left">疑難雜症處理 (問題發問請來此區)</h3>
                    <h4 class="float-right">分區版主：</h4>
                </div>
                <section class="list_dash">
                    <a href="#">
                        <div class="name">
                            <h5><i class="fas fa-laptop"></i>筆電詢價分享</h5>
                            <p>筆電購買先來此區詢價，將想購買的品牌、型號貼上看看別人怎麼說</p>
                        </div>
                        <div class="num">
                            <span>211</span> / <span>487</span>
                        </div>
                        <div class="time">
                            <p>最後發表於</p>
                            <p>昨天 20:53 欣亞-酥酥</p>
                        </div>
                    </a>
                    <a href="#">
                        <div class="name">
                            <h5><i class="fas fa-desktop"></i>電腦組裝請益估價</h5>
                            <p>對於硬體購買的問題不管是價格還是規格都歡迎來本區發問</p>
                        </div>
                        <div class="num">
                            <span>211</span> / <span>487</span>
                        </div>
                        <div class="time">
                            <p>最後發表於</p>
                            <p>昨天 20:53 欣亞-酥酥</p>
                        </div>
                    </a>
                    <a href="#">
                        <div class="name">
                            <h5><i class="fas fa-server"></i>軟硬體問題</h5>
                            <p>硬體安裝上的問題與軟體或系統上的疑難雜症歡迎在本區發問</p>
                        </div>
                        <div class="num">
                            <span>211</span> / <span>487</span>
                        </div>
                        <div class="time">
                            <p>最後發表於</p>
                            <p>昨天 20:53 欣亞-酥酥</p>
                        </div>
                    </a>
                    <a href="#">
                        <div class="name">
                            <h5><i class="fab fa-apple"></i>Apple專區</h5>
                            <p>筆電購買先來此區詢價，將想購買的品牌、型號貼上看別人怎麼說</p>
                        </div>
                        <div class="num">
                            <span>211</span> / <span>487</span>
                        </div>
                        <div class="time">
                            <p>最後發表於</p>
                            <p>昨天 20:53 欣亞-酥酥</p>
                        </div>
                    </a>
                    <a href="#">
                        <div class="name">
                            <h5><i class="fas fa-wrench"></i>原廠維修站點資訊</h5>
                            <p>對於硬體購買的問題不管是價格還是規格都歡迎來本區發問對</p>
                        </div>
                        <div class="num">
                            <span>211</span> / <span>487</span>
                        </div>
                        <div class="time">
                            <p>最後發表於</p>
                            <p>昨天 20:53 欣亞-酥酥</p>
                        </div>
                    </a>
                </section>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="green_big_title">
                    <h3 class="float-left">疑難雜症處理 (問題發問請來此區)</h3>
                    <h4 class="float-right">分區版主：</h4>
                </div>
                <section class="list_dash">
                    <a href="#">
                        <div class="name">
                            <h5><i class="fas fa-laptop"></i>筆電詢價分享</h5>
                            <p>筆電購買先來此區詢價，將想購買的品牌、型號貼上看看別人怎麼說</p>
                        </div>
                        <div class="num">
                            <span>211</span> / <span>487</span>
                        </div>
                        <div class="time">
                            <p>最後發表於</p>
                            <p>昨天 20:53 欣亞-酥酥</p>
                        </div>
                    </a>
                    <a href="#">
                        <div class="name">
                            <h5><i class="fas fa-desktop"></i>電腦組裝請益估價</h5>
                            <p>對於硬體購買的問題不管是價格還是規格都歡迎來本區發問</p>
                        </div>
                        <div class="num">
                            <span>211</span> / <span>487</span>
                        </div>
                        <div class="time">
                            <p>最後發表於</p>
                            <p>昨天 20:53 欣亞-酥酥</p>
                        </div>
                    </a>
                    <a href="#">
                        <div class="name">
                            <h5><i class="fas fa-server"></i>軟硬體問題</h5>
                            <p>硬體安裝上的問題與軟體或系統上的疑難雜症歡迎在本區發問</p>
                        </div>
                        <div class="num">
                            <span>211</span> / <span>487</span>
                        </div>
                        <div class="time">
                            <p>最後發表於</p>
                            <p>昨天 20:53 欣亞-酥酥</p>
                        </div>
                    </a>
                    <a href="#">
                        <div class="name">
                            <h5><i class="fab fa-apple"></i>Apple專區</h5>
                            <p>筆電購買先來此區詢價，將想購買的品牌、型號貼上看別人怎麼說</p>
                        </div>
                        <div class="num">
                            <span>211</span> / <span>487</span>
                        </div>
                        <div class="time">
                            <p>最後發表於</p>
                            <p>昨天 20:53 欣亞-酥酥</p>
                        </div>
                    </a>
                    <a href="#">
                        <div class="name">
                            <h5><i class="fas fa-wrench"></i>原廠維修站點資訊</h5>
                            <p>對於硬體購買的問題不管是價格還是規格都歡迎來本區發問對</p>
                        </div>
                        <div class="num">
                            <span>211</span> / <span>487</span>
                        </div>
                        <div class="time">
                            <p>最後發表於</p>
                            <p>昨天 20:53 欣亞-酥酥</p>
                        </div>
                    </a>
                    <a href="#">
                        <div class="name">
                            <h5><i class="far fa-tired"></i>申訴專區</h5>
                            <p>對於硬體購買的問題不管是價格還是規格都歡迎來本區發問對</p>
                        </div>
                        <div class="num">
                            <span>211</span> / <span>487</span>
                        </div>
                        <div class="time">
                            <p>最後發表於</p>
                            <p>昨天 20:53 欣亞-酥酥</p>
                        </div>
                    </a>
                </section>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="green_big_title">
                    <h3 class="float-left">開箱評測與使用心得分享</h3>
                    <h4 class="float-right">分區版主：</h4>
                </div>
                <section class="list_dash">
                    <a href="#">
                        <div class="name">
                            <h5><i class="fas fa-wrench"></i>DIY 電腦零件組</h5>
                            <p>筆電購買先來此區詢價，將想購買的品牌、型號貼上看看別人怎麼說</p>
                        </div>
                        <div class="num">
                            <span>211</span> / <span>487</span>
                        </div>
                        <div class="time">
                            <p>最後發表於</p>
                            <p>昨天 20:53 欣亞-酥酥</p>
                        </div>
                    </a>
                    <a href="#">
                        <div class="name">
                            <h5><i class="fas fa-mobile-alt"></i>電腦手機與行動裝置</h5>
                        </div>
                        <div class="num">
                            <span>211</span> / <span>487</span>
                        </div>
                        <div class="time">
                            <p>最後發表於</p>
                            <p>昨天 20:53 欣亞-酥酥</p>
                        </div>
                    </a>
                    <a href="#">
                        <div class="name">
                            <h5><i class="fab fa-apple"></i>Apple使用分享</h5>
                        </div>
                        <div class="num">
                            <span>211</span> / <span>487</span>
                        </div>
                        <div class="time">
                            <p>最後發表於</p>
                            <p>昨天 20:53 欣亞-酥酥</p>
                        </div>
                    </a>
                    <a href="#">
                        <div class="name">
                            <h5><i class="fas fa-headphones"></i>周邊商品</h5>
                        </div>
                        <div class="num">
                            <span>211</span> / <span>487</span>
                        </div>
                        <div class="time">
                            <p>最後發表於</p>
                            <p>昨天 20:53 欣亞-酥酥</p>
                        </div>
                    </a>
                </section>
            </div>
        </div>

        <?php require("./footer.php"); ?>
    </div>


  </body>
</html>