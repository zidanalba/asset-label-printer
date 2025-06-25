' print_template.vbs
' Placeholders: {{LBX_FILE}}, {{ASSET_NAME}}, {{HOSPITAL_NAME}}, {{SERIAL_NUMBER}}, {{QRCODE}}

Set ObjDoc = CreateObject("bpac.Document")
bRet = ObjDoc.Open("{{LBX_FILE}}")

If (bRet <> False) Then
    ObjDoc.GetObject("assetName").Text = "{{ASSET_NAME}}"
    ObjDoc.GetObject("hospitalName").Text = "{{HOSPITAL_NAME}}"
    ObjDoc.GetObject("qrCode").Text = "{{QRCODE}}"
    ObjDoc.GetObject("assetSerialNumber").Text = "{{SERIAL_NUMBER}}"
    ObjDoc.StartPrint "DocumentName", bpoAutoCut
    ObjDoc.PrintOut 1, bpoAutoCut
    ObjDoc.EndPrint
    ObjDoc.Close
End If

Set ObjDoc = Nothing 