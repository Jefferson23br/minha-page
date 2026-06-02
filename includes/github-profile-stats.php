<?php

declare(strict_types=1);

function fetch_github_user(string $username): ?array
{
    $safeName = preg_replace('/[^a-zA-Z0-9_-]/', '', $username) ?: 'user';
    $cacheDir = __DIR__ . '/cache';
    $cacheFile = $cacheDir . '/github_user_' . $safeName . '.json';
    $ttl = 3600;

    if (is_readable($cacheFile) && (time() - filemtime($cacheFile)) < $ttl) {
        $cached = json_decode((string) file_get_contents($cacheFile), true);
        if (is_array($cached) && !empty($cached['login'])) {
            return $cached;
        }
    }

    $url = 'https://api.github.com/users/' . rawurlencode($username);
    $context = stream_context_create([
        'http' => [
            'method' => 'GET',
            'header' => "User-Agent: JeffersonLima-Portfolio\r\nAccept: application/vnd.github+json\r\n",
            'timeout' => 12,
            'ignore_errors' => true,
        ],
    ]);

    $body = @file_get_contents($url, false, $context);
    if ($body !== false) {
        $data = json_decode($body, true);
        if (is_array($data) && !empty($data['login'])) {
            if (!is_dir($cacheDir)) {
                @mkdir($cacheDir, 0755, true);
            }
            @file_put_contents($cacheFile, json_encode($data));
            return $data;
        }
    }

    if (is_readable($cacheFile)) {
        $stale = json_decode((string) file_get_contents($cacheFile), true);
        if (is_array($stale) && !empty($stale['login'])) {
            return $stale;
        }
    }

    return null;
}

function render_github_profile_stats(array $t, string $username = 'Jefferson23br'): void
{
    $user = fetch_github_user($username);
    $ariaLabel = $t['github_stats_alt'] ?? ('GitHub stats ' . $username);
    $profileUrl = 'https://github.com/' . rawurlencode($username);

    echo '<div class="github-profile" role="img" aria-label="' . e($ariaLabel) . '">';

    if ($user === null) {
        echo '<p class="github-profile__empty">' . e($t['github_stats_unavailable'] ?? 'Stats temporarily unavailable.') . '</p>';
        echo '<a href="' . e($profileUrl) . '" target="_blank" rel="noopener" class="github-profile__link">@' . e($username) . '</a>';
        echo '</div>';
        return;
    }

    $repos = (int) ($user['public_repos'] ?? 0);
    $followers = (int) ($user['followers'] ?? 0);
    $following = (int) ($user['following'] ?? 0);
    $login = (string) ($user['login'] ?? $username);
    $name = trim((string) ($user['name'] ?? ''));
    $avatar = (string) ($user['avatar_url'] ?? '');
    $sinceYear = '';
    if (!empty($user['created_at'])) {
        $sinceYear = date('Y', strtotime((string) $user['created_at']));
    }

    echo '<div class="github-profile__head">';
    if ($avatar !== '') {
        echo '<img class="github-profile__avatar" src="' . e($avatar) . '" alt="" width="64" height="64" loading="lazy" decoding="async">';
    }
    echo '<div class="github-profile__identity">';
    if ($name !== '') {
        echo '<span class="github-profile__name">' . e($name) . '</span>';
    }
    echo '<a href="' . e($profileUrl) . '" target="_blank" rel="noopener" class="github-profile__login">@' . e($login) . '</a>';
    echo '</div>';
    echo '</div>';

    echo '<dl class="github-profile__stats">';
    echo '<div class="github-profile__stat"><dt>' . e($t['github_stat_repos']) . '</dt><dd>' . e((string) $repos) . '</dd></div>';
    echo '<div class="github-profile__stat"><dt>' . e($t['github_stat_followers']) . '</dt><dd>' . e((string) $followers) . '</dd></div>';
    echo '<div class="github-profile__stat"><dt>' . e($t['github_stat_following']) . '</dt><dd>' . e((string) $following) . '</dd></div>';
    if ($sinceYear !== '') {
        echo '<div class="github-profile__stat"><dt>' . e($t['github_stat_since']) . '</dt><dd>' . e($sinceYear) . '</dd></div>';
    }
    echo '</dl>';
    echo '</div>';
}
