<?php

/**
 * ImagemService.class [ SEVICE ]
 * @copyright (c) 2017, Leo Bessa
 */
class  ImagemService extends AbstractService
{

    public function __construct()
    {
        parent::__construct(ImagemEntidade::ENTIDADE);
    }

    /**
     * @param $imagem
     * @param $noImagem
     * @param null $pasta
     * @param null $coImagem
     * @return mixed
     */
    public function salvaImagem($imagem, $noImagem, $pasta = null, $coImagem = null)
    {
        /** @var Upload $up */
        $up = new Upload();
        $noImagem = Valida::ValNome(strtolower(trim($noImagem)));

        if ($imagem):
            if ($imagem[DS_CAMINHO]["tmp_name"]):
                $img = $imagem[DS_CAMINHO];
                $up->UploadImagens($img, $noImagem, $pasta);
                $imagem[DS_CAMINHO] = $pasta . $up->getNameImage();
                return $this->Salva($imagem, $coImagem);
            endif;
        endif;
        return false;
    }

    public static function getImagemCoUsuario($coUsuario)
    {
        $UsuarioModel = new UsuarioModel();
        /** @var UsuarioEntidade $usuario */
        $usuario = $UsuarioModel->PesquisaUmRegistro($coUsuario);
        if($usuario->getCoImagem()){
            return $usuario->getCoImagem()->getDsCaminho();
        }else{
            return null;
        }
    }

    public static function getImagemCoPessoa($coPessoa)
    {
        $UsuarioModel = new UsuarioModel();
        return $UsuarioModel->getPessoaCoUsuario($coPessoa);
    }

}