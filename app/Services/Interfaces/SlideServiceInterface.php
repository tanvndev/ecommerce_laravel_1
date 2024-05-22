<?php

namespace App\Services\Interfaces;

interface SlideServiceInterface
{
    public function paginate();
    public function create();
    public function update($id);
    public function destroy($id);
    public function updateStatus();
    public function updateStatusAll();
    public function convertSlidesToArray($slides = []);
    public function dragUpdate($data = []);
    public function getSlide($keyword = []);
}
