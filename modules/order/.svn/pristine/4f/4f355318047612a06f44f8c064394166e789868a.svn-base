<?php
class report_priceinsupplier_model_ajax extends Engine_Class {

    public function process() {
        $query  = $this->getArgument('query');
        $brand  = $this->getArgument('brand');

        $model = Shop::Get()->getShopService()->getProductsAll();
        $model->setDeleted(0);
        $model->setHidden(0);

        if ($query) {
            $model->addWhere('model', '%'.str_replace(' ', '%', $query).'%', 'LIKE');
        } else {
            $model->filterModel('', '!=');
        }

        if ($brand) {
            $model->setBrandid($brand);
        }

        $model->setGroupByQuery('model');

        $dataArray = array();
        while ($m = $model->getNext()) {
            $dataArray[] = array(
                'text' => $m->getModel(),
                'id' => $m->getModel()
            );
        }

        echo json_encode(array("Results" => $dataArray));
        exit;

    }

}