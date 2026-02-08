<?php
/**
 * Image Diagnostic Tool
 * Upload this file to your public folder and access it via browser
 * URL: https://wellpath.resnetsystems.site/check-images.php
 */

header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Image Diagnostic Tool</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; background: #f5f5f5; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        h1 { color: #2d5f4d; }
        .success { color: #22c55e; font-weight: bold; }
        .error { color: #ef4444; font-weight: bold; }
        .info { background: #e0f2fe; padding: 10px; border-radius: 4px; margin: 10px 0; }
        .section { margin: 20px 0; padding: 15px; border: 1px solid #e5e7eb; border-radius: 4px; }
        table { width: 100%; border-collapse: collapse; margin: 10px 0; }
        th, td { padding: 8px; text-align: left; border-bottom: 1px solid #e5e7eb; }
        th { background: #f9fafb; font-weight: bold; }
        code { background: #f3f4f6; padding: 2px 6px; border-radius: 3px; font-family: monospace; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔍 Image Diagnostic Tool</h1>
        
        <div class="section">
            <h2>1. Server Information</h2>
            <table>
                <tr>
                    <th>Setting</th>
                    <th>Value</th>
                </tr>
                <tr>
                    <td>Document Root</td>
                    <td><code><?php echo $_SERVER['DOCUMENT_ROOT']; ?></code></td>
                </tr>
                <tr>
                    <td>Current Script Path</td>
                    <td><code><?php echo __FILE__; ?></code></td>
                </tr>
                <tr>
                    <td>Server Software</td>
                    <td><code><?php echo $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown'; ?></code></td>
                </tr>
                <tr>
                    <td>PHP Version</td>
                    <td><code><?php echo PHP_VERSION; ?></code></td>
                </tr>
            </table>
        </div>

        <div class="section">
            <h2>2. Images Directory Check</h2>
            <?php
            $imagesDir = __DIR__ . '/images';
            $imagesDirExists = is_dir($imagesDir);
            ?>
            <p>Images directory: <code><?php echo $imagesDir; ?></code></p>
            <p>Status: <?php echo $imagesDirExists ? '<span class="success">✓ EXISTS</span>' : '<span class="error">✗ NOT FOUND</span>'; ?></p>
            
            <?php if ($imagesDirExists): ?>
                <p>Permissions: <code><?php echo substr(sprintf('%o', fileperms($imagesDir)), -4); ?></code></p>
                
                <h3>Files in images directory:</h3>
                <table>
                    <tr>
                        <th>Filename</th>
                        <th>Size</th>
                        <th>Permissions</th>
                        <th>Readable</th>
                    </tr>
                    <?php
                    $files = scandir($imagesDir);
                    $avifFiles = array_filter($files, function($file) {
                        return pathinfo($file, PATHINFO_EXTENSION) === 'avif';
                    });
                    
                    if (empty($avifFiles)) {
                        echo '<tr><td colspan="4" class="error">No AVIF files found!</td></tr>';
                    } else {
                        foreach ($avifFiles as $file) {
                            $filePath = $imagesDir . '/' . $file;
                            $size = filesize($filePath);
                            $perms = substr(sprintf('%o', fileperms($filePath)), -4);
                            $readable = is_readable($filePath);
                            
                            echo '<tr>';
                            echo '<td><code>' . htmlspecialchars($file) . '</code></td>';
                            echo '<td>' . number_format($size) . ' bytes</td>';
                            echo '<td><code>' . $perms . '</code></td>';
                            echo '<td>' . ($readable ? '<span class="success">✓ Yes</span>' : '<span class="error">✗ No</span>') . '</td>';
                            echo '</tr>';
                        }
                    }
                    ?>
                </table>
            <?php endif; ?>
        </div>

        <div class="section">
            <h2>3. .htaccess Files Check</h2>
            <?php
            $htaccessFiles = [
                'public/.htaccess' => __DIR__ . '/.htaccess',
                'public/images/.htaccess' => $imagesDir . '/.htaccess'
            ];
            
            foreach ($htaccessFiles as $label => $path) {
                $exists = file_exists($path);
                echo '<p><strong>' . $label . ':</strong> ';
                echo $exists ? '<span class="success">✓ EXISTS</span>' : '<span class="error">✗ NOT FOUND</span>';
                
                if ($exists) {
                    $readable = is_readable($path);
                    echo ' | Readable: ' . ($readable ? '<span class="success">✓ Yes</span>' : '<span class="error">✗ No</span>');
                    
                    if ($readable) {
                        $content = file_get_contents($path);
                        $hasAvifMime = strpos($content, 'image/avif') !== false;
                        echo ' | Has AVIF MIME: ' . ($hasAvifMime ? '<span class="success">✓ Yes</span>' : '<span class="error">✗ No</span>');
                    }
                }
                echo '</p>';
            }
            ?>
        </div>

        <div class="section">
            <h2>4. Direct Image Access Test</h2>
            <div class="info">
                <strong>Test URL:</strong> <a href="/images/hero-homepage.avif" target="_blank">https://wellpath.resnetsystems.site/images/hero-homepage.avif</a>
            </div>
            <?php
            $testImage = $imagesDir . '/hero-homepage.avif';
            if (file_exists($testImage)) {
                echo '<p class="success">✓ File exists on server</p>';
                echo '<p>File size: ' . number_format(filesize($testImage)) . ' bytes</p>';
                echo '<p>Full path: <code>' . $testImage . '</code></p>';
                
                // Try to read file
                if (is_readable($testImage)) {
                    echo '<p class="success">✓ File is readable by PHP</p>';
                    
                    // Check MIME type
                    if (function_exists('mime_content_type')) {
                        $mimeType = mime_content_type($testImage);
                        echo '<p>Detected MIME type: <code>' . $mimeType . '</code></p>';
                    }
                } else {
                    echo '<p class="error">✗ File is NOT readable by PHP</p>';
                }
            } else {
                echo '<p class="error">✗ File does NOT exist on server</p>';
            }
            ?>
        </div>

        <div class="section">
            <h2>5. Recommendations</h2>
            <?php
            $issues = [];
            
            if (!$imagesDirExists) {
                $issues[] = 'Images directory does not exist. Upload your images to: <code>' . $imagesDir . '</code>';
            } elseif (empty($avifFiles)) {
                $issues[] = 'No AVIF files found in images directory. Upload your AVIF images.';
            }
            
            if (!file_exists(__DIR__ . '/.htaccess')) {
                $issues[] = 'Missing public/.htaccess file. This file is required for Laravel to work properly.';
            } elseif (!strpos(file_get_contents(__DIR__ . '/.htaccess'), 'image/avif')) {
                $issues[] = 'public/.htaccess does not contain AVIF MIME type configuration. Add it to support AVIF images.';
            }
            
            if ($_SERVER['DOCUMENT_ROOT'] !== __DIR__) {
                $issues[] = 'Document root mismatch! Server document root should point to: <code>' . __DIR__ . '</code> but currently points to: <code>' . $_SERVER['DOCUMENT_ROOT'] . '</code>';
            }
            
            if (empty($issues)) {
                echo '<p class="success">✓ No issues detected! If images still don\'t load, try:</p>';
                echo '<ul>';
                echo '<li>Clear browser cache</li>';
                echo '<li>Restart Apache/Nginx server</li>';
                echo '<li>Check file permissions (should be 644 for files, 755 for directories)</li>';
                echo '</ul>';
            } else {
                echo '<p class="error">Issues found:</p>';
                echo '<ol>';
                foreach ($issues as $issue) {
                    echo '<li>' . $issue . '</li>';
                }
                echo '</ol>';
            }
            ?>
        </div>

        <div class="section">
            <h2>6. Quick Fixes</h2>
            <p><strong>If document root is wrong:</strong></p>
            <p>Contact your hosting provider or update your Apache/Nginx configuration to point to the <code>public</code> folder.</p>
            
            <p><strong>If permissions are wrong:</strong></p>
            <p>Run these commands via SSH:</p>
            <pre style="background: #1f2937; color: #10b981; padding: 10px; border-radius: 4px; overflow-x: auto;">
chmod 755 public/images
chmod 644 public/images/*.avif
            </pre>
            
            <p><strong>If .htaccess is missing AVIF support:</strong></p>
            <p>Add this to your <code>public/.htaccess</code> file:</p>
            <pre style="background: #1f2937; color: #10b981; padding: 10px; border-radius: 4px; overflow-x: auto;">
# Add MIME types for modern image formats
&lt;IfModule mod_mime.c&gt;
    AddType image/avif .avif
    AddType image/webp .webp
&lt;/IfModule&gt;
            </pre>
        </div>
    </div>
</body>
</html>
