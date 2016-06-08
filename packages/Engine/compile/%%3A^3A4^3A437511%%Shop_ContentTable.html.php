<?php /* Smarty version 2.6.27-optimized, created on 2015-11-26 17:53:44
         compiled from /var/www/shop.local/api/forms/Shop_ContentTable.html */ ?>
<?php echo $this->_tpl_vars['filter']; ?>


<div class="shop-overflow-table">
    <table class="<?php echo $this->_tpl_vars['cssClassName']; ?>
 table-filter">
        <?php echo $this->_tpl_vars['headers']; ?>


        <?php $_from = $this->_tpl_vars['rowsArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['r']):
?>
            <?php echo $this->_tpl_vars['r']; ?>

        <?php endforeach; endif; unset($_from); ?>
    </table>
</div>

<div class="shop-table-control">
    <?php echo $this->_tpl_vars['stepper']; ?>


    <?php if ($this->_tpl_vars['rowsArray'] && ( $this->_tpl_vars['isUserAdmin'] || $this->_tpl_vars['canExport'] ) && ! $this->_tpl_vars['disableExports']): ?>
        <div class="ob-block-export js-block-export">
            <a href="#" class="link" onclick="$j('.options').toggle(); return false;"><span><?php echo $this->_tpl_vars['translate_export_to']; ?>
</span></a>
            <div class="options" id="options" style="display: none;">
                <div class="block">
                    <a href="<?php echo $this->_tpl_vars['urlexportcsv']; ?>
" class="csv"><?php echo $this->_tpl_vars['translate_export_to']; ?>
 CSV</a>
                    <a href="<?php echo $this->_tpl_vars['urlexportxls']; ?>
" class="xls"><?php echo $this->_tpl_vars['translate_export_to']; ?>
 XLS</a>
                    <a href="<?php echo $this->_tpl_vars['urlexportxml']; ?>
" class="xml"><?php echo $this->_tpl_vars['translate_export_to']; ?>
 XML</a>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            $j(function() {
                $j(".js-block-export .block a").click(function (event) {
                    $j('.js-block-export .options').toggle();
                });
            });
        </script>
    <?php endif; ?>
    <div class="clear"></div>
</div>