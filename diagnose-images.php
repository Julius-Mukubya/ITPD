<?php
echo "<h1>Image Diagnostic Report</h1>";
echo "<style>
    body { font-family: Arial, sans-serif; margin: 20px; }
    table { border-collapse: collapse; width: 100%; margin: 10px 0; }
    th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
    th { background-color: #4CAF50; color: white; }
    .success { color: green; }
    .error { color: red; }
    .test-image { max-width: 150px; border: 2px solid #ccc; margin: 5px; }
    .test-image.error { border-color: red; }
</style>";

// 1. Check actual files in storage
echo "<h2>1. Physical Files in Storage</h2>";
$storageDir = __DIR__ . '/storage/content-images';
echo "<p>Checking: {$storageDir}</p>";

$imageFiles = [];
if (is_dir($storageDir)) {
    $files = scandir($storageDir);
    $imageFiles = array_filter($files, function($file) {
        return !in_array($file, ['.', '..', '.gitignore']);
    });
    
    echo "<p class='success'>✓ Found " . count($imageFiles) . " files</p>";
    echo "<table>";
    echo "<tr><th>Filename</th><th>Size</th><th>Permissions</th><th>Test Load</th></tr>";
    foreach ($imageFiles as $file) {
        $fullPath = $storageDir . '/' . $file;
        $size = number_format(filesize($fullPath) / 1024, 2) . ' KB';
        $perms = substr(sprintf('%o', fileperms($fullPath)), -4);
        $testUrl = '/storage/content-images/' . $file;
        echo "<tr>";
        echo "<td>{$file}</td>";
        echo "<td>{$size}</td>";
        echo "<td>{$perms}</td>";
        echo "<td><img src='{$testUrl}' class='test-image' onerror=\"this.className='test-image error'; this.alt='FAILED'\" alt='Loading...' /></td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p class='error'>✗ Directory does not exist!</p>";
}

// 2. Check storage directory structure
echo "<h2>2. Storage Directory Structure</h2>";
$publicStorage = __DIR__ . '/storage';
if (is_link($publicStorage)) {
    echo "<p class='success'>✓ Symlink exists</p>";
    echo "<p>Points to: " . readlink($publicStorage) . "</p>";
} elseif (is_dir($publicStorage)) {
    echo "<p class='success'>✓ Storage directory exists (not a symlink)</p>";
    
    // List subdirectories
    $subdirs = array_filter(scandir($publicStorage), function($item) use ($publicStorage) {
        return $item != '.' && $item != '..' && is_dir($publicStorage . '/' . $item);
    });
    echo "<p>Subdirectories: " . implode(', ', $subdirs) . "</p>";
} else {
    echo "<p class='error'>✗ Storage path does not exist!</p>";
}

// 3. Test direct URL access
echo "<h2>3. Test Direct URL Access</h2>";
if (!empty($imageFiles)) {
    $testFile = reset($imageFiles);
    $testUrl = '/storage/content-images/' . $testFile;
    echo "<p>Testing URL: <a href='{$testUrl}' target='_blank'>{$testUrl}</a></p>";
    echo "<p>Full URL: <a href='https://wellpath.resnetsystems.site{$testUrl}' target='_blank'>https://wellpath.resnetsystems.site{$testUrl}</a></p>";
    echo "<div>";
    echo "<img src='{$testUrl}' style='max-width:300px; border:2px solid #ccc;' onerror=\"this.style.border='2px solid red'; this.alt='FAILED TO LOAD'; this.nextElementSibling.style.display='block';\" />";
    echo "<p class='error' style='display:none;'>✗ Image failed to load via URL</p>";
    echo "</div>";
}

// 4. Check .htaccess
echo "<h2>4. .htaccess Configuration</h2>";
$htaccessPath = __DIR__ . '/.htaccess';
if (file_exists($htaccessPath)) {
    echo "<p class='success'>✓ .htaccess exists</p>";
    $htaccess = file_get_contents($htaccessPath);
    if (strpos($htaccess, 'RewriteEngine On') !== false) {
        echo "<p class='success'>✓ RewriteEngine is enabled</p>";
    }
    if (strpos($htaccess, 'mod_mime') !== false) {
        echo "<p class='success'>✓ MIME types configured</p>";
    }
} else {
    echo "<p class='error'>✗ .htaccess not found</p>";
}

// 5. Server info
echo "<h2>5. Server Information</h2>";
echo "<pre>";
echo "Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "\n";
echo "Script Path: " . __DIR__ . "\n";
echo "Request URI: " . $_SERVER['REQUEST_URI'] . "\n";
echo "Server Software: " . $_SERVER['SERVER_SOFTWARE'] . "\n";
echo "</pre>";

echo "<hr><p><strong style='color:red;'>DELETE THIS FILE AFTER CHECKING!</strong></p>";
?>
