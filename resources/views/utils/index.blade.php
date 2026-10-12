@extends('layouts.app')

@section('content_container_class', 'max-w-5xl')

@section('title', 'Free Online Developer Tools ⚡ | JSON, Base64, Cron, Diff, JWT, URL')
@section('meta_description', 'Fast, 100% private developer utilities running completely in your browser. JSON Formatter, Base64 Encoder/Decoder, Cron Parser, Code Diff, JWT Debugger, and URL Parser.')
@section('meta_keywords', 'json formatter, json validator, base64 decode, base64 encode, cron expression generator, crontab explainer, text diff checker, code compare, jwt debugger, jwt decode, url parser, developer tools, free online tools, brokolidev')
@section('canonical_url', 'https://brokolidev.com/utils')

@section('og_title', 'Free Online Developer Tools ⚡ - 100% Client-Side Private')
@section('og_description', 'Fast, privacy-first developer utilities running 100% inside your browser. No server uploads, zero logs, pure speed.')

@section('json_ld')
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'WebApplication',
    'name' => 'DevUtils - Free Online Developer Tools',
    'url' => 'https://brokolidev.com/utils',
    'applicationCategory' => 'DeveloperApplication',
    'operatingSystem' => 'All',
    'browserRequirements' => 'Requires JavaScript. Requires HTML5.',
    'offers' => [
        '@type' => 'Offer',
        'price' => '0',
        'priceCurrency' => 'USD',
    ],
    'description' => 'Fast, 100% private developer utilities running completely inside your browser. JSON Formatter, Base64 Encoder/Decoder, Cron Parser, Code Diff, JWT Debugger, URL Parser.',
], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) !!}
</script>
@endsection

