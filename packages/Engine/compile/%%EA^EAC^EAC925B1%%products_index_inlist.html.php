<?php /* Smarty version 2.6.27-optimized, created on 2015-11-18 16:47:22
         compiled from /var/www/shop.local/contents/shop/admin/products/products_index_inlist.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', '/var/www/shop.local/contents/shop/admin/products/products_index_inlist.html', 27, false),)), $this); ?>
<div class="shop-productexplorer-list <?php if ($this->_tpl_vars['folderviewCookie']): ?>line<?php endif; ?>">
    <?php if ($this->_tpl_vars['openCategory']): ?>
        <div class="element js-droppable" js-data-id="<?php echo $this->_tpl_vars['openCategory']['parentid']; ?>
">
            <a href="<?php echo $this->_tpl_vars['openCategory']['url']; ?>
" class="image-folder back"></a>
            <a href="<?php echo $this->_tpl_vars['openCategory']['url']; ?>
" class="name">
                <?php if ($this->_tpl_vars['openCategory']['name']): ?>
                    <?php echo $this->_tpl_vars['translate_back_in']; ?>
 <?php echo $this->_tpl_vars['openCategory']['name']; ?>

                <?php else: ?>
                    <?php echo $this->_tpl_vars['translate_back']; ?>

                <?php endif; ?>
            </a>
        </div>
    <?php endif; ?>

    <?php $_from = $this->_tpl_vars['categoryArrayForFolders']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
        <div class="element js-draggable js-droppable <?php if ($this->_tpl_vars['e']['hidden']): ?>hidden<?php endif; ?>" js-data-id="<?php echo $this->_tpl_vars['e']['id']; ?>
">
            <a href="<?php echo $this->_tpl_vars['e']['url']; ?>
" class="image-folder"></a>
            <acronym title="<?php echo $this->_tpl_vars['e']['name']; ?>
"><a href="<?php echo $this->_tpl_vars['e']['url']; ?>
" class="name"><?php echo $this->_tpl_vars['e']['name']; ?>
</a></acronym>
        </div>
    <?php endforeach; endif; unset($_from); ?>

    <div class="element">
        <a href="#" class="image-folder new js-add-new-category" js-data-id="<?php echo $this->_tpl_vars['openCategoryId']; ?>
"></a>
        <a href="#" class="name js-add-new-category" js-data-id="<?php echo $this->_tpl_vars['openCategoryId']; ?>
"><?php echo $this->_tpl_vars['translate_category_add']; ?>
</a>
    </div>

    <?php if (count($this->_tpl_vars['productsArray']) > 0): ?>
        <?php $_from = $this->_tpl_vars['productsArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
            <div class="element js-product-preview js-draggable <?php if ($this->_tpl_vars['e']['hidden']): ?>hidden<?php endif; ?> js-draggable-product"  js-data-id="<?php echo $this->_tpl_vars['e']['id']; ?>
" data-id="<?php echo $this->_tpl_vars['e']['id']; ?>
">
                <div class="inner-el">
                    <a href="<?php echo $this->_tpl_vars['e']['url']; ?>
" class="image"><span><img src="<?php echo $this->_tpl_vars['e']['image']; ?>
" alt="" /></span></a>
                    <acronym title="<?php echo $this->_tpl_vars['e']['name']; ?>
"><a href="<?php echo $this->_tpl_vars['e']['url']; ?>
" class="name"><?php echo $this->_tpl_vars['e']['name']; ?>
</a></acronym>
                    <label><input type="checkbox" name="id[]" class="js-checkbox" value="<?php echo $this->_tpl_vars['e']['id']; ?>
" /></label>
                </div>
            </div>
        <?php endforeach; endif; unset($_from); ?>
    <?php else: ?>
        <?php if (! $this->_tpl_vars['categoryArrayForFolders']): ?>
            <div class="shop-message-error"> <?php echo $this->_tpl_vars['translate_tovarov_net']; ?>
. </div>
        <?php endif; ?>
    <?php endif; ?>

    <div class="element">
        <a href="/admin/shop/products/add/?categoryid=<?php echo $this->_tpl_vars['openCategoryId']; ?>
" class="image-folder new-product"></a>
        <a href="/admin/shop/products/add/?categoryid=<?php echo $this->_tpl_vars['openCategoryId']; ?>
" class="name"><?php echo $this->_tpl_vars['translate_dobavit_tovar']; ?>
</a>
    </div>

    <!--do not remove-->
    <div class="empty"></div>
    <div class="empty"></div>
    <div class="empty"></div>
    <div class="empty"></div>
    <div class="empty"></div>
    <div class="empty"></div>
    <div class="empty"></div>
    <div class="empty"></div>
    <div class="empty"></div>
    <div class="empty"></div>
    <div class="empty"></div>
    <div class="empty"></div>
    <!--do not remove end-->
</div>

<script type="text/javascript">
    $j('.shop-productexplorer-list .js-droppable').droppable({
        activeClass: "droppable",
        hoverClass: "droppable-hover"
    });
    $j('.js-block-tree .item').droppable({
        activeClass: "droppable",
        hoverClass: "droppable-hover"
    });
    $j('.shop-productexplorer-list .js-draggable').draggable({ revert: "invalid" });
</script>