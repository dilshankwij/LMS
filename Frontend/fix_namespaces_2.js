const fs = require('fs');
const path = require('path');

const ROOT = 'c:\\Users\\dilsh\\Documents\\Internship\\AdminLTE-3.1.0';
const SEEDER_PATH = path.join(ROOT, 'Backend', 'database', 'seeders', 'DatabaseSeeder.php');

let content = fs.readFileSync(SEEDER_PATH, 'utf8');
content = content.replace('use Illuminate\\SupportFacades\\Hash;', 'use Illuminate\\Support\\Facades\\Hash;');
fs.writeFileSync(SEEDER_PATH, content);
console.log('✓ Seeder Hash import fixed!');
