<?php
/**
 * Created by IntelliJ IDEA.
 * User: alexmedeiros
 * Date: 17/10/2016
 * Time: 13:13
 */


class TiposCampoEnum extends AbstractEnum
{
    const TEXT = 'text';
    const HIDDEN = 'hidden';
    const SELECT = 'select';
    const TEXTAREA = 'textarea';
    const FILE = 'file';
    const SINGLEFILE = 'singlefile';
    const RADIO = 'radio';
    const CHECKBOX = 'checkbox';
    const COLOR = 'color';
    const PASSWORD = 'password';

    protected static $descricao = [
        TiposCampoEnum::TEXT => 'Text',
        TiposCampoEnum::HIDDEN => 'Hidden',
        TiposCampoEnum::SELECT => 'Select',
        TiposCampoEnum::TEXTAREA => 'Textarea',
        TiposCampoEnum::FILE => 'File',
        TiposCampoEnum::SINGLEFILE => 'SingleFile',
        TiposCampoEnum::RADIO => 'Radio',
        TiposCampoEnum::CHECKBOX => 'Checkbox',
        TiposCampoEnum::COLOR => 'Color',
        TiposCampoEnum::PASSWORD => 'password',
    ];
}
