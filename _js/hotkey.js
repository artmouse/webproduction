// управление таблицами с клавиатуры
function HotKeyTable(tableSelector, rowSelector, selectedClass, scrollFunction) {
    this.tableSelector = tableSelector;
    this.rowSelector = rowSelector;
    this.selectedClass = selectedClass;
    this.scrollFunction = scrollFunction;

    this.$table = $j(tableSelector).first();
    if (!this.$table.length) {
        return false;
    }

    var keyEnter = 13;
    var keySpace = 32;
    var keyLeft = 37;
    var keyUp = 38;
    var keyRight = 39;
    var keyDown = 40;

    var _this = this;

    $j(window).keydown(function(event) {
        var $target = $j(event.target);

        if ($target.is('input') || $target.is('textarea')) {
            return;
        }

        if (event.which == keyDown) {
            // стрелка вниз - выделить следующий элемент
            event.preventDefault();
            _this.selectRow(_this.getNextRow());

        } else if (event.which == keyUp) {
            // стрелка вверх - выделить предыдущий элемент
            event.preventDefault();
            _this.selectRow(_this.getPreviousRow());

        } else if (event.which == keyEnter) {
            // enter - клик по первой ссылке
            event.preventDefault();
            _this.goToCurrentRowTarget();

        } else if (event.which == keySpace) {
            // пробел - ставит или снимает checkbox
            event.preventDefault();
            _this.checkCurrentRow();

        }
    });
}

HotKeyTable.prototype.getCurrentRow = function() {
    return this.$table.find(this.rowSelector + '.js-hotkey-row-last');
}

HotKeyTable.prototype.getNextRow = function() {
    var $rowSelected = this.getCurrentRow();

    if ($rowSelected.length) {
        var $nextRow = $rowSelected.next(this.rowSelector);
    } else {
        var $nextRow = this.$table.find(this.rowSelector).first();
    }

    return $nextRow;
}

HotKeyTable.prototype.getPreviousRow = function() {
    var $rowSelected = this.getCurrentRow();

    if ($rowSelected.length) {
        var $previousRow = $rowSelected.prev(this.rowSelector);
    } else {
        var $previousRow = this.$table.find(this.rowSelector).first();
    }

    return $previousRow;
}

HotKeyTable.prototype.selectRow = function($row) {
    if (!$row.length) {
        return false;
    }

    this.$table.find(this.rowSelector/* + ':not(.js-hotkey-row-checked)'*/).removeClass(this.selectedClass);
    this.$table.find(this.rowSelector).removeClass('js-hotkey-row-last');

    $row.addClass(this.selectedClass);
    $row.addClass('js-hotkey-row-last');

    this.scrollFunction(this.$table, $row);

    return $row;
}

HotKeyTable.prototype.goToCurrentRowTarget = function() {
    var $row = this.getCurrentRow();
    if (!$row.length) {
        return false;
    }

    var $link = false;
    if (this.targetSelector) {
        $link = $row.find(targetSelector).first();
    }
    if (!$link) {
        $link = $row.find('a[href!="#"]').first();
    }

    if ($link.length) {
        var href = $link.attr('href');
        document.location = href;
    }
}

HotKeyTable.prototype.checkCurrentRow = function() {
    var $row = this.getCurrentRow();
    if (!$row.length) {
        return false;
    }

    var $checkbox = $row.find('input[type="checkbox"]').first();

    if ($checkbox.length) {
        if (!$checkbox.prop('checked')) {
            $checkbox.prop('checked', true);
            $row.addClass('row-checked');
            $row.addClass('js-hotkey-row-checked');
            $row.addClass(this.selectedClass);

        } else {
            $checkbox.prop('checked', false);
            $row.removeClass('js-hotkey-row-checked');
            $row.removeClass('row-checked');
            //$row.removeClass(this.selectedClass);
        }
    }
}

HotKeyTable.prototype._isRowScrolled = function($row) {
    var $window = $j(window);

    var docViewTop = $window.scrollTop();
    var docViewBottom = docViewTop + $window.height();

    var elemTop = $row.offset().top;
    var elemBottom = elemTop + $row.height();

    return ((elemBottom <= docViewBottom) && (elemTop >= docViewTop));
}

$j(function() {

    var table = new HotKeyTable('.shop-table', 'tbody tr', 'row-selected', function($table, $row) {
        if ($row[0].getBoundingClientRect().top < 0) {
            $j('html, body').animate({
                scrollTop: $row.offset().top - 40
            }, 0);
        }

        if ($j($row).offset().top - $j(window).scrollTop() > $j(window).height() - 70) {
            $j('html, body').animate({
                scrollTop: $row.offset().top + $row.height() - $j(window).height()+50
            }, 0);
        }

    });
});