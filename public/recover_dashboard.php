<?php
$transcript_path = 'C:\Users\hp\.gemini\antigravity-ide\brain\4ee3f6ae-f974-470a-9fff-52e12619b4e7\.system_generated\logs\transcript_full.jsonl';
$lines = file($transcript_path);
$last_content = '';
$found = false;

foreach ($lines as $line) {
    $data = json_decode($line, true);
    if (isset($data['step_index']) && $data['step_index'] >= 673) {
        break; // Stop before the step where I overwrote it with glassmorphism
    }
    
    if (isset($data['tool_calls'])) {
        foreach ($data['tool_calls'] as $tool_call) {
            if ($tool_call['name'] === 'write_to_file' || $tool_call['name'] === 'replace_file_content') {
                $args = $tool_call['args'];
                if (isset($args['TargetFile']) && strpos($args['TargetFile'], 'super-dashboard.blade.php') !== false) {
                    if (isset($args['CodeContent'])) {
                        $last_content = $args['CodeContent'];
                        $found = true;
                    }
                }
            }
        }
    }
}

if ($found) {
    file_put_contents('C:\laragon\www\sampah\public\recovered_dashboard.txt', $last_content);
    echo "Found and saved to recovered_dashboard.txt";
} else {
    echo "Not found via write_to_file. Trying to search view_file output.\n";
    
    // Maybe we viewed it?
    $last_view = '';
    foreach ($lines as $line) {
        $data = json_decode($line, true);
        if (isset($data['step_index']) && $data['step_index'] >= 673) break;
        if (isset($data['tool_calls'])) {
            foreach ($data['tool_calls'] as $tool_call) {
                if ($tool_call['name'] === 'view_file') {
                    $args = $tool_call['args'];
                    if (isset($args['AbsolutePath']) && strpos($args['AbsolutePath'], 'super-dashboard.blade.php') !== false) {
                        // We found a view_file call, but the output is in the next step (response).
                    }
                }
            }
        }
    }
}
