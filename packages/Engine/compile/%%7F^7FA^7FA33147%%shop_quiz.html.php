<?php /* Smarty version 2.6.27-optimized, created on 2015-11-06 00:01:10
         compiled from /var/www/shop.local/modules/quiz/contents/shop_quiz.html */ ?>
<?php if ($this->_tpl_vars['question'] && ( $this->_tpl_vars['answerArray'] || $this->_tpl_vars['resultsArray'] )): ?>
    <div class="os-caption-block"><?php echo $this->_tpl_vars['translate_quiz']; ?>
</div>
    <div id="quiz" class="shop-block-quiz">
        <div class="quiz-block-question"><?php echo $this->_tpl_vars['question']; ?>
</div>
        <input type="hidden" id="quiz-id" value="<?php echo $this->_tpl_vars['quizid']; ?>
" />
        <input type="hidden" id="quiz-type" value="<?php echo $this->_tpl_vars['type']; ?>
" />

        <div id="quiz-content" class="quiz-block-content">
            <div id="quiz-answers" class="block-answer" <?php if ($this->_tpl_vars['answered']): ?> style="display: none;" <?php endif; ?>>
                <?php $_from = $this->_tpl_vars['answerArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['index'] => $this->_tpl_vars['e']):
?>
                    <label id="quiz-answers-inputs" class="item">
                        <?php if ($this->_tpl_vars['type'] == 'check'): ?>
                            <input class="checker" name="answer[]" type="checkbox" value="<?php echo $this->_tpl_vars['e']['id']; ?>
" />
                        <?php else: ?>
                            <input class="checker" name="answer" type="radio" value="<?php echo $this->_tpl_vars['e']['id']; ?>
" />
                        <?php endif; ?>
                        <span class="answer-text">
                            <?php echo $this->_tpl_vars['e']['answer']; ?>

                        </span>
                        <span class="clear"></span>
                    </label>
                <?php endforeach; endif; unset($_from); ?>
                <div class="button">
                    <input class="os-submit" type="button" id="quiz-submit" value="<?php echo $this->_tpl_vars['translate_vote']; ?>
" onclick="sendQuizAnswer(); return false;" />
                </div>
            </div>

            <?php if ($this->_tpl_vars['resultsArray']): ?>
                <div id="quiz-results">
                    <?php $_from = $this->_tpl_vars['resultsArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['index'] => $this->_tpl_vars['e']):
?>
                        <div class="item-result">
                            <div class="result">
                                <span><?php echo $this->_tpl_vars['e']['percent']; ?>
% &mdash; <?php echo $this->_tpl_vars['e']['amount']; ?>
 <?php echo $this->_tpl_vars['translate_voices']; ?>
</span>
                                <div class="feel" style="width: <?php echo $this->_tpl_vars['e']['percent']; ?>
%;">&nbsp;</div>
                            </div>
                            <span class="result-answer-text"><?php echo $this->_tpl_vars['e']['answer']; ?>
</span>
                        </div>
                    <?php endforeach; endif; unset($_from); ?>
                    <div class="button">
                        <a href="#" id="quiz-reanswer" onclick="reAnswer(); return false;"><?php echo $this->_tpl_vars['translate_discussed']; ?>
</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>