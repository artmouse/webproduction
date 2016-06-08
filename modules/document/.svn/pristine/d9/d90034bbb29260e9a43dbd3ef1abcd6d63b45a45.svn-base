<?php
class document_order_status_action_block_document_writing extends Engine_Class {

    public function process() {
        $this->setValue('contentID', $this->getContentID());
        $this->setValue('index', $this->getValue('index'));

        $data = $this->getValue('data');
        if ($data) {
            $data = json_decode($data);

            $this->setValue('documentname', $data->documentName);
            $this->setValue('templateid', $data->templateid);
            $this->setValue('contractorid', $data->contractorid);
            $this->setValue('letter', $data->letter);
            $this->setValue('letter_text', $data->letterText);
            $this->setValue('paymentId', $data->paymentId);
            $this->setValue('managerId', (int) $data->managerId);
            /*$this->setValue('sent', $data->sent);
            $this->setValue('sdate', $data->sdate);
            $this->setValue('recieved', $data->recieved);
            $this->setValue('bdate', $data->bdate);
            $this->setValue('archive', $data->archive);
            $this->setValue('adate', $data->adate);*/
        }


        // список шаблонов
        $templates = DocumentService::Get()->getDocumentTemplatesByClassname('ShopOrder');
        $templateArray = array();
        while ($x = $templates->getNext()) {
            if ($this->getUser()->isAllowed('document-print-'.$x->getId())) {
                $templateArray[] = array(
                    'id' => $x->getId(),
                    'name' => htmlspecialchars($x->getName()),
                );
            }
        }
        $this->setValue('templateArray', $templateArray);

        // юр лица
        $contractors = Shop::Get()->getShopService()->getContractorsActive();
        $this->setValue('contractorArray', $contractors->toArray());

        $paymentArray  = array();

        $payment = Shop::Get()->getShopService()->getPaymentAll();
        $payment->setHidden(0);
        while ($x = $payment->getNext()) {
            $paymentArray[] = array(
                'id' => $x->getId(),
                'name' => $x->getName()
            );
        }
        $this->setValue('paymentArray', $paymentArray);

        $managerArray = array();
        $users = Shop::Get()->getUserService()->getUsersManagers();
        while ($x = $users->getNext()) {
            $managerArray[] = array(
                'id' => $x->getId(),
                'name' => $x->makeName(true, 'lfm')
            );
        }
        $this->setValue('managerArray', $managerArray);
    }

    public function processData() {
        $index = $this->getValue('index');

        /*// оригинальный файл
        $fileoriginal = $this->getArgumentSecure($index.'_fileoriginal');
        $uploadName = false;
        if (!empty($fileoriginal['tmp_name'])) {
            $name = $fileoriginal['name'];
            $path = $fileoriginal['tmp_name'];
            $ext = pathinfo($name, PATHINFO_EXTENSION);
            $md5 = md5(file_get_contents($path));

            $uploadName = $md5.'.'.$ext;

            copy($path, PackageLoader::Get()->getProjectPath().'media/document/'.$uploadName);
        }*/

        $dataArray = array(
            'documentName' => $this->getArgumentSecure($index.'_documentname'),
            'templateid' => $this->getArgumentSecure($index.'_templateid'),
            'contractorid' => $this->getArgumentSecure($index.'_contractorid'),
            'letter' => $this->getArgumentSecure($index.'_letter'),
            'letterText' => $this->getArgumentSecure($index.'_letter_text'),
            'paymentId' => $this->getArgumentSecure($index.'_paymentId'),
            'managerId' => $this->getArgumentSecure($index.'_managerId'),
            //'sent' => $this->getArgumentSecure($index.'_sent'),
            //'sdate' => $this->getArgumentSecure($index.'_sdate'),
            //'recieved' => $this->getArgumentSecure($index.'_recieved'),
            //'bdate' => $this->getArgumentSecure($index.'_bdate'),
            //'archive' => $this->getArgumentSecure($index.'_archive'),
            //'adate' => $this->getArgumentSecure($index.'_adate'),
            //'fileoriginal' => $uploadName,
        );


        WorkflowStatusLoader::Get()->addBlockData(
            $this->_getStatus(),
            $this->getContentID(),
            $this->getValue('sort'),
            json_encode($dataArray)
        );
    }

