<?php /* Smarty version 2.6.27-optimized, created on 2015-11-24 17:05:25
         compiled from /var/www/shop.local//templates/default//shop_product.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', '/var/www/shop.local//templates/default//shop_product.html', 45, false),array('modifier', 'count', '/var/www/shop.local//templates/default//shop_product.html', 242, false),)), $this); ?>
<input type="hidden" id="productPage" value="<?php echo $this->_tpl_vars['productID']; ?>
">

<?php if ($this->_tpl_vars['message'] == 'commentok'): ?>
    <div class="os-message-success">
        <?php echo $this->_tpl_vars['translate_testimonials_success']; ?>
.
    </div>
<?php endif; ?>

<?php if ($this->_tpl_vars['message'] == 'commenterror'): ?>
    <div class="os-message-error">
        <?php echo $this->_tpl_vars['translate_testimonials_error']; ?>
.
    </div>
<?php endif; ?>

<div class="os-crumbs">
    <?php if ($this->_tpl_vars['pathArray']): ?>
        <div itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
            <a href="/" itemprop="url">
                <span itemprop="title"><?php echo $this->_tpl_vars['storeTitle']; ?>
</span>
            </a>
        </div>
    <?php endif; ?>
    <?php $_from = $this->_tpl_vars['pathArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
        <div itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
            <a href="<?php echo $this->_tpl_vars['e']['url']; ?>
" itemprop="url">
                <span itemprop="title"><?php echo $this->_tpl_vars['e']['name']; ?>
</span>
            </a>
        </div>
    <?php endforeach; endif; unset($_from); ?>
    <div itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
        <a href="<?php echo $this->_tpl_vars['url']; ?>
" itemprop="url">
            <span itemprop="title"><?php echo $this->_tpl_vars['name']; ?>
</span>
        </a>
    </div>
</div>

<div class="os-product-view" itemscope itemtype="http://schema.org/Product">
    <h1 itemprop="name"><?php if ($this->_tpl_vars['seoh1']): ?> <?php echo $this->_tpl_vars['seoh1']; ?>
 <?php else: ?> <?php echo $this->_tpl_vars['name']; ?>
 <?php endif; ?></h1>
    <?php if ($this->_tpl_vars['imagesArray']): ?>
        <div class="os-block-productimage js-productimage-block">
            <div class="line">
                <ul>
                    <?php $_from = $this->_tpl_vars['imagesArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['e']):
?>
                        <li>
                            <a href="<?php echo $this->_tpl_vars['e']['originalUrl']; ?>
" class="colorbox" title="<?php echo $this->_tpl_vars['name']; ?>
"><img itemprop="image" src="<?php echo $this->_tpl_vars['e']['cropUrl']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" title="<?php echo ((is_array($_tmp=$this->_tpl_vars['name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" /></a>
                        </li>
                    <?php endforeach; endif; unset($_from); ?>
                </ul>
            </div>

            <?php if ($this->_tpl_vars['rating'] > 0): ?>
                <div class="os-block-rating" itemscope itemtype="http://data-vocabulary.org/Review-aggregate">
                    <div class="inner" itemprop="rating" itemscope itemtype="http://data-vocabulary.org/Rating" style="width: <?php echo $this->_tpl_vars['rating']*20; ?>
%;">
                        <em itemprop="average"><?php echo $this->_tpl_vars['rating']; ?>
</em>
                        <em itemprop="best">5</em>
                        <em itemprop="count"><?php echo $this->_tpl_vars['ratingCount']; ?>
</em>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (count ( $this->_tpl_vars['imagesArray'] ) > 1): ?>
                <div class="control">
                    <ul>
                        <?php $_from = $this->_tpl_vars['imagesArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
                            <li>
                                <a href="#">
                                    <img src="<?php echo $this->_tpl_vars['e']['cropUrl']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" title="<?php echo ((is_array($_tmp=$this->_tpl_vars['name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" />
                                </a>
                            </li>
                        <?php endforeach; endif; unset($_from); ?>
                    </ul>
                </div>

                <script type="text/javascript">
                    $j(function() {
                        $j('.js-productimage-block .line').jCarouselLite({
                            speed: 500,
                            visible: 1,
                            btnGo: $j('.js-productimage-block .control li'),
                            activeClass: 'selected',
                            circular: false
                        });
                    });
                </script>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <div class="os-block-productcontent <?php if (! $this->_tpl_vars['imagesArray']): ?>noimg<?php endif; ?>">
        <?php if ($this->_tpl_vars['descriptionshort']): ?>
            <div class="main-description" itemprop="description"><?php echo $this->_tpl_vars['descriptionshort']; ?>
</div>
        <?php endif; ?>

        <div itemprop="offers" itemscope itemtype="http://schema.org/Offer">
            <form method="post" id="id-order">
                <div class="block-price">
                    <?php if ($this->_tpl_vars['price'] == 0): ?>
                        <div class="os-price-specify " itemprop="priceSpecification"><?php echo $this->_tpl_vars['translate_specify_a_price']; ?>
</div>
                        <input type="hidden" id="canAddMarkup" value="">
                    <?php else: ?>
                        <?php if (! $this->_tpl_vars['avail']): ?>
                            <div class="os-price-unavailable">
                                <span itemprop="price" id="priceSpan"><?php echo $this->_tpl_vars['price']; ?>
</span>
                                <span itemprop="priceCurrency"><?php echo $this->_tpl_vars['currency']; ?>
</span>
                            </div>
                        <?php else: ?>
                            <div class="os-price-available">
                                <span itemprop="price" id="priceSpan"><?php echo $this->_tpl_vars['price']; ?>
</span>
                                <span itemprop="priceCurrency"><?php echo $this->_tpl_vars['currency']; ?>
</span>
                            </div>
                        <?php endif; ?>

                        <div class="js_personal_discount_check" data-productid="<?php echo $this->_tpl_vars['id']; ?>
"></div>

                        <input type="hidden" id="canAddMarkup" value="<?php echo $this->_tpl_vars['price']; ?>
">
                    <?php endif; ?>
                    <?php if (( $this->_tpl_vars['discount'] && $this->_tpl_vars['avail'] && ! $this->_tpl_vars['canMakePreorder'] ) || ( $this->_tpl_vars['discount'] && $this->_tpl_vars['canMakePreorder'] && ! $this->_tpl_vars['avail'] )): ?>
                        <div class="os-discount">-<?php echo $this->_tpl_vars['discount']; ?>
%</div>
                        <input type="hidden" id="dataDiscount" value="<?php echo $this->_tpl_vars['discount']; ?>
">
                    <?php endif; ?>
                    <?php if ($this->_tpl_vars['priceold'] && $this->_tpl_vars['priceold'] > $this->_tpl_vars['price']): ?>
                        <div class="os-price-old">
                            <?php echo $this->_tpl_vars['priceold']; ?>
 <?php echo $this->_tpl_vars['currency']; ?>

                        </div>
                    <?php endif; ?>
                    <div class="clear"></div>
                </div>

                <?php if ($this->_tpl_vars['iconImage']): ?>
                    <div class="icon-block-image">
                        <?php if ($this->_tpl_vars['iconURL']): ?>
                            <div class="part image">
                                <a href="<?php echo $this->_tpl_vars['iconURL']; ?>
"><img src="<?php echo $this->_tpl_vars['iconImage']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['iconName'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" title="<?php echo ((is_array($_tmp=$this->_tpl_vars['iconName'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" /></a>
                            </div>
                            <div class="part">
                                <a href="<?php echo $this->_tpl_vars['iconURL']; ?>
"><strong><?php echo $this->_tpl_vars['iconName']; ?>
</strong></a>
                            </div>
                        <?php else: ?>
                            <div class="part image">
                                <img src="<?php echo $this->_tpl_vars['iconImage']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['iconName'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" title="<?php echo ((is_array($_tmp=$this->_tpl_vars['iconName'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" />
                            </div>
                            <div class="part">
                                <strong><?php echo $this->_tpl_vars['iconName']; ?>
</strong>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <div class="code">
                    <div class="inner-code">
                        <?php if ($this->_tpl_vars['code']): ?>
                            <?php echo $this->_tpl_vars['translate_item_code']; ?>
: <span itemprop="mpn"><?php echo $this->_tpl_vars['code']; ?>
</span><br />
                        <?php endif; ?>
                        <?php if ($this->_tpl_vars['barcode']): ?>
                            <?php echo $this->_tpl_vars['translate_item_barcode']; ?>
: <span itemprop="gtin13"><?php echo $this->_tpl_vars['barcode']; ?>
</span><br />
                        <?php endif; ?>
                    </div>
                </div>
                <div class="clear"></div>

                <div class="avail">
                    <?php if ($this->_tpl_vars['avail']): ?>
                        <?php if ($this->_tpl_vars['availtext']): ?>
                            <div class="os-available" itemprop="availability"><?php echo $this->_tpl_vars['availtext']; ?>
</div>
                        <?php else: ?>
                            <div class="os-available"><?php echo $this->_tpl_vars['translate_v_nalichii']; ?>
</div>
                        <?php endif; ?>
                    <?php else: ?>
                        <?php if ($this->_tpl_vars['availtext']): ?>
                            <div class="os-unavailable" itemprop="availability"><?php echo $this->_tpl_vars['availtext']; ?>
</div>
                        <?php else: ?>
                            <div class="os-unavailable"><?php echo $this->_tpl_vars['translate_net_v_nalichii']; ?>
</div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>

                <?php if ($this->_tpl_vars['canbuy'] || $this->_tpl_vars['canMakePreorder']): ?>
                    <div class="block-button">
                        <input type="text" value="<?php echo $this->_tpl_vars['count']; ?>
" name="count" class="count js-shop-buy-count" />

                                                <div class="js-shop-buy" data-productid="<?php echo $this->_tpl_vars['id']; ?>
">
                            <a href="#" class="js-shop-buy-action os-submit green"><?php echo $this->_tpl_vars['translate_to_basket']; ?>
</a>
                        </div>
                    </div>

                    <div class="block-button">
                        <a class="os-submit light" href="javascript: void(0);" onclick="basket_order_quick('<?php echo $this->_tpl_vars['productID']; ?>
', '<?php echo $this->_tpl_vars['nameQuick']; ?>
');"><?php echo $this->_tpl_vars['translate_buy_quick']; ?>
</a>
                    </div>
                <?php endif; ?>

                <?php if ($this->_tpl_vars['noticeOfAvailability']): ?>
                    <div class="block-button double">
                        <a class="os-submit" href="javascript: void(0);"onclick= "<?php if (! $this->_tpl_vars['emailAndAuthorized']): ?>popupOpen('#id-notice-of-availability');<?php else: ?>productsNoticeOfAvailability();<?php endif; ?>">
                        <?php echo $this->_tpl_vars['translate_notice_of_availability']; ?>
</a><br />
                    </div>

                    <?php if ($this->_tpl_vars['sameModelProductArray']): ?>
                        <div class="clear"></div>
                        <div class="os-recomended-list">
                            <?php $_from = $this->_tpl_vars['sameModelProductArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['r']):
?>
                                <div class="os-recomended-element">
                                    <div class="recomended-wrap">
                                        <div class="block-image">
                                            <a href="<?php echo $this->_tpl_vars['r']['url']; ?>
" target="_blank">
                                                <img src="<?php echo $this->_tpl_vars['r']['image']; ?>
" alt="<?php echo $this->_tpl_vars['r']['name']; ?>
" title="<?php echo $this->_tpl_vars['r']['name']; ?>
">
                                            </a>
                                        </div>
                                        <div class="block-name">
                                            <a href="<?php echo $this->_tpl_vars['r']['url']; ?>
" target="_blank"><?php echo $this->_tpl_vars['r']['name']; ?>
</a>
                                        </div>
                                        <div class="clear"></div>
                                        <div class="block-button">
                                            <?php if ($this->_tpl_vars['r']['price'] > 0): ?>
                                                <div class="os-price-available">
                                                    <span itemprop="price"><?php echo $this->_tpl_vars['r']['price']; ?>
</span>
                                                    <span itemprop="priceCurrency"><?php echo $this->_tpl_vars['currency']; ?>
</span>
                                                </div>
                                            <?php else: ?>
                                                <div class="os-price-specify" itemprop="priceSpecification"><?php echo $this->_tpl_vars['translate_specify_a_price']; ?>
</div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; endif; unset($_from); ?>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>

                <div class="block-links">
                    <?php if ($this->_tpl_vars['foundcheaper']): ?>
                        <a class="os-link-dashed" href="javascript: void(0);" onclick="popupOpen('.js-block-cheaper');"><?php echo $this->_tpl_vars['translate_found_cheaper']; ?>
?</a><br />
                    <?php endif; ?>
                    <div class="js-shop-compare" data-productid="<?php echo $this->_tpl_vars['id']; ?>
">
                        <a href="javascript:void(0);" class="os-link-dashed js-shop-compare-action"><?php echo $this->_tpl_vars['translate_shop_compare_action']; ?>
</a>
                        <a href="/compare/" class="js-shop-compared" style="display: none;"><?php echo $this->_tpl_vars['translate_compared']; ?>
</a>
                        <br /><a href="javascript:void(0);" data-productid="<?php echo $this->_tpl_vars['id']; ?>
" class="os-link-dashed js-shop-favorite" ></a>
                    </div>
                </div>
                <div class="clear"></div>

                <?php if (count($this->_tpl_vars['seriesArray']) > 1): ?>
                    <div class="block-gotomodel">
                        <div class="caption"><?php echo $this->_tpl_vars['translate_model_line']; ?>
</div>
                        <select id="js-go-to-model">
                            <option value="" selected>---</option>
                            <?php $_from = $this->_tpl_vars['seriesArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
                                <option value="<?php echo $this->_tpl_vars['e']['url']; ?>
"><?php echo $this->_tpl_vars['e']['name']; ?>
</option>
                            <?php endforeach; endif; unset($_from); ?>
                        </select>
                    </div>

                    <script>
                        $j(function(){
                            // bind change event to select, and go to selected model
                            $j('#js-go-to-model').bind('change', function () {
                                var url = $j(this).val();
                                if (url) {
                                    window.location = url;
                                }
                                return false;
                            });
                        });
                    </script>
                <?php endif; ?>

                <?php if ($this->_tpl_vars['optionArray']): ?>
                    <div class="os-options-list">
                        <div class="head"><?php echo $this->_tpl_vars['translate_order_options']; ?>
</div>
                        <div class="body">
                            <?php $_from = $this->_tpl_vars['optionArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
                                <select name="option-<?php echo $this->_tpl_vars['e']['id']; ?>
" class="js-shop-buy-option" data-optionid="<?php echo $this->_tpl_vars['e']['id']; ?>
">
                                    <option value=""><?php echo $this->_tpl_vars['translate_select_the']; ?>
 <?php echo $this->_tpl_vars['e']['name']; ?>
</option>
                                    <?php $_from = $this->_tpl_vars['e']['valueArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['v']):
?>
                                        <option value="<?php echo ((is_array($_tmp=$this->_tpl_vars['v'][0])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"><?php echo $this->_tpl_vars['v'][0]; ?>
</option>
                                    <?php endforeach; endif; unset($_from); ?>
                                </select>
                                <?php $_from = $this->_tpl_vars['e']['valueArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['v']):
?>
                                    <input type="hidden" id="option<?php echo $this->_tpl_vars['e']['id']; ?>
hidden<?php echo $this->_tpl_vars['v'][2]; ?>
" value="<?php echo $this->_tpl_vars['v'][1]; ?>
"/>
                                <?php endforeach; endif; unset($_from); ?>
                            <?php endforeach; endif; unset($_from); ?>
                         </div>
                    </div>
                <?php endif; ?>
            </form>
        </div>

        <div class="block-brand">
            <?php if ($this->_tpl_vars['brand']): ?>
                <?php echo $this->_tpl_vars['translate_brand']; ?>
:
                <a href="<?php echo $this->_tpl_vars['brand']['url']; ?>
" itemprop="brand">
                    <?php echo $this->_tpl_vars['brand']['name']; ?>

                    <?php if ($this->_tpl_vars['brand']['image']): ?>
                        <img itemprop="logo" src="<?php echo $this->_tpl_vars['brand']['image']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['brand']['name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" title="<?php echo ((is_array($_tmp=$this->_tpl_vars['brand']['name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" />
                    <?php endif; ?>
                </a>
                <br />
            <?php endif; ?>

            <?php if ($this->_tpl_vars['model']): ?>
                <?php echo $this->_tpl_vars['translate_model']; ?>
: <strong itemprop="model"><?php echo $this->_tpl_vars['model']; ?>
</strong>
                <br />
            <?php endif; ?>
        </div>

        <?php if ($this->_tpl_vars['share']): ?>
            <div class="product-share">
                <div class="caption"><?php echo $this->_tpl_vars['translate_action']; ?>
!</div>
                <?php echo $this->_tpl_vars['share']; ?>

            </div>
        <?php endif; ?>

        <?php if ($this->_tpl_vars['siteurl']): ?>
            <div class="siteurl">
                <a href="<?php echo $this->_tpl_vars['siteurl']; ?>
"><?php echo $this->_tpl_vars['translate_site_url']; ?>
</a>
            </div>
        <?php endif; ?>

        <?php if ($this->_tpl_vars['showSocial']): ?>
            <div class="social">
                <noindex>
                    <?php echo $this->_tpl_vars['translate_social_block']; ?>
:
                    <script type="text/javascript" src="//yandex.st/share/share.js" charset="utf-8"></script>
                    <div class="yashare-auto-init" data-yashareL10n="ru" data-yashareType="link" data-yashareQuickServices="yaru,vkontakte,facebook,twitter,odnoklassniki,moimir,lj,friendfeed,moikrug"></div>
                </noindex>
            </div>
        <?php endif; ?>
    </div>
    <div class="clear"></div>

    <?php if ($this->_tpl_vars['supplierArray'] || $this->_tpl_vars['storageArray']): ?>
        <div class="os-block-productfeatures" style="border: 1px solid blue;">
            <?php if ($this->_tpl_vars['storageArray']): ?>
                <table>
                    <thead>
                    <tr>
                        <td><?php echo $this->_tpl_vars['translate_storage']; ?>
</td>
                        <td><?php echo $this->_tpl_vars['translate_arrival_date']; ?>
</td>
                        <td><?php echo $this->_tpl_vars['translate_price_in_stock']; ?>
</td>
                        <td><?php echo $this->_tpl_vars['translate_number']; ?>
</td>
                    </tr>
                    </thead>
                    <?php $_from = $this->_tpl_vars['storageArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['s']):
?>
                        <tr>
                            <td><?php echo $this->_tpl_vars['s']['name']; ?>
</td>
                            <td><?php echo $this->_tpl_vars['s']['cdate']; ?>
</td>
                            <td><?php echo $this->_tpl_vars['s']['price']; ?>
 <?php echo $this->_tpl_vars['s']['currency']; ?>
</td>
                            <td><?php echo $this->_tpl_vars['s']['count']; ?>
</td>
                        </tr>
                    <?php endforeach; endif; unset($_from); ?>
                </table>
                <br />
            <?php endif; ?>

            <?php if ($this->_tpl_vars['supplierArray']): ?>
                <table>
                    <thead>
                        <tr>
                            <td><?php echo $this->_tpl_vars['translate_supplier']; ?>
</td>
                            <td><?php echo $this->_tpl_vars['translate_supplier_code']; ?>
</td>
                            <td><?php echo $this->_tpl_vars['translate_supplier_price']; ?>
</td>
                            <td><?php echo $this->_tpl_vars['translate_supplier_avail']; ?>
</td>
                        </tr>
                    </thead>
                    <?php $_from = $this->_tpl_vars['supplierArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['index'] => $this->_tpl_vars['e']):
?>
                        <tr>
                            <td> <?php echo $this->_tpl_vars['e']['supplierName']; ?>
</td>
                            <td><?php echo $this->_tpl_vars['e']['supplierCode']; ?>
</td>
                            <td align="right"><?php echo $this->_tpl_vars['e']['supplierPrice']; ?>
</td>
                            <td>
                                <?php if ($this->_tpl_vars['e']['supplierAvail']): ?>
                                    <?php echo $this->_tpl_vars['translate_available']; ?>

                                    <?php echo $this->_tpl_vars['e']['supplierDate']; ?>

                                <?php else: ?>
                                    <?php echo $this->_tpl_vars['translate_out_of_stock']; ?>

                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; endif; unset($_from); ?>
                </table>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <?php if ($this->_tpl_vars['urledit']): ?>
        <div class="admin-edit">
            <a class="os-submit red edit" href="<?php echo $this->_tpl_vars['urledit']; ?>
" target="_blank" title="<?php echo $this->_tpl_vars['translate_edit']; ?>
"></a>
        </div>
    <?php endif; ?>
</div>

<?php if ($this->_tpl_vars['actionSetArray']): ?>
    <div class="os-productaction-carousel js-action-carousel">
        <?php $_from = $this->_tpl_vars['actionSetArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['actionset']):
?>
            <div>
                <div class="os-block-caption">
                    <?php echo $this->_tpl_vars['translate_rekomenduem_kupit_komplekt_tovarov']; ?>
:
                </div>
                <div class="line">
                    <?php $_from = $this->_tpl_vars['actionset']['productArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['p']):
?>
                        <div class="product-element">
                            <div class="image">
                                <a target="_blank" href="<?php echo $this->_tpl_vars['p']['url']; ?>
">
                                    <img src="<?php echo $this->_tpl_vars['p']['image']; ?>
">
                                </a>
                            </div>
                            <div class="name">
                                <a href="<?php echo $this->_tpl_vars['p']['url']; ?>
">
                                    <?php echo $this->_tpl_vars['p']['name']; ?>

                                </a>
                            </div>
                        </div>
                    <?php endforeach; endif; unset($_from); ?>
                </div>
                <div class="block-buy">
                    <?php echo $this->_tpl_vars['translate_tsena_dannogo_nabora']; ?>
:
                    <span class="os-price-available"><?php echo $this->_tpl_vars['actionset']['sum']; ?>
 <?php echo $this->_tpl_vars['currency']; ?>
</span>
                    <?php if ($this->_tpl_vars['canbuy']): ?>
                        <div class="block-button">
                            
                                                        <div class="js-shop-buy" data-setid="<?php echo $this->_tpl_vars['actionset']['id']; ?>
">
                                <a href="#" class="js-shop-buy-action os-submit green"><?php echo $this->_tpl_vars['translate_to_basket']; ?>
</a>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="clear"></div>
                </div>
            </div>
        <?php endforeach; endif; unset($_from); ?>
    </div>
<?php endif; ?>





<?php if ($this->_tpl_vars['description'] || $this->_tpl_vars['width'] || $this->_tpl_vars['length'] || $this->_tpl_vars['height'] || $this->_tpl_vars['weight'] || $this->_tpl_vars['characteristicsArray'] || $this->_tpl_vars['characteristics'] || $this->_tpl_vars['seriesArray'] || $this->_tpl_vars['commentIntegration'] || $this->_tpl_vars['commentsArray'] || $this->_tpl_vars['allowcomment'] || $this->_tpl_vars['productnewsArray']): ?>
    <div class="os-block-tabs product-tabs js-product-tabs">
        <?php if ($this->_tpl_vars['description'] || $this->_tpl_vars['width'] || $this->_tpl_vars['length'] || $this->_tpl_vars['height'] || $this->_tpl_vars['weight']): ?>
            <a href="#" data-nav="js-description-block"><?php echo $this->_tpl_vars['translate_item_info']; ?>
</a>
        <?php endif; ?>
        <?php if ($this->_tpl_vars['videoArray']): ?>
            <a href="#" data-nav="js-video-block"><?php echo $this->_tpl_vars['translate_video']; ?>
</a>
        <?php endif; ?>
        <?php if ($this->_tpl_vars['characteristicsArray'] || $this->_tpl_vars['characteristics']): ?>
            <a href="#" data-nav="js-features-block"><?php echo $this->_tpl_vars['translate_features']; ?>
</a>
        <?php endif; ?>
        <?php if (count($this->_tpl_vars['seriesArray']) > 1): ?>
            <a href="#" data-nav="js-series-block"><?php echo $this->_tpl_vars['translate_model_line']; ?>
</a>
        <?php endif; ?>
        <?php if ($this->_tpl_vars['commentIntegration']): ?>
            <a href="#" data-nav="js-comments-block"><?php echo $this->_tpl_vars['translate_many_comments']; ?>
</a>
        <?php endif; ?>
        <?php if ($this->_tpl_vars['commentsArray'] || $this->_tpl_vars['allowcomment']): ?>
            <a href="#" data-nav="js-feedback-block"><?php echo $this->_tpl_vars['translate_comments']; ?>
<?php if ($this->_tpl_vars['commentsArray']): ?>: <?php echo count($this->_tpl_vars['commentsArray']); ?>
<?php endif; ?></a>
        <?php endif; ?>
        <?php if ($this->_tpl_vars['productnewsArray']): ?>
            <a href="#" data-nav="js-block-news"><?php echo $this->_tpl_vars['translate_news_simple']; ?>
</a>
        <?php endif; ?>
        <div class="clear"></div>
    </div>
    <div class="os-tabs-place js-product-tabs-place" style="display: none;"></div>
<?php endif; ?>
<?php if ($this->_tpl_vars['description'] || $this->_tpl_vars['width'] || $this->_tpl_vars['length'] || $this->_tpl_vars['height'] || $this->_tpl_vars['weight']): ?>
    <h2 class="js-description-block"><?php echo $this->_tpl_vars['translate_item_info']; ?>
 <?php if ($this->_tpl_vars['seoh1']): ?> <?php echo $this->_tpl_vars['seoh1']; ?>
 <?php else: ?> <?php echo $this->_tpl_vars['name']; ?>
 <?php endif; ?></h2>
    <div class="os-block-productdescription">
        <div class="os-editor-content js-ckEditor-container">
            <?php echo $this->_tpl_vars['description']; ?>

        </div>

                <?php if ($this->_tpl_vars['width'] != 0): ?>
            <br/><?php echo $this->_tpl_vars['translate_width']; ?>
: <span itemprop="width"><?php echo $this->_tpl_vars['width']; ?>
</span>
        <?php endif; ?>
        <?php if ($this->_tpl_vars['height'] != 0): ?>
            <br/><?php echo $this->_tpl_vars['translate_height']; ?>
: <span itemprop="height"><?php echo $this->_tpl_vars['height']; ?>
</span>
        <?php endif; ?>
        <?php if ($this->_tpl_vars['length'] != 0): ?>
            <br/><?php echo $this->_tpl_vars['translate_length']; ?>
: <?php echo $this->_tpl_vars['length']; ?>

        <?php endif; ?>
        <?php if ($this->_tpl_vars['weight'] != 0): ?>
            <br/><?php echo $this->_tpl_vars['translate_weight']; ?>
: <span itemprop="weight"><?php echo $this->_tpl_vars['weight']; ?>
</span>
        <?php endif; ?>
    </div>
<?php endif; ?>

<?php if ($this->_tpl_vars['videoArray']): ?>
    <h2 class="js-video-block"><?php echo $this->_tpl_vars['translate_video']; ?>
 <?php if ($this->_tpl_vars['seoh1']): ?> <?php echo $this->_tpl_vars['seoh1']; ?>
 <?php else: ?> <?php echo $this->_tpl_vars['name']; ?>
 <?php endif; ?></h2>
    <div class="os-block-productdescription">
        <?php $_from = $this->_tpl_vars['videoArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['v']):
?>
            <?php echo $this->_tpl_vars['v']; ?>
 <br />
        <?php endforeach; endif; unset($_from); ?>
    </div>
<?php endif; ?>

<?php if ($this->_tpl_vars['characteristicsArray'] || $this->_tpl_vars['characteristics']): ?>
    <h2 class="js-features-block"><?php echo $this->_tpl_vars['translate_features']; ?>
 <?php if ($this->_tpl_vars['seoh1']): ?> <?php echo $this->_tpl_vars['seoh1']; ?>
 <?php else: ?> <?php echo $this->_tpl_vars['name']; ?>
 <?php endif; ?></h2>
    <div class="os-block-productfeatures">
        <?php if ($this->_tpl_vars['characteristicsArray']): ?>
            <table>
                <thead>
                    <tr>
                        <td><?php echo $this->_tpl_vars['translate_properties']; ?>
</td>
                        <td><?php echo $this->_tpl_vars['translate_features']; ?>
</td>
                    </tr>
                </thead>
                <?php $_from = $this->_tpl_vars['characteristicsArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['index'] => $this->_tpl_vars['e']):
?>
                    <tr>
                        <td><?php echo $this->_tpl_vars['index']; ?>
</td>
                        <td>
                            <?php $_from = $this->_tpl_vars['e']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['i']):
?>
                                <?php if ($this->_tpl_vars['i']['characteristicColor']): ?>
                                    <div style="background-color: <?php echo $this->_tpl_vars['i']['characteristicColor']; ?>
; display: inline-block; width: 30px;">
                                        &nbsp;
                                    </div>
                                <?php endif; ?>
                                <?php if ($this->_tpl_vars['k'] > 0): ?>,&nbsp;<?php endif; ?>
                                <?php if ($this->_tpl_vars['i']['characteristicInfo']): ?>
                                    <a href="<?php echo $this->_tpl_vars['i']['characteristicInfo']['url']; ?>
" title="<?php echo $this->_tpl_vars['translate_contacts_all']; ?>
 <?php echo $this->_tpl_vars['i']['characteristicInfo']['title']; ?>
"><?php echo $this->_tpl_vars['i']['characteristicValue']; ?>
</a>
                                <?php else: ?>
                                    <?php echo $this->_tpl_vars['i']['characteristicValue']; ?>

                                <?php endif; ?>
                            <?php endforeach; endif; unset($_from); ?>
                        </td>
                    </tr>
                <?php endforeach; endif; unset($_from); ?>
            </table>
            <?php if ($this->_tpl_vars['characteristics_message']): ?>
                <br /><?php echo $this->_tpl_vars['characteristics_message']; ?>

            <?php endif; ?>
        <?php else: ?>
            <?php echo $this->_tpl_vars['characteristics']; ?>

        <?php endif; ?>
    </div>
<?php endif; ?>

<?php if (count($this->_tpl_vars['seriesArray']) > 1): ?>
    <h2 class="js-series-block"><?php echo $this->_tpl_vars['translate_model_line']; ?>
 <?php if ($this->_tpl_vars['seoh1']): ?> <?php echo $this->_tpl_vars['seoh1']; ?>
 <?php else: ?> <?php echo $this->_tpl_vars['name']; ?>
 <?php endif; ?></h2>
    <div class="os-block-productfeatures">
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <td <?php if ($this->_tpl_vars['imageInModel']): ?>colspan="2"<?php endif; ?>><?php echo $this->_tpl_vars['translate_title_short']; ?>
</td>
                        <td><?php echo $this->_tpl_vars['translate_price']; ?>
</td>
                        <?php $_from = $this->_tpl_vars['filterNameArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
                            <td><?php echo $this->_tpl_vars['e']; ?>
</td>
                        <?php endforeach; endif; unset($_from); ?>
                    </tr>
                </thead>

                <?php $_from = $this->_tpl_vars['seriesArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
                    <tr>
                        <?php if ($this->_tpl_vars['imageInModel']): ?>
                            <td>
                                <?php if ($this->_tpl_vars['e']['image']): ?>
                                    <img src="<?php echo $this->_tpl_vars['e']['image']; ?>
" style="max-height: 100px; max-width: 100px;">
                                <?php endif; ?>
                            </td>
                        <?php endif; ?>
                        <td <?php if ($this->_tpl_vars['imageInModel']): ?>class="mark"<?php endif; ?>>
                            <a href="<?php echo $this->_tpl_vars['e']['url']; ?>
"><?php echo $this->_tpl_vars['e']['name']; ?>
</a>
                        </td>
                        <td class="nowrap">
                            <?php if ($this->_tpl_vars['e']['price'] == 0): ?>
                                <div class="os-price-specify element-inline" itemprop="priceSpecification"><?php echo $this->_tpl_vars['translate_specify_a_price']; ?>
</div>
                            <?php else: ?>
                                <?php if (! $this->_tpl_vars['e']['avail']): ?>
                                    <div class="os-price-unavailable element-inline">
                                        <span id="priceSpan"><?php echo $this->_tpl_vars['e']['price']; ?>
</span> <?php echo $this->_tpl_vars['currency']; ?>

                                    </div>
                                <?php else: ?>
                                    <div class="os-price-available element-inline">
                                        <span id="priceSpan"><?php echo $this->_tpl_vars['e']['price']; ?>
</span> <?php echo $this->_tpl_vars['currency']; ?>

                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>

                            <div class="avail">
                                <?php if ($this->_tpl_vars['e']['avail']): ?>
                                    <?php if ($this->_tpl_vars['e']['availtext']): ?>
                                        <div class="os-available"><?php echo $this->_tpl_vars['e']['availtext']; ?>
</div>
                                    <?php else: ?>
                                        <div class="os-available">в наличии</div>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <?php if ($this->_tpl_vars['e']['availtext']): ?>
                                        <div class="os-unavailable"><?php echo $this->_tpl_vars['e']['availtext']; ?>
</div>
                                    <?php else: ?>
                                        <div class="os-unavailable">нет в наличии</div>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        </td>
                        <?php $_from = $this->_tpl_vars['filterNameArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['filterID'] => $this->_tpl_vars['filterName']):
?>
                            <td><?php echo $this->_tpl_vars['filterValueArray'][$this->_tpl_vars['filterID']][$this->_tpl_vars['e']['id']]; ?>
</td>
                        <?php endforeach; endif; unset($_from); ?>
                    </tr>
                <?php endforeach; endif; unset($_from); ?>
            </table>
        </div>
    </div>
<?php endif; ?>

<?php if ($this->_tpl_vars['commentIntegration']): ?>
    <h2 class="js-comments-block"><?php echo $this->_tpl_vars['translate_many_comments']; ?>
 <?php if ($this->_tpl_vars['seoh1']): ?> <?php echo $this->_tpl_vars['seoh1']; ?>
 <?php else: ?> <?php echo $this->_tpl_vars['name']; ?>
 <?php endif; ?></h2>
    <div class="os-integrated-comment"><?php echo $this->_tpl_vars['commentIntegration']; ?>
</div>
<?php endif; ?>

<div class="os-feedback-list">
    <h2 class="js-feedback-block"><?php echo $this->_tpl_vars['translate_comments']; ?>
 <?php if ($this->_tpl_vars['seoh1']): ?> <?php echo $this->_tpl_vars['seoh1']; ?>
 <?php else: ?> <?php echo $this->_tpl_vars['name']; ?>
 <?php endif; ?></h2>
    <?php if ($this->_tpl_vars['commentsArray']): ?>
        <?php $_from = $this->_tpl_vars['commentsArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
            <div class="element" itemscope itemtype="http://schema.org/Review">
                <?php if (! $this->_tpl_vars['e']['rating'] == '0'): ?>
                    <div class="os-block-rating" itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating">
                        <div class="inner" style="width: <?php echo $this->_tpl_vars['e']['rating']*20; ?>
%;">
                            <meta itemprop="worstRating" content = "0"/>
                            <em itemprop="ratingValue"><?php echo $this->_tpl_vars['e']['rating']; ?>
</em>
                            <em itemprop="bestRating">5</em>
                        </div>
                    </div>
                <?php endif; ?>

                <span itemprop="reviewBody"><?php echo $this->_tpl_vars['e']['content']; ?>
</span><br />

                <?php if ($this->_tpl_vars['e']['plus']): ?>
                    <strong class="good-side"><?php echo $this->_tpl_vars['translate_plus']; ?>
:</strong> <?php echo $this->_tpl_vars['e']['plus']; ?>
<br />
                <?php endif; ?>

                <?php if ($this->_tpl_vars['e']['minus']): ?>
                    <strong class="bad-side"><?php echo $this->_tpl_vars['translate_minus']; ?>
:</strong> <?php echo $this->_tpl_vars['e']['minus']; ?>
<br />
                <?php endif; ?>

                <?php if ($this->_tpl_vars['e']['imagecrop']): ?>
                    <a href="<?php echo $this->_tpl_vars['e']['image']; ?>
" class="colorbox"><img src="<?php echo $this->_tpl_vars['e']['imagecrop']; ?>
"></a>
                    <br />
                <?php endif; ?>
                <?php if ($this->_tpl_vars['e']['answer']): ?>
                    <div class="adminanswer">
                        <br />
                        <strong><?php echo $this->_tpl_vars['translate_answer_administration']; ?>
:</strong>
                        <br />
                        <?php echo $this->_tpl_vars['e']['answer']; ?>

                    </div>
                <?php endif; ?>
                <div class="info">
                    <span itemprop="datePublished" content="<?php echo $this->_tpl_vars['e']['datetime']; ?>
"><?php echo $this->_tpl_vars['e']['datetime']; ?>
</span>
                    <span itemprop="author">
                       <?php echo $this->_tpl_vars['translate_from_small']; ?>
 <?php echo $this->_tpl_vars['e']['name']; ?>

                    </span>
                    <?php echo $this->_tpl_vars['translate_o']; ?>
 <span itemprop="itemReviewed">
                        <?php if ($this->_tpl_vars['e']['shopgb']): ?>
                            <?php echo $this->_tpl_vars['storeTitle']; ?>

                        <?php else: ?>
                            <?php echo $this->_tpl_vars['name']; ?>

                        <?php endif; ?>
                    </span>
                    
                </div>
            </div>
        <?php endforeach; endif; unset($_from); ?>
        <br />
    <?php else: ?>
        <div class="element">
            <strong style="color:#808080"><?php echo $this->_tpl_vars['translate_nocomments_message']; ?>
</strong>
        </div>
        <br />
    <?php endif; ?>
    
    <a href="javascript: void(0);" class="os-submit" onclick="popupOpen('.js-popup-comment-block');"><?php echo $this->_tpl_vars['translate_reviews_of_the_store_add_simple']; ?>
</a>

    <?php if ($this->_tpl_vars['allowcomment']): ?>
        <div class="os-block-popup js-popup-comment-block" style="display: none;">
            <div class="dark" onclick="popupClose('.js-popup-comment-block');"></div>
            <div class="block-popup">
                <div class="head">
                    <a href="javascript: void(0);" class="close" onclick="popupClose('.js-popup-comment-block');">&nbsp;</a>
                    <?php echo $this->_tpl_vars['translate_write_a_review']; ?>

                </div>
                <form method="post" enctype="multipart/form-data">
                    <div class="body">
                        <table>
                            <tr>
                                <td class="vtop"><?php echo $this->_tpl_vars['translate_review_big']; ?>
<span class="important">*</span>:</td>
                                <td><textarea class="js-required" name="postcomment"></textarea></td>
                            </tr>
                            <tr>
                                <td class="vtop"><?php echo $this->_tpl_vars['translate_plus']; ?>
:</td>
                                <td><textarea name="postplus"></textarea></td>
                            </tr>
                            <tr>
                                <td class="vtop"><?php echo $this->_tpl_vars['translate_minus']; ?>
:</td>
                                <td><textarea name="postminus"></textarea></td>
                            </tr>
                            <tr>
                                <td><?php echo $this->_tpl_vars['translate_rating']; ?>
</td>
                                <td>
                                    <div class="os-block-rating">
                                        <div class="inner"></div>
                                        <div class="rating-values js-block-rating">
                                            <span data-count="1"></span>
                                            <span data-count="2"></span>
                                            <span data-count="3"></span>
                                            <span data-count="4"></span>
                                            <span data-count="5"></span>
                                        </div>
                                        <input name="commentrating" type="hidden" value="" />
                                        <div class="text js-rating-clear"></div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <?php echo $this->_tpl_vars['translate_upload_image']; ?>

                                </td>
                                <td>
                                    <input type="file" name="upload_image" />
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="foot">
                        <input type="hidden" name="ajs" class="ajs" value="1" />
                        <input class="js-form-validation os-submit" type="submit" value="<?php echo $this->_tpl_vars['translate_send']; ?>
" name="submitcomment" />
                    </div>
                </form>
            </div>
        </div>
    <?php else: ?>
        <?php echo $this->_tpl_vars['translate_rating_add_message']; ?>

        <a href="/registration/"><?php echo $this->_tpl_vars['translate_sing_up']; ?>
</a>
        <?php echo $this->_tpl_vars['translate_or']; ?>

        <a href="/client/orders/"><?php echo $this->_tpl_vars['translate_authorize']; ?>
</a>.
    <?php endif; ?>
</div>

<?php if ($this->_tpl_vars['productnewsArray']): ?>
    <h2 class="js-block-news"><?php echo $this->_tpl_vars['translate_news_simple']; ?>
</h2>
    <div class="os-block-news">
        <?php $_from = $this->_tpl_vars['productnewsArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
            <div class="element">
                <a href="<?php echo $this->_tpl_vars['e']['url']; ?>
"><?php echo $this->_tpl_vars['e']['name']; ?>
</a>
                <span><?php echo $this->_tpl_vars['e']['date']; ?>
</span>
            </div>
        <?php endforeach; endif; unset($_from); ?>
    </div>
<?php endif; ?>

<?php $_from = $this->_tpl_vars['listsArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
    <div class="os-block-caption"><h3><?php echo $this->_tpl_vars['e']['name']; ?>
</h3></div>
    <?php echo $this->_tpl_vars['e']['html']; ?>

<?php endforeach; endif; unset($_from); ?>

<?php if ($this->_tpl_vars['tagArray']): ?>
    <?php echo $this->_tpl_vars['translate_also']; ?>
:
    <?php $_from = $this->_tpl_vars['tagArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
        <a href="<?php echo $this->_tpl_vars['e']['url']; ?>
"><?php echo $this->_tpl_vars['e']['name']; ?>
</a>
    <?php endforeach; endif; unset($_from); ?>
    <br />
    <br />
<?php endif; ?>

<?php echo $this->_tpl_vars['seocontent']; ?>


<?php echo $this->_tpl_vars['foundcheaper']; ?>


<?php echo $this->_tpl_vars['noticeOfAvailability']; ?>