<?php

namespace App\Middleware\News;

class Article extends BaseNews
{
    use PostProcess, CustomView;
}
