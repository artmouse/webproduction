<?php /* Smarty version 2.6.27-optimized, created on 2015-12-20 20:51:18
         compiled from /var/www/shop.local/modules/collars/contents/shop_product.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', '/var/www/shop.local/modules/collars/contents/shop_product.html', 177, false),)), $this); ?>

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

<div class="cl-product-info" itemscope itemtype="http://schema.org/Product">
    <div class="block-head">
        <h1 itemprop="name">
            <?php if ($this->_tpl_vars['seoh1']): ?> <?php echo $this->_tpl_vars['seoh1']; ?>
 <?php else: ?> <?php echo $this->_tpl_vars['name']; ?>
 <?php endif; ?>

            <?php if ($this->_tpl_vars['brand']): ?>
                <span>by</span>
                <a class="brand-name" href="<?php echo $this->_tpl_vars['brand']['url']; ?>
" itemprop="brand">
                    <?php echo $this->_tpl_vars['brand']['name']; ?>

                </a>
            <?php endif; ?>
            <a href="javascript:void(0);" data-productid="<?php echo $this->_tpl_vars['id']; ?>
" class="cl-favorite-button js-shop-favorite" ></a>
        </h1>
    </div>

    <div class="cl-crumbs">
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
    <br />
    <br />

    <div class="cl-product-code">
        <?php if ($this->_tpl_vars['code']): ?>
            <?php echo $this->_tpl_vars['translate_item_code']; ?>
: <?php echo $this->_tpl_vars['code']; ?>
<br />
        <?php endif; ?>
        <?php if ($this->_tpl_vars['barcode']): ?>
            <?php echo $this->_tpl_vars['translate_item_barcode']; ?>
: <?php echo $this->_tpl_vars['barcode']; ?>
<br />
        <?php endif; ?>
    </div>
    <br />
    <br />

    <form method="post" id="id-order">
        <div class="left-layer">
            <div class="cl-product-view">
                <div class="description">
                    <div class="inner-element">
                        <div class="block-price">
                            <?php if ($this->_tpl_vars['price'] == 0): ?>
                                <div class="os-price-specify " itemprop="priceSpecification">
                                    <?php echo $this->_tpl_vars['translate_specify_a_price']; ?>

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
                                    <div class="os-price-available <?php if ($this->_tpl_vars['priceold'] && $this->_tpl_vars['priceold'] > $this->_tpl_vars['price']): ?>new-price<?php endif; ?>">
                                        <span itemprop="price" id="priceSpan"><?php echo $this->_tpl_vars['price']; ?>
</span>
                                        <span itemprop="priceCurrency"><?php echo $this->_tpl_vars['currency']; ?>
</span>
                                        <?php if ($this->_tpl_vars['delivery_price']): ?>
                                            <div class="block-delivery">
                                                <span style="font-family: Helvetica, Arial, sans-serif; color: #333333; font-size: 15px;">
                                                    + Shipping Fees <?php echo $this->_tpl_vars['delivery_price']; ?>
 <?php echo $this->_tpl_vars['currency']; ?>

                                                </span>
                                                <a href="/delivery-details">Details</a>
                                            </div>
                                        <?php endif; ?>
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
                        </div>
                        <div class="size-list">
                            <a href="#">Size</a>
                            1, 2, 3
                        </div>

                        <?php if ($this->_tpl_vars['delivery']): ?>
                            <div class="block-delivery">
                                <div class="ta-center">
                                    <strong><?php echo $this->_tpl_vars['translate_delivery']; ?>
</strong>
                                </div>
                                <?php echo $this->_tpl_vars['delivery']; ?>

                            </div>
                        <?php endif; ?>

                        <?php if ($this->_tpl_vars['warranty']): ?>
                            <div class="inner-element">
                                <div class="ta-center">
                                    <strong><?php echo $this->_tpl_vars['translate_warranty']; ?>
</strong>
                                </div>
                                <?php echo $this->_tpl_vars['warranty']; ?>

                            </div>
                        <?php endif; ?>

                        <?php if ($this->_tpl_vars['payment']): ?>
                            <div class="inner-element">
                                <div class="ta-center">
                                    <strong><?php echo $this->_tpl_vars['translate_payment']; ?>
</strong>
                                </div>
                                <?php echo $this->_tpl_vars['payment']; ?>

                            </div>
                        <?php endif; ?>
                    </div>

                    <?php if ($this->_tpl_vars['descriptionshort']): ?>
                        <div class="inner-element" itemprop="description">
                            <?php echo $this->_tpl_vars['descriptionshort']; ?>

                        </div>
                    <?php endif; ?>

                    <?php if ($this->_tpl_vars['rating'] > 0): ?>
                        <div class="inner-element">
                            <strong>Customers Reviews</strong><br />
                                <div class="cl-block-rating" itemscope itemtype="http://data-vocabulary.org/Review-aggregate">
                                    <div class="inner" itemprop="rating" itemscope itemtype="http://data-vocabulary.org/Rating" style="width: <?php echo $this->_tpl_vars['rating']*20; ?>
%;">
                                        <em itemprop="average"><?php echo $this->_tpl_vars['rating']; ?>
</em>
                                        <em itemprop="best">5</em>
                                        <em itemprop="count"><?php echo $this->_tpl_vars['ratingCount']; ?>
</em>
                                    </div>
                                </div>
                        </div>
                    <?php endif; ?>

                </div>

                <div class="product-image">
                    <?php if ($this->_tpl_vars['imagesArray']): ?>
                        <div class="cl-product-slide-for js-prod-slider-for">
                            <?php $_from = $this->_tpl_vars['imagesArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['e']):
?>
                                <div>
                                    <a href="<?php echo $this->_tpl_vars['e']['originalUrl']; ?>
" class="colorbox" title="<?php echo $this->_tpl_vars['name']; ?>
">
                                        <img itemprop="image" src="<?php echo $this->_tpl_vars['e']['cropUrl']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" title="<?php echo ((is_array($_tmp=$this->_tpl_vars['name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" />
                                    </a>
                                </div>
                            <?php endforeach; endif; unset($_from); ?>
                        </div>

                        <div class="cl-product-slide-nav js-prod-slider-nav">
                            <?php $_from = $this->_tpl_vars['imagesArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
                                <div>
                                    <div class="nav-element">
                                        <a href="javascript:void(0);">
                                            <img src="<?php echo $this->_tpl_vars['e']['cropUrl']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" title="<?php echo ((is_array($_tmp=$this->_tpl_vars['name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" />
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; endif; unset($_from); ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="clear"></div>
            </div>

            <div class="about-product">

                <div class="cl-block-tabs">
                    <div class="tabs js-tabs">
                        <a data-tab="1" href="javascript:void(0);" class="selected">Product Description</a>
                        <a data-tab="2" href="javascript:void(0);"><?php echo $this->_tpl_vars['translate_comments']; ?>
</a>
                    </div>

                    <div  class="tabs-content js-tab-1" style="display: block">

                        <?php if ($this->_tpl_vars['description'] || $this->_tpl_vars['width'] || $this->_tpl_vars['length'] || $this->_tpl_vars['height'] || $this->_tpl_vars['weight']): ?>
                            <h3><?php echo $this->_tpl_vars['translate_item_info']; ?>
 <?php if ($this->_tpl_vars['seoh1']): ?> <?php echo $this->_tpl_vars['seoh1']; ?>
 <?php else: ?> <?php echo $this->_tpl_vars['name']; ?>
 <?php endif; ?></h3>
                            <div class="os-editor-content js-ckEditor-container">
                                <?php echo $this->_tpl_vars['description']; ?>

                            </div>

                                                        <?php if ($this->_tpl_vars['width'] != 0): ?>
                            <br/><?php echo $this->_tpl_vars['translate_width']; ?>
: <span><?php echo $this->_tpl_vars['width']; ?>
</span>
                            <?php endif; ?>
                            <?php if ($this->_tpl_vars['height'] != 0): ?>
                            <br/><?php echo $this->_tpl_vars['translate_height']; ?>
: <span><?php echo $this->_tpl_vars['height']; ?>
</span>
                            <?php endif; ?>
                            <?php if ($this->_tpl_vars['length'] != 0): ?>
                            <br/><?php echo $this->_tpl_vars['translate_length']; ?>
: <?php echo $this->_tpl_vars['length']; ?>

                            <?php endif; ?>
                            <?php if ($this->_tpl_vars['weight'] != 0): ?>
                            <br/><?php echo $this->_tpl_vars['translate_weight']; ?>
: <span><?php echo $this->_tpl_vars['weight']; ?>
</span>
                            <?php endif; ?>
                        <?php endif; ?>
                        <br />
                        <br />

                        <?php if ($this->_tpl_vars['videoArray']): ?>
                            <h3><?php echo $this->_tpl_vars['translate_video']; ?>
 <?php if ($this->_tpl_vars['seoh1']): ?> <?php echo $this->_tpl_vars['seoh1']; ?>
 <?php else: ?> <?php echo $this->_tpl_vars['name']; ?>
 <?php endif; ?></h3>
                            <div class="cl-video">
                                <?php $_from = $this->_tpl_vars['videoArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['v']):
?>
                                    <?php echo $this->_tpl_vars['v']; ?>
 <br />
                                <?php endforeach; endif; unset($_from); ?>
                            </div>
                        <?php endif; ?>
                        <br />
                        <br />

                        <?php if ($this->_tpl_vars['characteristicsArray'] || $this->_tpl_vars['characteristics']): ?>
                            <h3><?php echo $this->_tpl_vars['translate_features']; ?>
 <?php if ($this->_tpl_vars['seoh1']): ?> <?php echo $this->_tpl_vars['seoh1']; ?>
 <?php else: ?> <?php echo $this->_tpl_vars['name']; ?>
 <?php endif; ?></h3>
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
">
                                                                <?php echo $this->_tpl_vars['i']['characteristicValue']; ?>

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
                    </div>

                    <div class="tabs-content js-tab-2" >
                        <div class="questions">
                            <?php if ($this->_tpl_vars['commentIntegration']): ?>
                                <h2 class="js-comments-block"><?php echo $this->_tpl_vars['translate_many_comments']; ?>
 <?php if ($this->_tpl_vars['seoh1']): ?> <?php echo $this->_tpl_vars['seoh1']; ?>
 <?php else: ?> <?php echo $this->_tpl_vars['name']; ?>
 <?php endif; ?></h2>
                                <div class="os-integrated-comment">
                                    <?php echo $this->_tpl_vars['commentIntegration']; ?>

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
                                                <div class="cl-block-rating" itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating">
                                                    <div class="inner" style="width: <?php echo $this->_tpl_vars['e']['rating']*20; ?>
%;">
                                                        <meta itemprop="worstRating" content = "0"/>
                                                        <em itemprop="ratingValue"><?php echo $this->_tpl_vars['e']['rating']; ?>
</em>
                                                        <em itemprop="bestRating">5</em>
                                                    </div>
                                                </div>
                                            <?php endif; ?>

                                            <span itemprop="reviewBody">
                                                <a style="text-decoration: none;" href="<?php echo $this->_tpl_vars['e']['url']; ?>
" target="_blank" >
                                                    <?php echo $this->_tpl_vars['e']['content']; ?>

                                                </a>
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

                                <a href="javascript: void(0);" class="cl-button green" onclick="popupOpen('.js-popup-comment-block');"><?php echo $this->_tpl_vars['translate_reviews_of_the_store_add_simple']; ?>
</a>

                                <?php if ($this->_tpl_vars['allowcomment']): ?>
                                    <div class="cl-block-popup js-popup-comment-block" style="display: none;">
                                        <div class="dark" onclick="popupClose('.js-popup-comment-block');"></div>
                                        <div class="block-popup">
                                            <div class="head">
                                                <a href="javascript: void(0);" class="close" onclick="popupClose('.js-popup-comment-block');">&nbsp;</a>
                                                <?php echo $this->_tpl_vars['translate_write_a_review']; ?>

                                            </div>
                                            <form method="post" enctype="multipart/form-data">
                                                <div class="body">
                                                    <div class="block-form">
                                                        <div class="form-element">
                                                            <div class="descript"><?php echo $this->_tpl_vars['translate_review_big']; ?>
<span class="important">*</span>:</div>
                                                            <textarea class="js-required" name="postcomment"></textarea>
                                                        </div>
                                                        <div class="form-element">
                                                            <div class="descript"><?php echo $this->_tpl_vars['translate_plus']; ?>
:</div>
                                                            <textarea name="postplus"></textarea>
                                                        </div>
                                                        <div class="form-element">
                                                            <div class="descript"><?php echo $this->_tpl_vars['translate_minus']; ?>
:</div>
                                                            <textarea name="postminus"></textarea>
                                                        </div>
                                                        <div class="form-element">
                                                            <div class="descript"><?php echo $this->_tpl_vars['translate_rating']; ?>
</div>
                                                            <div class="cl-block-rating">
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
                                                        </div>
                                                        <div class="form-element">
                                                            <div class="descript"><?php echo $this->_tpl_vars['translate_upload_image']; ?>
</div>
                                                            <input type="file" name="upload_image" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="foot ta-center">
                                                    <input type="hidden" name="ajs" class="ajs" value="1" />
                                                    <input class="js-form-validation cl-button green" type="submit" value="<?php echo $this->_tpl_vars['translate_send']; ?>
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
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <div class="right-layer">
            <div class="cl-select-product">
                <?php if ($this->_tpl_vars['optionArray']): ?>
                <div class="os-options-list">
                    <?php $_from = $this->_tpl_vars['optionArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
                        <div class="inner-element">
                            <select name="option-<?php echo $this->_tpl_vars['e']['id']; ?>
" class="js-shop-buy-option chzn-select" data-optionid="<?php echo $this->_tpl_vars['e']['id']; ?>
">
                                <option class="" value=""><?php echo $this->_tpl_vars['translate_select_the']; ?>
 <?php echo $this->_tpl_vars['e']['name']; ?>
</option>
                                <?php $_from = $this->_tpl_vars['e']['valueArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['v']):
?>
                                    <option id="<?php echo $this->_tpl_vars['v'][1]; ?>
" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['v'][0])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"><?php echo $this->_tpl_vars['v'][0]; ?>
</option>
                                                                <?php endforeach; endif; unset($_from); ?>
                            </select>
                            <?php $_from = $this->_tpl_vars['e']['valueArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['v']):
?>
                                <input type="hidden" class="js-hash-input" id="option<?php echo $this->_tpl_vars['e']['id']; ?>
hidden<?php echo $this->_tpl_vars['v'][2]; ?>
" value="<?php echo $this->_tpl_vars['v'][1]; ?>
"/>
                            <?php endforeach; endif; unset($_from); ?>
                        </div>
                    <?php endforeach; endif; unset($_from); ?>

                    <script>

                        $j(function() {

                            var hash = [];
                            $j('.js-hash-input').each(function(id, el){

                                if ($j(el).attr('id').indexOf('custom-quantity') == 6) {

                                    hash.push($j(el).attr('id'));
                                }

                            });
                            var param1 = $j('select').attr('data-optionid');
                            var base_price = parseFloat($j('#optioncustom-quantityhiddenc81e728d9d4c2f636f067f89cc14862c').val());
                            var select_1 = {};
                            var select_2 = {};
                            select_1.id = param1;

                            $j('select').change(function() {

                                var current_id = $j(this).attr('data-optionid');

                                if (current_id != 'custom-quantity') {


                                    var val = $j("select[name=option-"+current_id+"] option:selected").attr('id');

                                    if (select_1.id != current_id) {
                                        select_2.id = current_id;
                                        select_2.value = val;
                                    } else {
                                        select_1.value = val;
                                    }

                                    var val1 = parseFloat(select_1.value);
                                    var val2 = parseFloat(select_2.value);
                                    if(isNaN(val1)) val1 = 0;
                                    if(isNaN(val2)) val2 = 0;
                                    var sum = val1 + val2;
                                    var result = base_price + sum;
                                    for (var i = 0; i<hash.length; i++) {
                                        if (i == 0) {
                                          continue;
                                        }

                                        $j('#'+hash[i]).val(result*i);
                                    }

                                }

                            });

                        });
                    </script>

                </div>
                <?php endif; ?>

                <?php if ($this->_tpl_vars['canbuy'] || $this->_tpl_vars['canMakePreorder']): ?>
                    <div class="block-button">

                        <a class="cl-button  fl-l js-quick-order" href="javascript: void(0);" onclick="basket_order_quick('<?php echo $this->_tpl_vars['productID']; ?>
', '<?php echo $this->_tpl_vars['nameQuick']; ?>
');">Buy it Now</a>
                        <script>

                            function basket_order_quick (productId, productName) {
                                $j('input[name="productid"]').val(productId);
                                $j('#quickOrderProductName').text(productName);

                                popupOpen('.js-popup-quickorder');
                            }

                            $j('.js-quick-order').click(function (event) {
                                // опции заказа
                                var productOptions = '';
                                $j('.js-shop-buy-option').each(function (i, e) {
                                    var optionID = $j(e).data('optionid');
                                    var optionValue = $j(e).val();

                                    productOptions += optionID + ':' + optionValue + ';';


                                });

                                console.log(productOptions);
                                $j('#option').text(productOptions);
                            });



                        </script>


                                                <div class="js-shop-buy fl-r" data-productid="<?php echo $this->_tpl_vars['id']; ?>
">
                            <a href="#" class="js-shop-buy-action cl-button basket">Add to basket</a>
                        </div>
                        <div class="clear"></div>
                    </div>
                <?php endif; ?>


            </div>

           <?php if ($this->_tpl_vars['advertise']): ?>
            <div class="cl-aside-block-text">
                <div class="title">Advertise</div>
                 <?php echo $this->_tpl_vars['advertise']; ?>

            </div>
            <?php endif; ?>

            <?php if ($this->_tpl_vars['faq']): ?>
            <div class="cl-block-answers">
                <div class="head">answered questions</div>
                <div class="body">
                <?php $_from = $this->_tpl_vars['faq']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i']):
?>
                    <div class="item"><a style="text-decoration: none;" href="<?php echo $this->_tpl_vars['i']['url']; ?>
"><?php echo $this->_tpl_vars['i']['name']; ?>
</a></div>
                <?php endforeach; endif; unset($_from); ?>
                </div>
            </div>
            <?php endif; ?>

        </div>
        <div class="clear"></div>
    </form>

</div>


<?php $_from = $this->_tpl_vars['listsArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
    <div class="os-block-caption"><h3><?php echo $this->_tpl_vars['e']['name']; ?>
</h3></div>
    <?php echo $this->_tpl_vars['e']['html']; ?>

<?php endforeach; endif; unset($_from); ?>


<?php echo $this->_tpl_vars['seocontent']; ?>


<?php echo $this->_tpl_vars['noticeOfAvailability']; ?>
