<?php /* Smarty version 2.6.27-optimized, created on 2015-12-17 00:05:44
         compiled from /var/www/shop.local/modules/document/contents//document/document_index.html */ ?>
<div class="nb-top-nav-place js-top-nav-buffer"></div>
<div class="nb-top-nav js-top-nav">
    <div class="nb-block-tabs">
        <div class="tab-element"><a href="/admin/document/" <?php if (! $this->_tpl_vars['control_filterdirection']): ?>class="selected"<?php endif; ?>>Все документы</a></div>
        <div class="tab-element"><a href="/admin/document/?filterdirection=in" <?php if ($this->_tpl_vars['control_filterdirection'] == 'in'): ?>class="selected"<?php endif; ?>>Входящие</a></div>
        <div class="tab-element"><a href="/admin/document/?filterdirection=out" <?php if ($this->_tpl_vars['control_filterdirection'] == 'out'): ?>class="selected"<?php endif; ?>>Исходящие</a></div>
        <div class="tab-element"><a href="/admin/document/?filterdirection=our" <?php if ($this->_tpl_vars['control_filterdirection'] == 'our'): ?>class="selected"<?php endif; ?>>Внутренние</a></div>
        <div class="clear"></div>
    </div>
</div>

<?php echo $this->_tpl_vars['table_block']; ?>