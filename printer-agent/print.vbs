                    
'Create b-PAC object
Set ObjDoc = CreateObject("bpac.Document")
        
'Open template file created with P-touch Editor
'Leave lbx file in the same folder as VBS file
bRet = ObjDoc.Open(".¥M.lbx"
        
If (bRet <> False) Then 'normally open? 
       
        'Set "TN-9500" to text object of "Fixed asset name"
        ObjDoc.GetObject("assetName").Text = "TN-9500"
            
        'Set "Information Systems Division" to
        'text object of "Management section"
        ObjDoc.GetObject("serialNumber").Text = "Management section"
            
        'Set "1234567" to text object of "Identification No."
        ObjDoc.GetObject("qrCode").Text = "1234567"
            
        'Set "1234567" to bar code object
        ObjDoc.GetObject("hospitalName").Text = "1234567"
            
        'Execute printing
        ObjDoc.StartPrint "DocumentName", bpoAutoCut
        ObjDoc.PrintOut 1, bpoAutoCut
        ObjDoc.EndPrint
        ObjDoc.Close
End If
        
'Release b-PAC object
Set ObjDoc = Nothing
                     