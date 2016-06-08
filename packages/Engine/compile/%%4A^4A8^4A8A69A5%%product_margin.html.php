<?php /* Smarty version 2.6.27-optimized, created on 2015-11-25 15:26:40
         compiled from /var/www/shop.local/modules/product-margin/content/admin/marginrule//product_margin.html */ ?>
<?php echo $this->_tpl_vars['menu']; ?>


<div class="shop-message-info">
    <?php if ($this->_tpl_vars['result']): ?>
        <?php echo $this->_tpl_vars['translate_select_price']; ?>
: <?php echo $this->_tpl_vars['result']['price']; ?>
 <?php echo $this->_tpl_vars['currency']; ?>
<br/>
        <?php echo $this->_tpl_vars['translate_select_supplier']; ?>
: <?php echo $this->_tpl_vars['currentSupplierName']; ?>
<br/>
        <?php echo $this->_tpl_vars['translate_rule']; ?>
: <?php echo $this->_tpl_vars['result']['ruleName']; ?>

    <?php elseif ($this->_tpl_vars['reculc']): ?>
        <?php echo $this->_tpl_vars['translate_no_results_found_for_this_product']; ?>
.<br/>
    <?php else: ?>
        Для пересчета цены нажмите кнопку "Пересчитать цену".
    <?php endif; ?>
</div>

<?php if ($this->_tpl_vars['suppliersInfoArray'] || $this->_tpl_vars['storageInfoArray']): ?>
    <h2><?php echo $this->_tpl_vars['translate_results_of_conversion']; ?>
</h2>
<?php endif; ?>

<?php if ($this->_tpl_vars['suppliersInfoArray']): ?>
    <div class="shop-overflow-table">
        <table class="shop-table" width="100%">
            <thead>
                <tr>
                    <td><?php echo $this->_tpl_vars['translate_vendors']; ?>
</td>
                    <td><?php echo $this->_tpl_vars['translate_base_price']; ?>
</td>
                    <td><?php echo $this->_tpl_vars['translate_discount']; ?>
</td>
                    <td><?php echo $this->_tpl_vars['translate_recommended_retail']; ?>
</td>
                    <td><?php echo $this->_tpl_vars['translate_rule']; ?>
</td>
                    <td><?php echo $this->_tpl_vars['translate_price']; ?>
</td>
                </tr>
            </thead>
            <?php $_from = $this->_tpl_vars['suppliersInfoArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
                <tr>
                    <td><?php echo $this->_tpl_vars['e']['name']; ?>
</td>
                    <td><?php echo $this->_tpl_vars['e']['priceBase']; ?>
 <?php echo $this->_tpl_vars['currency']; ?>
</td>
                    <td><?php if ($this->_tpl_vars['e']['discount']): ?><?php echo $this->_tpl_vars['e']['discount']; ?>
%<?php endif; ?></td>
                    <td><?php if ($this->_tpl_vars['e']['recomreatil']): ?><?php echo $this->_tpl_vars['e']['recomreatil']; ?>
 <?php echo $this->_tpl_vars['currency']; ?>
<?php endif; ?></td>
                    <td><?php echo $this->_tpl_vars['e']['ruleName']; ?>
</td>
                    <td><?php echo $this->_tpl_vars['e']['price']; ?>
 <?php echo $this->_tpl_vars['currency']; ?>
</td>
                </tr>
            <?php endforeach; endif; unset($_from); ?>
        </table>
    </div>
    <br />
<?php endif; ?>

<?php if ($this->_tpl_vars['storageInfoArray']): ?>
    <div class="shop-overflow-table">
        <table class="shop-table" width="100%">
            <thead>
                <tr>
                    <td><?php echo $this->_tpl_vars['translate_storage']; ?>
</td>
                    <td><?php echo $this->_tpl_vars['translate_base_price']; ?>
</td>
                    <?php if ($this->_tpl_vars['storageInfoArray']['discount']): ?>
                        <td><?php echo $this->_tpl_vars['translate_discount']; ?>
</td>
                    <?php endif; ?>
                    <?php if ($this->_tpl_vars['storageInfoArray']['recomreatil']): ?>
                        <td>translate_recommended_retail</td>
                    <?php endif; ?>
                    <td><?php echo $this->_tpl_vars['translate_rule']; ?>
</td>
                    <td><?php echo $this->_tpl_vars['translate_price']; ?>
</td>
                </tr>
            </thead>
            <tr>
                <td><?php echo $this->_tpl_vars['storageInfoArray']['name']; ?>
</td>
                <td><?php echo $this->_tpl_vars['storageInfoArray']['priceBase']; ?>
 <?php echo $this->_tpl_vars['currency']; ?>
</td>
                <?php if ($this->_tpl_vars['storageInfoArray']['discount']): ?>
                    <td><?php echo $this->_tpl_vars['storageInfoArray']['discount']; ?>
%</td>
                <?php endif; ?>
                <?php if ($this->_tpl_vars['storageInfoArray']['recomreatil']): ?>
                    <td><?php echo $this->_tpl_vars['storageInfoArray']['recomreatil']; ?>
 <?php echo $this->_tpl_vars['currency']; ?>
</td>
                <?php endif; ?>
                <td><?php echo $this->_tpl_vars['storageInfoArray']['ruleName']; ?>
</td>
                <td><?php echo $this->_tpl_vars['storageInfoArray']['price']; ?>
 <?php echo $this->_tpl_vars['currency']; ?>
</td>
            </tr>
        </table>
    </div>
    <br />
<?php endif; ?>

<form class="ob-button-fixed" action="" method="post" enctype="multipart/form-data">
    <input type="submit" name="ok" value="Пересчитать цену" class="ob-button button-green" />
</form>
<div class="ob-button-fixed-place"></div>