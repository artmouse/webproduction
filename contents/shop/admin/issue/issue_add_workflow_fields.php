<?php
class issue_add_workflow_fields extends Engine_Class {

    public function process() {
        try {
            $workflow = Shop::Get()->getShopService()->getOrderCategoryByID(
                $this->getArgument('workflowid')
            );

            // custom fields
            try {
                $customFieldArray = Engine::Get()->getConfigField('project-box-customfield-order');

                foreach ($customFieldArray as $index => $x) {
                    if (!empty($x['workflowid'])) {
                        if ($x['workflowid'] != $workflow->getId()) {
                            unset($customFieldArray[$index]);
                        }
                    }
                }
            } catch (Exception $e) {
                $customFieldArray = array();
            }

            // дополнительные поля
            $a = array();
            foreach ($customFieldArray as $key => $x) {
                $a[$key] = array(
                'name' => $x['name'],
                'value' => htmlspecialchars($value),
                'type' => $x['type'],
                );
            }
            $this->setValue('customFieldArray', $a);
        } catch (Exception $ge) {

        }
    }


}