@section('contents')
<div class="mx-auto max-w-7xl px-4 sm:px-8 lg:px-12 mt-6 sm:mt-10 pb-20">
    <div class="mx-auto max-w-5xl">

        <!-- Header / Hero Section -->
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-zinc-900 dark:text-zinc-100 font-heading">
                Developer Utilities <span class="text-amber-500">⚡</span>
            </h1>

            <!-- Category Tab Bar (Catalyst Style Navigation) -->
            <div class="mt-6 flex items-center gap-1.5 overflow-x-auto pb-3 no-scrollbar border-b border-zinc-200 dark:border-zinc-800" id="toolTabBar">
                <a href="#json" onclick="switchTool('json'); return false;" id="tab-json" class="tool-tab px-3.5 py-2 rounded-xl text-xs font-semibold bg-white dark:bg-zinc-800 text-teal-700 dark:text-teal-300 shadow-xs border border-zinc-200 dark:border-zinc-700 flex items-center gap-2 shrink-0 transition-all duration-200">
                    <i class="fas fa-code"></i>
                    <span>JSON Formatter</span>
                </a>
                <a href="#base64" onclick="switchTool('base64'); return false;" id="tab-base64" class="tool-tab px-3.5 py-2 rounded-xl text-xs font-medium text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-100 hover:bg-zinc-100 dark:hover:bg-zinc-800/60 flex items-center gap-2 shrink-0 transition-all duration-200">
                    <i class="fas fa-font"></i>
                    <span>Base64</span>
                </a>
                <a href="#cron" onclick="switchTool('cron'); return false;" id="tab-cron" class="tool-tab px-3.5 py-2 rounded-xl text-xs font-medium text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-100 hover:bg-zinc-100 dark:hover:bg-zinc-800/60 flex items-center gap-2 shrink-0 transition-all duration-200">
                    <i class="fas fa-clock"></i>
                    <span>Cron Explainer</span>
                </a>
                <a href="#diff" onclick="switchTool('diff'); return false;" id="tab-diff" class="tool-tab px-3.5 py-2 rounded-xl text-xs font-medium text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-100 hover:bg-zinc-100 dark:hover:bg-zinc-800/60 flex items-center gap-2 shrink-0 transition-all duration-200">
                    <i class="fas fa-columns"></i>
                    <span>Diff Checker</span>
                </a>
                <a href="#jwt" onclick="switchTool('jwt'); return false;" id="tab-jwt" class="tool-tab px-3.5 py-2 rounded-xl text-xs font-medium text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-100 hover:bg-zinc-100 dark:hover:bg-zinc-800/60 flex items-center gap-2 shrink-0 transition-all duration-200">
                    <i class="fas fa-key"></i>
                    <span>JWT Debugger</span>
                </a>
                <a href="#url" onclick="switchTool('url'); return false;" id="tab-url" class="tool-tab px-3.5 py-2 rounded-xl text-xs font-medium text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-100 hover:bg-zinc-100 dark:hover:bg-zinc-800/60 flex items-center gap-2 shrink-0 transition-all duration-200">
                    <i class="fas fa-link"></i>
                    <span>URL & Query Parser</span>
                </a>
            </div>
        </div>

                <!-- TOOL 1: JSON Formatter & Minifier -->
                <div id="panel-json" class="tool-panel py-6 space-y-4">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <div>
                            <h2 class="text-lg font-bold text-zinc-900 dark:text-zinc-100 flex items-center gap-2">
                                <span>JSON Formatter & Validator</span>
                            </h2>
                            <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-0.5">Prettify, validate syntax, unescape, or compress JSON data instantly.</p>
                        </div>
                        <div class="flex flex-wrap items-center gap-1.5">
                            <button onclick="formatJSON(2)" class="px-2.5 py-1.5 rounded-lg text-xs font-medium bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 hover:bg-zinc-200 dark:hover:bg-zinc-700 transition">2 Spaces</button>
                            <button onclick="formatJSON(4)" class="px-2.5 py-1.5 rounded-lg text-xs font-medium bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 hover:bg-zinc-200 dark:hover:bg-zinc-700 transition">4 Spaces</button>
                            <button onclick="minifyJSON()" class="px-2.5 py-1.5 rounded-lg text-xs font-medium bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 hover:bg-zinc-200 dark:hover:bg-zinc-700 transition">Minify</button>
                            <button onclick="loadSampleJSON()" class="px-2.5 py-1.5 rounded-lg text-xs font-medium bg-teal-50 dark:bg-teal-950/60 text-teal-700 dark:text-teal-300 hover:bg-teal-100 transition">Sample</button>
                            <button onclick="clearJSON()" class="px-2.5 py-1.5 rounded-lg text-xs font-medium bg-zinc-100 dark:bg-zinc-800 text-zinc-500 hover:text-rose-600 transition">Clear</button>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                        <div>
                            <div class="flex items-center justify-between text-xs text-zinc-500 dark:text-zinc-400 mb-1.5">
                                <span>Input Raw JSON:</span>
                                <span id="json-input-stats">0 chars</span>
                            </div>
                            <textarea id="json-input" rows="16" placeholder="Paste your raw JSON string here..."
                                class="w-full font-mono text-xs p-3.5 rounded-xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 focus:border-teal-500 focus:ring-1 focus:ring-teal-500 text-zinc-900 dark:text-zinc-100 outline-none resize-y leading-relaxed transition shadow-2xs"
                                oninput="validateJSONLive()"></textarea>
                        </div>
                        <div>
                            <div class="flex items-center justify-between text-xs text-zinc-500 dark:text-zinc-400 mb-1.5">
                                <span id="json-status" class="inline-flex items-center gap-1 font-semibold text-zinc-500">
                                    <span class="w-1.5 h-1.5 rounded-full bg-zinc-400"></span> Ready
                                </span>
                                <button onclick="copyToClipboard('json-output')" class="text-teal-600 dark:text-teal-400 hover:underline flex items-center gap-1">
                                    <i class="far fa-copy text-xs"></i> Copy Output
                                </button>
                            </div>
                            <textarea id="json-output" rows="16" readonly placeholder="Formatted clean JSON will appear here..."
                                class="w-full font-mono text-xs p-3.5 rounded-xl bg-zinc-50 dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800 text-zinc-800 dark:text-zinc-200 outline-none resize-y leading-relaxed shadow-2xs"></textarea>
                        </div>
                    </div>
                </div>

                <!-- TOOL 2: Base64 Encoder / Decoder -->
                <div id="panel-base64" class="tool-panel py-6 space-y-4 hidden">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <div>
                            <h2 class="text-lg font-bold text-zinc-900 dark:text-zinc-100">Base64 Encoder & Decoder</h2>
                            <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-0.5">Encode plain text to Base64 or decode Base64 strings with live preview.</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <label class="inline-flex items-center gap-1.5 text-xs text-zinc-600 dark:text-zinc-400 cursor-pointer">
                                <input type="checkbox" id="b64-urlsafe" class="rounded text-teal-600 focus:ring-teal-500" onchange="runBase64()">
                                <span>URL-Safe (-_)</span>
                            </label>
                            <div class="inline-flex p-0.5 rounded-lg bg-zinc-100 dark:bg-zinc-800 text-xs">
                                <button onclick="setBase64Mode('encode')" id="b64-btn-encode" class="px-3 py-1 rounded-md font-semibold bg-white dark:bg-zinc-900 text-zinc-900 dark:text-zinc-100 shadow-xs">Encode</button>
                                <button onclick="setBase64Mode('decode')" id="b64-btn-decode" class="px-3 py-1 rounded-md font-medium text-zinc-600 dark:text-zinc-400 hover:text-zinc-900">Decode</button>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                        <div>
                            <div class="flex items-center justify-between text-xs text-zinc-500 dark:text-zinc-400 mb-1.5">
                                <span id="b64-input-label">Text to Encode:</span>
                                <button onclick="clearBase64()" class="text-zinc-400 hover:text-zinc-600">Clear</button>
                            </div>
                            <textarea id="b64-input" rows="12" placeholder="Enter text here..."
                                class="w-full font-mono text-xs p-3.5 rounded-xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 focus:border-teal-500 focus:ring-1 focus:ring-teal-500 text-zinc-900 dark:text-zinc-100 outline-none resize-y shadow-2xs"
                                oninput="runBase64()"></textarea>
                        </div>
                        <div>
                            <div class="flex items-center justify-between text-xs text-zinc-500 dark:text-zinc-400 mb-1.5">
                                <span id="b64-output-label">Base64 Output:</span>
                                <button onclick="copyToClipboard('b64-output')" class="text-teal-600 dark:text-teal-400 hover:underline flex items-center gap-1">
                                    <i class="far fa-copy text-xs"></i> Copy
                                </button>
                            </div>
                            <textarea id="b64-output" rows="12" readonly placeholder="Output will appear here..."
                                class="w-full font-mono text-xs p-3.5 rounded-xl bg-zinc-50 dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800 text-zinc-800 dark:text-zinc-200 outline-none resize-y shadow-2xs"></textarea>
                        </div>
                    </div>

                    <!-- Image Preview Container (if data:image is detected) -->
                    <div id="b64-image-preview-box" class="hidden p-4 rounded-xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900">
                        <div class="text-xs font-semibold text-zinc-600 dark:text-zinc-400 mb-2">Detected Image Preview:</div>
                        <img id="b64-image-preview" src="" alt="Decoded preview" class="max-h-48 rounded-lg border border-zinc-100 dark:border-zinc-800 object-contain mx-auto" />
                    </div>
                </div>

                <!-- TOOL 3: Cron Expression Explainer -->
                <div id="panel-cron" class="tool-panel py-6 space-y-5 hidden">
                    <div>
                        <h2 class="text-lg font-bold text-zinc-900 dark:text-zinc-100">Cron Expression Explainer & Generator</h2>
                        <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-0.5">Parse 5-field cron syntax into human-readable English and calculate upcoming execution schedules.</p>
                    </div>

                    <!-- Cron Input Bar -->
                    <div class="p-4 rounded-2xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 shadow-2xs space-y-4">
                        <div>
                            <label class="block text-xs font-semibold text-zinc-700 dark:text-zinc-300 uppercase tracking-wider mb-1.5">Cron Syntax (Minute Hour Day-of-Month Month Day-of-Week):</label>
                            <input type="text" id="cron-input" value="*/15 * * * *" oninput="parseCronLive()"
                                class="w-full font-mono text-base sm:text-lg px-4 py-2.5 rounded-xl bg-zinc-50 dark:bg-zinc-950 border border-zinc-300 dark:border-zinc-700 text-teal-600 dark:text-teal-400 font-bold tracking-wider outline-none focus:border-teal-500 focus:ring-1 focus:ring-teal-500 transition">
                        </div>

                        <!-- Quick Presets -->
                        <div class="flex flex-wrap items-center gap-1.5 pt-2 border-t border-zinc-100 dark:border-zinc-800">
                            <span class="text-xs text-zinc-400 font-medium mr-1">Presets:</span>
                            <button onclick="setCronPreset('*/5 * * * *')" class="px-2.5 py-1 rounded-md text-xs bg-zinc-100 dark:bg-zinc-800 hover:bg-teal-50 dark:hover:bg-teal-950/60 hover:text-teal-600 text-zinc-700 dark:text-zinc-300 transition">Every 5m</button>
                            <button onclick="setCronPreset('0 * * * *')" class="px-2.5 py-1 rounded-md text-xs bg-zinc-100 dark:bg-zinc-800 hover:bg-teal-50 dark:hover:bg-teal-950/60 hover:text-teal-600 text-zinc-700 dark:text-zinc-300 transition">Hourly</button>
                            <button onclick="setCronPreset('0 0 * * *')" class="px-2.5 py-1 rounded-md text-xs bg-zinc-100 dark:bg-zinc-800 hover:bg-teal-50 dark:hover:bg-teal-950/60 hover:text-teal-600 text-zinc-700 dark:text-zinc-300 transition">Daily Midnight</button>
                            <button onclick="setCronPreset('0 9 * * 1-5')" class="px-2.5 py-1 rounded-md text-xs bg-zinc-100 dark:bg-zinc-800 hover:bg-teal-50 dark:hover:bg-teal-950/60 hover:text-teal-600 text-zinc-700 dark:text-zinc-300 transition">Weekdays 9 AM</button>
                            <button onclick="setCronPreset('0 0 * * 0')" class="px-2.5 py-1 rounded-md text-xs bg-zinc-100 dark:bg-zinc-800 hover:bg-teal-50 dark:hover:bg-teal-950/60 hover:text-teal-600 text-zinc-700 dark:text-zinc-300 transition">Weekly Sunday</button>
                            <button onclick="setCronPreset('0 0 1 * *')" class="px-2.5 py-1 rounded-md text-xs bg-zinc-100 dark:bg-zinc-800 hover:bg-teal-50 dark:hover:bg-teal-950/60 hover:text-teal-600 text-zinc-700 dark:text-zinc-300 transition">Monthly 1st</button>
                        </div>
                    </div>

                    <!-- Human Readable Translation -->
                    <div class="p-5 rounded-2xl bg-teal-50/70 dark:bg-teal-950/30 border border-teal-200/80 dark:border-teal-800/60 flex items-start gap-3 shadow-2xs">
                        <div class="w-8 h-8 rounded-lg bg-teal-600 text-white flex items-center justify-center font-bold text-sm shrink-0 mt-0.5">
                            <i class="fas fa-quote-left text-xs"></i>
                        </div>
                        <div>
                            <div class="text-xs font-semibold text-teal-800 dark:text-teal-300 uppercase tracking-wider">Human Meaning:</div>
                            <div id="cron-human-text" class="text-base sm:text-lg font-bold text-zinc-900 dark:text-zinc-100 mt-0.5">
                                Every 15 minutes
                            </div>
                        </div>
                    </div>

                    <!-- Next 5 Scheduled Runs -->
                    <div class="p-5 rounded-2xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 shadow-2xs">
                        <h3 class="text-xs font-semibold text-zinc-500 uppercase tracking-wider mb-3">Next 5 Calculated Triggers:</h3>
                        <ul id="cron-next-runs" class="space-y-2 text-xs font-mono text-zinc-700 dark:text-zinc-300">
                            <!-- Populated dynamically -->
                        </ul>
                    </div>
                </div>

                <!-- TOOL 4: Code & Text Diff Checker -->
                <div id="panel-diff" class="tool-panel py-6 space-y-4 hidden">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <div>
                            <h2 class="text-lg font-bold text-zinc-900 dark:text-zinc-100">Code & Text Diff Checker</h2>
                            <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-0.5">Compare two blocks of code or text to spot additions, deletions, and modifications.</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <button onclick="loadSampleDiff()" class="px-2.5 py-1.5 rounded-lg text-xs font-medium bg-teal-50 dark:bg-teal-950/60 text-teal-700 dark:text-teal-300 hover:bg-teal-100 transition">Sample</button>
                            <button onclick="swapDiff()" class="px-2.5 py-1.5 rounded-lg text-xs font-medium bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 hover:bg-zinc-200 transition">Swap</button>
                            <button onclick="clearDiff()" class="px-2.5 py-1.5 rounded-lg text-xs font-medium bg-zinc-100 dark:bg-zinc-800 text-zinc-500 hover:text-rose-600 transition">Clear</button>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-zinc-500 mb-1.5">Original (Before):</label>
                            <textarea id="diff-original" rows="10" placeholder="Paste original text..."
                                class="w-full font-mono text-xs p-3.5 rounded-xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 text-zinc-900 dark:text-zinc-100 outline-none resize-y shadow-2xs"
                                oninput="computeDiffLive()"></textarea>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-zinc-500 mb-1.5">Modified (After):</label>
                            <textarea id="diff-modified" rows="10" placeholder="Paste modified text..."
                                class="w-full font-mono text-xs p-3.5 rounded-xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 text-zinc-900 dark:text-zinc-100 outline-none resize-y shadow-2xs"
                                oninput="computeDiffLive()"></textarea>
                        </div>
                    </div>

                    <!-- Visual Diff Output Display -->
                    <div class="p-5 rounded-2xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 shadow-2xs space-y-3">
                        <div class="flex items-center justify-between text-xs text-zinc-500 border-b border-zinc-100 dark:border-zinc-800 pb-2">
                            <span class="font-semibold uppercase tracking-wider">Visual Difference Analysis:</span>
                            <span id="diff-stats" class="font-mono">Ready</span>
                        </div>
                        <div id="diff-output-container" class="font-mono text-xs leading-relaxed max-h-80 overflow-y-auto space-y-0.5 divide-y divide-zinc-100/50 dark:divide-zinc-800/50">
                            <div class="text-zinc-400 py-3 text-center italic">Paste text above to view unified line-by-line diff.</div>
                        </div>
                    </div>
                </div>

                <!-- TOOL 5: JWT Token Debugger -->
                <div id="panel-jwt" class="tool-panel py-6 space-y-4 hidden">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <div>
                            <h2 class="text-lg font-bold text-zinc-900 dark:text-zinc-100">JWT Debugger & Inspector</h2>
                            <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-0.5">Decode JSON Web Tokens, inspect claims, and verify expiry dates locally without sending credentials over the network.</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <button onclick="loadSampleJWT()" class="px-2.5 py-1.5 rounded-lg text-xs font-medium bg-teal-50 dark:bg-teal-950/60 text-teal-700 dark:text-teal-300 hover:bg-teal-100 transition">Sample Token</button>
                            <button onclick="clearJWT()" class="px-2.5 py-1.5 rounded-lg text-xs font-medium bg-zinc-100 dark:bg-zinc-800 text-zinc-500 hover:text-rose-600 transition">Clear</button>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-zinc-500 mb-1.5">Encoded JWT String:</label>
                        <textarea id="jwt-input" rows="4" placeholder="Paste your Bearer eyJhbGci... token here"
                            class="w-full font-mono text-xs p-3.5 rounded-xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 text-zinc-900 dark:text-zinc-100 outline-none resize-y shadow-2xs"
                            oninput="parseJWTLive()"></textarea>
                    </div>

                    <!-- Token Expiry Status Banner -->
                    <div id="jwt-status-banner" class="hidden p-4 rounded-xl border">
                        <div class="flex items-center justify-between">
                            <span id="jwt-status-text" class="text-xs font-bold flex items-center gap-2"></span>
                            <span id="jwt-alg-badge" class="text-xs px-2 py-0.5 rounded-md bg-zinc-100 dark:bg-zinc-800 font-mono text-zinc-600 dark:text-zinc-400"></span>
                        </div>
                    </div>

                    <!-- Decoded Header & Payload Cards -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                        <div class="p-4 rounded-xl bg-white dark:bg-zinc-900 border border-rose-200/70 dark:border-rose-900/50 shadow-2xs space-y-2">
                            <div class="flex items-center justify-between text-xs font-bold text-rose-600 dark:text-rose-400">
                                <span>HEADER (Algorithm & Token Type)</span>
                                <button onclick="copyToClipboard('jwt-header-json')" class="text-zinc-400 hover:text-zinc-600 text-[11px] font-normal"><i class="far fa-copy"></i></button>
                            </div>
                            <pre id="jwt-header-json" class="font-mono text-xs text-zinc-800 dark:text-zinc-200 overflow-x-auto p-2 bg-rose-50/50 dark:bg-rose-950/20 rounded-lg">{}</pre>
                        </div>

                        <div class="p-4 rounded-xl bg-white dark:bg-zinc-900 border border-purple-200/70 dark:border-purple-900/50 shadow-2xs space-y-2">
                            <div class="flex items-center justify-between text-xs font-bold text-purple-600 dark:text-purple-400">
                                <span>PAYLOAD (Claims & Subject)</span>
                                <button onclick="copyToClipboard('jwt-payload-json')" class="text-zinc-400 hover:text-zinc-600 text-[11px] font-normal"><i class="far fa-copy"></i></button>
                            </div>
                            <pre id="jwt-payload-json" class="font-mono text-xs text-zinc-800 dark:text-zinc-200 overflow-x-auto p-2 bg-purple-50/50 dark:bg-purple-950/20 rounded-lg">{}</pre>
                        </div>
                    </div>
                </div>

                <!-- TOOL 6: URL & Query String Parser -->
                <div id="panel-url" class="tool-panel py-6 space-y-4 hidden">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <div>
                            <h2 class="text-lg font-bold text-zinc-900 dark:text-zinc-100">URL & Query String Parser</h2>
                            <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-0.5">Deconstruct complex URLs, inspect parameters as key-value pairs, and encode/decode values.</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <button onclick="loadSampleURL()" class="px-2.5 py-1.5 rounded-lg text-xs font-medium bg-teal-50 dark:bg-teal-950/60 text-teal-700 dark:text-teal-300 hover:bg-teal-100 transition">Sample</button>
                            <button onclick="clearURL()" class="px-2.5 py-1.5 rounded-lg text-xs font-medium bg-zinc-100 dark:bg-zinc-800 text-zinc-500 hover:text-rose-600 transition">Clear</button>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-zinc-500 mb-1.5">Full URL:</label>
                        <input type="text" id="url-input" placeholder="https://api.example.com/v1/search?q=developer+tools&category=tech&page=1#results"
                            class="w-full font-mono text-xs px-3.5 py-2.5 rounded-xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 text-zinc-900 dark:text-zinc-100 outline-none focus:border-teal-500 focus:ring-1 focus:ring-teal-500 transition shadow-2xs"
                            oninput="parseURLLive()">
                    </div>

                    <!-- URL Components Breakdown -->
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 text-xs">
                        <div class="p-3 rounded-xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 shadow-2xs">
                            <div class="text-[10px] text-zinc-400 font-semibold uppercase">Protocol</div>
                            <div id="url-proto" class="font-mono font-bold text-zinc-800 dark:text-zinc-200 mt-0.5 truncate">-</div>
                        </div>
                        <div class="p-3 rounded-xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 shadow-2xs">
                            <div class="text-[10px] text-zinc-400 font-semibold uppercase">Host</div>
                            <div id="url-host" class="font-mono font-bold text-zinc-800 dark:text-zinc-200 mt-0.5 truncate">-</div>
                        </div>
                        <div class="p-3 rounded-xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 shadow-2xs">
                            <div class="text-[10px] text-zinc-400 font-semibold uppercase">Path</div>
                            <div id="url-path" class="font-mono font-bold text-zinc-800 dark:text-zinc-200 mt-0.5 truncate">-</div>
                        </div>
                        <div class="p-3 rounded-xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 shadow-2xs">
                            <div class="text-[10px] text-zinc-400 font-semibold uppercase">Hash / Fragment</div>
                            <div id="url-hash" class="font-mono font-bold text-zinc-800 dark:text-zinc-200 mt-0.5 truncate">-</div>
                        </div>
                    </div>

                    <!-- Query Parameters Table -->
                    <div class="p-5 rounded-2xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 shadow-2xs space-y-3">
                        <div class="flex items-center justify-between text-xs text-zinc-500 border-b border-zinc-100 dark:border-zinc-800 pb-2">
                            <span class="font-semibold uppercase tracking-wider">Query Parameters (<span id="url-param-count">0</span>):</span>
                            <button onclick="copyQueryAsJSON()" class="text-teal-600 dark:text-teal-400 hover:underline">Copy As JSON</button>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-xs font-mono">
                                <thead>
                                    <tr class="text-zinc-400 border-b border-zinc-100 dark:border-zinc-800">
                                        <th class="py-2 pr-4 font-semibold">Key</th>
                                        <th class="py-2 pr-4 font-semibold">Value</th>
                                        <th class="py-2 text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="url-params-tbody" class="divide-y divide-zinc-100 dark:divide-zinc-800 text-zinc-700 dark:text-zinc-300">
                                    <tr>
                                        <td colspan="3" class="py-4 text-center text-zinc-400 italic">No query parameters detected.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

    </div>
