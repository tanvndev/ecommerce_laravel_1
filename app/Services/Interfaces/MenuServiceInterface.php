<?php

namespace App\Services\Interfaces;

interface MenuServiceInterface
{
    public function save();
    public function destroy($id);
    public function updateStatus();
    public function updateStatusAll();
    public function saveChildrend($menu);
    public function getAndConvertMenu($menu);
    public function convertMenu($menuList);
    public function dragUpdate($json = [], $menuCatalogueId = 0, $parentId = 0);
    public function findMenuItemTranslate($menus, $languageId);
    public function saveTranslate($languageId = 0);
}
