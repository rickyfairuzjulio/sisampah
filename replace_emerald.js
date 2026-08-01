const fs = require('fs');
const path = require('path');

function walk(dir) {
    let results = [];
    const list = fs.readdirSync(dir);
    list.forEach(file => {
        file = path.join(dir, file);
        const stat = fs.statSync(file);
        if (stat && stat.isDirectory()) { 
            results = results.concat(walk(file));
        } else { 
            if(file.endsWith('.blade.php') || file.endsWith('.css')) {
                results.push(file);
            }
        }
    });
    return results;
}

const files = walk('c:\\laragon\\www\\sampah\\resources');
let count = 0;

files.forEach(file => {
    let content = fs.readFileSync(file, 'utf8');
    if(content.includes('forest-emerald')) {
        content = content.replace(/forest-emerald/g, 'emerald');
        fs.writeFileSync(file, content);
        count++;
    }
});

console.log(`Replaced forest-emerald with emerald in ${count} files.`);
