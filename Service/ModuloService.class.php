<?php

/**
 * ModuloService.class [ SEVICE ]
 * @copyright (c) 2018, Leo Bessa
 */
class  ModuloService extends AbstractService
{

    private $ObjetoModel;


    public function __construct()
    {
        parent::__construct(ModuloEntidade::ENTIDADE);
        $this->ObjetoModel = New ModuloModel();
    }

    public function salvaModulo($dados)
    {
        $retorno = [
            SUCESSO => false,
            MSG => null
        ];
        $moduloValidador = new ModuloValidador();
        /** @var ModuloValidador $validador */
        $validador = $moduloValidador->validarModulo($dados);
        if ($validador[SUCESSO]) {
            $modulo[NO_MODULO] = trim($dados[NO_MODULO]);
            $modulo[CO_PROJETO] = $dados[CO_PROJETO];

            if (!empty($_POST[CO_MODULO])):
                $coModulo = $dados[CO_MODULO];
                $retorno[SUCESSO] = $this->Salva($modulo, $coModulo);
            else:
                $modulo[DT_CADASTRO] = Valida::DataHoraAtualBanco();
                $retorno[SUCESSO] = $this->Salva($modulo);
            endif;
        } else {
            $session = new Session();
            $session->setSession(MENSAGEM, $validador[MSG]);
            $retorno = $validador;
        }
        return $retorno;
    }
}