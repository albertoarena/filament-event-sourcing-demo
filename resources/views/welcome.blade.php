<!doctype html>
<html lang="en" class="antialiased">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Filament Event Sourcing — Demo</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            font-family: -apple-system, "SF Pro Display", "Inter", "Segoe UI", system-ui, sans-serif;
            color: #f8fafc;
            background:
                radial-gradient(900px 600px at 85% -10%, rgba(245, 158, 11, 0.22), transparent 60%),
                radial-gradient(800px 700px at 110% 120%, rgba(59, 130, 246, 0.16), transparent 55%),
                linear-gradient(135deg, #0b1120 0%, #111827 55%, #0b1324 100%);
        }

        body::before {
            content: "";
            position: fixed;
            inset: 0;
            background-image:
                linear-gradient(rgba(148, 163, 184, 0.06) 1px, transparent 1px),
                linear-gradient(90deg, rgba(148, 163, 184, 0.06) 1px, transparent 1px);
            background-size: 48px 48px;
            mask-image: radial-gradient(1100px 700px at 40% 30%, black, transparent 80%);
            pointer-events: none;
        }

        .card {
            position: relative;
            max-width: 620px;
            text-align: center;
        }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-size: 0.8125rem;
            font-weight: 700;
            letter-spacing: 0.22em;
            text-transform: uppercase;
            color: #fbbf24;
            margin-bottom: 1.5rem;
        }
        .eyebrow .dot {
            width: 9px; height: 9px; border-radius: 999px;
            background: #fbbf24;
            box-shadow: 0 0 16px 2px rgba(251, 191, 36, 0.8);
        }

        h1 {
            font-size: clamp(2.5rem, 6vw, 3.75rem);
            line-height: 1.05;
            font-weight: 800;
            letter-spacing: -0.03em;
        }
        h1 .accent {
            background: linear-gradient(95deg, #fcd34d, #f59e0b);
            -webkit-background-clip: text; background-clip: text; color: transparent;
        }

        p.lead {
            margin: 1.5rem auto 0;
            max-width: 480px;
            font-size: 1.1875rem;
            line-height: 1.6;
            color: #cbd5e1;
        }

        .cta {
            display: inline-flex;
            align-items: center;
            gap: 0.625rem;
            margin-top: 2.5rem;
            padding: 0.875rem 1.75rem;
            border-radius: 0.75rem;
            font-size: 1.0625rem;
            font-weight: 700;
            color: #1f1300;
            text-decoration: none;
            background: linear-gradient(95deg, #fcd34d, #f59e0b);
            box-shadow: 0 12px 30px -10px rgba(245, 158, 11, 0.6);
            transition: transform 0.15s ease, box-shadow 0.15s ease;
        }
        .cta:hover {
            transform: translateY(-2px);
            box-shadow: 0 18px 38px -12px rgba(245, 158, 11, 0.7);
        }
        .cta svg { width: 1.125rem; height: 1.125rem; }

        .creds {
            margin-top: 1.5rem;
            font-size: 0.9375rem;
            color: #94a3b8;
        }
        .creds code {
            font-family: ui-monospace, SFMono-Regular, Menlo, monospace;
            color: #fcd34d;
            background: rgba(148, 163, 184, 0.12);
            border: 1px solid rgba(148, 163, 184, 0.2);
            padding: 0.125rem 0.4375rem;
            border-radius: 0.375rem;
        }

        .chips {
            margin-top: 2.5rem;
            display: flex;
            flex-wrap: wrap;
            gap: 0.625rem;
            justify-content: center;
        }
        .chip {
            font-size: 0.875rem;
            font-weight: 600;
            color: #e2e8f0;
            padding: 0.5rem 0.875rem;
            border-radius: 999px;
            background: rgba(148, 163, 184, 0.12);
            border: 1px solid rgba(148, 163, 184, 0.22);
        }
        .chip b { color: #fbbf24; font-weight: 700; }

        .repo {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            margin-top: 2.5rem;
            font-size: 0.9375rem;
            font-weight: 600;
            color: #94a3b8;
            text-decoration: none;
            transition: color 0.15s ease;
        }
        .repo:hover { color: #f8fafc; }
        .repo svg { width: 1.125rem; height: 1.125rem; }
    </style>
</head>
<body>
    <main class="card">
        <div class="eyebrow"><span class="dot"></span> Filament Plugin Demo</div>

        <h1>Filament <span class="accent">Event Sourcing</span></h1>

        <p class="lead">
            A live demo of spatie/laravel-event-sourcing bridged into a Filament
            panel — browse stored events, inspect per-record history, and replay projectors.
        </p>

        <a class="cta" href="{{ url('/admin/login') }}">
            Log in to the demo
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M3 10a.75.75 0 0 1 .75-.75h10.638L10.23 5.29a.75.75 0 1 1 1.04-1.08l5.5 5.25a.75.75 0 0 1 0 1.08l-5.5 5.25a.75.75 0 1 1-1.04-1.08l4.158-3.96H3.75A.75.75 0 0 1 3 10Z" clip-rule="evenodd" />
            </svg>
        </a>

        <p class="creds">
            Demo login — <code>demo@example.com</code> / <code>password</code>
        </p>

        <div class="chips">
            <span class="chip"><b>›</b> Event history</span>
            <span class="chip"><b>›</b> Stored events</span>
            <span class="chip"><b>›</b> Projector replay</span>
        </div>

        <div>
            <a class="repo" href="https://github.com/albertoarena/filament-event-sourcing" target="_blank" rel="noopener">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0 1 12 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.02 10.02 0 0 0 22 12.017C22 6.484 17.523 2 12 2Z" clip-rule="evenodd" />
                </svg>
                View the plugin on GitHub
            </a>
        </div>
    </main>
</body>
</html>
