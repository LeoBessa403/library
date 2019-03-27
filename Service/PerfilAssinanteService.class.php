<?php

/**
 * PerfilAssinanteService.class [ SEVICE ]
 * @copyright (c) 2019, Leo Bessa
 */
class  PerfilAssinanteService extends AbstractService
{

    private $ObjetoModel;


    public function __construct()
    {
        parent::__construct(PerfilAssinanteEntidade::ENTIDADE);
        $this->ObjetoModel = New PerfilAssinanteModel();
    }

    public function salvaPerfilAssinante($dados)
    {
        /** @var PerfilFuncionalidadeService $perfilFuncionalidadeService */
        $perfilFuncionalidadeService = $this->getService(PERFIL_FUNCIONALIDADE_SERVICE);
        /** @var PDO $PDO */
        $PDO = $this->getPDO();
        $retorno = [
            SUCESSO => false,
            MSG => null
        ];
        $session = new Session();

        $perfil[NO_PERFIL] = trim($dados[NO_PERFIL]);
        $perfil[CO_ASSINANTE] = AssinanteService::getCoAssinanteLogado();
        $perfil[ST_STATUS] = StatusUsuarioEnum::ATIVO;

        $PDO->beginTransaction();
        if (!empty($_POST[CO_PERFIL])):
            $coPerfil = $dados[CO_PERFIL];
            $atualiza = $this->Salva($perfil, $coPerfil);
            if ($atualiza):
                $perfilFuncional[CO_PERFIL_ASSINANTE] = $coPerfil;
                $perfilFuncionalidadeService->DeletaQuando($perfilFuncional);
                $session->setSession(MENSAGEM, ATUALIZADO);
            endif;
        else:
            $coPerfil = $this->Salva($perfil);
            if ($coPerfil):
                $session->setSession(MENSAGEM, CADASTRADO);
            endif;
        endif;
        if ($coPerfil) {
            $perfilFunc[CO_PERFIL_ASSINANTE] = $coPerfil;
            if($dados[CO_FUNCIONALIDADE]){
                foreach ($dados[CO_FUNCIONALIDADE] as $coFuncionalidade) {
                    $perfilFunc[CO_FUNCIONALIDADE] = $coFuncionalidade;
                    $perfilFuncionalidadeService->Salva($perfilFunc);
                }
            }
            $retorno[SUCESSO] = true;
        }
        if ($retorno[SUCESSO]) {
            $PDO->commit();
        } else {
            $session->setSession(MENSAGEM, 'Não foi possível Salvar o Perfil');
            $PDO->rollBack();
        }
        return $retorno;
    }


}