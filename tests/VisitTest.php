<?php

use Codecourse\LaravelPopularity\Tests\Models\Article;
use Codecourse\LaravelPopularity\Tests\Models\User;
use Illuminate\Support\Carbon;

it('creates a visit', function () {
    $article = Article::factory()->create();

    $article->visit();

    expect($article->visits->count())->toBe(1);
});

it('creates a visit with the default ip address', function () {
    $article = Article::factory()->create();

    $article->visit()->withIp();

    expect($article->visits->first()->data)->toMatchArray(['ip' => request()->ip()]);
});

it('creates a visit with the given ip address', function () {
    $article = Article::factory()->create();

    $article->visit()->withIp('cats');

    expect($article->visits->first()->data)->toMatchArray(['ip' => 'cats']);
});

it('creates a visit with custom data', function () {
    $article = Article::factory()->create();

    $article->visit()->withData([
        'cats' => true
    ]);

    expect($article->visits->first()->data)->toMatchArray(['cats' => true]);
});

it('creates a visit with the given user', function () {
    $user = new User(['id' => 1]);
    $article = Article::factory()->create();

    $article->visit()->withUser($user);

    expect($article->visits->first()->data)->toMatchArray(['user_id' => $user->id]);
});

it('does not add a user id if user is null', function () {
    $article = Article::factory()->create();

    $article->visit()->withUser(null);

    expect($article->visits->first()->data)->toBeEmpty();
});

it('does not create dupliate visits with the same data', function () {
    $article = Article::factory()->create();

    $article->visit()->withData([
        'cats' => true
    ]);

    $article->visit()->withData([
        'cats' => true
    ]);

    expect($article->visits->count())->toBe(1);
});

it('does not create visits within the timeframe', function () {
    $article = Article::factory()->create();

    Carbon::setTestNow(now()->subDays(2));
    $article->visit();

    Carbon::setTestNow();
    $article->visit();
    $article->visit();

    expect($article->visits->count())->toBe(2);
});

it('creates visits after a default daily timeframe', function () {
    $article = Article::factory()->create();

    $article->visit()->withIp();
    Carbon::setTestNow(now()->addDay()->addHour());
    $article->visit()->withIp();

    expect($article->visits->count())->toBe(2);
});

it('creates visits after a hourly timeframe', function () {
    $article = Article::factory()->create();

    $article->visit()->hourlyIntervals()->withIp();
    Carbon::setTestNow(now()->addHour()->addMinute());
    $article->visit()->hourlyIntervals()->withIp();

    expect($article->visits->count())->toBe(2);
});

it('creates visits after a daily timeframe', function () {
    $article = Article::factory()->create();

    $article->visit()->dailyInterval()->withIp();
    Carbon::setTestNow(now()->addDay());
    $article->visit()->dailyInterval()->withIp();

    expect($article->visits->count())->toBe(2);
});

it('creates visits after a weekly timeframe', function () {
    $article = Article::factory()->create();

    $article->visit()->weeklyInterval()->withIp();
    Carbon::setTestNow(now()->addWeek());
    $article->visit()->weeklyInterval()->withIp();

    expect($article->visits->count())->toBe(2);
});

it('creates visits after a monthly timeframe', function () {
    $article = Article::factory()->create();

    $article->visit()->monthlyInterval()->withIp();
    Carbon::setTestNow(now()->addMonth());
    $article->visit()->monthlyInterval()->withIp();

    expect($article->visits->count())->toBe(2);
});

it('creates visits after a custom timeframe', function () {
    $article = Article::factory()->create();

    $article->visit()->customInterval(now()->subYear())->withIp();
    Carbon::setTestNow(now()->addYear());
    $article->visit()->customInterval(now()->subYear())->withIp();

    expect($article->visits->count())->toBe(2);
});
