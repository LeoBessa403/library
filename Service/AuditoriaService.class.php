<?php

/**
 * AuditoriaService.class [ SEVICE ]
 * @copyright (c) 2018, Leo Bessa
 */
class  AuditoriaService extends AbstractService
{

    private $ObjetoModel;

    public function __construct()
    {
        parent::__construct(AuditoriaEntidade::ENTIDADE);
        $this->ObjetoModel = New AuditoriaModel();
    }

    public function PesquisaAvancada($Condicoes)
    {
        return $this->ObjetoModel->PesquisaAvancada($Condicoes);
    }

    public function PesquisaEvolucaoEsforco($Condicoes)
    {
        return $this->ObjetoModel->PesquisaEvolucaoEsforco($Condicoes);
    }

    public static function PesquisaTabelasCombo()
    {
        $conn = new ObjetoPDO();
        $conexao = $conn->inicializarConexao();

        $result = mysqli_query($conexao, 'SHOW TABLES');
        $tabelas = [];
        if ($result) {
            while ($row = mysqli_fetch_row($result)) {
                $Entidade = str_replace(array('tb_', 'TB_'), '', $row[0]);
                $Entidade = str_replace('_', ' ', $Entidade);
                $Entidade = ucwords($Entidade);
                $tabelas[strtoupper($row[0])] = $Entidade;
            }
        }
        return $tabelas;
    }
}