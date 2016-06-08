<?php /* Smarty version 2.6.27-optimized, created on 2015-12-14 14:30:00
         compiled from /var/www/shop.local/modules/kazakhfilm-adaptive/contents/shop_tpl.html */ ?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo $this->_tpl_vars['title']; ?>
</title>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <meta name="author" content="<?php echo $this->_tpl_vars['shopname']; ?>
" />
    <meta name="viewport" content="width=device-width" />
    <meta name = "format-detection" content = "telephone=no" />
        <?php if ($this->_tpl_vars['shopName']): ?><meta name="dcterms.rightsHolder" content="<?php echo $this->_tpl_vars['shopName']; ?>
" /><?php endif; ?>
    <link rel="canonical" href="<?php echo $this->_tpl_vars['canonical']; ?>
" />
    <link rel="icon" href="<?php echo $this->_tpl_vars['favicon']; ?>
" type="image/x-icon" />
    <link rel="shortcut icon" href="<?php echo $this->_tpl_vars['favicon']; ?>
" type="image/x-icon" />

    <link href='http://fonts.googleapis.com/css?family=Noto+Sans:400,700&amp;subset=latin,cyrillic-ext' rel='stylesheet' type='text/css'>

    <?php echo $this->_tpl_vars['integration_google_wmt']; ?>

    <?php echo $this->_tpl_vars['integration_yandex_wmt']; ?>

    <?php echo $this->_tpl_vars['loginzaVerification']; ?>


    <?php echo $this->_tpl_vars['engine_includes']; ?>

    <script type="text/javascript" src="/templates/kazakhfilm-adaptive/_js/jquery.bxslider.min.js"></script>
    <link rel="stylesheet" type="text/css" media="screen, projection" href="/templates/kazakhfilm-adaptive/_js/jquery.bxslider.css" />
    <!--[if IE]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
</head>
<body <?php if ($this->_tpl_vars['contentID'] == index): ?>class="index-body"<?php endif; ?>>
<div class="page-wrapper js-page-wrap">
    <header class="kz-bg-header">
        <div class="kz-mainer-1280">
            <div class="kz-logo-line">
                <div class="logo-block">
                    <a href="/">
                        <img src="/templates/kazakhfilm-adaptive/_images/new-design/top-logo.png" alt="">
                    </a>
                </div>

                <div class="slogan-block">
                    гостиничный комплекс<br>
                    hotel kazakhfilm
                </div>

                <div class="phones-block">
                    <a href="tel://<?php echo $this->_tpl_vars['phone1']; ?>
"><?php echo $this->_tpl_vars['phone1']; ?>
</a><br />
                    <a href="tel://<?php echo $this->_tpl_vars['phone2']; ?>
"><?php echo $this->_tpl_vars['phone2']; ?>
</a>
                </div>
            </div>

            <div class="kz-nav-line">
                <?php echo $this->_tpl_vars['block_menu_textpage']; ?>

            </div>
            <?php if ($this->_tpl_vars['contentID'] == index): ?>
                <div class="kz-promotext-line">
                    <?php if ($this->_tpl_vars['first_text']): ?>
                    <?php echo $this->_tpl_vars['first_text']; ?>

                    <?php endif; ?>
                    <div class="smaller-text">
                        <?php if ($this->_tpl_vars['second_text']): ?>
                        <?php echo $this->_tpl_vars['second_text']; ?>

                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>

            <div class="kz-booking-form">
                <div class="heading">Забронируйте номер прямо сейчас!</div>
                <form>
                    <div class="input-text">
                        <input name="cbname" type="text" placeholder="Введите имя" onfocus="placeholder='';" onblur="placeholder='Введите имя';" required>
                    </div>
                    <div class="input-text">
                        <input name="cbphone"  type="tel"  placeholder="Введите телефон" onfocus="placeholder='';" onblur="placeholder='Введите телефон';" class="js-phone-formatter" required>
                    </div>
                    <input name="ok" type="submit" value="ЗАБРОНИРУЙТЕ НОМЕР">

                </form>

            </div>
        </div>
    </header>

    <div class="content-wrap">
        <div class="inner">
            <div class="insider">

                <?php echo $this->_tpl_vars['content']; ?>


            </div>
            <br />
        </div>

        <?php if ($this->_tpl_vars['seocontent']): ?>
            <?php if ($this->_tpl_vars['contentID'] == index): ?>
                <div class="inner">
                    <div class="insider">
                        <div class="tpl-seo-text-block" >
                            <?php echo $this->_tpl_vars['seocontent']; ?>

                        </div>
                    </div>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>



    <?php echo $this->_tpl_vars['block_position_template_order']; ?>


    <?php echo $this->_tpl_vars['block_callback']; ?>

    <div class="page-buffer js-page-buffer">&nbsp;</div>
</div>

<div class="page-footer js-footer-height">

    <div class="kz-prefooter-block">
        <div class="inner">
            <div class="insider">

                <div class="contacts">
                    <strong>Круглосуточно:</strong><br />
                    <a class="tel" href="tel://<?php echo $this->_tpl_vars['phone1']; ?>
"><?php echo $this->_tpl_vars['phone1']; ?>
</a><br />
                    <a class="tel" href="tel://<?php echo $this->_tpl_vars['phone2']; ?>
"><?php echo $this->_tpl_vars['phone2']; ?>
</a><br />
                    (WhatsApp, Viber)<br />
                    <a href="mailto:<?php echo $this->_tpl_vars['email']; ?>
"><?php echo $this->_tpl_vars['email']; ?>
</a> <br />
                    <a href="skype:<?php echo $this->_tpl_vars['phone1']; ?>
?call" class="skype">skype: <?php echo $this->_tpl_vars['skype']; ?>
</a>
                </div>

                <div class="tpl-contacts-call-us-back backcall">
                    <div class="button" data-caption="callusModal"><span>ЗАКАЗАТЬ</span>
                        обратный ЗВОНОК</div>
                    <!--Мы перезвоним в любую страну СНГ.-->
                </div>

                <div class="adress">
                    г. Алматы, <br />&nbsp;мкр. Казахфильм, 18а
                </div>
                <div class="clear">&nbsp;</div>
                <br>
            </div>
        </div>

        <div class="inner">
            <div class="insider">
                <div class="counters">
                    <?php echo $this->_tpl_vars['integration_liveinternet']; ?>

                    <?php echo $this->_tpl_vars['integration_ga']; ?>

                    <?php echo $this->_tpl_vars['integration_cloudim']; ?>

                </div>

                <div class="developers-block">
                    <?php echo $this->_tpl_vars['copyright']; ?>

                </div>
                <div class="clear">&nbsp;</div>
            </div>
        </div>
    </div>
</div>
</body>
</html>