</div>

<!-- Embedded Client-Side Script Engine -->
<script>
    const VALID_TOOLS = ['json', 'base64', 'cron', 'diff', 'jwt', 'url'];

    // Tab Switching Logic with Hash state update
    function switchTool(toolId, updateHash = true) {
        if (!VALID_TOOLS.includes(toolId)) {
            toolId = 'json';
        }

        document.querySelectorAll('.tool-panel').forEach(panel => panel.classList.add('hidden'));
        document.querySelectorAll('.tool-tab').forEach(tab => {
            tab.className = "tool-tab px-3.5 py-2 rounded-xl text-xs font-medium text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-100 hover:bg-zinc-100 dark:hover:bg-zinc-800/60 flex items-center gap-2 shrink-0 transition-all duration-200";
        });

        const activePanel = document.getElementById('panel-' + toolId);
        const activeTab = document.getElementById('tab-' + toolId);

        if (activePanel) activePanel.classList.remove('hidden');
        if (activeTab) {
            activeTab.className = "tool-tab px-3.5 py-2 rounded-xl text-xs font-semibold bg-white dark:bg-zinc-800 text-teal-700 dark:text-teal-300 shadow-xs border border-zinc-200 dark:border-zinc-700 flex items-center gap-2 shrink-0 transition-all duration-200";
        }

        if (updateHash && window.location.hash !== '#' + toolId) {
            history.replaceState(null, '', '#' + toolId);
        }
    }

    // 1. JSON Utilities
    function formatJSON(indent) {
        const input = document.getElementById('json-input').value;
        const statusEl = document.getElementById('json-status');
        const outputEl = document.getElementById('json-output');

        if (!input.trim()) return;

        try {
            const parsed = JSON.parse(input);
            outputEl.value = JSON.stringify(parsed, null, indent);
            statusEl.innerHTML = `<span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> <span class="text-emerald-600 dark:text-emerald-400 font-semibold">Valid JSON</span>`;
        } catch (e) {
            statusEl.innerHTML = `<span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> <span class="text-rose-600 dark:text-rose-400 font-semibold">${e.message}</span>`;
        }
    }

    function minifyJSON() {
        const input = document.getElementById('json-input').value;
        const statusEl = document.getElementById('json-status');
        const outputEl = document.getElementById('json-output');

        if (!input.trim()) return;

        try {
            const parsed = JSON.parse(input);
            outputEl.value = JSON.stringify(parsed);
            statusEl.innerHTML = `<span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> <span class="text-emerald-600 dark:text-emerald-400 font-semibold">Minified Clean</span>`;
        } catch (e) {
            statusEl.innerHTML = `<span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> <span class="text-rose-600 dark:text-rose-400 font-semibold">${e.message}</span>`;
        }
    }

    function validateJSONLive() {
        const input = document.getElementById('json-input').value;
        const statsEl = document.getElementById('json-input-stats');
        statsEl.innerText = `${input.length} chars`;
        if (input.trim()) formatJSON(2);
    }

    function loadSampleJSON() {
        const sample = {
            "name": "Ted Choi",
            "role": "Software Engineer",
            "skills": ["PHP/Laravel", "Node.js", "Docker", "Go", "AWS", "GCP"],
            "projects": [
                { "name": "SurplusRadar", "status": "Active" },
                { "name": "DevUtils", "stars": 128 }
            ],
            "verified": true
        };
        document.getElementById('json-input').value = JSON.stringify(sample);
        formatJSON(2);
    }

    function clearJSON() {
        document.getElementById('json-input').value = '';
        document.getElementById('json-output').value = '';
        document.getElementById('json-status').innerHTML = `<span class="w-1.5 h-1.5 rounded-full bg-zinc-400"></span> Ready`;
        document.getElementById('json-input-stats').innerText = '0 chars';
    }

    // 2. Base64 Utilities
    let b64Mode = 'encode';
    function setBase64Mode(mode) {
        b64Mode = mode;
        const encBtn = document.getElementById('b64-btn-encode');
        const decBtn = document.getElementById('b64-btn-decode');
        const inLabel = document.getElementById('b64-input-label');
        const outLabel = document.getElementById('b64-output-label');

        if (mode === 'encode') {
            encBtn.className = "px-3 py-1 rounded-md font-semibold bg-white dark:bg-zinc-900 text-zinc-900 dark:text-zinc-100 shadow-xs";
            decBtn.className = "px-3 py-1 rounded-md font-medium text-zinc-600 dark:text-zinc-400 hover:text-zinc-900";
            inLabel.innerText = "Text to Encode:";
            outLabel.innerText = "Base64 Output:";
        } else {
            decBtn.className = "px-3 py-1 rounded-md font-semibold bg-white dark:bg-zinc-900 text-zinc-900 dark:text-zinc-100 shadow-xs";
            encBtn.className = "px-3 py-1 rounded-md font-medium text-zinc-600 dark:text-zinc-400 hover:text-zinc-900";
            inLabel.innerText = "Base64 to Decode:";
            outLabel.innerText = "Plain Text Output:";
        }
        runBase64();
    }

    function runBase64() {
        const input = document.getElementById('b64-input').value;
        const outputEl = document.getElementById('b64-output');
        const urlSafe = document.getElementById('b64-urlsafe').checked;
        const previewBox = document.getElementById('b64-image-preview-box');
        const previewImg = document.getElementById('b64-image-preview');

        if (!input.trim()) {
            outputEl.value = '';
            previewBox.classList.add('hidden');
            return;
        }

        try {
            if (b64Mode === 'encode') {
                let encoded = btoa(unescape(encodeURIComponent(input)));
                if (urlSafe) {
                    encoded = encoded.replace(/\+/g, '-').replace(/\//g, '_').replace(/=+$/, '');
                }
                outputEl.value = encoded;
                previewBox.classList.add('hidden');
            } else {
                let clean = input.trim();
                if (urlSafe) {
                    clean = clean.replace(/-/g, '+').replace(/_/g, '/');
                    while (clean.length % 4) clean += '=';
                }

                // Detect if it's an image Data URI
                if (clean.startsWith('data:image/')) {
                    previewImg.src = clean;
                    previewBox.classList.remove('hidden');
                    outputEl.value = `[Data URI Image Detected - Width/Height Loaded]`;
                    return;
                }

                const decoded = decodeURIComponent(escape(atob(clean)));
                outputEl.value = decoded;
                previewBox.classList.add('hidden');
            }
        } catch (e) {
            outputEl.value = `Error: ${e.message}`;
            previewBox.classList.add('hidden');
        }
    }

    function clearBase64() {
        document.getElementById('b64-input').value = '';
        document.getElementById('b64-output').value = '';
        document.getElementById('b64-image-preview-box').classList.add('hidden');
    }

    // 3. Cron Explainer
    function setCronPreset(cron) {
        document.getElementById('cron-input').value = cron;
        parseCronLive();
    }

    function parseCronLive() {
        const expr = (document.getElementById('cron-input').value || '').trim();
        const parts = expr.split(/\s+/);
        const humanEl = document.getElementById('cron-human-text');
        const nextRunsEl = document.getElementById('cron-next-runs');

        if (parts.length !== 5) {
            humanEl.innerText = "Invalid syntax: standard cron requires exactly 5 fields (Minute Hour Day Month DayOfWeek).";
            humanEl.className = "text-sm sm:text-base font-bold text-rose-600 dark:text-rose-400 mt-0.5";
            nextRunsEl.innerHTML = `<li class="text-zinc-400">Awaiting valid 5-field cron...</li>`;
            return;
        }

        humanEl.className = "text-base sm:text-lg font-bold text-zinc-900 dark:text-zinc-100 mt-0.5";

        const [min, hour, dom, mon, dow] = parts;
        let explanation = [];

        // Minute analysis
        if (min === '*') explanation.push("Every minute");
        else if (min.startsWith('*/')) explanation.push(`Every ${min.slice(2)} minutes`);
        else explanation.push(`At minute ${min}`);

        // Hour analysis
        if (hour !== '*') {
            if (hour.startsWith('*/')) explanation.push(`past every ${hour.slice(2)} hours`);
            else explanation.push(`past hour ${hour}:00`);
        }

        // Day of month analysis
        if (dom !== '*') {
            explanation.push(`on day ${dom} of the month`);
        }

        // Month analysis
        if (mon !== '*') {
            explanation.push(`in month ${mon}`);
        }

        // Day of week analysis
        if (dow !== '*') {
            const days = { '0': 'Sunday', '1': 'Monday', '2': 'Tuesday', '3': 'Wednesday', '4': 'Thursday', '5': 'Friday', '6': 'Saturday', '7': 'Sunday' };
            if (dow === '1-5') explanation.push("on Monday through Friday");
            else if (days[dow]) explanation.push(`on ${days[dow]}`);
            else explanation.push(`on day-of-week ${dow}`);
        }

        humanEl.innerText = explanation.join(", ");

        // Calculate next 5 approximate runs
        let now = new Date();
        let runsHtml = '';
        for (let i = 1; i <= 5; i++) {
            let nextDate = new Date(now.getTime() + i * 15 * 60000);
            runsHtml += `<li class="flex items-center gap-2"><span class="text-teal-600 font-bold">#${i}</span> <span>${nextDate.toLocaleString()}</span></li>`;
        }
        nextRunsEl.innerHTML = runsHtml;
    }

    // 4. Diff Checker
    function computeDiffLive() {
        const orig = document.getElementById('diff-original').value;
        const mod = document.getElementById('diff-modified').value;
        const container = document.getElementById('diff-output-container');
        const statsEl = document.getElementById('diff-stats');

        if (!orig && !mod) {
            container.innerHTML = `<div class="text-zinc-400 py-3 text-center italic">Paste text above to view unified line-by-line diff.</div>`;
            statsEl.innerText = 'Ready';
            return;
        }

        const origLines = orig.split('\n');
        const modLines = mod.split('\n');

        let html = '';
        let added = 0;
        let removed = 0;

        let max = Math.max(origLines.length, modLines.length);
        for (let i = 0; i < max; i++) {
            let o = origLines[i];
            let m = modLines[i];

            if (o === m) {
                html += `<div class="px-2 py-1 text-zinc-600 dark:text-zinc-400 bg-transparent flex gap-3"><span class="w-8 text-right text-zinc-300 dark:text-zinc-700 select-none">${i+1}</span><span>  ${escapeHTML(o || '')}</span></div>`;
            } else {
                if (o !== undefined) {
                    removed++;
                    html += `<div class="px-2 py-1 text-rose-700 dark:text-rose-300 bg-rose-50 dark:bg-rose-950/40 rounded flex gap-3"><span class="w-8 text-right text-rose-300 dark:text-rose-700 select-none">${i+1}</span><span>- ${escapeHTML(o)}</span></div>`;
                }
                if (m !== undefined) {
                    added++;
                    html += `<div class="px-2 py-1 text-emerald-700 dark:text-emerald-300 bg-emerald-50 dark:bg-emerald-950/40 rounded flex gap-3"><span class="w-8 text-right text-emerald-300 dark:text-emerald-700 select-none">${i+1}</span><span>+ ${escapeHTML(m)}</span></div>`;
                }
            }
        }

        container.innerHTML = html;
        statsEl.innerHTML = `<span class="text-emerald-600 font-bold">+${added}</span> / <span class="text-rose-600 font-bold">-${removed}</span> lines`;
    }

    function loadSampleDiff() {
        document.getElementById('diff-original').value = "const port = 8080;\nconst mode = 'development';\nconsole.log(`Server starting on ${port}`);\napp.listen(port);";
        document.getElementById('diff-modified').value = "const port = process.env.PORT || 3000;\nconst mode = 'production';\nconst timeout = 5000;\nconsole.log(`Production server online at ${port}`);\napp.listen(port);";
        computeDiffLive();
    }

    function swapDiff() {
        const orig = document.getElementById('diff-original').value;
        document.getElementById('diff-original').value = document.getElementById('diff-modified').value;
        document.getElementById('diff-modified').value = orig;
        computeDiffLive();
    }

    function clearDiff() {
        document.getElementById('diff-original').value = '';
        document.getElementById('diff-modified').value = '';
        computeDiffLive();
    }

    // 5. JWT Debugger
    function parseJWTLive() {
        let token = (document.getElementById('jwt-input').value || '').trim();
        if (token.startsWith('Bearer ')) token = token.slice(7).trim();

        const banner = document.getElementById('jwt-status-banner');
        const statusText = document.getElementById('jwt-status-text');
        const algBadge = document.getElementById('jwt-alg-badge');
        const headerPre = document.getElementById('jwt-header-json');
        const payloadPre = document.getElementById('jwt-payload-json');

        if (!token) {
            banner.classList.add('hidden');
            headerPre.innerText = '{}';
            payloadPre.innerText = '{}';
            return;
        }

        const parts = token.split('.');
        if (parts.length !== 3) {
            banner.classList.remove('hidden');
            banner.className = "p-4 rounded-xl border border-rose-200 bg-rose-50 dark:bg-rose-950/40 text-rose-700 dark:text-rose-300";
            statusText.innerHTML = `<i class="fas fa-triangle-exclamation"></i> Invalid JWT format: Token must have 3 dot-separated segments.`;
            algBadge.innerText = 'INVALID';
            return;
        }

        try {
            const header = JSON.parse(decodeBase64Url(parts[0]));
            const payload = JSON.parse(decodeBase64Url(parts[1]));

            headerPre.innerText = JSON.stringify(header, null, 2);
            payloadPre.innerText = JSON.stringify(payload, null, 2);

            algBadge.innerText = `Algorithm: ${header.alg || 'none'}`;
            banner.classList.remove('hidden');

            // Check expiration
            if (payload.exp) {
                const expDate = new Date(payload.exp * 1000);
                const now = new Date();
                if (now > expDate) {
                    banner.className = "p-4 rounded-xl border border-rose-200 bg-rose-50 dark:bg-rose-950/40 text-rose-700 dark:text-rose-300";
                    statusText.innerHTML = `<span class="w-2 h-2 rounded-full bg-rose-500"></span> <span>Expired on ${expDate.toLocaleString()}</span>`;
                } else {
                    banner.className = "p-4 rounded-xl border border-emerald-200 bg-emerald-50 dark:bg-emerald-950/40 text-emerald-800 dark:text-emerald-300";
                    statusText.innerHTML = `<span class="w-2 h-2 rounded-full bg-emerald-500"></span> <span>Active & Valid until ${expDate.toLocaleString()}</span>`;
                }
            } else {
                banner.className = "p-4 rounded-xl border border-zinc-200 bg-zinc-50 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300";
                statusText.innerHTML = `<i class="fas fa-info-circle text-teal-500"></i> No expiration claim ('exp') found in payload.`;
            }
        } catch (e) {
            banner.classList.remove('hidden');
            banner.className = "p-4 rounded-xl border border-rose-200 bg-rose-50 dark:bg-rose-950/40 text-rose-700 dark:text-rose-300";
            statusText.innerText = `Decode Error: ${e.message}`;
        }
    }

    function decodeBase64Url(str) {
        let base64 = str.replace(/-/g, '+').replace(/_/g, '/');
        while (base64.length % 4) base64 += '=';
        return decodeURIComponent(escape(atob(base64)));
    }

    function loadSampleJWT() {
        const sampleJWT = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9." +
            "eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IlRlZCBDaG9pIiwicm9sZSI6IlNvZnR3YXJlIEVuZ2luZWVyIiwiaWF0IjoxNTE2MjM5MDIyLCJleHAiOjE5OTk5OTk5OTl9." +
            "4fW31e67Jk0_M-xS721d-example-signature";
        document.getElementById('jwt-input').value = sampleJWT;
        parseJWTLive();
    }

    function clearJWT() {
        document.getElementById('jwt-input').value = '';
        parseJWTLive();
    }

    // 6. URL & Query Parser
    let parsedParamsObj = {};
    function parseURLLive() {
        const urlString = (document.getElementById('url-input').value || '').trim();
        const protoEl = document.getElementById('url-proto');
        const hostEl = document.getElementById('url-host');
        const pathEl = document.getElementById('url-path');
        const hashEl = document.getElementById('url-hash');
        const tbody = document.getElementById('url-params-tbody');
        const countEl = document.getElementById('url-param-count');

        parsedParamsObj = {};

        if (!urlString) {
            protoEl.innerText = '-';
            hostEl.innerText = '-';
            pathEl.innerText = '-';
            hashEl.innerText = '-';
            countEl.innerText = '0';
            tbody.innerHTML = `<tr><td colspan="3" class="py-4 text-center text-zinc-400 italic">No query parameters detected.</td></tr>`;
            return;
        }

        try {
            const url = new URL(urlString.includes('://') ? urlString : `https://${urlString}`);
            protoEl.innerText = url.protocol;
            hostEl.innerText = url.host;
            pathEl.innerText = url.pathname;
            hashEl.innerText = url.hash || '-';

            let rows = '';
            let count = 0;
            url.searchParams.forEach((val, key) => {
                count++;
                parsedParamsObj[key] = val;
                rows += `
                    <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/40 transition">
                        <td class="py-2.5 pr-4 text-teal-600 dark:text-teal-400 font-bold">${escapeHTML(key)}</td>
                        <td class="py-2.5 pr-4 break-all text-zinc-800 dark:text-zinc-200">${escapeHTML(val)}</td>
                        <td class="py-2.5 text-right"><button onclick="copyRaw('${escapeHTML(val)}')" class="text-zinc-400 hover:text-zinc-600 text-xs"><i class="far fa-copy"></i></button></td>
                    </tr>
                `;
            });

            countEl.innerText = count;
            tbody.innerHTML = count > 0 ? rows : `<tr><td colspan="3" class="py-4 text-center text-zinc-400 italic">No query parameters present in this URL.</td></tr>`;
        } catch (e) {
            tbody.innerHTML = `<tr><td colspan="3" class="py-4 text-center text-rose-500 font-sans text-xs">Invalid URL format: ${e.message}</td></tr>`;
        }
    }

    function loadSampleURL() {
        document.getElementById('url-input').value = "https://api.brokolidev.com/v1/search?query=developer+utilities&category=tools&limit=50&active=true#filter-results";
        parseURLLive();
    }

    function clearURL() {
        document.getElementById('url-input').value = '';
        parseURLLive();
    }

    function copyQueryAsJSON() {
        navigator.clipboard.writeText(JSON.stringify(parsedParamsObj, null, 2));
        alert('Copied parameters as formatted JSON!');
    }

    // Helper functions
    function copyToClipboard(elementId) {
        const text = document.getElementById(elementId).value;
        if (!text) return;
        navigator.clipboard.writeText(text);
        alert('Copied to clipboard!');
    }

    function copyRaw(text) {
        navigator.clipboard.writeText(text);
        alert('Copied value!');
    }

    function escapeHTML(str) {
        return str.replace(/[&<>'"]/g, tag => ({
            '&': '&amp;', '<': '&lt;', '>': '&gt;', "'": '&#39;', '"': '&quot;'
        }[tag] || tag));
    }

    function getToolFromHash() {
        const hash = (window.location.hash || '').replace('#', '').toLowerCase();
        return VALID_TOOLS.includes(hash) ? hash : 'json';
    }

    // Run on initial load and handle browser back/forward navigation
    document.addEventListener('DOMContentLoaded', () => {
        const initialTool = getToolFromHash();
        switchTool(initialTool, false);
        parseCronLive();
    });

    window.addEventListener('hashchange', () => {
        const tool = getToolFromHash();
        switchTool(tool, false);
    });
</script>
@endsection
