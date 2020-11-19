<?php


namespace source\App;

use Source\Core\Controller;
use Source\Models\User;

/**
 * JSON-PHP | Class Web
 *
 * @author Euclides Bernardo <euclidesquissembebernado@gmail.com>
 * @package source\App
 */
class Web extends Controller
{
    public function __construct()
    {
        parent::__construct(CONF_VIEW_PATH . CONF_VIEW_THEME);
    }

    public function home(): void
    {
        $head = $this->seo->render(
            CONF_SITE_NAME,
            CONF_SITE_DESC,
            url('/'),
            ''
        );

        echo $this->view->render('widgets/home/home', [
            'head' => 'Euclides'
        ]);
    }

    public function error(array $data): void
    {
        echo "${data['errCode']}";
    }
}
