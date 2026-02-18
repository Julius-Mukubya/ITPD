<?php
// scripts/check_images.php
// Usage: php scripts/check_images.php
// Bootstraps the Laravel app and scans DB text columns for image filenames,
// then checks common public/storage and storage paths and reports missing files.

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

echo "Starting image check...\n";

$extensions = ['jpg','jpeg','png','webp','avif','gif'];

$found = [];
$missing = [];

// Get all tables
$tablesRaw = DB::select('SHOW TABLES');
foreach ($tablesRaw as $row) {
    $props = get_object_vars($row);
    $table = array_shift($props);
    if (! $table) continue;

    // Get columns
    try {
        $colsRaw = DB::select("SHOW COLUMNS FROM `{$table}`");
    } catch (Exception $e) {
        // ignore
        continue;
    }

    $columns = array_map(function($c){ return $c->Field; }, $colsRaw);

    // choose candidate columns (char/varchar/text/json)
    $candidateCols = [];
    foreach ($colsRaw as $col) {
        $type = strtolower($col->Type);
        if (strpos($type,'char')!==false || strpos($type,'text')!==false || strpos($type,'varchar')!==false || strpos($type,'json')!==false) {
            $candidateCols[] = $col->Field;
        }
    }

    if (empty($candidateCols)) continue;

    foreach ($candidateCols as $col) {
        // build query: check if column contains any of the extensions
        try {
            $query = DB::table($table)->select($col, (in_array('id',$columns) ? 'id' : DB::raw('NULL as id')))->where(function($q) use ($col, $extensions) {
                foreach ($extensions as $ext) {
                    $q->orWhere($col, 'like', "%.$ext%");
                }
            })->limit(2000);

            $rows = $query->get();
        } catch (Exception $e) {
            continue;
        }

        foreach ($rows as $r) {
            $val = $r->{$col};
            $id = property_exists($r,'id') ? $r->id : null;
            if (!$val) continue;

            // if JSON array/object, try decode and extract strings
            $candidates = [];
            if ((is_string($val) && (substr($val,0,1)=='[' || substr($val,0,1)=='{'))) {
                $decoded = json_decode($val, true);
                if (json_last_error()===JSON_ERROR_NONE) {
                    $flatten = new RecursiveIteratorIterator(new RecursiveArrayIterator($decoded));
                    foreach ($flatten as $item) {
                        if (is_string($item)) $candidates[] = $item;
                    }
                } else {
                    $candidates[] = $val;
                }
            } else {
                $candidates[] = $val;
            }

            foreach ($candidates as $cand) {
                // find all file-like substrings
                if (!is_string($cand)) continue;
                if (preg_match_all('/[A-Za-z0-9_\-\/]+\.(?:jpg|jpeg|png|webp|avif|gif)/i', $cand, $m)) {
                    foreach ($m[0] as $file) {
                        $found[] = ['table'=>$table,'column'=>$col,'id'=>$id,'file'=>$file];

                        // check common places where app stores/serves the files
                        $candidatesPaths = [
                            public_path($file),
                            public_path('storage/'.$file),
                            public_path('images/'.$file),
                            storage_path('content-images/'.$file),
                            storage_path('campaign-banners/'.$file),
                            storage_path('profile-photos/'.$file),
                            storage_path('avatars/'.$file),
                            storage_path('app/public/'.$file),
                        ];

                        $exists = false;
                        foreach ($candidatesPaths as $p) {
                            if (file_exists($p)) { $exists = true; break; }
                        }

                        if (! $exists) {
                            $missing[] = ['table'=>$table,'column'=>$col,'id'=>$id,'file'=>$file];
                        }
                    }
                }
            }
        }
    }
}

echo "Scan complete.\n";
echo "Total referenced image-like strings found: " . count($found) . "\n";
echo "Total missing files: " . count($missing) . "\n\n";

if (!empty($missing)) {
    echo "Missing files (table, column, id, file):\n";
    foreach ($missing as $m) {
        echo sprintf("%s | %s | %s | %s\n", $m['table'], $m['column'], $m['id'] ?? '-', $m['file']);
    }
    echo "\nYou can restore these files to `public/storage` or update DB references accordingly.\n";
} else {
    echo "No missing files detected in checked locations.\n";
}

echo "Tip: Re-run with more targeted checks if DB is large or if files live on external disks.\n";

exit(0);
