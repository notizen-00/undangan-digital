const { execSync } = require('child_process');

execSync('php artisan migrate', { stdio: 'inherit' });
