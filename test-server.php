<?php
// Simple test file - upload to project ROOT
echo "✓ Server is working!<br>";
echo "Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "<br>";
echo "This file location: " . __FILE__ . "<br>";
echo "<br>";
echo "If you can see this, your document root is pointing to the PROJECT ROOT, not the PUBLIC folder.<br>";
echo "This is incorrect for Laravel. Please update your server configuration.";
?>
