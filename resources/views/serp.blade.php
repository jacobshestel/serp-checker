<!doctype html>
<html lang="uk">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Google Organic Rank Checker</title>
    <style>
        :root { --gap: 12px; }
        body { font-family: system-ui, -apple-system, sans-serif; max-width: 760px; margin: 24px auto; padding: 0 12px; }
        form { display: grid; gap: var(--gap); margin-bottom: 24px; }
        label { font-weight: 600; display:block; margin-bottom: 6px; }
        input, select, button { padding: 10px; font-size: 16px; width: 100%; box-sizing: border-box; }
        .row { display: grid; gap: var(--gap); grid-template-columns: 1fr 1fr; }
        .card { border: 1px solid #ddd; padding: 16px; border-radius: 8px; }
        .muted { color: #666; font-size: 14px; }
        .error { color: #b00020; font-size: 14px; margin-top: 4px; }
        .hint { color: #666; font-size: 12px; margin-top: 4px; }
        .actions { display:flex; gap: var(--gap); align-items:center; }
        .small { font-size: 12px; }
    </style>
</head>
<body>
<h1>Перевірка рангу сайту у Google</h1>

<form method="POST" action="{{ route('search') }}" id="rankForm">
    @csrf

    <div>
        <label for="keyword">Пошукове слово</label>
        <input id="keyword" name="keyword" value="{{ old('keyword', $input['keyword'] ?? '') }}" placeholder="напр.: laravel framework" required autofocus>
        @error('keyword') <div class="error">{{ $message }}</div> @enderror
    </div>

    <div>
        <label for="site">Сайт (домен або URL)</label>
        <input id="site" name="site" type="text" required placeholder="напр.: example.com або https://example.com">
        @error('site') <div class="error">{{ $message }}</div> @enderror
        <div class="hint">Можна домен або повний URL. Ми самі приведемо до домену.</div>
    </div>

    <div class="row">
        <div>
            <label for="location">Локація</label>
            <input id="location" name="location" value="{{ old('location', $input['location'] ?? 'United States') }}" placeholder="напр.: Germany або United States" required>
            @error('location') <div class="error">{{ $message }}</div> @enderror
        </div>
        <div>
            <label for="language">Мова</label>
            <input id="language" name="language" value="{{ old('language', $input['language'] ?? 'English') }}" placeholder="напр.: English або German" required>
            @error('language') <div class="error">{{ $message }}</div> @enderror
        </div>
    </div>

    <div class="row">
        <div>
            <label for="se_domain">Пошуковий домен</label>
            <select id="se_domain" name="se_domain">
                @php $se = old('se_domain', $input['se_domain'] ?? 'google.com'); @endphp
                <option value="google.com" {{ $se==='google.com'?'selected':'' }}>google.com</option>
                <option value="google.de" {{ $se==='google.de'?'selected':'' }}>google.de</option>
                <option value="google.co.uk" {{ $se==='google.co.uk'?'selected':'' }}>google.co.uk</option>
                <option value="google.fr" {{ $se==='google.fr'?'selected':'' }}>google.fr</option>
            </select>
            <div class="hint">Обери дзеркало Google під ринок.</div>
        </div>
        <div>
            <label for="depth">Глибина (топ-N)</label>
            <input id="depth" name="depth" type="number" min="10" max="100" step="10" value="{{ old('depth', $input['depth'] ?? 50) }}">
            <div class="hint">Якщо не знаходить — збільш до 100 (повільніше).</div>
        </div>
    </div>

    <div class="actions">
        <button id="submitBtn" type="submit">Пошук</button>
        <span id="progress" class="muted small" aria-live="polite"></span>
    </div>
</form>

@isset($error)
    <div class="card" role="alert">
        <strong>Помилка API:</strong> {{ $error }}
        <div class="muted">Перевір доступ у .env, локацію/мову, домен Google або зменш глибину.</div>
    </div>
@endisset

<div id="results" aria-live="polite" aria-atomic="true">
    @isset($rank)
        <div class="card">
            <h3>Результат</h3>
            <p>Позиція сайту: <strong>{{ $rank }}</strong></p>
            @if(!empty($item))
                <p class="muted">URL: <a href="{{ $item['url'] ?? '#' }}" target="_blank" rel="noopener">{{ $item['url'] ?? '' }}</a></p>
                <p class="muted">Title: {{ $item['title'] ?? '' }}</p>
            @endif
        </div>
    @elseif(isset($input) && !isset($error))
        <div class="card">
            <strong>Сайт не знайдено у топ-100.</strong>
            <div class="muted">Спробуй інше ключове слово, іншу локацію/мову або збільш глибину.</div>
        </div>
    @endif
</div>

<script>
    (function(){
        const form = document.getElementById('rankForm');
        const btn = document.getElementById('submitBtn');
        const prog = document.getElementById('progress');
        form.addEventListener('submit', function(){
            btn.disabled = true;
            prog.textContent = 'Йде пошук…';
        });
    })();
</script>
</body>
</html>
