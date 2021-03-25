/*
 Copyright (c) 2003-2020, CKSource - Frederico Knabben. All rights reserved.
 For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
*/
CKEDITOR.addTemplates('default', {
    imagesPath: CKEDITOR.getUrl(CKEDITOR.plugins.getPath("templates")+"templates/images/"),
    templates:
        [
            {
                title: 'Cx Rolagem M',
                image: 'template1.png',
                description: 'Caixa de Rolagem tamanho Médio para componentes',
                html: '<div class="cx_rolagem">\n' +
                    '    <div class="tt_cx_rolagem">&nbsp;</div>\n' +
                    '    <div class="cx-texto-rolagem-m">&nbsp;</div>\n' +
                    '</div>'
            },
            {
                title: 'Cx Rolagem M',
                image: 'template1.png',
                description: 'Caixa de Rolagem tamanho Grande para componentes',
                html: '<div class="cx_rolagem">\n' +
                    '    <div class="tt_cx_rolagem">&nbsp;</div>\n' +
                    '    <div class="cx-texto-rolagem-g">&nbsp;</div>\n' +
                    '</div>'
            },
        ]
});

CKEDITOR.editorConfig = function (config) {
    config.templates_replaceContent = false;
    config.allowedContent = true;
}


