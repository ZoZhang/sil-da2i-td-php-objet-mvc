<?php
/**
 * Exercice Web TD2
 *
 * @author ZHANG Zhao
 * @email  zo.zhang@gmail.com
 * @site   td2.web.zhaozhang.fr
 */

namespace Film;

class HomeController extends \Film\AbstractsController
{
    protected static $_templates = [
        'header.phtml',
        'home.phtml',
        'footer.phtml'
    ];

}