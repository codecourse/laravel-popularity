<?php

use Codecourse\LaravelPopularity\Tests\Models\Article;
use Illuminate\Support\Carbon;

it('gets the total visit count', function () {
    $article = Article::factory()->create();

    $article->visit();

    $article = Article::withTotalVisitCount()->first();

    expect($article->visit_count_total)->toEqual(1);
});

it('get records by all time popularity', function () {
    Article::factory()->times(2)->create()->each->visit();

    $popularSeries = Article::factory()->create();
    Carbon::setTestNow(now()->subDays(2));
    $popularSeries->visit();
    Carbon::setTestNow();
    $popularSeries->visit();

    $article = Article::latest()->popularAllTime()->get();

    expect($article->count())->toBe(3);
    expect($article->first()->visit_count_total)->toEqual(2);
});

it('gets popular records between two dates', function () {
    $article = Article::factory()->times(2)->create();

    Carbon::setTestNow(Carbon::createFromDate(1989, 11, 16));
    $article[0]->visit();

    Carbon::setTestNow();
    $article[0]->visit();
    $article[1]->visit();

    $article = Article::popularBetween(Carbon::createFromDate(1989, 11, 15), Carbon::createFromDate(1989, 11, 17))->get();

    expect($article->count())->toBe(1);
    expect($article[0]->visit_count)->toEqual(1);
});

it('gets popular records by the last x days', function () {
    $article = Article::factory()->times(2)->create();

    Carbon::setTestNow(now()->subDays(4));
    $article[0]->visit();

    Carbon::setTestNow();
    $article[1]->visit();

    $article = Article::popularLastDays(2)->get();

    expect($article->count())->toBe(1);
});

it('gets popular records by the last week', function () {
    $article = Article::factory()->times(2)->create();

    Carbon::setTestNow(now()->subDays(7)->startOfWeek());
    $article[0]->visit();

    Carbon::setTestNow();
    $article[1]->visit();

    $article = Article::popularLastWeek()->get();

    expect($article->count())->toBe(1);
});

it('gets popular records by this week', function () {
    $article = Article::factory()->times(2)->create();

    Carbon::setTestNow(now()->subWeek()->subDay());
    $article[0]->visit();

    Carbon::setTestNow();
    $article[1]->visit();

    $article = Article::popularThisWeek()->get();

    expect($article->count())->toBe(1);
});

it('gets popular records by this month', function () {
    $article = Article::factory()->times(2)->create();

    Carbon::setTestNow(now()->subMonth()->subDay());
    $article[0]->visit();

    Carbon::setTestNow();
    $article[1]->visit();

    $article = Article::popularThisMonth()->get();

    expect($article->count())->toBe(1);
});

it('gets popular records by last month', function () {
    $article = Article::factory()->times(2)->create();

    Carbon::setTestNow(now()->subMonth()->startOfMonth());
    $article[0]->visit();

    Carbon::setTestNow();
    $article[1]->visit();

    $article = Article::popularLastMonth()->get();

    expect($article->count())->toBe(1);
});

it('gets popular records by this year', function () {
    $article = Article::factory()->times(2)->create();

    Carbon::setTestNow(now()->subYear()->subDay());
    $article[0]->visit();

    Carbon::setTestNow();
    $article[1]->visit();

    $article = Article::popularThisYear()->get();

    expect($article->count())->toBe(1);
});

it('gets popular records by last year', function () {
    $article = Article::factory()->times(2)->create();

    Carbon::setTestNow(now()->subYear()->startOfYear());
    $article[0]->visit();

    Carbon::setTestNow();
    $article[1]->visit();

    $article = Article::popularLastYear()->get();

    expect($article->count())->toBe(1);
});
