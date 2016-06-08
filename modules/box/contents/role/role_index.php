<?php
class role_index extends Engine_Class {

    public function process() {
        $table = new Shop_ContentTable(new Datasource_Role());

        /*$field = new Forms_ContentFieldControlLink('url', 'shop-admin-role-control', 'key');
        $table->addField($field);
        $table->getField('url')->setName('URL');*/

        for ($j = 1; $j <= 10; $j++) {
            $table->removeField('kpi'.$j.'param');
            $table->removeField('description');
            $table->removeField('salary'.$j.'workflowid');
            if ($j > 3) {
                $table->removeField('kpi'.$j.'id');
                $table->removeField('kpi'.$j.'value');
                $table->removeField('salary'.$j.'koef');
            }
        }
        $this->setValue('table', $table->render());
    }

}