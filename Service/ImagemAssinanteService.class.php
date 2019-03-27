<?php

/**
 * ImagemAssinanteService.class [ SEVICE ]
 * @copyright (c) 2018, Leo Bessa
 */
class  ImagemAssinanteService extends AbstractService
{

    private $ObjetoModel;


    public function __construct()
    {
        parent::__construct(ImagemAssinanteEntidade::ENTIDADE);
        $this->ObjetoModel = New ImagemAssinanteModel();
    }

    public function salvaImagemAssinante($arquivos, $noFantasia, $imagem_logo)
    {
        /** @var ImagemService $imagemService */
        $imagemService = $this->getService(IMAGEM_SERVICE);
        $up = new Upload();
        $retorno[SUCESSO] = true;
        $noFantasia = (!empty($noFantasia)) ? strtoupper(trim($noFantasia)) : 'Novo Assinante';
        $noFantasia = $noFantasia . "-" . AssinanteService::getCoAssinanteLogado();
        $noPasta = "Assinante/Assinante-" . AssinanteService::getCoAssinanteLogado();

        $imagemAssinante[CO_ASSINANTE] = AssinanteService::getCoAssinanteLogado();
        $imagem[DS_CAMINHO] = "";
        $nome = Valida::ValNome($noFantasia);
        if ($arquivos[DS_CAMINHO]["tmp_name"]):
            $foto = $_FILES[DS_CAMINHO];
            $up->UploadImagens($foto, "FP-" . $nome, $noPasta);
            $imagem[DS_CAMINHO] = $up->getNameImage();
            $imagemAssinante[CO_IMAGEM] = $imagemService->Salva($imagem, $imagem_logo);
            $retorno[SUCESSO] = $this->Salva($imagemAssinante, $imagem_logo);
        endif;

        $fotos = $arquivos[CO_IMAGEM_ASSINANTE];
        if ($fotos['name'][0]) {
            $upArquivos = $up->UploadImagens($fotos, $nome, $noPasta);
            foreach ($upArquivos as $value) {
                $imagem[DS_CAMINHO] = $value;
                $imagemAssinante[CO_IMAGEM] = $imagemService->Salva($imagem);
                $retorno[SUCESSO] = $this->Salva($imagemAssinante);
            }
        }

        return $retorno;
    }

}