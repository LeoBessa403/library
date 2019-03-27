<?php

class PessoaForm extends AbstractController
{
    public static function ValidarCPF($link, $tamanho = 12)
    {
        $id = "ValidacaoPessoa";

        /** @var Form $formulario */
        $formulario = new Form($id, UrlAmigavel::$modulo . "/" . UrlAmigavel::$controller
            . "/" . UrlAmigavel::$action, 'Validar',  $tamanho);

        $formulario
            ->setId(NU_CPF)
            ->setClasses("cpf ob")
            ->setInfo('Verificação de dados')
            ->setTamanhoInput(12)
            ->setLabel("CPF")
            ->CriaInpunt();

        return $formulario->finalizaForm($link);
    }

}

?>
   