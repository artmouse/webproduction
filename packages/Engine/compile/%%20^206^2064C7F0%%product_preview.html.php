<?php /* Smarty version 2.6.27-optimized, created on 2015-11-24 12:07:18
         compiled from /var/www/shop.local/contents/shop/admin/products/product_preview.html */ ?>
<?php if ($this->_tpl_vars['image']): ?>
    <div class="image">
        <a href="<?php echo $this->_tpl_vars['url']; ?>
"><img src="<?php echo $this->_tpl_vars['image']; ?>
" alt="<?php echo $this->_tpl_vars['name']; ?>
" /></a>
    </div>
<?php endif; ?>
<div class="name">
    <a href="<?php echo $this->_tpl_vars['url']; ?>
"><strong><?php echo $this->_tpl_vars['name']; ?>
</strong></a>
    (<?php if ($this->_tpl_vars['source']): ?><?php echo $this->_tpl_vars['translate_product_service']; ?>
<?php else: ?><?php echo $this->_tpl_vars['translate_product']; ?>
<?php endif; ?>)
    <br />
</div>

<?php if ($this->_tpl_vars['description'] || $this->_tpl_vars['categoryPath']): ?>
    <div class="description">
        <?php echo $this->_tpl_vars['categoryPath']; ?>

        <?php echo $this->_tpl_vars['description']; ?>

    </div>
<?php endif; ?>

<table class="list">
    <?php if ($this->_tpl_vars['price']): ?>
        <tr>
            <td><?php echo $this->_tpl_vars['translate_price']; ?>
:</td>
            <td>
                <?php echo $this->_tpl_vars['price']; ?>
 <?php echo $this->_tpl_vars['currency']; ?>

            </td>
        </tr>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['pricebase']): ?>
        <tr>
            <td><?php echo $this->_tpl_vars['translate_sebestoimost']; ?>
:</td>
            <td>
                <?php echo $this->_tpl_vars['pricebase']; ?>
 <?php echo $this->_tpl_vars['currency']; ?>

            </td>
        </tr>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['id']): ?>
        <tr>
            <td>ID:</td>
            <td>
                <?php echo $this->_tpl_vars['id']; ?>

            </td>
        </tr>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['code1c']): ?>
        <tr>
            <td><?php echo $this->_tpl_vars['translate_code']; ?>
:</td>
            <td>
                <?php echo $this->_tpl_vars['code1c']; ?>

            </td>
        </tr>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['articul']): ?>
        <tr>
            <td><?php echo $this->_tpl_vars['translate_articul']; ?>
:</td>
            <td>
                <?php echo $this->_tpl_vars['articul']; ?>

            </td>
        </tr>
    <?php endif; ?>
    <tr>
        <td></td>
        <td>
                        <a href="<?php echo $this->_tpl_vars['urlBarcode']; ?>
" onclick="shop_product_barcode('<?php echo $this->_tpl_vars['urlBarcode']; ?>
'); return false;"><?php echo $this->_tpl_vars['translate_item_barcode']; ?>
</a>
            <a href="<?php echo $this->_tpl_vars['urlPricecode']; ?>
" onclick="shop_product_barcode('<?php echo $this->_tpl_vars['urlPricecode']; ?>
'); return false;"><?php echo $this->_tpl_vars['translate_tsennik']; ?>
</a>
            <a href="/admin/shop/storage/pricecode/print/?code=<?php echo $this->_tpl_vars['id']; ?>
" target="_blank"><?php echo $this->_tpl_vars['translate_drugoy_tsennik']; ?>
</a>
        </td>
    </tr>
</table>