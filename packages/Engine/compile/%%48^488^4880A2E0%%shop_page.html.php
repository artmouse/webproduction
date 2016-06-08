<?php /* Smarty version 2.6.27-optimized, created on 2015-11-18 16:17:53
         compiled from /var/www/shop.local//templates/default//shop_page.html */ ?>
<div class="os-crumbs">
    <div itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
        <a href="/" itemprop="url">
            <span itemprop="title"><?php echo $this->_tpl_vars['translate_main']; ?>
</span>
        </a>
    </div>
    <div itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
        <a href="<?php echo $this->_tpl_vars['currentURL']; ?>
" itemprop="url">
            <span itemprop="title"><?php echo $this->_tpl_vars['name']; ?>
</span>
        </a>
    </div>
</div>

<?php if ($this->_tpl_vars['content']): ?>
    <div class="os-editor-content js-ckEditor-container">
        <?php echo $this->_tpl_vars['content']; ?>

    </div>
<?php endif; ?>

<?php if ($this->_tpl_vars['urledit']): ?>
    <a href="<?php echo $this->_tpl_vars['urledit']; ?>
" class="os-link-edit"><?php echo $this->_tpl_vars['translate_edit']; ?>
</a>
<?php endif; ?>


<?php echo $this->_tpl_vars['logiccontent']; ?>


<?php echo $this->_tpl_vars['seocontent']; ?>