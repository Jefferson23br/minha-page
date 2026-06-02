<?php

declare(strict_types=1);

function github_api_get(string $url): ?array
{
    $context = stream_context_create([
        'http' => [
            'method' => 'GET',
            'header' => "User-Agent: JeffersonLima-Portfolio\r\nAccept: application/vnd.github+json\r\n",
            'timeout' => 12,
            'ignore_errors' => true,
        ],
    ]);

    $body = @file_get_contents($url, false, $context);
    if ($body === false) {
        return null;
    }

    $data = json_decode($body, true);
    return is_array($data) ? $data : null;
}

function github_language_color(string $language): string
{
    $colors = [
        'TypeScript' => '#3178c6',
        'JavaScript' => '#d4a72c',
        'PHP' => '#777bb4',
        'Kotlin' => '#a97bff',
        'Dart' => '#00b4ab',
        'C++' => '#f34b7d',
        'Python' => '#3572a5',
        'Java' => '#b07219',
        'HTML' => '#e34c26',
        'CSS' => '#563d7c',
        'Vue' => '#41b883',
        'Go' => '#00add8',
        'Rust' => '#dea584',
        'Ruby' => '#701516',
        'Shell' => '#89e051',
        'C#' => '#178600',
        'Swift' => '#f05138',
    ];

    return $colors[$language] ?? '#3b82f6';
}

function fetch_github_language_stats(string $username, int $maxRepos = 20): ?array
{
    $safeName = preg_replace('/[^a-zA-Z0-9_-]/', '', $username) ?: 'user';
    $cacheDir = __DIR__ . '/cache';
    $cacheFile = $cacheDir . '/github_langs_' . $safeName . '.json';
    $ttl = 21600;

    if (is_readable($cacheFile) && (time() - filemtime($cacheFile)) < $ttl) {
        $cached = json_decode((string) file_get_contents($cacheFile), true);
        if (is_array($cached) && !empty($cached)) {
            return $cached;
        }
    }

    $repos = github_api_get('https://api.github.com/users/' . rawurlencode($username) . '/repos?per_page=100&sort=pushed&type=owner');
    if ($repos === null) {
        return is_readable($cacheFile) ? json_decode((string) file_get_contents($cacheFile), true) : null;
    }

    usort($repos, static function (array $a, array $b): int {
        return strcmp((string) ($b['pushed_at'] ?? ''), (string) ($a['pushed_at'] ?? ''));
    });

    $totals = [];
    $checked = 0;

    foreach ($repos as $repo) {
        if ($checked >= $maxRepos) {
            break;
        }
        if (!empty($repo['fork'])) {
            continue;
        }
        $langUrl = (string) ($repo['languages_url'] ?? '');
        if ($langUrl === '') {
            continue;
        }
        $langData = github_api_get($langUrl);
        if ($langData === null) {
            continue;
        }
        foreach ($langData as $lang => $bytes) {
            $totals[$lang] = ($totals[$lang] ?? 0) + (int) $bytes;
        }
        $checked++;
    }

    if ($totals === []) {
        return is_readable($cacheFile) ? json_decode((string) file_get_contents($cacheFile), true) : null;
    }

    arsort($totals);

    if (!is_dir($cacheDir)) {
        @mkdir($cacheDir, 0755, true);
    }
    @file_put_contents($cacheFile, json_encode($totals));

    return $totals;
}

function render_github_languages(array $t, string $username = 'Jefferson23br'): void
{
    $langs = fetch_github_language_stats($username);
    $title = $t['github_langs_title'] ?? 'Languages';
    $ariaLabel = $t['github_langs_alt'] ?? $title;

    echo '<div class="github-langs" role="img" aria-label="' . e($ariaLabel) . '">';
    echo '<div class="github-card__heading">';
    echo '<span class="github-card__heading-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg></span>';
    echo '<h3 class="github-card__title">' . e($title) . '</h3>';
    echo '</div>';

    if ($langs === null || $langs === []) {
        echo '<p class="github-langs__empty">' . e($t['github_langs_unavailable'] ?? 'Languages unavailable.') . '</p>';
        echo '</div>';
        return;
    }

    $top = array_slice($langs, 0, 5, true);
    $totalBytes = array_sum($top);
    if ($totalBytes <= 0) {
        echo '<p class="github-langs__empty">' . e($t['github_langs_unavailable'] ?? 'Languages unavailable.') . '</p>';
        echo '</div>';
        return;
    }

    echo '<ul class="github-langs__list">';
    foreach ($top as $lang => $bytes) {
        $pct = max(4, (int) round(($bytes / $totalBytes) * 100));
        $color = github_language_color($lang);
        echo '<li class="github-langs__item">';
        echo '<div class="github-langs__row" style="--lang-color:' . e($color) . ';--lang-pct:' . e((string) $pct) . '%">';
        echo '<div class="github-langs__meta">';
        echo '<span class="github-langs__dot"></span>';
        echo '<span class="github-langs__name">' . e($lang) . '</span>';
        echo '<span class="github-langs__pct">' . e((string) $pct) . '%</span>';
        echo '</div>';
        echo '<div class="github-langs__track"><span class="github-langs__bar"></span></div>';
        echo '</div></li>';
    }
    echo '</ul>';
    echo '</div>';
}
