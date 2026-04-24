#!/bin/bash

# Post-receive hook for automatic deployment
# Place this in: /home/u492381568/domains/pu-pr.com/public_html/main/.git/hooks/post-receive
# Make executable: chmod +x post-receive

echo "========================================"
echo "Auto-deploy triggered at $(date)"
echo "========================================"

# Navigate to laravel directory
cd /home/u492381568/domains/pu-pr.com/public_html/main

# Pull latest code
echo "Pulling latest code..."
git --work-tree=/home/u492381568/domains/pu-pr.com/public_html/main --git-dir=/home/u492381568/domains/pu-pr.com/public_html/main/.git pull origin main 2>&1

# Fix database password (because .env doesn't load properly)
echo "Fixing database password..."
sed -i "s/'password' => env('DB_PASSWORD', '')/'password' => 'Pupr123*#'/g" /home/u492381568/domains/pu-pr.com/public_html/main/config/database.php 2>&1

# Clear Laravel cache
echo "Clearing Laravel cache..."
rm -f /home/u492381568/domains/pu-pr.com/public_html/main/bootstrap/cache/*.php 2>&1

echo "========================================"
echo "Deploy complete!"
echo "========================================"