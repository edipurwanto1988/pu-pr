#!/bin/bash

# Deploy script for PU-PR
# Run this after pulling new code

echo "Starting deployment..."

cd /home/u492381568/domains/pu-pr.com/public_html/main

echo "Pulling latest code..."
git pull origin main

echo "Fixing database password..."
sed -i "s/'password' => env('DB_PASSWORD', '')/'password' => 'Pupr123*#'/g" config/database.php

echo "Clearing cache..."
rm -f bootstrap/cache/*.php

echo "Deploy complete!"