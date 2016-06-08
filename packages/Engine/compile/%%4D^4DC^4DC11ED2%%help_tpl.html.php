<?php /* Smarty version 2.6.27-optimized, created on 2015-11-23 15:01:02
         compiled from /var/www/shop.local/contents/help/help_tpl.html */ ?>
<!DOCTYPE html>
<html>
<head>
    <title><?php if ($this->_tpl_vars['title']): ?><?php echo $this->_tpl_vars['title']; ?>
 &mdash; <?php endif; ?>CRM-система OneBox</title>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <meta property="og:title" content="<?php if ($this->_tpl_vars['title']): ?><?php echo $this->_tpl_vars['title']; ?>
 &mdash; <?php endif; ?>CRM-система OneBox"/> <!--Название страници-->
    <meta property="og:image" content="/_images/help/logo-og.png" /> <!--URL логотипа-->
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <link rel="icon" href="<?php echo $this->_tpl_vars['favicon']; ?>
" type="image/x-icon" />
    <link rel="shortcut icon" href="<?php echo $this->_tpl_vars['favicon']; ?>
" type="image/x-icon" />

    <link href='//fonts.googleapis.com/css?family=Noto+Sans:400,700&amp;subset=latin,cyrillic-ext' rel='stylesheet' type='text/css'>
    <?php echo $this->_tpl_vars['engine_includes']; ?>

</head>
<body>
    <div class="os-mainer">
        <section class="os-content">
            <div class="content-wrapper js-content-wrap">
                <div class="os-crumbs">
                    <div itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
                        <a href="/doc/" itemprop="url"><span itemprop="title">CRM-система OneBox</span></a>
                    </div>
                    <?php if ($this->_tpl_vars['pathArray']): ?>&raquo;<?php endif; ?>
                    <?php $_from = $this->_tpl_vars['pathArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['pathForeach'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['pathForeach']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['p']):
        $this->_foreach['pathForeach']['iteration']++;
?>
                        <div itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
                            <a href="/doc/<?php echo $this->_tpl_vars['p']['key']; ?>
" itemprop="url"><span itemprop="title"><?php echo $this->_tpl_vars['p']['title']; ?>
</span></a>
                        </div>
                        <?php if (! ($this->_foreach['pathForeach']['iteration'] == $this->_foreach['pathForeach']['total'])): ?>
                            &raquo;
                        <?php endif; ?>
                    <?php endforeach; endif; unset($_from); ?>
                </div>

                <?php echo $this->_tpl_vars['content']; ?>


                <?php if ($this->_tpl_vars['selected']): ?>
                    <br />
                    <br />
                    <h2>
                        Смотрите также:
                    </h2>
                    <ul>
                    <?php $_from = $this->_tpl_vars['chapterLinks']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['link']):
?>
                        <li><a href="<?php echo $this->_tpl_vars['link']['url']; ?>
"><?php echo $this->_tpl_vars['link']['name']; ?>
</a></li>
                    <?php endforeach; endif; unset($_from); ?>
                    </ul>
                <?php endif; ?>
                <br />
            </div>
        </section>

        <header class="os-header">
            <a href="/doc/" class="logo"><span>Documentation</span></a>
            <div class="menu">
                <?php echo $this->_tpl_vars['menu']; ?>

            </div>
        </header>
        <div class="clear"></div>
    </div>
    <script type='text/javascript'>hljs.initHighlightingOnLoad();</script>
</body>
</html>