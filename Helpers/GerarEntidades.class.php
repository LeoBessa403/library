<?php

/**
 * Gestao.class [ HELPER ]
 * Reponsável por realizar o backup do Banco de Dados!
 *
 * @copyright (c) 2015, Leonardo Bessa
 */
class GerarEntidades
{
    var $tabelas;
    var $constantes;
    var $relacionamentos;
    var $conn;

    /** @var array Classes Padrões pra não criação das Entidades Models e Services */
    protected static $CLASS_PADRAO = [
        'tb_acesso', 'tb_auditoria', 'tb_auditoria_itens', 'tb_auditoria_tabela', 'tb_contato', 'tb_endereco',
        'tb_funcionalidade', 'tb_imagem', 'tb_pagina', 'tb_pagina_visita', 'tb_perfil_funcionalidade',
        'tb_perfil', 'tb_pessoa', 'tb_trafego', 'tb_usuario_perfil', 'tb_usuario', 'tb_visita',
        'tb_assinante', 'tb_assinante_filial', 'tb_assinante_matriz', 'tb_imagem_assinante', 'tb_modulo',
        'tb_plano', 'tb_plano_assinante', 'tb_plano_assinante_assinatura', 'tb_controller'
    ];

    public function __construct($tabelas = array())
    {
        $this->tabelas = $tabelas;
        $this->constantes = ($tabelas) ? true : false;
        $conn = new ObjetoPDO();
        $this->conn = $conn->inicializarConexao();
        $this->gerar();
    }

    /**
     * @return bool
     */
    public function gerar()
    {
        try {
            $constantes = array();
            if (!$this->tabelas) {
                $result = mysqli_query($this->conn, 'SHOW TABLES');
                $this->tabelas = [];
                if ($result) {
                    while ($row = mysqli_fetch_row($result)) {
                        if (!in_array($row[0], static::$CLASS_PADRAO))
                            $this->tabelas[] = $row[0];
                    }
                }
            }

            if (!empty($this->tabelas)) {
                // Gera a Classe de Relacionamentos
                foreach ($this->tabelas as $table) {
                    $table = strtolower($table);
                    $row2 = mysqli_query($this->conn, 'SHOW COLUMNS FROM ' . $table);
                    $colunas = array();
                    $relacionamentosTabela = array();
                    if (mysqli_num_rows($row2) > 0) {
                        while ($row = mysqli_fetch_assoc($row2)) {
                            $colunas[] = $row['Field'];
                            $constantes[strtoupper($row['Field'])] = $row['Field'];
                            if ($row['Extra'] == '' && $row['Key'] != '')
                                $relacionamentosTabela[] = $row['Field'];

                        }
                    }
                    foreach ($relacionamentosTabela as $rel) {
                        $this->relacionamentos[$table][$rel] = [
                            $rel,
                            $this->getEntidade($rel)
                        ];
                        $this->relacionamentos[str_replace('co_', 'tb_', $rel)][str_replace(array('TB_', 'tb_'), 'co_', $table)] = [
                            $rel,
                            $this->getEntidade($table)
                        ];
                    }
                }
                $this->geraClassRelacionamento($this->relacionamentos);

                /**
                 * Iterate tables
                 */
                foreach ($this->tabelas as $table) {
                    $table = strtolower($table);
                    $row2 = mysqli_query($this->conn, 'SHOW COLUMNS FROM ' . $table);
                    $colunas = array();
                    $chave_primaria = '';
                    $relacionamentosTabela = array();
                    if (mysqli_num_rows($row2) > 0) {
                        while ($row = mysqli_fetch_assoc($row2)) {
                            $colunas[] = $row['Field'];
                            $constantes[strtoupper($row['Field'])] = $row['Field'];
                            if ($row['Extra'] != '')
                                $chave_primaria = $row['Field'];
                            if ($row['Extra'] == '' && $row['Key'] != '')
                                $relacionamentosTabela[] = $row['Field'];

                        }
                    }
                    $Entidade = $this->getEntidade($table);
                    $constantes = $this->geraConstantesService($constantes, $table);
                    $this->geraEntidade($Entidade, $table, $chave_primaria, $colunas, $this->relacionamentos[$table]);
                    $this->geraModel($Entidade);
                    $this->geraConstantes($constantes);
                    $this->geraService($Entidade);

                }
            }
        } catch (Exception $e) {
            Notificacoes::geraMensagem(
                'Error Gerar Entidade. ' . $e->getMessage(),
                TiposMensagemEnum::ERRO
            );
            return false;
        }
        return true;
    }

