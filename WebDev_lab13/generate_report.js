const fs = require('fs');

const lines = [
  'Тема: Основи роботи з серверним JavaScript через Node.js',
  'Мета: Ознайомитися з підходами та технологіями використання JavaScript на сервері.',
  'Результати: Встановлено Node.js та виконано простий HTTP сервер.',
  'Висновки: Node.js корисний для створення масштабованих веб-застосунків.'
];

function escapePdf(text) {
  return text.replace(/[()\\]/g, '\\$&');
}

function addObject(arr, content) {
  arr.push(content);
  return arr.length;
}

const objects = [];
const fontId = addObject(objects, '<< /Type /Font /Subtype /Type1 /Name /F1 /BaseFont /Helvetica >>');

let stream = 'BT\n/F1 12 Tf\n';
let y = 750;
for (const line of lines) {
  stream += `50 ${y} Td (${escapePdf(line)}) Tj\n`;
  y -= 20;
}
stream += 'ET';
const contentId = addObject(objects, `<< /Length ${stream.length} >>\nstream\n${stream}\nendstream`);
const pageId = addObject(objects, `<< /Type /Page /Parent 4 0 R /MediaBox [0 0 595 842] /Contents ${contentId} 0 R /Resources << /Font << /F1 ${fontId} 0 R >> >> >>`);
const pagesId = addObject(objects, `<< /Type /Pages /Kids [${pageId} 0 R] /Count 1 >>`);
const catalogId = addObject(objects, `<< /Type /Catalog /Pages ${pagesId} 0 R >>`);

let pdf = '%PDF-1.4\n';
const offsets = [0];
for (let i = 0; i < objects.length; i++) {
  offsets.push(Buffer.byteLength(pdf, 'utf8'));
  pdf += `${i + 1} 0 obj\n${objects[i]}\nendobj\n`;
}
const xrefOffset = Buffer.byteLength(pdf, 'utf8');
pdf += `xref\n0 ${objects.length + 1}\n`;
pdf += '0000000000 65535 f \n';
for (let i = 1; i <= objects.length; i++) {
  pdf += offsets[i].toString().padStart(10, '0') + ' 00000 n \n';
}
pdf += `trailer\n<< /Root ${catalogId} 0 R /Size ${objects.length + 1} >>\n`;
pdf += `startxref\n${xrefOffset}\n%%EOF`;

fs.writeFileSync('Node_JS_Report.pdf', pdf);
console.log('PDF generated as Node_JS_Report.pdf');
