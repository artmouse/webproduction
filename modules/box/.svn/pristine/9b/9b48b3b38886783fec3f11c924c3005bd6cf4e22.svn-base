<?php
/**
 * По ключевым словам выбрать более подходящие workflow для задач,
 * чем default workflow для задач.
 *
 * @copyright (C) 2011-2015 WebProduction (tm) <webproduction.ua>
 *
 * This program is commercial software;
 * you cannot redistribute it and/or modify it.
 */

require(dirname(__FILE__).'/../../../packages/Engine/include.2.6.php');
Engine::Get()->enableErrorReporting();

$default = IssueService::Get()->getIssueWorkflowDefault();

$issues = IssueService::Get()->getIssuesAll();
$issues->setCategoryid($default->getId());
$issues->setDateclosed('0000-00-00 00:00:00');
while ($x = $issues->getNext()) {
    print $x->getId()."\n";
    print $x->getName()."\n";

    try {
        $workflow = IssueService::Get()->getIssueWorkflowDefault($x->getName());
        if ($workflow->getId() != $x->getCategoryid()) {
            print 'New workflow = '.$workflow->getName()."\n";

            Shop::Get()->getShopService()->updateOrderCategory(
                $x,
                false, // user
                $workflow
            );
        }
    } catch (Exception $ex) {
        print_r($ex);
    }

    print "\n";
}

print "\n\ndone.\n\n";