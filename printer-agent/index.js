const express = require('express');
const fs = require('fs');
const path = require('path');
const { exec } = require('child_process');
const app = express();
const PORT = 3001;

app.use(express.json());

// Helper to fill VBS template
function fillVbsTemplate(template, replacements) {
    return template.replace(/\{\{(\w+)\}\}/g, (_, key) => replacements[key] || '');
}

app.post('/print', (req, res) => {
    const assets = req.body.assets;
    if (!Array.isArray(assets) || assets.length === 0) {
        return res.status(400).json({ error: 'No assets provided.' });
    }

    const results = [];
    let completed = 0;

    assets.forEach((asset, idx) => {
        const { assetSerialNumber, assetName, hospitalName, assetCode, labelSize } = asset;
        if (
            assetName === undefined || assetName === null || assetName === '' ||
            hospitalName === undefined || hospitalName === null || hospitalName === '' ||
            assetCode === undefined || assetCode === null || assetCode === '' ||
            labelSize === undefined || labelSize === null || labelSize === ''
        ) {
            results[idx] = { success: false, error: 'Missing required fields.', asset };
            completed++;
            if (completed === assets.length) {
                return res.json({ results });
            }
            return;
        }

        const lbxFileMap = { S: 'S.lbx', M: 'M.lbx', L: 'L.lbx' };
        const lbxFile = lbxFileMap[labelSize];
        if (!lbxFile) {
            results[idx] = { success: false, error: 'Invalid label size.', asset };
            completed++;
            if (completed === assets.length) {
                return res.json({ results });
            }
            return;
        }
        const lbxPath = path.join(__dirname, lbxFile);
        const vbsTemplatePath = path.join(__dirname, 'print_template.vbs');
        const vbsTemplate = fs.readFileSync(vbsTemplatePath, 'utf8');
        // Handle serial number: max 16 chars, use '-' if missing
        let serialNumber = assetSerialNumber;
        if (!serialNumber || serialNumber.trim() === '') {
            serialNumber = '-';
        } else if (serialNumber.length > 16) {
            serialNumber = serialNumber.substring(0, 16);
        }
        const filledVbs = fillVbsTemplate(vbsTemplate, {
            LBX_FILE: lbxPath,
            ASSET_NAME: assetName,
            HOSPITAL_NAME: 'SMH CIBINONG',
            SERIAL_NUMBER: serialNumber,
            QRCODE: assetCode
        });
        const tempVbsPath = path.join(__dirname, `print_job_${Date.now()}_${idx}.vbs`);
        fs.writeFileSync(tempVbsPath, filledVbs);
        const command = `cscript //nologo "${tempVbsPath}"`;
        console.log('Running:', command);
        exec(command, (error, stdout, stderr) => {
            console.log('stdout:', stdout);
            console.log('stderr:', stderr);
            fs.unlinkSync(tempVbsPath);
            if (error) {
                results[idx] = { success: false, error: stderr || error.message, asset };
            } else {
                results[idx] = { success: true, output: stdout, asset };
            }
            completed++;
            if (completed === assets.length) {
                res.json({ results });
            }
        });
    });
});

app.listen(PORT, () => {
    console.log(`Printer agent listening on port ${PORT}`);
}); 