    private function getEntidade($Entidade)
    {
        $Entidade = str_replace(array('tb_', 'co_'), '', $Entidade);
        $Entidade = str_replace('_', ' ', $Entidade);
        $Entidade = ucwords($Entidade);
        $Entidade = str_replace(' ', '', $Entidade);
        return $Entidade;
    }

    private function geraClassRelacionamento($relacionamentos)
    {
        $ArquivoRelacionamento = '';
        if (!$this->constantes) {

            $ArquivoRelacionamento .= "<?php\n
/**
 * Relacionamentos.class [ RELACIONAMENTOS DO BANCO ]
 * @copyright (c) " . date('Y') . ", Leo Bessa
 */\n
class Relacionamentos
{\n\n";
            $ArquivoRelacionamento .= "\tpublic static function getRelacionamentos(){
    \t\treturn array(\n";
        } else {
            $ArquivoRelacionamento .= "\n\n\n\n\n\n";
        }

        foreach ($relacionamentos as $tabela => $valor) {
            $ArquivoRelacionamento .= "\t\t\t(" . $this->getEntidade($tabela) . "Entidade::TABELA) => Array(\n";
            $i = 0;
            foreach ($valor as $campo => $entidade) {
                $ArquivoRelacionamento .= "\t\t\t\t(" . strtoupper($campo) . ") => Array(\n";
                $ArquivoRelacionamento .= "\t\t\t\t\t('Campo') => " . strtoupper($entidade[$i]) . ",\n";
                $ArquivoRelacionamento .= "\t\t\t\t\t('Entidade') => '" . $entidade[$i + 1] . "Entidade',\n";
                $ArquivoRelacionamento .= "\t\t\t\t\t('Tipo') => '1',\n";
                $ArquivoRelacionamento .= "\t\t\t\t),\n";
            }
            $ArquivoRelacionamento .= "\t\t\t),\n";
        }
        if (!$this->constantes)
            $ArquivoRelacionamento .= "\t\t);\n}\n}";


        $this->saveRelacionamentos($ArquivoRelacionamento);
    }

    protected function saveRelacionamentos($ArquivoRelacionamento)
    {
        if (!$ArquivoRelacionamento) return false;
        try {
            $handle = fopen(PASTA_CLASS . '/Relacionamentos.class.php', 'a+');
            fwrite($handle, $ArquivoRelacionamento);
            fclose($handle);
        } catch (Exception $e) {
            Notificacoes::geraMensagem(
                'Error Gerar Entidade. ' . $e->getMessage(),
                TiposMensagemEnum::ERRO
            );
            return false;
        }
        return true;
    }

    private function geraConstantesService($constantes, $table)
    {
        $constantes[strtoupper(str_replace(array('TB_', 'tb_'), '', $table)) . "_SERVICE"] =
            $this->getEntidade($table) . "Service";

        return $constantes;
    }

    private function geraEntidade($Entidade, $table, $chave_primaria, $colunas, $relacionamentosTabela)
    {
        foreach ($colunas as $coluna) {
            if (!empty($relacionamentosTabela[$coluna])) {
                unset($relacionamentosTabela[$coluna]);
            }
        }
        $ArquivoEntidade = "<?php\n
/**
 * {$Entidade}.Entidade [ ENTIDADE ]
 * @copyright (c) " . date('Y') . ", Leo Bessa
 */\n
class {$Entidade}Entidade extends AbstractEntidade
{
\tconst TABELA = '" . strtoupper($table) . "';
\tconst ENTIDADE = '{$Entidade}Entidade';
\tconst CHAVE = " . strtoupper($chave_primaria) . ";\n\n";

        foreach ($colunas as $coluna) {
            $ArquivoEntidade .= "\tprivate $" . $coluna . ";\n";
        }
        foreach ($relacionamentosTabela as $index => $novaColuna) {
            $ArquivoEntidade .= "\tprivate $" . str_replace(array('TB_', 'tb_'), 'co_', $index) . ";\n";
        }
        $ArquivoEntidade .= "\n\n";
        $ArquivoEntidade .= "\t/**
    * @return array
    */\n";
        $ArquivoEntidade .= "\tpublic static function getCampos() 
    {
    \treturn [\n";
        foreach ($colunas as $coluna) {
            $ArquivoEntidade .= "\t\t\t" . strtoupper($coluna) . ",\n";
        }
        $ArquivoEntidade .= "\t\t];
    }\n\n";
        $ArquivoEntidade .= "\t/**\n\t* @return array \$relacionamentos
    */\n";
        $ArquivoEntidade .= "\tpublic static function getRelacionamentos() 
    {
    \t\$relacionamentos = Relacionamentos::getRelacionamentos();\n\t\treturn \$relacionamentos[static::TABELA];\n\t}\n";
        $ArquivoEntidade .= "\n\n";
        foreach ($colunas as $coluna) {
            $metodoGet = $this->getMetodo($coluna);
            $ArquivoEntidade .= "\t/**\n";

            if (strstr($coluna, 'co_') && $coluna != $chave_primaria) {
                $ArquivoEntidade .= "\t* @return " . $this->getEntidade($coluna) . "Entidade \$$coluna";
            } elseif ($coluna == $chave_primaria) {
                $ArquivoEntidade .= "\t* @return int \$$coluna";
            } else {
                $ArquivoEntidade .= "\t* @return mixed \$$coluna";
            }
            $ArquivoEntidade .= "
    */\n";
            $ArquivoEntidade .= "\tpublic function {$metodoGet}()
    {
        return \$this->$coluna;
    }\n\n";
            $metodoSet = $this->getMetodo($coluna, false);
            $ArquivoEntidade .= "\t/**\n\t* @param \$$coluna";
            $ArquivoEntidade .= "
    * @return mixed
    */\n";
            $ArquivoEntidade .= "\tpublic function {$metodoSet}(\$$coluna)
    {
        return \$this->$coluna = \$$coluna;
    }\n\n";
        }

        foreach ($relacionamentosTabela as $index => $metodos) {
            $metodos = str_replace(array('TB_', 'tb_'), 'co_', $index);
            $metodoGet = $this->getMetodo($metodos);

            $ArquivoEntidade .= "\t/**\n";

            if (strstr($metodos, 'co_') && $metodos != $chave_primaria) {
                $ArquivoEntidade .= "\t* @return " . $this->getEntidade($metodos) . "Entidade \$$metodos";
            } else {
                $ArquivoEntidade .= "\t* @return \$$metodos";
            }
            $ArquivoEntidade .= "
     */\n";
            $ArquivoEntidade .= "\tpublic function {$metodoGet}()
    {
        return \$this->$metodos;
    }\n\n";
            $metodoSet = $this->getMetodo($metodos, false);
            $ArquivoEntidade .= "\t/**
     * @param \$$metodos
     * @return mixed
     */\n";
            $ArquivoEntidade .= "\tpublic function {$metodoSet}(\$$metodos)
    {
        return \$this->$metodos = \$$metodos;
    }\n\n";
        }

        $ArquivoEntidade .= "}";
        $this->saveEntidade($ArquivoEntidade, $Entidade);
    }

    private function getMetodo($campo, $get = true)
    {
        $metodo = str_replace('_', ' ', $campo);
        $metodo = ucwords($metodo);
        $metodo = str_replace(' ', '', $metodo);
        $tipo = ($get) ? 'get' : 'set';
        $metodo = $tipo . $metodo;
        return $metodo;
    }

    protected function saveEntidade($ArquivoEntidade, $Entidade)
    {
        if (!$ArquivoEntidade) return false;
        try {
            $arquivo = PASTA_ENTIDADES . $Entidade . 'Entidade.class.php';
            if (!file_exists($arquivo)) {
                $handle = fopen($arquivo, 'w+');
                fwrite($handle, $ArquivoEntidade);
                fclose($handle);
            }
        } catch (Exception $e) {
            Notificacoes::geraMensagem(
                'Error Gerar Entidade. ' . $e->getMessage(),
                TiposMensagemEnum::ERRO
            );
            return false;
        }

        return true;
    }

    private function geraModel($Entidade)
    {
        $ArquivoModel = "<?php\n
/**
 * {$Entidade}Model.class [ MODEL ]
 * @copyright (c) " . date('Y') . ", Leo Bessa
 */
class  {$Entidade}Model extends AbstractModel
{\n
    public function __construct()
    {
        parent::__construct({$Entidade}Entidade::ENTIDADE);
    }\n\n
}";
        $this->saveModel($ArquivoModel, $Entidade);
    }

    protected function saveModel($ArquivoModel, $Entidade)
    {
        if (!$ArquivoModel) return false;
        try {
            $arquivo = PASTA_MODEL . $Entidade . 'Model.class.php';
            if (!file_exists($arquivo)) {
                $handle = fopen($arquivo, 'w+');
                fwrite($handle, $ArquivoModel);
                fclose($handle);
            }
        } catch (Exception $e) {
            Notificacoes::geraMensagem(
                'Error Gerar Entidade. ' . $e->getMessage(),
                TiposMensagemEnum::ERRO
            );
            return false;
        }

        return true;
    }

    private function geraConstantes($constantes)
    {
        if (!$this->constantes) {

            $ArquivoConstante = "<?php \n
/**
 * Constantes.class [ HELPER ]
 * Classe responável por manipular e validade dados do sistema!
 *
 * @copyright (c) " . date('Y') . ", Leo Bessa
 */ \n";
            foreach ($constantes as $indice => $res) {
                $ArquivoConstante .= "define('" . $indice . "', '" . $res . "');\n";
            }
            $ArquivoConstante .= "\n";
            $this->saveConstantes($ArquivoConstante, 'w+');
        } else {
            $ArquivoConstante = "\n\n\n";
            foreach ($constantes as $indice => $res) {
                $ArquivoConstante .= "define('" . $indice . "', '" . $res . "');\n";
            }
            $this->saveConstantes($ArquivoConstante, 'a+');
        }
    }

    protected function saveConstantes($ArquivoConstante, $operacao)
    {
        if (!$ArquivoConstante) return false;
        try {
            $handle = fopen(PASTA_CLASS . 'Constantes.class.php', $operacao);
            fwrite($handle, $ArquivoConstante);
            fclose($handle);
        } catch (Exception $e) {
            Notificacoes::geraMensagem(
                'Error Gerar Entidade. ' . $e->getMessage(),
                TiposMensagemEnum::ERRO
            );
            return false;
        }
        return true;
    }

    private function geraService($Entidade)
    {
        $ArquivoService = "<?php\n
/**
 * {$Entidade}Service.class [ SEVICE ]
 * @copyright (c) " . date('Y') . ", Leo Bessa
 */
class  {$Entidade}Service extends AbstractService
{\n
    private \$ObjetoModel;\n\n
    public function __construct()
    {
        parent::__construct({$Entidade}Entidade::ENTIDADE);
        \$this->ObjetoModel = New {$Entidade}Model();
    }\n\n
}";
        $this->saveService($ArquivoService, $Entidade);
    }

    protected function saveService($ArquivoService, $Entidade)
    {
        if (!$ArquivoService) return false;
        try {
            $arquivo = PASTA_SEVICE . $Entidade . 'Service.class.php';
            if (!file_exists($arquivo)) {
                $handle = fopen($arquivo, 'w+');
                fwrite($handle, $ArquivoService);
                fclose($handle);
            }
        } catch (Exception $e) {
            Notificacoes::geraMensagem(
                'Error Gerar Entidade. ' . $e->getMessage(),
                TiposMensagemEnum::ERRO
            );
            return false;
        }

        return true;
    }
}
