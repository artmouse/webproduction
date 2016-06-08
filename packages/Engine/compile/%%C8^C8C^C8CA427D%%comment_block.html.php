<?php /* Smarty version 2.6.27-optimized, created on 2015-12-11 18:00:38
         compiled from /var/www/shop.local/contents/shop/admin/comment/comment_block.html */ ?>
<?php if ($this->_tpl_vars['commentArray']): ?>
    <div class="ob-block-comments">
        <div class="nb-block-tabs js-slide-tabs js-comments-type">
            <div class="tab-element"><a class="selected" href="#"><?php echo $this->_tpl_vars['translate_all']; ?>
</a></div>
            <div class="tab-element"><a href="#"><?php echo $this->_tpl_vars['acl_comments']; ?>
</a></div>
            <div class="tab-element"><a href="#" data-type="notify"><?php echo $this->_tpl_vars['translate_uvedomleniya']; ?>
</a></div>
            <div class="tab-element"><a href="#" data-type="email"><?php echo $this->_tpl_vars['translate_pisma']; ?>
</a></div>
            <div class="tab-element"><a href="#" data-type="sms">SMS</a></div>
            <div class="tab-element"><a href="#" data-type="call"><?php echo $this->_tpl_vars['translate_zvonki']; ?>
</a></div>
            <div class="tab-element"><a href="#" data-type="change"><?php echo $this->_tpl_vars['translate_changes']; ?>