    public function processStatus(Events_Event $event) {
        $data = $this->getValue('data');

        if (!$data) {
            return false;
        }

        $data = json_decode($data);

        if ($data->documentName && $data->templateid) {

            $order = $this->_getEventOrder($event);

            $documentUser = $this->_getEventUser($event);
            if ($data->managerId) {
                try {
                    $documentUser = Shop::Get()->getUserService()->getUserByID($data->managerId);
                } catch (Exception $euser) {

                }
            }

            $document = DocumentService::Get()->addDocument(
                $documentUser,
                $data->documentName,
                $data->templateid,
                'ShopOrder-'.$order->getId(),
                $data->contractorid,
                false,
                false,
                false,
                false,
                $this->_getEventOrder($event)->makeAssignArrayForDocument()
            );

            // надо отправлять письмо с документом
            if ($document && $data->letter) {

                // соответсвие оплаты
                if ($data->paymentId && $order->getPaymentid() != $data->paymentId) {
                    return;
                }

                $clientEmail = $order->getClientemail();

                if (!$clientEmail) {
                    try {
                        $clientEmail = $order->getClient()->getEmail();
                    } catch (Exception $emailEx) {

                    }
                }

                if (!$clientEmail) {
                    return;
                }

                // получаем шаблон
                $tpl = $data->letterText;

                // формируем письмо
                $html = Shop::Get()->getShopService()->makeOrderTemplate($order, $tpl);

                // убираем из него subject
                if (preg_match("/Subject\:\s*(.+?)\n/iu", $html, $r)) {
                    $subject = trim(strip_tags($r[1]));
                    $html = trim(preg_replace("/Subject\:\s*(.+?)\n/iu", '', $html, 1));
                } else {
                    $subject = false;
                }

                // обратный емейл
                $emailFrom = Shop::Get()->getSettingsService()->getSettingValue('reverse-email');

                // отправляем письмо
                if ($clientEmail && Checker::CheckEmail($emailFrom)) {
                    $this->_document = $document;

                    $html2 =preg_replace_callback("/\[(.+?)\]/ius", array($this, '_callback'), $document->getContent());
                    // use absolute links (like http://my.host/image.gif).
                    /*if (@isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
                        $h = 'https://';
                    } else {
                        $h = 'http://';
                    }
                    $html =  preg_replace('/\/media\//', $h . Engine::GetURLParser()->getHost() . '/media/', $html);*/
                    $fileHTML = PackageLoader::Get()->getProjectPath().'/media/tmp/'.$document->getId().'.html';
                    $filePDF = PackageLoader::Get()->getProjectPath().'/media/document/'.$document->getId().'.pdf';

                    if (!substr_count($html2, '<body>')) {
                        $tmp = '<!DOCTYPE html><html><head><meta
                    http-equiv="content-type" content="text/html; charset=UTF-8" />';
                        $tmp .= '</head><body>';
                        $tmp .= $html2;
                        $tmp .= '</body></html>';

                        $html2 = $tmp;
                        unset($tmp);
                    }

                    @unlink($filePDF);

                    file_put_contents($fileHTML, $html2, LOCK_EX);

                    PackageLoader::Get()->import('PDF');
                    PDF_Container::Get()->html2pdf_extenal($fileHTML, $filePDF);

                    /*file_put_contents(
                        PackageLoader::Get()->getProjectPath().
                        'media/file/'.$document->getName().'.doc',
                        $content = preg_replace_callback(
                            "/\[(.+?)\]/ius",
                            array($this, '_callback'),
                            $document->getContent()
                        )
                    );*/

                    $fileAttachedArray[] = array(
                        'name' => $document->getName().'.pdf',
                        'type' => 'application/pdf',
                        'tmp_name' => $filePDF,
                    );

                    Shop::Get()->getUserService()->sendEmail(
                        $emailFrom,
                        $clientEmail,
                        $subject,
                        $html,
                        'text',
                        $fileAttachedArray,
                        Shop::Get()->getShopService()->getMailTemplate()
                    );
                }


                $user = $this->_getEventUser($event);

                $comment = trim(strip_tags($html));
                $comment .= "\n\n";
                $comment .= "Отправлено на email {$clientEmail} от email {$emailFrom}";
                $comment .= " с темой ".$subject;

                // после того как письмо отправлено,
                // добавляем его в комментарий к order'y
                Shop::Get()->getShopService()->addOrderEmail(
                    $order,
                    $user,
                    $comment
                );
            }

        }


    }

    /**
     * Обертка
     *
     * @return ShopOrder
     */
    private function _getEventOrder($event) {
        return $event->getOrder();
    }


    /**
     * Обертка
     *
     * @return ShopOrder
     */
    private function _getEventUser($event) {
        return $event->getUser();
    }


    /**
     * Обертка
     *
     * @return ShopOrderStatus
     */
    private function _getStatus () {
        return $this->getValue('status');
    }

    private function _callback($x) {
        $name = $x[1];

        $tmp = new XShopDocumentFieldValue();
        $tmp->setDocumentid($this->_document->getId());
        $tmp->setName($name);
        $tmp->select();
        $value = $tmp->getValue();

        return $value;
    }
    private $_document;
}