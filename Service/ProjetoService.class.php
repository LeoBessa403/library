<?php

/**
 * ProjetoService.class [ SEVICE ]
 * @copyright (c) 2018, Leo Bessa
 */
class  ProjetoService extends AbstractService
{

    private $ObjetoModel;


    public function __construct()
    {
        parent::__construct(ProjetoEntidade::ENTIDADE);
        $this->ObjetoModel = New ProjetoModel();
    }

    public function salvaProjeto($dados)
    {
        $retorno = [
            SUCESSO => false,
            MSG => null
        ];
        $projetoValidador = new ProjetoValidador();
        /** @var ProjetoValidador $validador */
        $validador = $projetoValidador->validarProduto($dados);
        if ($validador[SUCESSO]) {
            $projeto[NO_PROJETO] = trim($dados[NO_PROJETO]);

            if (!empty($_POST[CO_PROJETO])):
                $coProjeto = $dados[CO_PROJETO];
                $retorno[SUCESSO] = $this->Salva($projeto, $coProjeto);
            else:
                $projeto[DT_CADASTRO] = Valida::DataHoraAtualBanco();
                $retorno[SUCESSO] = $this->Salva($projeto);
            endif;
        } else {
            $session = new Session();
            $session->setSession(MENSAGEM, $validador[MSG]);
            $retorno = $validador;
        }
        return $retorno;
    }
}