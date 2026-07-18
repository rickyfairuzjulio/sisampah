<?php

$logos = [
    'bca.png' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/5/5c/Bank_Central_Asia.svg/1280px-Bank_Central_Asia.svg.png',
    'bri.png' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/2/2e/BRI_2020.svg/2560px-BRI_2020.svg.png',
    'bsi.png' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/a/a0/Bank_Syariah_Indonesia.svg/2560px-Bank_Syariah_Indonesia.svg.png',
    'dana.png' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/7/72/Logo_dana_blue.svg/2560px-Logo_dana_blue.svg.png',
    'gopay.png' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/8/86/Gopay_logo.svg/2560px-Gopay_logo.svg.png'
];

$dir = __DIR__ . '/public/images/banks';
if (!is_dir($dir)) {
    mkdir($dir, 0777, true);
}

foreach ($logos as $filename => $url) {
    $path = $dir . '/' . $filename;
    echo "Downloading $filename...\n";
    $opts = [
        "http" => [
            "method" => "GET",
            "header" => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64)\r\n"
        ]
    ];
    $context = stream_context_create($opts);
    $content = @file_get_contents($url, false, $context);
    if ($content) {
        file_put_contents($path, $content);
        echo "Saved $path\n";
    } else {
        echo "Failed to download $filename\n";
    }
}

echo "Done!\n";
