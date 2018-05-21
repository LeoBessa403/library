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
                "DF" => "Distrito Federal",
                "AC" => "Acre",
                "AL" => "Alagoas",
                "AM" => "Amazonas",
                "AP" => "Amapá",
                "BA" => "Bahia",
                "CE" => "Ceará",
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

}