</a></div>
            <span class="hover"></span>
            <div class="clear"></div>
        </div>

        <?php $_from = $this->_tpl_vars['commentArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
            <?php if ($this->_tpl_vars['e']['type'] == 'comment'): ?>
                                <div class="comment-item <?php if ($this->_tpl_vars['e']['my']): ?>my-comment<?php endif; ?> js-item-comment">
                    <div class="avatar nb-block-avatar" style="background-image: url('<?php echo $this->_tpl_vars['e']['avatar']; ?>
');"></div>
                    <div class="identifier" style="background-color: <?php echo $this->_tpl_vars['e']['color']; ?>
;"></div>
                                        <div class="chead">
                        <?php if ($this->_tpl_vars['e']['content'] != $this->_tpl_vars['translate_soobshchenie_udaleno']): ?>
                            <?php if ($this->_tpl_vars['e']['edit']): ?>
                                <a class="ob-link-delete ob-icon js-edit-message" href="#" data-id="<?php echo $this->_tpl_vars['e']['id']; ?>
" data-action="delete"></a>
                                <a class="ob-link-edit ob-icon js-edit-message" href="#" data-id="<?php echo $this->_tpl_vars['e']['id']; ?>
" data-action="edit"></a>
                            <?php endif; ?>
                            <a class="ob-link-quote ob-icon js-quote-message" href="#" data-id="<?php echo $this->_tpl_vars['e']['id']; ?>
" title="<?php echo $this->_tpl_vars['translate_tsitirovat']; ?>
"></a>
                            <span style="display: none;" class="js-comment-content-original" data-id="<?php echo $this->_tpl_vars['e']['id']; ?>
"><?php echo $this->_tpl_vars['e']['contentOriginal']; ?>
</span>
                        <?php endif; ?>

                        <?php if ($this->_tpl_vars['e']['userURL']): ?>
                            <a href="<?php echo $this->_tpl_vars['e']['userURL']; ?>
" class="name js-contact-preview js-comment-author-<?php echo $this->_tpl_vars['e']['id']; ?>
" data-id="<?php echo $this->_tpl_vars['e']['userID']; ?>
"><?php echo $this->_tpl_vars['e']['userName']; ?>
</a>
                        <?php else: ?>
                            <?php echo $this->_tpl_vars['e']['userName']; ?>

                        <?php endif; ?>

                        <?php if ($this->_tpl_vars['e']['companyName']): ?>
                            <span class="tag"><?php echo $this->_tpl_vars['e']['companyName']; ?>
</span>
                        <?php endif; ?>

                        <span class="date"><?php echo $this->_tpl_vars['e']['datetime']; ?>
</span>
                    </div>
                    <div class="cbody" id="js-text-<?php echo $this->_tpl_vars['e']['id']; ?>
">
                        <?php echo $this->_tpl_vars['e']['content']; ?>

                    </div>
                </div>
            <?php elseif ($this->_tpl_vars['e']['type'] == 'commentresult'): ?>
                                <div class="comment-item <?php if ($this->_tpl_vars['e']['my']): ?>my-comment<?php endif; ?> marked js-item-comment">
                    <div class="avatar nb-block-avatar" style="background-image: url('<?php echo $this->_tpl_vars['e']['avatar']; ?>
');"></div>
                    <div class="identifier" style="background-color: <?php echo $this->_tpl_vars['e']['color']; ?>
;"></div>
                    <div class="chead">
                        <?php if ($this->_tpl_vars['e']['content'] != $this->_tpl_vars['translate_soobshchenie_udaleno']): ?>
                            <?php if ($this->_tpl_vars['e']['edit']): ?>
                                <a class="ob-link-delete ob-icon js-edit-message" href="#" data-id="<?php echo $this->_tpl_vars['e']['id']; ?>
" data-action="delete"></a>
                                <a class="ob-link-edit ob-icon js-edit-message" href="#" data-id="<?php echo $this->_tpl_vars['e']['id']; ?>
" data-action="edit"></a>
                            <?php endif; ?>
                            <a class="ob-link-quote ob-icon js-quote-message" href="#" data-id="<?php echo $this->_tpl_vars['e']['id']; ?>
" title="<?php echo $this->_tpl_vars['translate_tsitirovat']; ?>
"></a>
                            <span style="display: none;" class="js-comment-content-original" data-id="<?php echo $this->_tpl_vars['e']['id']; ?>
"><?php echo $this->_tpl_vars['e']['contentOriginal']; ?>
</span>
                        <?php endif; ?>

                        <?php if ($this->_tpl_vars['e']['userURL']): ?>
                            <a href="<?php echo $this->_tpl_vars['e']['userURL']; ?>
" class="name js-contact-preview js-comment-author-<?php echo $this->_tpl_vars['e']['id']; ?>
" data-id="<?php echo $this->_tpl_vars['e']['userID']; ?>
"><?php echo $this->_tpl_vars['e']['userName']; ?>
</a>
                        <?php else: ?>
                            <?php echo $this->_tpl_vars['e']['userName']; ?>

                        <?php endif; ?>

                        <?php if ($this->_tpl_vars['e']['companyName']): ?>
                            <span class="tag"><?php echo $this->_tpl_vars['e']['companyName']; ?>
</span>
                        <?php endif; ?>

                        <span class="date"><?php echo $this->_tpl_vars['e']['datetime']; ?>
</span>
                    </div>
                    <div class="cbody" id="js-text-<?php echo $this->_tpl_vars['e']['id']; ?>
">
                        <?php echo $this->_tpl_vars['e']['content']; ?>

                    </div>
                </div>
            <?php elseif ($this->_tpl_vars['e']['type'] == 'notify'): ?>
                                <div class="comment-item other js-item-notify">
                    <span class="icon-type ob-icon-warning"></span>
                    <div class="chead">
                        <?php if ($this->_tpl_vars['e']['userURL']): ?>
                            <a href="<?php echo $this->_tpl_vars['e']['userURL']; ?>
" class="name js-contact-preview js-comment-author-<?php echo $this->_tpl_vars['e']['id']; ?>
" data-id="<?php echo $this->_tpl_vars['e']['userID']; ?>
"><?php echo $this->_tpl_vars['e']['userName']; ?>
</a>
                        <?php else: ?>
                            <?php echo $this->_tpl_vars['e']['userName']; ?>

                        <?php endif; ?>

                        <span class="date"><?php echo $this->_tpl_vars['e']['datetime']; ?>
</span>
                    </div>
                    <?php echo $this->_tpl_vars['e']['content']; ?>

                    <div class="clear"></div>
                </div>
            <?php elseif ($this->_tpl_vars['e']['type'] == 'document'): ?>
                                <div class="comment-item other js-item-document">
                    <span class="icon-type ob-icon-edit"></span>
                    <div class="chead">
                        <?php if ($this->_tpl_vars['e']['userURL']): ?>
                            <a href="<?php echo $this->_tpl_vars['e']['userURL']; ?>
" class="name js-contact-preview js-comment-author-<?php echo $this->_tpl_vars['e']['id']; ?>
" data-id="<?php echo $this->_tpl_vars['e']['userID']; ?>
"><?php echo $this->_tpl_vars['e']['userName']; ?>
</a>
                        <?php else: ?>
                            <?php echo $this->_tpl_vars['e']['userName']; ?>

                        <?php endif; ?>

                        <span class="date"><?php echo $this->_tpl_vars['e']['datetime']; ?>
</span>
                    </div>
                    <?php echo $this->_tpl_vars['e']['content']; ?>

                </div>
            <?php elseif ($this->_tpl_vars['e']['type'] == 'change'): ?>
                                <div class="comment-item other js-item-change">
                    <span class="icon-type ob-icon-edit"></span>
                    <div class="chead">
                        <?php if ($this->_tpl_vars['e']['userURL']): ?>
                            <a href="<?php echo $this->_tpl_vars['e']['userURL']; ?>
" class="name js-contact-preview js-comment-author-<?php echo $this->_tpl_vars['e']['id']; ?>
" data-id="<?php echo $this->_tpl_vars['e']['userID']; ?>
"><?php echo $this->_tpl_vars['e']['userName']; ?>
</a>
                        <?php else: ?>
                            <?php echo $this->_tpl_vars['e']['userName']; ?>

                        <?php endif; ?>

                        <span class="date"><?php echo $this->_tpl_vars['e']['datetime']; ?>
</span>
                    </div>
                    <?php echo $this->_tpl_vars['e']['content']; ?>

                    <div class="clear"></div>
                </div>
            <?php elseif ($this->_tpl_vars['e']['type'] == 'email'): ?>
                                <div class="comment-item other <?php if ($this->_tpl_vars['e']['my']): ?>my-comment<?php endif; ?> js-item-email">
                    <div class="identifier" style="background-color: <?php echo $this->_tpl_vars['e']['color']; ?>
;"></div>
                    <span class="icon-type ob-icon-email"></span>
                    <div class="chead">
                        <?php if ($this->_tpl_vars['e']['content'] != $this->_tpl_vars['translate_soobshchenie_udaleno']): ?>
                            <a class="ob-link-quote ob-icon js-quote-message" href="#" data-id="<?php echo $this->_tpl_vars['e']['id']; ?>
" title="<?php echo $this->_tpl_vars['translate_tsitirovat']; ?>
"></a>
                            <span style="display: none;" class="js-comment-content-original" data-id="<?php echo $this->_tpl_vars['e']['id']; ?>
"><?php echo $this->_tpl_vars['e']['contentOriginal']; ?>
</span>
                        <?php endif; ?>

                        <?php if ($this->_tpl_vars['e']['userURL']): ?>
                            <a href="<?php echo $this->_tpl_vars['e']['userURL']; ?>
" class="name js-contact-preview js-comment-author-<?php echo $this->_tpl_vars['e']['id']; ?>
" data-id="<?php echo $this->_tpl_vars['e']['userID']; ?>
"><?php echo $this->_tpl_vars['e']['userName']; ?>
</a>
                        <?php else: ?>
                            <?php echo $this->_tpl_vars['e']['userName']; ?>

                        <?php endif; ?>

                        <?php if ($this->_tpl_vars['e']['companyName']): ?>
                            <span class="tag"><?php echo $this->_tpl_vars['e']['companyName']; ?>
</span>
                        <?php endif; ?>

                        <span class="date"><?php echo $this->_tpl_vars['e']['datetime']; ?>
</span>
                    </div>
                    <div class="cbody" id="js-text-<?php echo $this->_tpl_vars['e']['id']; ?>
">
                        <?php echo $this->_tpl_vars['e']['content']; ?>

                    </div>
                </div>
            <?php elseif ($this->_tpl_vars['e']['type'] == 'sms'): ?>
                                <div class="comment-item other <?php if ($this->_tpl_vars['e']['my']): ?>my-comment<?php endif; ?> js-item-sms">
                    <div class="identifier" style="background-color: <?php echo $this->_tpl_vars['e']['color']; ?>
;"></div>
                    <span class="icon-type ob-icon-sms"></span>
                    <div class="chead">
                        <?php if ($this->_tpl_vars['e']['content'] != $this->_tpl_vars['translate_soobshchenie_udaleno']): ?>
                            <a class="ob-link-quote ob-icon js-quote-message" href="#" data-id="<?php echo $this->_tpl_vars['e']['id']; ?>
" title="<?php echo $this->_tpl_vars['translate_tsitirovat']; ?>
"></a>
                            <span style="display: none;" class="js-comment-content-original" data-id="<?php echo $this->_tpl_vars['e']['id']; ?>
"><?php echo $this->_tpl_vars['e']['contentOriginal']; ?>
</span>
                        <?php endif; ?>

                        <?php if ($this->_tpl_vars['e']['userURL']): ?>
                            <a href="<?php echo $this->_tpl_vars['e']['userURL']; ?>
" class="name js-contact-preview js-comment-author-<?php echo $this->_tpl_vars['e']['id']; ?>
" data-id="<?php echo $this->_tpl_vars['e']['userID']; ?>
"><?php echo $this->_tpl_vars['e']['userName']; ?>
</a>
                        <?php else: ?>
                            <?php echo $this->_tpl_vars['e']['userName']; ?>

                        <?php endif; ?>

                        <?php if ($this->_tpl_vars['e']['companyName']): ?>
                            <span class="tag"><?php echo $this->_tpl_vars['e']['companyName']; ?>
</span>
                        <?php endif; ?>

                        <span class="date"><?php echo $this->_tpl_vars['e']['datetime']; ?>
</span>
                    </div>
                    <div class="cbody" id="js-text-<?php echo $this->_tpl_vars['e']['id']; ?>
">
                        <?php echo $this->_tpl_vars['e']['content']; ?>

                    </div>
                </div>
            <?php elseif ($this->_tpl_vars['e']['type'] == 'call'): ?>
                                <div class="comment-item other <?php if ($this->_tpl_vars['e']['my']): ?>my-comment<?php endif; ?> js-item-call">
                    <div class="identifier" style="background-color: <?php echo $this->_tpl_vars['e']['color']; ?>
;"></div>
                    <span class="icon-type ob-icon-sms"></span>
                    <div class="chead">
                        <?php if ($this->_tpl_vars['e']['content'] != $this->_tpl_vars['translate_soobshchenie_udaleno']): ?>
                            <a class="ob-link-quote ob-icon js-quote-message" href="#" data-id="<?php echo $this->_tpl_vars['e']['id']; ?>
" title="<?php echo $this->_tpl_vars['translate_tsitirovat']; ?>
"></a>
                            <span style="display: none;" class="js-comment-content-original" data-id="<?php echo $this->_tpl_vars['e']['id']; ?>
"><?php echo $this->_tpl_vars['e']['contentOriginal']; ?>
</span>
                        <?php endif; ?>

                        <?php if ($this->_tpl_vars['e']['userURL']): ?>
                            <a href="<?php echo $this->_tpl_vars['e']['userURL']; ?>
" class="name js-contact-preview js-comment-author-<?php echo $this->_tpl_vars['e']['id']; ?>
" data-id="<?php echo $this->_tpl_vars['e']['userID']; ?>
"><?php echo $this->_tpl_vars['e']['userName']; ?>
</a>
                        <?php else: ?>
                            <?php echo $this->_tpl_vars['e']['userName']; ?>

                        <?php endif; ?>

                        <?php if ($this->_tpl_vars['e']['companyName']): ?>
                            <span class="tag"><?php echo $this->_tpl_vars['e']['companyName']; ?>
</span>
                        <?php endif; ?>

                        <span class="date"><?php echo $this->_tpl_vars['e']['datetime']; ?>
</span>
                    </div>
                    <div class="cbody" id="js-text-<?php echo $this->_tpl_vars['e']['id']; ?>
">
                        <?php echo $this->_tpl_vars['e']['content']; ?>

                    </div>
                </div>
            <?php else: ?>
                <div class="comment-item other js-item-notify">
                    <span class="icon-type ob-icon-warning"></span>
                    <span class="important"><?php echo $this->_tpl_vars['translate_neizvestniy_format_zapisi']; ?>
 <?php echo $this->_tpl_vars['e']['type']; ?>
 #<?php echo $this->_tpl_vars['e']['id']; ?>
.</span><br />
                    <?php echo $this->_tpl_vars['e']['content']; ?>

                </div>
            <?php endif; ?>
        <?php endforeach; endif; unset($_from); ?>

        <?php if (count ( $this->_tpl_vars['pagesArray'] ) > 1): ?>
            <div class="ob-block-stepper">
                <?php if ($this->_tpl_vars['urlprev']): ?>
                    <a href="<?php echo $this->_tpl_vars['urlprev']; ?>
" class="prev">&lsaquo; <?php echo $this->_tpl_vars['translate_back']; ?>
</a>
                    <?php if ($this->_tpl_vars['hellip']): ?>&hellip;<?php endif; ?>
                <?php endif; ?>

                <?php $_from = $this->_tpl_vars['pagesArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
                    <a href="<?php echo $this->_tpl_vars['e']['url']; ?>
" <?php if ($this->_tpl_vars['e']['selected']): ?>class="selected"<?php endif; ?>><?php echo $this->_tpl_vars['e']['name']; ?>
</a>
                <?php endforeach; endif; unset($_from); ?>

                <?php if ($this->_tpl_vars['urlnext']): ?>
                    <?php if ($this->_tpl_vars['hellip']): ?>&hellip;<?php endif; ?>
                    <a href="<?php echo $this->_tpl_vars['urlnext']; ?>
" class="next"><?php echo $this->_tpl_vars['translate_next']; ?>
 &rsaquo;</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
<?php endif; ?>