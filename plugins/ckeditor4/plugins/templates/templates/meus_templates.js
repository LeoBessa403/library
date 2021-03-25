/**
 * @license Copyright (c) 2003-2020, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

var home = $("#home").attr('data-val');

// Register a templates definition set named "default".
CKEDITOR.addTemplates('default', {
    // The name of sub folder which hold the shortcut preview images of the
    // templates.
    imagesPath: home + 'library/plugins/ckeditor4/plugins/templates/templates/images/',

    // The templates definitions.
    templates:
        [
            {
                title: 'Cx Conceito',
                image: 'template1.gif',
                description: 'Caixa de Rolagem tamanho Pequena para componentes',
                html: '<div class="cx_rolagem">\n' +
                    '    <div class="cx-texto-rolagem-lv bg-color-3 paragrafo">&nbsp;</div>\n' +
                    '</div>'
            },
            {
                title: 'Cx Rolagem Livre',
                image: 'template1.gif',
                description: 'Caixa de Rolagem tamanho Livre para componentes',
                html: '<div class="cx_rolagem">\n' +
                    '    <div class="tt_cx_rolagem2">&nbsp;</div>\n' +
                    '    <div class="cx-texto-rolagem-lv bg-color-3 paragrafo">&nbsp;</div>\n' +
                    '</div>'
            },
            {
                title: 'Cx Rolagem Pequena',
                image: 'template1.gif',
                description: 'Caixa de Rolagem tamanho Pequena para componentes',
                html: '<div class="cx_rolagem">\n' +
                    '    <div class="tt_cx_rolagem">&nbsp;</div>\n' +
                    '    <div class="cx-texto-rolagem-p bg-color-3 paragrafo">&nbsp;</div>\n' +
                    '</div>'
            },
            {
                title: 'Cx Rolagem Média',
                image: 'template1.gif',
                description: 'Caixa de Rolagem tamanho Médio para componentes',
                html: '<div class="cx_rolagem">\n' +
                    '    <div class="tt_cx_rolagem">&nbsp;</div>\n' +
                    '    <div class="cx-texto-rolagem-m bg-color-3 paragrafo">&nbsp;</div>\n' +
                    '</div>'
            },
            {
                title: 'Cx Rolagem Grande',
                image: 'template1.gif',
                description: 'Caixa de Rolagem tamanho Grande para componentes',
                html: '<div class="cx_rolagem">\n' +
                    '    <div class="tt_cx_rolagem">&nbsp;</div>\n' +
                    '    <div class="cx-texto-rolagem-g paragrafo">&nbsp;</div>\n' +
                    '</div>'
            },
            {
                title: 'Cx Exercício Total',
                image: 'template1.gif',
                description: 'Caixa de Rolagem tamanho Grande para componentes',
                html: '<div class="cx-exer-total">\n' +
                    '    <h3>Título do Exercício</h3>\n' +
                    '    <div class="cx-texto-rolagem-g paragrafo">Questões aqui</div>\n' +
                    '</div>'
            },
            {
                title: 'Cx Lateral Cor 2',
                image: 'template1.gif',
                description: 'Caixa de Rolagem Lateral',
                html: '<div class="img-lat">' +
                    '       <div class="clique total10"></div>' +
                    '           <div class="body-img-lat bg-color-2">' +
                    '               <p>Conteúdo aqui</p>' +
                    '           </div>' +
                    '       <div class="voltar voltarDepois"></div>' +
                    '</div>'
            },
            {
                title: 'Cx Lateral Cor 3',
                image: 'template1.gif',
                description: 'Caixa de Rolagem Lateral',
                html: '<div class="img-lat">' +
                    '       <div class="clique total10"></div>' +
                    '           <div class="body-img-lat bg-color-3 paragrafo">' +
                    '               <p>Conteúdo aqui</p>' +
                    '           </div>' +
                    '       <div class="voltar voltarDepois"></div>' +
                    '</div>'
            },
            {
                title: 'Cx Acordeon Médio',
                image: 'template1.gif',
                description: 'Caixa de Acordeon com 4 Abas',
                html: '<div class="accordion accordion-p">' +
                    '        <h3><a class="link-acordeon bg-color-1">Aba 1</a></h3>' +
                    '        <div class="cx-texto-rolagem-p bg-color-cinza">' +
                    '            <p>Conteudo Aba 1</p>' +
                    '        </div>' +
                    '        <h3><a class="link-acordeon bg-color-1">Aba 2</a></h3>' +
                    '        <div class="cx-texto-rolagem-p bg-color-cinza">' +
                    '            <p>Conteudo Aba 2</p>' +
                    '        </div>' +
                    '        <h3><a class="link-acordeon bg-color-1">Aba 3</a></h3>' +
                    '        <div class="cx-texto-rolagem-p bg-color-cinza">' +
                    '            <p>Conteudo Aba 3</p>' +
                    '        </div>' +
                    '        <h3><a class="link-acordeon bg-color-1">Aba 4</a></h3>' +
                    '        <div class="cx-texto-rolagem-p bg-color-cinza">' +
                    '            <p>Conteudo Aba 4</p>' +
                    '        </div>' +
                    '</div>'
            },
            {
                title: 'Cx Acordeon Grande',
                image: 'template1.gif',
                description: 'Caixa de Acordeon com 8 Abas',
                html: '<div class="accordion accordion-m">' +
                    '        <h3><a class="link-acordeon bg-color-1">Aba 1</a></h3>' +
                    '        <div class="cx-texto-rolagem-p bg-color-cinza">' +
                    '            <p>Conteudo Aba 1</p>' +
                    '        </div>' +
                    '        <h3><a class="link-acordeon bg-color-1">Aba 2</a></h3>' +
                    '        <div class="cx-texto-rolagem-p bg-color-cinza">' +
                    '            <p>Conteudo Aba 2</p>' +
                    '        </div>' +
                    '        <h3><a class="link-acordeon bg-color-1">Aba 3</a></h3>' +
                    '        <div class="cx-texto-rolagem-p bg-color-cinza">' +
                    '            <p>Conteudo Aba 3</p>' +
                    '        </div>' +
                    '        <h3><a class="link-acordeon bg-color-1">Aba 4</a></h3>' +
                    '        <div class="cx-texto-rolagem-p bg-color-cinza">' +
                    '            <p>Conteudo Aba 4</p>' +
                    '        </div>' +
                    '        <h3><a class="link-acordeon bg-color-1">Aba 5</a></h3>' +
                    '        <div class="cx-texto-rolagem-p bg-color-cinza">' +
                    '            <p>Conteudo Aba 5</p>' +
                    '        </div>' +
                    '        <h3><a class="link-acordeon bg-color-1">Aba 6</a></h3>' +
                    '        <div class="cx-texto-rolagem-p bg-color-cinza">' +
                    '            <p>Conteudo Aba 6</p>' +
                    '        </div>' +
                    '        <h3><a class="link-acordeon bg-color-1">Aba 7</a></h3>' +
                    '        <div class="cx-texto-rolagem-p bg-color-cinza">' +
                    '            <p>Conteudo Aba 7</p>' +
                    '        </div>' +
                    '        <h3><a class="link-acordeon bg-color-1">Aba 8</a></h3>' +
                    '        <div class="cx-texto-rolagem-p bg-color-cinza">' +
                    '            <p>Conteudo Aba 8</p>' +
                    '        </div>' +
                    '</div>'
            },
        ]
});
