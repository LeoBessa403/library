<?php

class PagSeguro
{

    public function getReferenciaPagamentoAssinante()
    {
        $url = URL_PAGSEGURO . "sessions?email=" . EMAIL_PAGSEGURO . "&token=" . TOKEN_PAGSEGURO;

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-Type: application/x-www-form-urlencoded; charset=UTF-8"));
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $retorno = curl_exec($curl);
        curl_close($curl);

        $xml = simplexml_load_string($retorno);
        return $xml;
    }

    public function processaPagamento()
    {
        $Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        $tpPagamento = $Dados[TP_PAGAMENTO][0];
        $DadosArray["email"] = EMAIL_PAGSEGURO;
        $DadosArray["token"] = TOKEN_PAGSEGURO;

        if ($tpPagamento == TipoPagamentoEnum::CARTAO_CREDITO) {
            $DadosArray['creditCardToken'] = $Dados['tokenCartao'];
            $DadosArray['installmentQuantity'] = $Dados['qntParcelas'];
            $DadosArray['installmentValue'] = $Dados['valorParcelas'];
            $DadosArray['noInterestInstallmentQuantity'] = $Dados['noIntInstalQuantity'];
            $DadosArray['creditCardHolderName'] = $Dados['creditCardHolderName'];
            $DadosArray['creditCardHolderCPF'] = $Dados['creditCardHolderCPF'];
            $DadosArray['creditCardHolderBirthDate'] = $Dados['creditCardHolderBirthDate'];
            $DadosArray['creditCardHolderAreaCode'] = $Dados['senderAreaCode'];
            $DadosArray['creditCardHolderPhone'] = $Dados['senderPhone'];
            $DadosArray['billingAddressStreet'] = $Dados['billingAddressStreet'];
            $DadosArray['billingAddressNumber'] = $Dados['billingAddressNumber'];
            $DadosArray['billingAddressComplement'] = $Dados['billingAddressComplement'];
            $DadosArray['billingAddressDistrict'] = $Dados['billingAddressDistrict'];
            $DadosArray['billingAddressPostalCode'] = $Dados['billingAddressPostalCode'];
            $DadosArray['billingAddressCity'] = $Dados['billingAddressCity'];
            $DadosArray['billingAddressState'] = $Dados['billingAddressState'];
            $DadosArray['billingAddressCountry'] = $Dados['billingAddressCountry'];
            $DadosArray['paymentMethod'] = 'creditCard';
        } elseif ($tpPagamento == TipoPagamentoEnum::BOLETO) {
            $DadosArray['paymentMethod'] = 'boleto';
        } elseif ($tpPagamento == TipoPagamentoEnum::PIX) {
            $DadosArray['bankName'] = $Dados['bankName'];
            $DadosArray['paymentMethod'] = 'eft';
        }

        $DadosArray['paymentMode'] = 'default';



        $DadosArray['receiverEmail'] = EMAIL_LOJA;
        $DadosArray['currency'] = 'BRL';
        $DadosArray['extraAmount'] = '0.00';

        while ($row_car = $resultado_car->fetch(PDO::FETCH_ASSOC)) {
            $DadosArray["itemId{$cont_item}"] = $row_car['produto_id'];
            $DadosArray["itemDescription{$cont_item}"] = $row_car['nome_produto'];
            $total_venda = number_format($row_car['valor_venda'], 2, '.', '');
            $DadosArray["itemAmount{$cont_item}"] = $total_venda;
            $DadosArray["itemQuantity{$cont_item}"] = $row_car['qnt_produto'];
            $cont_item++;
        }

        $DadosArray['notificationURL'] = URL_NOTIFICACAO;
        $DadosArray['reference'] = $Dados['reference'];
        $DadosArray['senderName'] = $Dados['senderName'];
        $DadosArray['senderCPF'] = $Dados['senderCPF'];
        $DadosArray['senderAreaCode'] = $Dados['senderAreaCode'];
        $DadosArray['senderPhone'] = $Dados['senderPhone'];
        $DadosArray['senderEmail'] = $Dados['senderEmail'];
        $DadosArray['senderHash'] = $Dados['hashCartao'];
        $DadosArray['shippingAddressRequired'] = $Dados['shippingAddressRequired'];
        $DadosArray['shippingAddressStreet'] = $Dados['shippingAddressStreet'];
        $DadosArray['shippingAddressNumber'] = $Dados['shippingAddressNumber'];
        $DadosArray['shippingAddressComplement'] = $Dados['shippingAddressComplement'];
        $DadosArray['shippingAddressDistrict'] = $Dados['shippingAddressDistrict'];
        $DadosArray['shippingAddressPostalCode'] = $Dados['shippingAddressPostalCode'];
        $DadosArray['shippingAddressCity'] = $Dados['shippingAddressCity'];
        $DadosArray['shippingAddressState'] = $Dados['shippingAddressState'];
        $DadosArray['shippingAddressCountry'] = $Dados['shippingAddressCountry'];
        $DadosArray['shippingType'] = $Dados['shippingType'];
        $DadosArray['shippingCost'] = $Dados['shippingCost'];

//        $buildQuery = http_build_query($DadosArray);
//        $url = URL_PAGSEGURO . "transactions";
//
//        $curl = curl_init($url);
//        curl_setopt($curl, CURLOPT_HTTPHEADER, Array("Content-Type: application/x-www-form-urlencoded; charset=UTF-8"));
//        curl_setopt($curl, CURLOPT_POST, true);
//        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
//        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
//        curl_setopt($curl, CURLOPT_POSTFIELDS, $buildQuery);
//        $retorno = curl_exec($curl);
//        curl_close($curl);
//        $xml = simplexml_load_string($retorno);


//        $retorna = ['erro' => true, 'dados' => $xml, 'DadosArray' => $DadosArray];
        header('Content-Type: application/json');
//        echo json_encode($DadosArray);
        echo $DadosArray;
    }


}