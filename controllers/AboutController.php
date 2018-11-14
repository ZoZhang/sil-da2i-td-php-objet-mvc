<?php
/**
 * Exercice Web TD2
 *
 * @author ZHANG Zhao
 * @email  zo.zhang@gmail.com
 * @site   td2.web.zhaozhang.fr
 */

namespace Film;

class AboutController extends \Film\AbstractsController
{
    protected static $_templates = [
        'header.phtml',
        'about.phtml',
        'footer.phtml'
    ];

    public static function getTitle()
    {
        return 'C\'test un exercice.';
    }
}