<li class="dropdown current-user">
    <a data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle" data-close-others="true"
       href="#">
        <?php
        $noPessoa = $user[md5(NO_PESSOA)];
        $foto = $user[md5('ds_caminho')];
        $sexo = $user[md5('st_sexo')];
        if ($sexo == "M"):
            $fotoPerfil = "avatar-homem.jpg";
        else:
            $fotoPerfil = "avatar-mulher.jpg";
        endif;
        if ($foto != "" && file_exists(PASTA_RAIZ . "uploads/usuarios/" . $foto)):
            echo Valida::GetMiniatura("usuarios/" . $foto,
                $noPessoa, 35, 35, "circle-img");
        else:
            echo '<img src="' . TIMTHUMB . '?src=' . HOME .
                'library/Imagens/' . $fotoPerfil . '&w=35&h=35" 
                                alt="' . $noPessoa . '" title="' . $noPessoa . '" 
                                class="circle-img" />';
        endif;
        ?>
        <span class="username">
                            <?php
                            echo Valida::Resumi($noPessoa, 25);
                            ?>
                            </span>
        <i class="clip-chevron-down"></i>
    </a>
    <ul class="dropdown-menu">
        <li>
            <a href="<?= PASTAADMIN; ?>Usuario/MeuPerfilUsuario">
                <i class="clip-user-3"></i>
                &nbsp;Meu Perfil
            </a>
        </li>
    </ul>
</li>