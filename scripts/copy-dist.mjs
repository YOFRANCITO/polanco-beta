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
console.log('✅ dist/ copied successfully from public/');
