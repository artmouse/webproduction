<?php
class action_block_client_order_send_email extends Engine_Class {

    public function process() {
        $this->setValue('contentID', $this->getContentID());
        $this->setValue('index', $this->getValue('index'));

        $data = (Array) json_decode($this->getValue('data'));

        $this->setValue('monday', $data['monday']);
        $this->setValue('tuesday', $data['tuesday']);
        $this->setValue('wednesday', $data['wednesday']);
        $this->setValue('thursday', $data['thursday']);
        $this->setValue('friday', $data['friday']);
        $this->setValue('saturday', $data['saturday']);
        $this->setValue('sunday', $data['sunday']);

        $this->setValue('mondayTime', $data['mondayTime']);
        $this->setValue('tuesdayTime', $data['tuesdayTime']);
        $this->setValue('wednesdayTime', $data['wednesdayTime']);
        $this->setValue('thursdayTime', $data['thursdayTime']);
        $this->setValue('fridayTime', $data['fridayTime']);
        $this->setValue('saturdayTime', $data['saturdayTime']);
        $this->setValue('sundayTime', $data['sundayTime']);

        $this->setValue('statusid', $data['status']);
        $this->setValue('subject', $data['subject']);
        $this->setValue('html', $data['html']);
        $this->setValue('signature', $data['signature']);
        $this->setValue('email', $data['email']);

        $status = $this->_getStatus();

        $statusArray = array();
        $workflow = $status->getWorkflow();

        $statusses = WorkflowService::Get()->getStatusNextByWorkflow($workflow, $status);

        while ($x = $statusses->getNext()) {
            if ($x->getId() == $status->getId()) {
                continue;
            }

            $statusArray[] = array(
                'id' => $x->getId(),
                'name' => $x->getName()
            );
        }

        $this->setValue('statusArray', $statusArray);

    }

    public function processData() {
        $index = $this->getValue('index');

        $data = array(
            'monday' => $this->getArgumentSecure($index.'_monday'),
            'tuesday' => $this->getArgumentSecure($index.'_tuesday'),
            'wednesday' => $this->getArgumentSecure($index.'_wednesday'),
            'thursday' => $this->getArgumentSecure($index.'_thursday'),
            'friday' => $this->getArgumentSecure($index.'_friday'),
            'saturday' => $this->getArgumentSecure($index.'_saturday'),
            'sunday' => $this->getArgumentSecure($index.'_sunday'),

            'mondayTime' => $this->getArgumentSecure($index.'_mondayTime'),
            'tuesdayTime' => $this->getArgumentSecure($index.'_tuesdayTime'),
            'wednesdayTime' => $this->getArgumentSecure($index.'_wednesdayTime'),
            'thursdayTime' => $this->getArgumentSecure($index.'_thursdayTime'),
            'fridayTime' => $this->getArgumentSecure($index.'_fridayTime'),
            'saturdayTime' => $this->getArgumentSecure($index.'_saturdayTime'),
            'sundayTime' => $this->getArgumentSecure($index.'_sundayTime'),

            'subject' => $this->getArgumentSecure($index.'_subject'),
            'status' => $this->getArgumentSecure($index.'_status'),
            'html' => $this->getArgumentSecure($index.'_html'),
            'signature' => $this->getArgumentSecure($index.'_signature'),
            'email' => $this->getArgumentSecure($index.'_email'),
        );

        WorkflowStatusLoader::Get()->addBlockData(
            $this->_getStatus(),
            $this->getContentID(),
            $this->getValue('sort'),
            json_encode($data)
        );
    }


