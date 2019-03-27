<?php

/**
 * EnderecoService.class [ SEVICE ]
 * @copyright (c) 2017, Leo Bessa
 */
class  EnderecoService extends AbstractService
{

    public function __construct()
    {
        parent::__construct(EnderecoEntidade::ENTIDADE);
    }

    public static function montaComboEstadosDescricao()
    {
        $ComboEstados =
            array(
                "" => Mensagens::MSG_SEM_ITEM_SELECIONADO,
                "AC" => "Acre",
                "AL" => "Alagoas",
                "AM" => "Amazonas",
                "AP" => "Amapá",
                "BA" => "Bahia",
                "CE" => "Ceará",
                "DF" => "Distrito Federal",
                "ES" => "Espírito Santo",
                "GO" => "Goiás",
                "MA" => "Maranhão",
                "MT" => "Mato Grosso",
                "MS" => "Mato Grosso do Sul",
                "MG" => "Minas Gerais",
                "PA" => "Pará",
                "PB" => "Paraíba",
                "PR" => "Paraná",
                "PE" => "Pernambuco",
                "PI" => "Piauí",
                "RJ" => "Rio de Janeiro",
                "RN" => "Rio Grande do Norte",
                "RO" => "Rondônia",
                "RS" => "Rio Grande do Sul",
                "RR" => "Roraima",
                "SC" => "Santa Catarina",
                "SE" => "Sergipe",
                "SP" => "São Paulo",
                "TO" => "Tocantins"
            );
        return $ComboEstados;
    }

    /**
     * @param EnderecoEntidade $endereco
     * @param array $dados
     * @return array
     */
    public function getArrayDadosEndereco(EnderecoEntidade $endereco, array $dados)
    {
        $dados[CO_ENDERECO] = $endereco->getCoEndereco();
        $dados[DS_ENDERECO] = $endereco->getDsEndereco();
        $dados[DS_COMPLEMENTO] = $endereco->getDsComplemento();
        $dados[DS_BAIRRO] = $endereco->getDsBairro();
        $dados[NO_CIDADE] = $endereco->getNoCidade();
        $dados[NU_CEP] = $endereco->getNuCep();
        $dados[SG_UF] = $endereco->getSgUf();

        return $dados;
    }

    public function salvaEnderecoAssinante($dados)
    {
        /** @var EmpresaService $empresaService */
        $empresaService = $this->getService(EMPRESA_SERVICE);
        /** @var AssinanteService $assinanteService */
        $assinanteService = $this->getService(ASSINANTE_SERVICE);
        /** @var AssinanteEntidade $assinante */
        $assinante = $assinanteService->getAssinanteLogado();
        $endereco = $this->getDados($dados, EnderecoEntidade::ENTIDADE);
        if (!empty($assinante->getCoEmpresa()->getCoEndereco())) {
            $this->Salva($endereco, $assinante->getCoEmpresa()->getCoEndereco());
            $empresa[CO_ENDERECO] = $assinante->getCoEmpresa()->getCoEndereco();
        } else {
            $empresa[CO_ENDERECO] = $this->Salva($endereco);
        }
        $retorno[SUCESSO] = $empresaService->Salva($empresa, $assinante->getCoEmpresa()->getCoEmpresa());

        return $retorno;
    }
}