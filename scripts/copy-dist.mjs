import { cpSync, existsSync, mkdirSync } from 'fs';
import { join, dirname } from 'path';
import { fileURLToPath } from 'url';

const __dirname = dirname(fileURLToPath(import.meta.url));
const root = join(__dirname, '..');
const src = join(root, 'public');
const dest = join(root, 'dist');

console.log('📦 Copying public/ → dist/ for Vercel...');

mkdirSync(dest, { recursive: true });
cpSync(src, dest, { recursive: true, force: true });

// Remove index.php from dist/ so Vercel forwards requests to api/index.php instead of downloading index.php as static
const distIndex = join(dest, 'index.php');
if (existsSync(distIndex)) {
  unlinkSync(distIndex);
  console.log('🗑️ Removed dist/index.php (routed to api/index.php)');
}
console.log('✅ dist/ ready for Vercel static assets');
