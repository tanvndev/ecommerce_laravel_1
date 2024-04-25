<?php

namespace App\Http\ViewComposers;

use App\Repositories\Interfaces\SystemRepositoryInterface as SystemRepository;
use Illuminate\View\View;


class SystemComposer
{
    private $systemRepository;
    public function __construct()
    {
        $this->systemRepository = app(SystemRepository::class);
    }
    public function compose(View $view)
    {
        // dd(session('currentLanguage'));
        $systems = $this->systemRepository->findByWhere(
            [
                'language_id' => ['=', session('currentLanguage')]
            ],
            ['keyword', 'content'],
            [],
            true
        );
        $systemsArr = [];

        foreach ($systems as $system) {
            $systemsArr[$system->keyword] = $system->content;
        }
        $view->with('systemSetting', $systemsArr);
    }
}
