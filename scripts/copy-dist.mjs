import { cpSync, existsSync, mkdirSync } from 'fs';
import { join, dirname } from 'path';
import { fileURLToPath } from 'url';

const __dirname = dirname(fileURLToPath(import.meta.url));
const root = join(__dirname, '..');
const src = join(root, 'public');
const dest = join(root, 'dist');

console.log('📦 Copying public/ → dist/ for Vercel...');

if (existsSync(dest)) {
  console.log('⚠️  dist/ already exists, skipping copy.');
} else {
  mkdirSync(dest, { recursive: true });
  cpSync(src, dest, { recursive: true });
  console.log('✅ dist/ created successfully from public/');
}
