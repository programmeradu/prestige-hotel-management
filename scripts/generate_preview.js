const fs = require('fs');
const path = require('path');

const mailsDir = path.join(__dirname, '../mails/en');
const outputFile = path.join(mailsDir, 'design_preview.html');

const excludedFiles = [
    'design_preview.html',
    'header.html',
    'footer.html',
    'header_order_conf.html',
    'index.html'
];

function generatePreview() {
    console.log('Reading templates from:', mailsDir);

    // 1. Get all HTML files
    let files = fs.readdirSync(mailsDir).filter(file => {
        return file.endsWith('.html') && !excludedFiles.includes(file);
    });

    console.log(`Found ${files.length} templates.`);

    // 2. Prepare Sidebar Items
    const sidebarItems = [];

    // 3. Process each file
    files.forEach((file, index) => {
        const id = file.replace('.html', '');
        const name = id.split('_').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ');

        // Make active class for first item
        const activeClass = index === 0 ? ' active' : '';

        // Sidebar Item
        sidebarItems.push(
            `<li class="template-item${activeClass}" onclick="loadTemplate('${file}', this)" title="${file}">${name}</li>`
        );
    });

    // Default first file
    const firstFile = files.length > 0 ? files[0] : '';

    // 4. Build Full HTML
    const finalHtml = `<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prestige Hotel Email Previews</title>
    <style>
        body { font-family: 'Open Sans', Arial, sans-serif; margin: 0; padding: 0; background: #e0e0e0; display: flex; height: 100vh; overflow: hidden; }
        
        /* Sidebar */
        .sidebar { background: #fff; width: 300px; border-right: 1px solid #ccc; display: flex; flex-direction: column; z-index: 10; padding-top: 20px; }
        .sidebar-header { padding: 0 20px 20px; border-bottom: 1px solid #eee; }
        .sidebar-header h2 { margin: 0; font-size: 18px; color: #001f3f; }
        .template-list { list-style: none; padding: 0; margin: 20px 0; overflow-y: auto; flex: 1; }
        .template-item { padding: 10px 20px; cursor: pointer; color: #555; transition: background 0.2s; border-left: 4px solid transparent; font-size: 13px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .template-item:hover { background: #f5f5f5; }
        .template-item.active { background: #f0f7ff; color: #001f3f; border-left-color: #C5A059; font-weight: bold; }

        /* Main View */
        .main-view { flex: 1; display: flex; flex-direction: column; background: #e0e0e0; overflow: hidden; }
        .toolbar { padding: 10px 20px; background: #fff; border-bottom: 1px solid #ccc; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
        .toolbar h3 { margin: 0; font-size: 16px; color: #333; }
        .device-toggles button { background: none; border: 1px solid #ddd; padding: 5px 10px; cursor: pointer; border-radius: 4px; margin-left: 5px; }
        .device-toggles button.active { background: #001f3f; color: #fff; border-color: #001f3f; }

        .preview-container { flex: 1; overflow: hidden; padding: 40px; display: flex; justify-content: center; align-items: flex-start; background: #dcdcdc; }
        /* Iframe Styles */
        iframe { background: #fff; box-shadow: 0 5px 25px rgba(0,0,0,0.15); transition: width 0.3s; width: 650px; height: 100%; border: none; }
        iframe.mobile { width: 375px; }

    </style>
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <h2>Prestige Emails (${files.length})</h2>
        </div>
        <ul class="template-list">
            ${sidebarItems.join('\n')}
        </ul>
    </div>

    <div class="main-view">
        <div class="toolbar">
            <h3 id="currentTemplateName">Preview</h3>
            <div class="device-toggles">
                <button class="active" onclick="setView('desktop')">Desktop</button>
                <button onclick="setView('mobile')">Mobile</button>
            </div>
        </div>
        <div class="preview-container">
            <iframe id="previewFrame" src="${firstFile}"></iframe>
        </div>
    </div>

    <script>
        function loadTemplate(filename, element) {
            document.getElementById('previewFrame').src = filename;
            
            document.querySelectorAll('.template-item').forEach(el => el.classList.remove('active'));
            element.classList.add('active');
            
            document.getElementById('currentTemplateName').innerText = element.innerText;
        }

        function setView(mode) {
            const frame = document.getElementById('previewFrame');
            if (mode === 'mobile') { frame.classList.add('mobile'); } 
            else { frame.classList.remove('mobile'); }
            
            document.querySelectorAll('.device-toggles button').forEach(el => el.classList.remove('active'));
            event.target.classList.add('active');
        }
    </script>
</body>
</html>`;

    // 5. Write to file
    fs.writeFileSync(outputFile, finalHtml);
    console.log(`Generated ${outputFile}`);
}

generatePreview();
