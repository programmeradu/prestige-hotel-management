const fs = require('fs');
const path = require('path');

const mailsDir = path.join(__dirname, '../mails/en');

const sharedHead = `<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
	<title>Message from {shop_name}</title>
	<style>
		/* Client-specific Styles */
		#outlook a { padding: 0; }
		body { width: 100% !important; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; margin: 0; padding: 0; font-family: 'Open Sans', Arial, sans-serif; background-color: #f9f9f9; }
		.ExternalClass { width: 100%; }
		.ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div { line-height: 100%; }
		#backgroundTable { margin: 0; padding: 0; width: 100% !important; line-height: 100% !important; }
		img { outline: none; text-decoration: none; -ms-interpolation-mode: bicubic; }
		a img { border: none; }
		.image_fix { display: block; }

		/* Prestige Gold Theme */
		.gold-text { color: #C5A059 !important; }
		.bg-dark { background-color: #001f3f !important; }
		.bg-gold { background-color: #C5A059 !important; }
		.border-bottom-gold { border-bottom: 3px solid #C5A059; }
		.btn-gold { background-color: #C5A059; color: #ffffff; display: inline-block; padding: 12px 24px; text-decoration: none; border-radius: 4px; font-weight: bold; text-transform: uppercase; font-size: 14px; }

		/* Responsive */
		@media only screen and (max-width: 600px) {
			table.container { width: 100% !important; }
			td.content-padding { padding: 15px !important; }
            
            /* Force tables to be full width on mobile */
            table { width: 100% !important; min-width: 100% !important; }
            
            /* Prevent text overlap */
            td { word-break: break-word; hyphens: auto; }
            
            /* Image resizing */
            img { max-width: 100% !important; height: auto !important; }
            
            /* Mobile blocks */
			.mobile-block { display: block !important; width: 100% !important; }
		}
	</style>
</head>`;

function fixResponsiveness() {
    // 1. Scan ALL html files in the directory
    fs.readdir(mailsDir, (err, files) => {
        if (err) {
            console.error('Error scanning directory:', err);
            return;
        }

        const htmlFiles = files.filter(file => file.endsWith('.html') && file !== 'design_preview.html');
        console.log(`Processing ${htmlFiles.length} files...`);

        htmlFiles.forEach(file => {
            const filePath = path.join(mailsDir, file);
            let content = fs.readFileSync(filePath, 'utf8');

            // 1. Replace Head with Robust Head
            // This handles updating existing heads or inserting if missing (though most have it)
            if (content.includes('<head>')) {
                content = content.replace(/<head>[\s\S]*?<\/head>/i, sharedHead);
            } else {
                // If for some reason missing head, we might want to wrap or prepend, but assuming structure:
                content = content.replace('<html>', '<html>' + sharedHead);
            }

            // 2. Add class="container" to the main table (width="600")
            if (!content.includes('class="container"')) {
                content = content.replace(/<table[^>]*width="600"[^>]*>/i, (match) => {
                    if (match.includes('class=')) {
                        return match.replace('class="', 'class="container ');
                    }
                    return match.replace(/width="600"/, 'class="container" width="600"');
                });
            }

            // 3. Add class="content-padding" to the main content td
            if (!content.includes('class="content-padding"')) {
                // Try to find the main content cell by typical padding style
                content = content.replace(/<td[^>]*style="[^"]*padding:\s*40px\s*50px[^"]*"[^>]*>/i, (match) => {
                    if (match.includes('class=')) {
                        return match.replace('class="', 'class="content-padding ');
                    }
                    return match.replace('style="', 'class="content-padding" style="');
                });
            }

            // 4. Update body tag (Force clean body tag with Open Sans)
            // Use a regex that captures attributes to be safe, but we want to homogenize it.
            content = content.replace(/<body[^>]*>/i, '<body style="-webkit-text-size-adjust:none;background-color:#f9f9f9;font-family:\'Open Sans\', Arial, sans-serif;color:#333333;font-size:14px;line-height:1.5;margin:0;padding:0;">');

            // 5. Update main background table id
            content = content.replace(/<table[^>]*width="100%"[^>]*>/i, (match) => {
                if (!match.includes('id="backgroundTable"')) {
                    return match.replace(/width="100%"/, 'id="backgroundTable" width="100%"');
                }
                return match;
            });

            fs.writeFileSync(filePath, content);
            console.log(`Fixed: ${file}`);
        });
    });
}

fixResponsiveness();