    public function processCronHour(Events_Event $event) {
        $event;
        $status = $this->_getStatus();

        $data = (Array) json_decode($this->getValue('data'));

        $weekDay = DateTime_Object::Now()->setFormat('w')->__toString();
        $hour = DateTime_Object::Now()->setFormat('H')->__toString();

        if (!$weekDay) {
            $weekDay = 'sunday';
        } elseif ($weekDay == '1') {
            $weekDay = 'monday';
        } elseif ($weekDay == '2') {
            $weekDay = 'tuesday';
        } elseif ($weekDay == '3') {
            $weekDay = 'wednesday';
        } elseif ($weekDay == '4') {
            $weekDay = 'thursday';
        } elseif ($weekDay == '5') {
            $weekDay = 'friday';
        } elseif ($weekDay == '6') {
            $weekDay = 'saturday';
        }

        if (!$data[$weekDay]) {
            return;
        }

        if ($data[$weekDay.'Time'] != $hour) {
            return;
        }
        $orders = Shop::Get()->getShopService()->getOrdersAll(false, true);
        $orders->setStatusid($status->getId());

        while ($x = $orders->getNext()) {
            try {
                $client = $x->getClient();

                $email = $x->getClientemail();
                if (!$email) {
                    $email = $client->getEmail();
                }

                if (!$email) {
                    continue;
                }

                $html = "";
                $arr = array();

                $html .='Заказ №'.$x->getId().'<br>';
                $html .= 'Клиент: '.$x->getClientname().'<br>';

                $arr[] = array(
                    ' ' => 'Заказ №',
                    '  ' => $x->getId(),
                    '   ' => '',
                    '    ' => '',
                    '     ' => '',
                    '      ' => ''
                );

                $arr[] = array(
                    ' ' => 'Клиент:',
                    '  ' => $x->getClientname()
                );

                $arr[] = array(
                    ' ' => '',
                );

                $arr[] = array(
                    ' ' => '№',
                    '  ' => 'ID',
                    '   ' => 'Товар',
                    '    ' => 'Количество',
                    '     ' => 'Цена',
                    '      ' => 'Сумма',
                );


                $html .= '<table>';
                $html .= '<tr>';
                $html .= '<td>№</td>';
                $html .= '<td>ID</td>';
                $html .= '<td>Товар</td>';
                $html .= '<td>Количество</td>';
                $html .= '<td>Цена</td>';
                $html .= '<td>Сумма</td>';
                $html .= '</tr>';

                $index = 0;
                $sum = 0;
                $orderCurrencySym = $x->getCurrency()->getSymbol();
                $products = $x->getOrderProducts();
                while ($p = $products->getNext()) {
                    $index++;

                    $sum += $priceBase = Shop::Get()->getCurrencyService()->convertCurrency(
                        $p->getProductcount() * $p->getProductprice(),
                        $p->getCurrency(),
                        $x->getCurrency()
                    );

                    $html .= '<tr>';
                    $html .= '<td>'.$index.'</td>';
                    $html .= '<td>'.$p->getProductid().'</td>';
                    $html .= '<td>'.$p->getProductname().'</td>';
                    $html .= '<td>'.$p->getProductcount().'</td>';
                    $html .= '<td>'.round($p->getProductprice(), 2).' '.$p->getCurrency()->getSymbol().'</td>';
                    $html .= '<td>'.round($p->getProductcount() * $p->getProductprice(), 2).' '.
                        $p->getCurrency()->getSymbol().'</td>';
                    $html .= '</tr>';


                    $arr[] = array(
                        ' ' => $index,
                        '  ' => $p->getProductid(),
                        '   ' => $p->getProductname(),
                        '    ' => $p->getProductcount(),
                        '     ' => round($p->getProductprice(), 2).' '.$p->getCurrency()->getSymbol(),
                        '      ' => round($p->getProductcount() * $p->getProductprice(), 2)
                            .' '.$p->getCurrency()->getSymbol()
                    );
                }

                $sum = round($sum, 2);

                $html .= '<tr>';
                $html .= '<td colspan="5">Всего</td>';
                $html .= '<td>'.$sum.' '.$orderCurrencySym.'</td>';
                $html .= '</tr>';
                $html .= '</table>';

                $arr[] = array(
                    ' ' => 'Всего',
                    '  ' => '',
                    '   ' => '',
                    '    ' => '',
                    '     ' => '',
                    '      ' => $sum.' '.$orderCurrencySym
                );

                PackageLoader::Get()->import('XLS');
                $xls = XLS_Creator::CreateFromArray($arr);

                file_put_contents(
                    PackageLoader::Get()->getProjectPath().'/media/export/order/order'.$x->getId().'.xls',
                    $xls
                );

                $fileAttachedArray[] = array(
                    'name' => $x->getId().'.xls',
                    'type' => 'application/xls',
                    'tmp_name' => PackageLoader::Get()->getProjectPath().'/media/export/order/order'.$x->getId().'.xls',
                );

                // обратный емейл
                $emailFrom = $data['email'];
                if (!$emailFrom) {
                    $emailFrom = Shop::Get()->getSettingsService()->getSettingValue('reverse-email');
                }

                if ($data['subject']) {
                    $subject = $data['subject'];
                } elseif (preg_match("/Subject\:\s*(.+?)\n/iu", $html, $r)) {
                    $subject = trim(strip_tags($r[1]));
                    $html = trim(preg_replace("/Subject\:\s*(.+?)\n/iu", '', $html, 1));
                } else {
                    $subject = false;
                }

                $template = false;
                if ($data['html']) {
                    $template = Shop::Get()->getShopService()->getMailTemplate();
                }

                $signatureUser = false;
                if ($data['signature']) {
                    try {
                        $signatureUser = $x->getManager();
                    } catch (Exception $emanager) {

                    }
                }

                Shop::Get()->getUserService()->sendEmail(
                    $emailFrom,
                    $email,
                    $subject,
                    $html,
                    'html',
                    $fileAttachedArray,
                    $template,
                    $signatureUser
                );

                $statusId = $data['status'];
                if ($statusId) {
                    Shop::Get()->getShopService()->updateOrderStatus(
                        false,
                        $x,
                        $statusId
                    );
                }


            } catch (Exception $eclient) {

            }
        }


    }

    /**
     * Обертка
     *
     * @return ShopOrderStatus
     */
    private function _getStatus () {
        return $this->getValue('status');
    }

    /**
     * Обертка
     *
     * @param Shop_Event_Order $event
     *
     * @return ShopOrder
     */
    private function _getOrder($event) {
        return $event->getOrder();
    }

    /**
     * Обертка
     *
     * @param Shop_Event_Order $event
     *
     * @return User
     */
    private function _getUser($event) {
        return $event->getUser();
    }

}