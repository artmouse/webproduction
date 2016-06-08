<?php
class gantt_update extends Engine_Class {

    public function process() {
        try {
            $issue = IssueService::Get()->getIssueByID(
            $this->getArgument('id')
            );

            // текущие даты задач
            $issueStart = DateTime_Formatter::DateISO9075($issue->getCdate());
            $issueEnd = DateTime_Formatter::DateISO9075($issue->getDateto());
            $issueClosed = DateTime_Formatter::DateISO9075($issue->getDateclosed());

            // если нет даты завершения - считать это 1 день
            // (для старых задач)
            if (!Checker::CheckDate($issueEnd)) {
                // если есть реальная дата закрытия
                // - то считаем что задача перлась аж сюда
                if (Checker::CheckDate($issueClosed)) {
                    $issueEnd = $issueClosed;
                } else {
                    $issueEnd = $issueStart;
                }
            }

            // корректировка на gantt
            $dateFrom = $this->getArgument('datefrom', 'date');
            $dateTo = $this->getArgument('dateto', 'date');
            if ($issueStart < $dateFrom) {
                $issueStart = $dateFrom;
            }

            if ($issueEnd > $dateTo) {
                $issueEnd = $dateTo;
            }

            // изменение ширины - это изменение даты окончания задачи
            try {
                $width = $this->getArgument('width', 'int');
                $width /= 20;
                $width --;
                $width = round($width);

                $issueEnd = DateTime_Object::FromString($issueStart)->addDay($width)->__toString();
                $issue->setDateto($issueEnd);

                $issue->update();
            } catch (Exception $e) {

            }

            // изменение позиции - это изменение даты старта задачи
            try {
                // x - это смещение относительно старта текущего месяца
                $x = $this->getArgument('x', 'int');
                $x /= 20;

                // вычисляем ширину задачи в днях
                $width = DateTime_Differ::DiffDay($issue->getDateto(), $issue->getCdate());
                if ($width <= 0) {
                    $width = 0;
                }

                $issueStart = DateTime_Object::FromString($dateFrom)->addDay(+$x)->__toString();
                $issueEnd = DateTime_Object::FromString($dateFrom)->addDay(+$x+$width)->__toString();

                $issue->setCdate($issueStart);
                $issue->setDateto($issueEnd);
                $issue->update();
            } catch (Exception $e) {

            }
        } catch (Exception $ge) {

        }
    }

}