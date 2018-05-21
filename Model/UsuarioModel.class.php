<?php

/**
 * UsuarioModel.class [ MODEL ]
 * @copyright (c) 2017, Leo Bessa
 */
class  UsuarioModel extends AbstractModel
{
    public function __construct()
    {
        parent::__construct(UsuarioEntidade::ENTIDADE);
    }

    public function PesquisaAvancada($Condicoes)
    {
        $tabela = UsuarioEntidade::TABELA . " usu" .
            " inner join " . PessoaEntidade::TABELA . " pes" .
            " on usu." . PessoaEntidade::CHAVE . " = pes." . PessoaEntidade::CHAVE;

        $campos = "usu.*";
        $pesquisa = new Pesquisa();
        $where = $pesquisa->getClausula($Condicoes);
        $pesquisa->Pesquisar($tabela, $where, null, $campos);
        $usuarios = [];
        /** @var UsuarioEntidade $usuario */
        foreach ($pesquisa->getResult() as $usuario) {
            $usu[0] = $usuario;
            $usuarios[] = $this->getUmObjeto(UsuarioEntidade::ENTIDADE, $usu);
        }
        return $usuarios;
    }

    public function Deleta($coUsuario)
    {
        /** @var PDO $PDO */
        $PDO = $this->getPDO();
        $PDO->beginTransaction();

        /** @var UsuarioEntidade $usuario */
        $usuario = $this->PesquisaUmRegistro($coUsuario);
        $this->Deleta($coUsuario);

        /** @var PessoaModel $PessoaModel */
        $PessoaModel = new PessoaModel();
        $PessoaModel->Deleta($usuario->getCoPessoa()->getCoPessoa());

        /** @var EnderecoModel $EnderecoModel */
        $EnderecoModel = new EnderecoModel();
        $EnderecoModel->Deleta($usuario->getCoPessoa()->getCoEndereco()->getCoEndereco());

        /** @var ContatoModel $ContatoModel */
        $ContatoModel = new ContatoModel();
        $ContatoModel->Deleta($usuario->getCoPessoa()->getCoContato()->getCoContato());

        /** @var ImagemModel $ImagemModel */
        $ImagemModel = new ImagemModel();
        $usuario = $ImagemModel->Deleta($usuario->getCoImagem()->getCoImagem());
        if ($usuario) {
            $PDO->commit();
        } else {
            $PDO->rollBack();
        }
        return $usuario;
    }

}