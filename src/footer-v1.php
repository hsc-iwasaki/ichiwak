<footer>
    <div class="inner">
        <div class="footer-logo">
            <img src="<?php echo get_template_directory_uri() ?>/img/global/footer-logo.png">
        </div>
        <div class="footer-links">
            <nav>
                <ul>
                    <li>
                        <a href="#">トップページ</a>
                    </li>
                    <li>
                        <a href="#">仕事を探す</a>
                    </li>
                    <li>
                        <a href="#">ピックアップ求人</a>
                    </li>
                    <li>
                        <a href="#">いちワクとは</a>
                    </li>
                    <li>
                        <a href="#">転職ノウハウ</a>
                    </li>
                    <li>
                        <a href="<?php echo get_home_url() ?>/privacy/">プライバシーポリシー</a>
                    </li>
                    <li>
                        <a href="#">市原おすすめスポット</a>
                    </li>
                    <li>
                        <a href="#">お問い合わせ</a>
                    </li>
                    <li>
                        <a href="<?php echo get_home_url() ?>/register-login#jh-login-tab/">ログイン</a>
                    </li>
                </ul>
            </nav>
            <div>
                <ul>
                    <?php if (!is_user_logged_in()) : ?>
                        <li class="footer-register">
                            <a href="<?php echo home_url() ?>/register-login/">
                                <img src="<?php echo get_template_directory_uri() ?>/img/global/register.png" alt="">
                                <span class="secondary-menu-text">アカウント登録はこちら</span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <li class="footer-employer">
                        <a href="#">
                            <img src="<?php echo get_template_directory_uri() ?>/img/global/employer.png" alt="">
                            <span class="secondary-menu-text">求人掲載をご希望の方へ</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</footer>
<?php wp_footer(); ?>
</body>

</html>